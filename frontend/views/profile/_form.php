<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */
/* @var $form yii\widgets\ActiveForm */
$identity = \Yii::$app->user->identity;
$action = \Yii::$app->controller->action->id;
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><?= ($action == 'create')?'Create Profile':'Update Profile'?></h3>
            </div>
            <div class="box-body">
                <div class="message"></div>
                <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>

                <?= $form->field($model, 'user_id')->hiddenInput(['value'=>$identity->getId()])->label(false) ?>

                <?= $form->field($model, 'parent_folder_access')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\frontend\models\ParentDocumentType::find()->all(),'id','title'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Parent Directory Access','multiple'=>true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>

                <?= $form->field($model, 'designation')->textInput() ?>

                <?= $form->field($model, 'file')->fileInput(['class'=>'form-control']) ?>

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
<?php
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


