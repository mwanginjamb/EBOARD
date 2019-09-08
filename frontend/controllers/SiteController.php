<?php
namespace frontend\controllers;

use frontend\models\Annotation;
use frontend\models\Calendar;
use frontend\models\ChildDocumentTypes;
use frontend\models\Documents;
use frontend\models\ParentDocumentType;
use frontend\models\Profile;
use frontend\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\debug\models\timeline\DataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\ContentNegotiator;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\Cors;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $modelClass = 'frontend\models\Documents';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index','contact'],
                'rules' => [
                    [
                        'actions' => ['contact'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','signup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'mobauth' => ['post'],
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::className(),
                'only' => ['docs','folders','subfolders','files','mobauth','addannotation','listannotations','events','userannotations','deleteannotation'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ],
            'authenticator'=>[
                'class'=> HttpBasicAuth::className(),
                'only'=>['docauth'],
                'auth'=> function($username,$password){
                        Yii::info("System attemps to  login with  '$username' and token '$password'",'auth');
                            $user = User::find()->where(['username' => $username])->one();
                            if ($user->verifyPassword($password)) {
                                return $user;
                            }
                            return null;

                }
            ],
            'corsFilter' => [
            'class' => Cors::className(),
            'cors' => [
                // restrict access to
                //'Origin' => ['http://localhost:9001', 'http://192.168.0.164:9001'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Method' => ['POST', 'PUT','GET'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Request-Headers' => ['*'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],
        ]

    ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()//show only permitted folders
    {
        $identity = \Yii::$app->user->identity;
        $access = [];
        if($identity !== Null && is_object($identity->profile)) {//ensure profile exists
            $access[] = $identity->profile->parent_folder_access;


            if (strpos($identity->profile->parent_folder_access, ',') > 0) {//for csv list of access ids
                $access = explode(',', $identity->profile->parent_folder_access);
            }
        }
        $folders = ParentDocumentType::find()->where(['id'=>$access])->all();//folders
        return $this->render('index',[
            'parents'=>$folders,
        ]);

    }
    public function actionDocs(){
        $documents = Documents::find()->joinWith('parentDocument')->joinWith('childDocument')->asArray()->all();
        return ['results'=>$documents];
    }
    public function actionFolders(){//show only allowed folders
        $access = [];
        $access[] = \Yii::$app->request->get('access');
        if(strpos(Yii::$app->request->get('access'),',') > 0){//for csv list of access ids
            $access = explode(',',Yii::$app->request->get('access'));
        }

        $folders = ParentDocumentType::find()
            ->select(['parentDocumentType.id','parentDocumentType.title'])
            ->joinwith('childDocumentTypes')
            ->where(['ParentDocumentType.id'=>$access])
            ->orderBy(['id'=>SORT_DESC])
            ->asArray()
            ->all();
        return ['results' => $folders];  
    }
    public function actionSubfolders($fid){       
        $subfolders = ChildDocumentTypes::find()->where(['parent_id'=>$fid])
            ->orderBy(['id'=>SORT_DESC])
            ->asArray()->all();
        return ['results'=>$subfolders];
    }
    public function actionFiles($sid){
        $files = Documents::find()->where(['child_document_id'=>$sid,'status'=>1])
            ->orderBy(['id'=>SORT_DESC])
            ->asArray()->all();
        return ['results'=>$files];
    }
    public function actionAddannotation(){
        //exit('....ooog');
        $model = new Annotation();

        $model->documentTitle = \Yii::$app->request->get('doc_title');
        $model->annotation = \Yii::$app->request->get('annotation');
        $model->creator = \Yii::$app->request->get('creator');
        $model->creatorEmail = \Yii::$app->request->get('email');
        $model->creatorDesignation = \Yii::$app->request->get('designation');
        $model->created_at = date('m-d-Y H:i:s');
        if($model->save()){
            return ['results'=>1];
        }
        else{
            return ['results'=>0];
        }
    }
    //method to list annotations
    public function actionListannotations($docTitle){
        $annotations = Annotation::find()->where(['documentTitle'=>$docTitle,'status'=>NULL])->asArray()->all();
        return ['results'=>$annotations];
    }

    //Get user annotation
    public function actionUserannotations($docTitle,$username){
        $annotations = Annotation::find()->where(['documentTitle'=>$docTitle,'creator'=>$username,'status'=>NULL])->asArray()->all();
        return ['results'=>$annotations];
    }

    //delete annotation
    public function actionDeleteannotation($id){
        $model = Annotation::find()->where(['id'=>$id])->one();

        if(is_object($model)){
            $model->status = 1;
            if($model->save()){
                return ['results'=>['deleted'=>true,'note'=>'Annotation Deleted Successfully.']];
            }else{
                return ['results'=> 'Error Deleting Annotation no: '.$model->getErrors()];
            }
        }else{
                return ['results'=> 'Error Deleting Annotation no: '.$id];
        }
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function actionMobauth($username,$password){//removed count and replaced it with is_object
        $result = [];
        if(isset($_GET)){

            $user = \common\models\User::find()->where(['username'=>$username])->one();

            if($user == NULL){
                $result['results'] = [
                    'status'=>'Wrong Username or Password'
                ];

            }

            else if(is_object($user) && $user->validatepassword($password)){
                Yii::$app->user->login($user);
                $identity = Yii::$app->user->identity;
                $result['results'] = [
                    'user'=>$user,
                    'status'=>'authenticated',
                    'profile'=>$identity->profile,
                    ];
            }
            else if (is_object($user) && !$user->validatepassword($password)){
                $result['results'] = [
                    'status'=>'Wrong Password'
                ];
            }

        }

       // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;

    }
    public function actionEvents(){//open events
        $events = Calendar::find()->where(['status'=>1])
            ->orderBy(['scheduled_date'=>SORT_DESC])
            ->joinWith('venue')
            ->asArray()->all();

        //print '<pre>';
        //print_r($events); exit;
        $ev = [];
        foreach($events as $e){
            $ev[] = [
                'id'=>$e['id'],
                'event'=>$e['event'],
                'scheduled_date'=>$e['scheduled_date'],
                'start_time'=>$this->formatTime($e['start_time']),
                'end_time'=>$this->formatTime($e['end_time']),
                'venue'=>$e['venue']['venue'],
                'status'=>$e['status'],
                'created_at'=>$this->formatTime($e['created_at']),
                'updated_at'=>$this->formatTime($e['updated_at']),
                'creator'=>ucwords($e['creator']),
                'creatorDesignation'=>$e['creatorDesignation'],
                'timeto'=>$this->calcto($e['scheduled_date']),

            ];
        }


        return ['results'=>$ev];
    }
    function formatTime($time){
        if(strpos($time,'.')) {
            list($t, $z) = explode('.', $time);
            $time = $t . ' Hrs';
        }
        $time = $time;
        return $time;
    }
    function calcto($date){
        $sdate = date('Y-m-d', strtotime($date));
        $now = date('Y-m-d');

        $initial = date_create($sdate);
        $curr = date_create($now);
        $diff=date_diff($curr,$initial);
        return $diff->format("%R%a");
    }
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();//customize to redirect to same page
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    public function actionViewdoc()//validate with the one on live system
    {
        //$path = \Yii::$app->request->get('path');

        $title = \Yii::$app->request->get('title');
        $upload_path = Yii::getAlias('@frontweb');
        $parts = explode("\\", $_GET['path'] );

        $file_name = end($parts);//get last part of the array which is the actual file namespace
        $path = '.\documents\\'.$file_name;

        //exit($path);
        //magic line
        return \Yii::$app->response->sendFile($path,$title,['inline'=>true]);
    }
    public function actionArchivedoc($id){

        $model = Documents::findOne(['id'=>$id]);
        $model->status = 0;
        if($model->save()){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return['message'=>1,'note'=>'<div class="alert alert-success">Document Archived Successfully.</div>'];//Update Successfully
        }else{
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return['message'=>0,'note'=>'<div class="alert alert-danger">Problem Archiving Document.</div>'];//Update Successfully
        }
    }
    public function actionNotification($folder,$foldername){

        $userIds = [];
        $identity = Yii::$app->user->identity;
        $profiles = Profile::find()->where(['like','parent_folder_access',$folder])->asArray()->all();
        foreach($profiles as $p){
            $userIds[] = $p['user_id'];
        }

        $emails = \common\models\User::find()->select(['username','email'])->where(['id'=>$userIds])->asArray()->all();
        foreach($emails as $e){

            $subject ='New Document Upload to ERC Eboard';
            $to = $e['email'];
            $message = 'Dear, <b>'.$e['username'].'</b> , proceed to the ERC Eboard App to view new document(s) upload.</br> Kind Regards';
            $message .= '<p><b>Document Folder : </b> '.$foldername.'</p>';
            if(Yii::$app->mailer->compose()
                ->setSubject($subject)
                //->setFrom(Yii::$app->params['adminEmail'])
                ->setFrom($identity->email)
                ->setTo($to)
                ->setHtmlBody($message)
                ->send()){//Successful notification to appraisee.
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return['message'=> 1,'note'=>'Notification Sent Successfully'];
            }else{//Notification not sent
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return['message'=> 0,'note'=>'Error Sending Notification'];
            }
        }
        /*print '<pre>';
        print_r($emails);
        print '</pre>';exit;*/
    }
}
