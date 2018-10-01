<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Documents;
use frontend\models\DocumentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DocumentsController implements the CRUD actions for Documents model.
 */
class DocumentsController extends Controller
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
     * Lists all Documents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Documents model.
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
     * Creates a new Documents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->enableCsrfValidation = false;
        $identity = \Yii::$app->user->identity;
        $model = new Documents();
        $path = Yii::getAlias('@frontweb');

        if (Yii::$app->request->post()) {

            $docs = UploadedFile::getInstances($model,'files');
            foreach($docs as $doc){
                /* print($_POST['Documents']['parent_document_id']).'<br />';
                print($_POST['Documents']['child_document_id']).'<br />';
                print($_POST['Documents']['status']).'<br />';exit;*/
                //print $parent.'<br />'; exit;
                $model = new Documents();
                $model->parent_document_id = $_POST['Documents']['parent_document_id'];
                $model->child_document_id = $_POST['Documents']['child_document_id'];
                $model->created_at = date('m-d-Y H:i:s');
                $model->updated_at = date('m-d-Y H:i:s');
                $model->title = str_replace(" ", "_", $doc->name);
                $model->size = $doc->size;
                $model->document_type = $doc->type;
                $model->created_by = $identity->username;
                $model->path = $path.'\\'.$doc->name;
                $model->status = $_POST['Documents']['status'];
                $doc->saveAs($path.'\\'. $doc->name);
                $model->save();
            }
            if($model->save()){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return['message'=>1,'note'=>'<div class="alert alert-success">Document(s) Uploaded Successfully.</div>'];//Update Successfully
            }else{
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return['message'=>0,'note'=>'<div class="alert alert-danger">Problem Uploading Document(s).</div>'];//Update Successfully
            }
            //return $this->redirect(['view', 'id' => $model->id]);
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Documents model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return['message'=>1,'note'=>'<div class="alert alert-success">Document Updated Successfully.</div>'];//Update Successfully
            }else{
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return['message'=>0,'note'=>'<div class="alert alert-danger">Problem Updating Document.</div>'];//Update Successfully
            }
            //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Documents model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        //Just purge from db do not unlink--> for forensic/audit purposes
        $id = \Yii::$app->request->post('id');
        if($this->findModel($id)->delete()){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return['message'=>1,'note'=>'<div class="alert alert-success">Document Deleted Successfully.</div>'];//Update Successfully
        }else{
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return['message'=>0,'note'=>'<div class="alert alert-danger">Problem Deleting Document.</div>'];//Update Successfully
        }

        //return $this->redirect(['index']);
    }

    /**
     * Finds the Documents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Documents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Documents::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
