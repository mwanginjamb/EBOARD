<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RSVPSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rsvps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rsvp-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rsvp', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'RSVPID',
            'CalenderID',
            'RSVPStatusID',
            'CreatedAt',
            'UpdatedAt',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
