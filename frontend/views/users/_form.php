<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Add E-Board User</h3>
            </div>
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'first_name')->textInput() ?>

                <?= $form->field($model, 'middle_name')->textInput() ?>

                <?= $form->field($model, 'last_name')->textInput() ?>

                <?= $form->field($model, 'user_type_id')->dropDownList(
                    ArrayHelper::map(\frontend\models\userType::find()->all(),'id','user_type'),
                    ['prompt'=>'User Type']
                ) ?>

                <?= $form->field($model, 'email')->textInput(['placeholder'=>'User Email']) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?php //$form->field($model, 'created_at')->textInput() ?>

                <?php //$form->field($model, 'updated_at')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>


</div>
