<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\title */

$this->title = 'Create Title';
$this->params['breadcrumbs'][] = ['label' => 'Titles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
