<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model frontend\models\Documents */
/* @var $form yii\widgets\ActiveForm */
$action = \Yii::$app->controller->action->id;
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><?= ($action == 'create')?'Upload Documents':'Update Document'?></h3>
            </div>
            <div class="box-body">
                <div class="message"></div>
                <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>
                <?= ($action == 'update')?$form->field($model, 'title')->textInput():'' ?>
                <?= $form->field($model, 'parent_document_id')->dropDownList(
                    ArrayHelper::map(\frontend\models\ParentDocumentType::find()->all(),'id','title'),
                    ['prompt'=>'Parent Folder']
                ) ?>

                <?= $form->field($model, 'child_document_id')->dropDownList(
                    ArrayHelper::map(\frontend\models\ChildDocumentTypes::find()->all(),'id','title'),
                    ['prompt'=>'Sub Folder']
                ) ?>

                <?php //$form->field($model, 'size')->textInput() ?>



                <?= ($action !== 'update')?$form->field($model,'files[]')->widget(FileInput::className(),
                    [
                    'options'=>['multiple'=>true],
                    'pluginOptions'=>['previewFileType'=>'any'],

                    ]):''; ?>

                <?= $form->field($model, 'status')->dropDownList(['0'=>'InActive','1'=>'Active'],['prompt'=>'Document Status']) ?>

                <?php //$form->field($model, 'created_at')->textInput() ?>

                <?php //$form->field($model, 'updated_at')->textInput() ?>

                <?php //$form->field($model, 'document_type')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>
<?php
$style = <<<CSS
    .file-drop-zone{
        height: 250px;
    }
CSS;
$this->registerCss($style);
$script = <<<JS
$(function(){
     $('.message').hide();
        $('form#{$model->formName()}').on('beforeSubmit',function(e){
           e.preventDefault();
            var \$form = $(this);
              $(this).ajaxSubmit({
                    target: '.message',
                    url: $(\$form).attr('action'),
                    type: 'post',
                    resetForm: true,
                    context: '\$form',
                    dataType: 'json',
                    beforeSend: function(){
                        
                        },
                    success: function(msg){
                        $('.message').show();
                        $(\$form).hide();                      
                            
                        $('.message').html(msg.note);
                                                                  
                            
                           
                        }
                    
            });
            return false;
        });//complete form submittion event
});
JS;
$this->registerJs($script);

