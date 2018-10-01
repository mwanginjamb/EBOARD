<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ParentDocumentType */

$this->title = 'Update Parent Document Type: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Parent Document Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parent-document-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
