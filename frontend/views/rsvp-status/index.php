<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RSVPStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rsvpstatuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rsvpstatus-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rsvpstatus', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'RSVPStatusID',
            'RSVPStatus',
            'CreatedAt',
            'UpdatedAt',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
