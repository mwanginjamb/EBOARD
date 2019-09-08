<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use frontend\models\Venue;

/* @var $this yii\web\View */
/* @var $model frontend\models\Calendar */
/* @var $form yii\widgets\ActiveForm */
$identity = \Yii::$app->user->identity;

?>

<div class="calendar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'scheduled_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter Scheduled Event Date'],
        'pluginOptions' => [
            'format' => 'yyyy-m-d',
            'autoclose'=>true
        ]
    ]); ?>
    <div class="bootstrap-timepicker">
    <?= $form->field($model, 'start_time')->textInput(['type'=>'text','class'=>' form-control timepicker']) ?>
    </div>

    <div class="bootstrap-timepicker">
    <?= $form->field($model, 'end_time')->textInput(['type'=>'text','class'=>' form-control timepicker']) ?>
    </div>

    <?= $form->field($model, 'venue')->dropDownList(
        ArrayHelper::map(Venue::find()->all(),'id','venue'),
        ['prompt'=>'Select an Event Venue']
    ); ?>

    <?= $form->field($model, 'status')->dropDownList(['1'=>'Open','2'=>'closed','postponed']) ?>

    <?php //$form->field($model, 'created_at')->textInput() ?>

    <?php //$form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'creator')->hiddenInput(['value'=>$identity->username])->label(false) ?>

    <?= $form->field($model, 'creatorDesignation')->hiddenInput(['value'=>$identity->profile->designation])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<JS
//Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
JS;

$this->registerJs($script);

?>