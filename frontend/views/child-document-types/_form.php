<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\ChildDocumentTypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Add a Sub-Folder</h3>

            </div>
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'parent_id')->dropDownList(
                    ArrayHelper::map(\frontend\models\ParentDocumentType::find()->all(),'id','title'),
                    ['prompt'=>'Parent Folder']
                ) ?>

                <?= $form->field($model, 'title')->textInput() ?>

                <?php //$form->field($model, 'size')->textInput() ?>

                <?php //$form->field($model, 'created_at')->textInput() ?>

                <?php //$form->field($model, 'update_at')->textInput() ?>

                <?php //$form->field($model, 'creator')->textInput() ?>

                <?= $form->field($model, 'status')->dropDownList(['0'=>'InActive','1'=>'Active'],['prompt'=>'Document Status']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Create Sub Folder', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>
