<?php
/**
 * Created by PhpStorm.
 * User: Francis
 * Date: 10/1/2018
 * Time: 2:33 AM
 */

namespace frontend\controllers;
use frontend\models\Documents;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;


class DocsController extends Controller
{
    public $modelClass = 'frontend\models\Documents';
    public function actionIndex(){
        $documents = Documents::find()->joinWith('parentDocument')->joinWith('childDocument')->asArray()->all();

        foreach($documents as $d){
           //print $k.'<br>';
           $doc = [
               'id'=>$d['id'],
               'name'=>$d['path'],
           ];

        }
        print '<pre>';
       return Json::encode($doc);
    }
}