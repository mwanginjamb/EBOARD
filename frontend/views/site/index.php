<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'ERC Document Manager';
//use leandrogehlen\treegrid\TreeGrid;
use yii\bootstrap\Modal;

Modal::begin([
    'header' => 'E-Board Documents',
    //'id' => 'vendor-modal',
    'size' => 'modal-lg',
    'options' => [
        'id' => 'doc-modal',
        'tabindex' => false // important for Select2 to work properly
    ],
]);
echo "<div id='doc-modal-content'></div>";
Modal::end();
$identity = \Yii::$app->user->identity;
?>
<div class="site-index">



    <div class="body-content">

        <div class="row">
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <div class="col-md-6">
                            <h3>Eboard Documents </h3>
                        </div>
                        <div class="col-md-6" style="padding-top:15px">
                            <?= ($identity->profile->designation == 'Administrator')? Html::a('<i class="fa fa-folder-open-o">&nbsp;</i>New Folder',['/parent-document-type/create'],[
                                'rel'=>'',
                                'rev'=>'',
                                'title'=>'Click to add a new Folder',
                                'class'=>'pull-right btn btn-warning new-folder','style'=>'margin-right:30px']):''; ?>
                        </div>
                    </div>

                     <div class="box-body">



                        <?php if (Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-info alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <h4><i class="icon fa fa-check"></i>Success!</h4>
                                <?= Yii::$app->session->getFlash('success') ?>
                            </div>
                    <?php endif; ?>



                         <?php
                            foreach($parents as $p){
                                //print $p->title.'<br/>';
                                print '<div class="box box-solid box-success collapsed-box">
                                              <div class="box-header with-border  ">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;<span class="box-title">'.ucwords($p->title).'&nbsp;&nbsp;&nbsp;&nbsp;Size(&nbsp;&nbsp;'.\Yii::$app->files->cummulativesize($p->id).'&nbsp;&nbsp;) Kb</span>
                                                                <div class="pull-left">
                                                                    <i class="fa fa-folder-o"></i>
                                                                </div>
                                                                <div class="box-tools pull-right">
                                                                        <button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i>
                                                                    </button>
                                                                    
                                                                </div>';

                                echo ($identity->profile->designation == 'Administrator')? Html::a('<i class="fa fa-folder-open-o">&nbsp;</i>New Subfolder',['child-document-types/create','folder'=>$p->id],['rel'=>$p->id,'rev'=>$p->title,'title'=>'Click to add a new sub-folder','class'=>'create-subfolder pull-right btn btn-default create-subfolder','style'=>'margin-right:30px']):'';

                                echo ($identity->profile->designation == 'Administrator')? Html::a('Send New Document Notification',['/site/notification'],['rel'=>$p->id,'rev'=>$p->title,'title'=>'Click to Email a new document upload notification to authorized members of this folder','class'=>'pull-right btn btn-default email-notification','style'=>'margin-right:30px']):'';


                                print'</div>
                                                <div class="box-body">
                                                    ';

                                $parent = $p->id;
                                $subfolders = \Yii::$app->files->Listsubfolders($parent);
                                if(count($subfolders)){foreach( $subfolders as $sub){
                                    print '<div class="box box-solid box-warning collapsed-box">
                                                <div class="box-header with-border">
                                                 &nbsp;&nbsp;&nbsp;&nbsp;<span class="box-title">'.ucwords($sub['title']).'&nbsp;&nbsp;&nbsp;&nbsp;Size(&nbsp;&nbsp;'.\Yii::$app->files->subfoldersize($sub['id']).'&nbsp;&nbsp;) Kb</span>
                                                                <div class="pull-left">
                                                                    <i class="fa fa-folder-open-o"></i>
                                                                </div>
                                                                <div class="box-tools pull-right"> ';
                                                                
                                                                 print ($identity->profile->designation == 'Administrator')? Html::a('<i class="fa fa-folder-open-o">&nbsp;</i>New Document',['documents/create','parent'=>$p->id,'subfolder'=>$sub['id']],['rel'=>$p->id,'rev'=>$sub['id'],'title'=>'Click to add a new Document','class'=>'create-doc pull-left btn btn-default create-subfolder','style'=>'margin-right:30px']):'';
                                                                
                                                                 print '<button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i>
                                                                    </button>
                                                                </div>
                                                                
                                                </div><!--end header-->
                                                <div class="box-body">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Document Name</th>
                                                                <th>Size</th>
                                                                <th>Parent Folder</th>
                                                                <th>Type</th>
                                                                <th>Date Uploaded</th>
                                                                <th>Created By</th>
                                                                <th colspan="4">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
                                    $documents = \Yii::$app->files->childfiles($sub['id']);//my custom component
//print '<pre>'; print_r($documents); exit;
                                    foreach ($documents as $d){

                                        //list($meta,$mime) = explode('/',$d['document_type']);
                                        $size = number_format(($d['size']/1024));
                                        print '<tr>
                                                              <td><a class="view-doc" target="_blank" href="/site/viewdoc?path='.$d['path'].'&title='.$d['title'].'" rel="'.$d['title'].'" title="View / Read Document"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;'.$d['title'].'</a></td> 
                                                               <td>'.$size.' Kb</td> 
                                                               <td>'.($d['parentDocument']['title']??'Not Set').'</td>
                                                               <td>'.$d['document_type'].'</td> 
                                                               <td>'.$d['created_at'].'</td> 
                                                               <td>'.ucwords($d['created_by']).'</td> 
                                                               <td><a class="view-doc" target="_blank" href="/site/viewdoc?path='.$d['path'].'&title='.$d['title'].'" rel="'.$d['title'].'" title="View / Read Document"><i class="fa fa-eye"></i></a></td>';


   if(!Yii::$app->user->isGuest && isset( $identity->profile->designation) && $identity->profile->designation === 'Administrator'):
                                                               print '<td><a class="arc-doc" href="javascript:void()" title="Hide Document" rel="'.$d['id'].'"><i class="fa fa-archive"></i></i></a></td>
                                                               <td><a class="update-doc" href="/documents/update?id='.$d['id'].'" title="Update Document" rel="'.$d['id'].'"><i class="fa fa-pencil-square-o"></i></i></a></td>

                                                               <td><a class="del-doc" href="/documents/delete?id='.$d['id'].'" title="Delete Document" rel="'.$d['id'].'"><i class="fa fa-trash-o"></i></i></a></td>';

endif;
                                                            print'</tr>';
                                    }
                                    print '</tbody>
                                                        </table>
                                                </div>
                                            </div>';
                                }}else{print 'Kindly organize files in subfolders';}


                                                        print '
                                                    </div><!--end subfolder box body -->
                                        </div><!--end subfolder box -->';

                            }
                         ?>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<?php
$script = <<<JS
$(function(){
    //alert('js working');
    /*Archive a document*/
    $('.arc-doc').on('click',function(e){
        e.preventDefault();        
        var doc_id = $(this).attr('rel');
        $.get('/site/archivedoc',{'id':doc_id})
        .done(function(msg){
            //if(msg.message == 1){
                        $('#doc-modal').modal('show')
                        .find('#doc-modal-content')
                        .html(msg.note); 
                 // } 
        });
        
    });
    /*Update document*/
    $('.update-doc').on('click',function(e){
         e.preventDefault();
         var form = $(this).attr('href');      
          $('#doc-modal').modal('show')
                        .find('#doc-modal-content')
                        .load(form);                    
           
    });
    /*delete a document*/
    $('.del-doc').on('click',function(e){
        e.preventDefault();        
        var doc_id = $(this).attr('rel');
        $.post('/documents/delete',{'id':doc_id})
        .done(function(msg){
           
                        $('#doc-modal').modal('show')
                        .find('#doc-modal-content')
                        .html(msg.note); 
                  
        });
        
    });


//create a new folder

    $('.new-folder').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        //alert(url);

        $('#doc-modal').modal('show')
                        .find('#doc-modal-content')
                        .load(url); 


        });

//create a subfolder--->create-subfolder



    $('.create-subfolder').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        //alert(url);

        $('#doc-modal').modal('show')
                        .find('#doc-modal-content')
                        .load(url); 


        });

//Create a Document--------------------------> create a folder


    $('.create-doc').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        //alert(url);

        $('#doc-modal').modal('show')
                        .find('#doc-modal-content')
                        .load(url); 


        });







    //send document upload notification
    
    $('.email-notification').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        //alert(url);
        var folder = $(this).attr('rel');
        var foldername = $(this).attr('rev');

        $.get('/site/notification',{'folder':folder,'foldername':foldername}).done(function(msg){
            alert(msg.note);
        });
    });




    
    /*Handle dismissal eveent of modal */
    $('#doc-modal').on('hidden.bs.modal',function(){
                var reld = location.reload(true);
                setTimeout(reld,1000);
    });
});
JS;
$this->registerJs($script);
