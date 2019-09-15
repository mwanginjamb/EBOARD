<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RSVPStatusSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rsvpstatus-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'RSVPStatusID') ?>

    <?= $form->field($model, 'RSVPStatus') ?>

    <?= $form->field($model, 'CreatedAt') ?>

    <?= $form->field($model, 'UpdatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
