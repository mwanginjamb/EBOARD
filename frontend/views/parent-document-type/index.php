<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ParentDocumentTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Committe Folders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parent-document-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create a Committe Folder', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            //'size',
            //'updated_at',
            'created_at',
            //'creator',
            //'status',
            //'user_type_ids',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
