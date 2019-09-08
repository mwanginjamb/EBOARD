<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Profile;
use frontend\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update','index','view','update','delete'],
                'rules' => [
                    [
                        'actions' => [''],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['create', 'update','index','view','update','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profile();
        $model->scenario = 'create';
        $path = \Yii::getAlias('@profile');
        $identity = \Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post())) {
            $parent = implode(',',$_POST['Profile']['parent_folder_access']);

            $image_instance = UploadedFile::getInstance($model,'file');
            $image_name = str_replace(' ','',$image_instance->name);
            $upload_path = $path.'\\'.$image_name;
            $image_instance->saveAs($upload_path);
            $model->parent_folder_access = $parent;//This is a string not an array
            $model->avatar = $image_name;
            $model->user_id = $identity->getId();
            $model->designation = $_POST['Profile']['designation'];
            $model->created_at = date('m-d-Y H:i:s');
            $model->updated_at = date('m-d-Y H:i:s');


            if($model->save()){
                return $this->redirect(['index']);
                /*Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return['message'=>1,'note'=>'<div class="alert alert-success">Profile Save Successfully</div>'];*/
            }
           /* else{
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return['message'=>0,'note'=>'<div class="alert alert-danger">Problem Saving Profile</div>'];
            }*/
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $model->scenario = 'update';
        $path = \Yii::getAlias('@profile');
        $oldfile = $model->avatar;
        if ($model->load(Yii::$app->request->post()) ) {
            //parent folder access come's in as an array, so implode it to a string
            /*print '<pre>';
            var_dump($_POST['Profile']['parent_folder_access']); exit();*/
            if(is_array($_POST['Profile']['parent_folder_access'])){
                //echo 'is array';
                $parent = implode(',',$_POST['Profile']['parent_folder_access']);
            }else{
                $parent = $_POST['Profile']['parent_folder_access'];
            }
            //exit;




            /*print '<pre>';
            print_r( $model->parent_folder_access);
            print '<br/>'.$parent."<br/>";
            print_r($_POST); exit;*/
            $image_instance = UploadedFile::getInstance($model,'file');
            if(isset($image_instance)){
                $image_name = str_replace(' ','',$image_instance->name);
                $upload_path = $path.'\\'.$image_name;
                $image_instance->saveAs($upload_path);
            }
            else{
                $model->avatar = $oldfile;
                $model->parent_folder_access = $parent;
            }

            if($model->save()){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //return['message'=>1,'note'=>'Profile successfully updated.'];//Update Successfully
                return $this->redirect(['index']);
            }
            else{
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return['message'=>2,'note'=>'Error updating profile.'];//Update error
            }
            //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionAssign(){
        $user = $_POST['user'];
        $committe = $_POST['committe'];
        $model = Profile::find()->where(['user_id'=>$user])->one();
//print_r($model); exit;
        if(strlen($model->parent_folder_access)>0){
            $model->parent_folder_access = $model->parent_folder_access.','.$committe;
        }
        else{
            $model->parent_folder_access = $committe;
        }

        if($model->save()){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return['message'=>1,'note'=>'User Assigned Successfully'];
        }else{
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return['message'=>1,'note'=>'Problem Assigning User Committe Access'];
        }

    }

    public function actionResign(){
        $user = $_POST['user'];
        $committe = $_POST['committe'];
        $model = Profile::find()->where(['user_id'=>$user])->one();
//print_r($model); exit;
        if(strlen($model->parent_folder_access)>0){
            //$model->parent_folder_access = $model->parent_folder_access.','.$committe;

            $model->parent_folder_access = str_replace($committe," ",$model->parent_folder_access);
        }
        else{
            $model->parent_folder_access = ' ';
        }

        if($model->save()){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return['message'=>1,'note'=>'User Access Revoked Successfully'];
        }else{
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return['message'=>1,'note'=>'Problem Revoking User Access'];
        }

    }
}
