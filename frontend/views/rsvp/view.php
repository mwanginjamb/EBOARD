<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\RSVP */

$this->title = $model->RSVPID;
$this->params['breadcrumbs'][] = ['label' => 'Rsvps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rsvp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->RSVPID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->RSVPID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'RSVPID',
            'CalenderID',
            'RSVPStatusID',
            'CreatedAt',
            'UpdatedAt',
        ],
    ]) ?>

</div>
