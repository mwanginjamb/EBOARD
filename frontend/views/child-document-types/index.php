<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ChildDocumentTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sub Folders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="child-document-types-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sub Folder', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'parent.title',
            'title',
            //'size',
            'created_at',
            //'update_at',
            //'creator',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
