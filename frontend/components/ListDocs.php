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
use frontend\models\ChildDocumentTypes;
use yii\db\Query;

class ListDocs extends Component
{
    public function parentfiles($parentFolderid){//files in a parent folder
        $files = Documents::find()->where(['parent_document_id'=>$parentFolderid,'status'=>1])->asArray()->all();
        return $files;
    }
    public function childfiles($childFolderid){//files in a subfolder
        $files = Documents::find()->where(['child_document_id'=>$childFolderid,'documents.status'=>1])->joinWith('parentDocument')->joinWith('childDocument')->asArray()->all();
        return $files;
    }
    public function Listsubfolders($parentid){
        $subfolders = ChildDocumentTypes::find()->where(['parent_id'=>$parentid])->asArray()->all();//subfolder
        return $subfolders;
    }
    public function cummulativesize($folderid){
        $query = (new Query())->from('documents')->where(['parent_document_id'=>$folderid,'documents.status'=>1]);
        $totalsize = $query->sum('size');
        return number_format($totalsize/1024);
    }
    public function subfoldersize($subfolderid){
        $query = (new Query())->from('documents')->where(['child_document_id'=>$subfolderid,'documents.status'=>1]);
        $totalsize = $query->sum('size');
        return number_format($totalsize/1024);
    }
}