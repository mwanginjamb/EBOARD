<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Profile;
use frontend\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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
        $path = \Yii::getAlias('@profile');
        $identity = \Yii::$app->user->identity;

        if (Yii::$app->request->post()) {
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
            //return $this->redirect(['view', 'id' => $model->id]);
            if($model->save()){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return['message'=>1,'note'=>'<div class="alert alert-success">Profile Save Successfully</div>'];
            }
            else{
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return['message'=>0,'note'=>'<div class="alert alert-danger">Problem Saving Profile</div>'];
            }
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
}
