<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RSVPStatus */

$this->title = 'Update Rsvpstatus: ' . $model->RSVPStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Rsvpstatuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->RSVPStatusID, 'url' => ['view', 'id' => $model->RSVPStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rsvpstatus-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
