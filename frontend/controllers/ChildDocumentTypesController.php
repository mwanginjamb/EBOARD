<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ChildDocumentTypes;
use frontend\models\ChildDocumentTypesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ChildDocumentTypesController implements the CRUD actions for ChildDocumentTypes model.
 */
class ChildDocumentTypesController extends Controller
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
     * Lists all ChildDocumentTypes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChildDocumentTypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ChildDocumentTypes model.
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
     * Creates a new ChildDocumentTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($folder="")
    {
        $model = new ChildDocumentTypes();
        $model->status = 1;//initiaize subfolder status to active 
        $model->created_at = date('m-d-Y H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            

            if(isset($folder)){
                $parentfolder = \frontend\models\ParentDocumentType::findOne($folder);
                $folderName = $parentfolder->title;
                Yii::$app->session->setFlash('success', 'Subfolder <u>'.$model->title.'</u> Created Successfully in <b>'.$folderName.'</b> .');
                return $this->redirect(['site/index']);
            }
            return $this->redirect(['view','id'=>$model->id]);
            
        }


        if(\Yii::$app->request->isAjax){//if create is invoked via ajax request then initiaize folder id
            $model->parent_id = $folder;
            return $this->renderAjax('create',[
                'model'=>$model,
            ]);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ChildDocumentTypes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->update_at = date('m-d-Y H:i:s');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ChildDocumentTypes model.
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
     * Finds the ChildDocumentTypes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ChildDocumentTypes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ChildDocumentTypes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
