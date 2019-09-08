<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Calendar */

$this->title = 'Create Calendar';
$this->params['breadcrumbs'][] = ['label' => 'Calendars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//print_r($model); exit();
?>
<div class="calendar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
