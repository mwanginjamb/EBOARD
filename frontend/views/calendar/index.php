<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

Modal::begin([
    'header' => 'E-BOARD CALENDAR SETUP',
    'size' => 'sm',
    'options' => [
        'id' => 'eboard-modal',
        'tabindex' => false // important for Select2 to work properly
    ],
]);
echo "<div id='eboard-modal-content'></div>";
Modal::end();

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CalendarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ERC Events Calendar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Calendar Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'event:ntext',
            'scheduled_date',
            'start_time',
            'end_time',
            'venue',
            //'status',
            //'created_at',
            //'updated_at',
            //'creator',
            //'creatorDesignation',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php
    //Events Timeline
    echo '<ul class="timeline">';
    foreach ($events as $e){



        //format date
        $date = date('Y M d', strtotime($e['scheduled_date']));


        echo ' <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-yellow">
            '.$date.'
        </span>
    </li>
     <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-bell-o bg-green"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i>End Time&nbsp;&nbsp;'.formatTime($e['end_time']).' </span> 
            <span class="time"><i class="fa fa-bell-o"></i>Start Time &nbsp;&nbsp;'.formatTime($e['start_time']).' </span>
             
        
            <span>'.
                     Html::a('', ['update','id'=>$e['id']], ['class' => ' btn update-event fa fa-edit','title'=>'Update Event']) ;
            echo '</span>
            <h3 class="timeline-header"><a href="#">'.$e['event'].'</a></h3>

            <div class="timeline-body">
               
            </div>

            <div class="timeline-footer">
                <a class="btn btn-warning btn-xs"><strong>Venue:</strong> '.$e['venue']['venue'].'</a>
                <span class="time" class="pull-right bg-danger"> <i class="fa fa-clock-o "></i>Happens in : '.calcto($e['scheduled_date']).'</span>

            </div>
        </div>
    </li>
    <!-- END timeline item -->';

    }
    echo '</ul>';
    //format time
    function formatTime($time){
        if(strpos($time,'.')) {
            list($t, $z) = explode('.', $time);
            $time = $t . ' Hrs';
        }
        $time = $time;
        return $time;
    }
    function calcto($date){
        $sdate = date('Y-m-d', strtotime($date));
        $now = date('Y-m-d');

        $initial = date_create($sdate);
        $curr = date_create($now);
        $diff=date_diff($curr,$initial);
        return $diff->format("%R%a days");
    }
    ?>
</div>
<?php

$script = <<<JS
    $('.update-event').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $('#eboard-modal').modal('show')
                        .find('#eboard-modal-content')
                        .load(url);    
    });
    
/*Handle dismissal eveent of modal */
    $('#eboard-modal').on('hidden.bs.modal',function(){
                var reld = location.reload(true);
                setTimeout(reld,1000);
    });

JS;

$this->registerJs($script);

?>

