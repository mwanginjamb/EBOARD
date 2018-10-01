<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\ParentDocumentType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Define a Top Level Directory</h3>
            </div>
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'title')->textInput() ?>

                <?php //$form->field($model, 'size')->textInput() ?>

                <?php //$form->field($model, 'updated_at')->textInput() ?>

                <?php //$form->field($model, 'created_at')->textInput() ?>

                <?php //$form->field($model, 'creator')->textInput() ?>

                <?= $form->field($model, 'status')->dropDownList(['0'=>'InActive','1'=>'Active'],['prompt'=>'Document Status']) ?>

                <?= $form->field($model, 'user_type_ids')->dropDownList(
                    ArrayHelper::map(\frontend\models\userType::find()->all(),'id','user_type'),
                    ['prompt'=>'User Type']
                ) ?>

                <div class="form-group">
                    <?= Html::submitButton('Create Folder', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
