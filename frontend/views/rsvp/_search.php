<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RSVPSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rsvp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'RSVPID') ?>

    <?= $form->field($model, 'CalenderID') ?>

    <?= $form->field($model, 'RSVPStatusID') ?>

    <?= $form->field($model, 'CreatedAt') ?>

    <?= $form->field($model, 'UpdatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
