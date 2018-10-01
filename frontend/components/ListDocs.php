<?php
/**
 * Created by PhpStorm.
 * User: Francis
 * Date: 10/1/2018
 * Time: 12:37 PM
 */

namespace frontend\components;

use Yii;
use yii\base\Component;
use frontend\models\Documents;
use yii\db\Query;

class ListDocs extends Component
{
    public function parentfiles($parentFolderid){
        $files = Documents::find()->where(['parent_document_id'=>$parentFolderid,'status'=>1])->asArray()->all();
        return $files;
    }
    public function childfiles($childFolderid){
        $files = Documents::find()->where(['parent_document_id'=>$childFolderid,'status'=>1])->asArray()->all();
        return $files;
    }
    public function cummulativesize($folderid){
        $query = (new Query())->from('documents')->where(['parent_document_id'=>$folderid]);
        $totalsize = $query->sum('size');
        return number_format($totalsize/1024);
    }
}