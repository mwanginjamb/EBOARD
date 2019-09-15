<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\RSVP */

$this->title = 'Create Rsvp';
$this->params['breadcrumbs'][] = ['label' => 'Rsvps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rsvp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
