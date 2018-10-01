<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'ERC Document Manager';
//use leandrogehlen\treegrid\TreeGrid;
use yii\bootstrap\Modal;

Modal::begin([
    'header' => 'E-Board Documents',
    //'id' => 'vendor-modal',
    'size' => 'sm',
    'options' => [
        'id' => 'doc-modal',
        'tabindex' => false // important for Select2 to work properly
    ],
]);
echo "<div id='doc-modal-content'></div>";
Modal::end();
?>
<div class="site-index">



    <div class="body-content">

        <div class="row">
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h2>Uploaded Documents</h2>
                    </div>

                     <div class="box-body">
                         <?php
                            foreach($parents as $p){
                                //print $p->title.'<br/>';
                                print '<div class="box box-solid box-success collapsed-box">
                                              <div class="box-header with-border  ">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;<span class="box-title">'.$p->title.'&nbsp;&nbsp;&nbsp;&nbsp;Size(&nbsp;&nbsp;'.\Yii::$app->files->cummulativesize($p->id).'&nbsp;&nbsp;) Kb</span>
                                                                <div class="pull-left">
                                                                    <i class="fa fa-folder-o"></i>
                                                                </div>
                                                                <div class="box-tools pull-right">                   
                                                                    <button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i>
                                                                    </button>
                                                                </div>
                                                </div>
                                                <div class="box-body">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Document Name</th>
                                                                <th>Size</th>
                                                                <th>Type</th>
                                                                <th>Date Uploaded</th>
                                                                <th>Created By</th>
                                                                <th colspan="4">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
                                                            $parent = $p->id;
                                                            $documents = \Yii::$app->files->parentfiles($parent);//my custom component

                                                foreach ($documents as $d){

                                                    //list($meta,$mime) = explode('/',$d['document_type']);
                                                    $size = number_format(($d['size']/1024));
                                                    print '<tr>
                                                              <td><a class="view-doc" target="_blank" href="/site/viewdoc?path='.$d['path'].'&title='.$d['title'].'" rel="'.$d['title'].'" title="View / Read Document"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;'.$d['title'].'</a></td> 
                                                               <td>'.$size.' Kb</td> 
                                                               <td>'.$d['document_type'].'</td> 
                                                               <td>'.$d['created_at'].'</td> 
                                                               <td>'.ucwords($d['created_by']).'</td> 
                                                               <td><a class="view-doc" target="_blank" href="/site/viewdoc?path='.$d['path'].'&title='.$d['title'].'" rel="'.$d['title'].'" title="View / Read Document"><i class="fa fa-eye"></i></a></td>
                                                               <td><a class="arc-doc" href="javascript:void()" title="Hide Document" rel="'.$d['id'].'"><i class="fa fa-archive"></i></i></a></td>
                                                               <td><a class="update-doc" href="/documents/update?id='.$d['id'].'" title="Update Document" rel="'.$d['id'].'"><i class="fa fa-pencil-square-o"></i></i></a></td>

                                                               <td><a class="del-doc" href="/documents/delete?id='.$d['id'].'" title="Delete Document" rel="'.$d['id'].'"><i class="fa fa-trash-o"></i></i></a></td>
                                                            </tr>';
                                                }
                                                        print '</tbody>
                                                    </table>
                                                </div>
                                        </div>';

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
    /*Handle dismissal eveent of modal */
    $('#doc-modal').on('hidden.bs.modal',function(){
                var reld = location.reload(true);
                setTimeout(reld,1000);
    });
});
JS;
$this->registerJs($script);
