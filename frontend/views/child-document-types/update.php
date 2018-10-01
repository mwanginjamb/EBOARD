<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ChildDocumentTypes */

$this->title = 'Update Child Document Types: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Child Document Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="child-document-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
