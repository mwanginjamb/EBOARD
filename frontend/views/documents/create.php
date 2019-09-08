<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Documents */

$this->title = 'Upload  Documents';
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'parent'=>isset($parent)?$parent:'',
        'subfolder'=>isset($subfolder)?$subfolder:'',
    ]) ?>

</div>
