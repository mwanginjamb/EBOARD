<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Calendar */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Calendars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('View All Events', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'event:ntext',
            'scheduled_date',
            'start_time',
            'end_time',
            'venue',
            'status',
            'created_at',
            'updated_at',
            'creator',
            'creatorDesignation',
        ],
    ]) ?>

</div>
