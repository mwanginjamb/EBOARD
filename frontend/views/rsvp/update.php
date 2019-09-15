<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RSVP */

$this->title = 'Update Rsvp: ' . $model->RSVPID;
$this->params['breadcrumbs'][] = ['label' => 'Rsvps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->RSVPID, 'url' => ['view', 'id' => $model->RSVPID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rsvp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
