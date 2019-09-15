<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RSVPStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rsvpstatus-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'RSVPStatusID')->textInput() ?>

    <?= $form->field($model, 'RSVPStatus')->textInput() ?>

    <?= $form->field($model, 'CreatedAt')->textInput() ?>

    <?= $form->field($model, 'UpdatedAt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
