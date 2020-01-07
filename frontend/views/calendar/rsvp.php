<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Calendar */

$this->title = 'EVENT RSVP';
$this->params['breadcrumbs'][] = ['label' => 'Calendars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-view">

    <h1><?= Html::encode($this->title) ?></h1>

   

   <table class="table">
            <thead>
                <td>Attendee</td>
                <td>Event</td>
                <td>RSVP</td>
                <td>RSVP Date</td>
            </thead>
            <tbody>
                <?php foreach($rsvps as $rsvp): ?>
                <tr>
                    <td><?= $rsvp->profile->first_name.' '.$rsvp->profile->last_name ?></td>
                    <td><?= $rsvp->event->event ?></td>
                    <td><?= $rsvp->rsvp->RSVPStatus ?></td>
                    <td><?= $rsvp->rsvp->CreatedAt ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
   </table>

</div>
