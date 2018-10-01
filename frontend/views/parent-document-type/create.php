<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ParentDocumentType */

$this->title = 'Create Parent Document Type';
$this->params['breadcrumbs'][] = ['label' => 'Parent Document Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parent-document-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
