<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Users';
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    .perm{
        overflow-x: scroll;
        width:90%;
        display: block;

    }
</style>
<div class="profile-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php


    print '<h1>User Permissions</h1>';

    //Define committes
    $committes = \frontend\models\ParentDocumentType::find()->all();
    $profiles = \frontend\models\Profile::find()->select(['first_name','user_id'])->all();
    $coms_no = count($committes);
    $i = $counter =  0;

    print '
    <div class="card">
        <div class="card-body">
    <table class="table table-striped perm">
    <tr>
            <th bgcolor="#7fffd4">Committes</th>';

            foreach($committes as $committe){
                ++$i;
                print '<th>
                            '.$committe->title.'
                        </th>';
                //if($i == 5) break;

            }
    print '</tr>';
                foreach($profiles as $p){
                    print '<tr>
                            <td>'.$p->first_name.'</td>';
                    foreach($committes as $committe){

                        $checked = isAssigned($p->user_id,$committe->id)?'checked':'';
                        print '<td><input type="checkbox"  class="assign" '.$checked.' rev="'.$checked.'" name="'.$committe->id.'" value="'.$p->user_id.'" /></td>';

                    }
                    print '</tr>';
                }



        print '
        </table>
        </div>
        </div>';


        $script = <<<JS
        $('.assign').on("click",function(){
            
            //checked = $(this).is('checked');
            var checked = $(this).attr('rev');
            //alert(checked);
            
            var committe = $(this).attr('name');
            var userId = $(this).val();
            
            if(checked == ''){
                $.post('assign/',{'user':userId,'committe':committe})
                .done(function(msg){
                    alert(msg.note);
                    console.log(msg.note);
                    setTimeout(function(){
                    location.reload();
                },500);
                });
            }
            else{
                 $.post('resign/',{'user':userId,'committe':committe})
                .done(function(msg){
                    alert(msg.note);
                    console.log(msg.note);
                    setTimeout(function(){
                    location.reload();
                },500);
                });
            }
            
            //alert('User:'+userId+' and comitte is :'+committe);
            
        });
JS;

        $this->registerJs($script);



        function isAssigned($userId,$CommitteId){
            $assigned = \frontend\models\Profile::find()->select('parent_folder_access')->where(['user_id'=>$userId])->one();

            $perm = $assigned->parent_folder_access;
            $p = [];
            if(strpos($perm,',')){
                $p = explode(',',$perm);

                $map = array_flip($p);
                return array_key_exists($CommitteId,$map)?1:'';

            }else{
               if($perm == $CommitteId ){
                   return 1;
               }
            }


        }
    ?>


    <!--<p>
        <?/*= Html::a('Create Profile', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->
    <h1><?= Html::encode($this->title) ?></h1>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        //'id',
        'user.username',
        'parent_folder_access',
        'designation',
        //'avatar',
        //'created_at',
        //'updated_at',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]);?>


</div>
