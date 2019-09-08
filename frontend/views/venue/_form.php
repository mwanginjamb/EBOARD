<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Venue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="venue-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'venue')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
