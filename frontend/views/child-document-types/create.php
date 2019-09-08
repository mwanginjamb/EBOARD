<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ChildDocumentTypes */

$this->title = 'Create Child Document Types';
$this->params['breadcrumbs'][] = ['label' => 'Child Document Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="child-document-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        
    ]) ?>

</div>
