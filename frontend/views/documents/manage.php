<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Documents */

$this->title = 'File Manager';
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
<div class="documents-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success box-solid collapsed-box">
                <div class="box-header with-border">
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="box-title">Archived Files</span>
                    <div class="pull-left">
                        <i class="fa fa-folder-open-o"></i>
                    </div>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>

                </div><!--end header-->
                <div class="box-body">
                    <?php
                        if(count($archived)){
                            echo '<table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%">Document Name</th>
                                                                <th>Size</th>
                                                                <th>Type</th>
                                                                <th>Date Uploaded</th>
                                                                <th>Created By</th>
                                                                <th colspan="4">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
                            foreach($archived as $d){

                                $title = wordwrap($d['title'],25,"\n",TRUE);
                                $size = number_format(($d['size']/1024));
                                print '<tr>
                                                              <td><a class="view-doc" target="_blank" href="/site/viewdoc?path='.$d['path'].'&title='.$d['title'].'" rel="'.$d['title'].'" title="View / Read Document"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;'.$title.'</a></td> 
                                                               <td>'.$size.' Kb</td>
                                                               
                                                               <td>'.$d['document_type'].'</td> 
                                                               <td>'.$d['created_at'].'</td> 
                                                               <td>'.ucwords($d['created_by']).'</td> 
                                                               <td><a class="restore-doc" target="_blank" href="/documents/update" rel="'.$d['id'].'" title="Restore"><i class="fa fa-window-restore"></i></a></td>
                                                               <td><a class="arc-doc" href="javascript:void()" title="Hide Document" rel="'.$d['id'].'"><i class="fa fa-archive"></i></i></a></td>
                                                               <td><a class="update-doc" href="/documents/update?id='.$d['id'].'" title="Update Document" rel="'.$d['id'].'"><i class="fa fa-pencil-square-o"></i></i></a></td>

                                                               <td><a class="del-doc" href="/documents/delete?id='.$d['id'].'" title="Delete Document" rel="'.$d['id'].'"><i class="fa fa-trash-o"></i></i></a></td>
                                                            </tr>';
                            }
                            echo '</tbody>
                                </table>';
                        }else{
                            echo '<p class="alert alert-info">There are no archived files.</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success box-solid collapsed-box">
                <div class="box-header with-border">
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="box-title">Manage Active Files</span>
                    <div class="pull-left">
                        <i class="fa fa-folder-open-o"></i>
                    </div>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>

                </div><!--end header-->
                <div class="box-body">
                    <?php
                    if(count($documents)){
                        echo '<table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th width="">Document Name</th>
                                                                <th width="">Size</th>
                                                                <th width="">Parent Folder</th>
                                                                <th width="">Sub-Folder</th>
                                                                <th width="">Type</th>
                                                                <th width="">Date Uploaded</th>
                                                                <th width="">Created By</th>
                                                                <th width="" colspan="4">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
                        foreach($documents as $d){
                            $opstyle = '';
                            if(!$d['childDocument']['title']){
                                $opstyle = 'class="bg-yellow"';
                            }
                            $title = wordwrap($d['title'],5,"\n",TRUE);
                            $size = number_format(($d['size']/1024));
                            print '<tr>
                                                              <td><a class="view-doc" target="_blank" href="/site/viewdoc?path='.$d['path'].'&title='.$d['title'].'" rel="'.$d['title'].'" title="View / Read Document"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;'.$title.'</a></td> 
                                                               <td>'.$size.' Kb</td> 
                                                               <td>'.($d['parentDocument']['title']??'Not Set').'</td>
                                                                 <td '.$opstyle.'>'.($d['childDocument']['title']??'Not Set').'</td>
                                                               <td>'.$d['document_type'].'</td> 
                                                               <td>'.$d['created_at'].'</td> 
                                                               <td>'.ucwords($d['created_by']).'</td> 
                                                               <td><a class="view-doc" target="_blank" href="/site/viewdoc?path='.$d['path'].'&title='.$d['title'].'" rel="'.$d['title'].'" title="View / Read Document"><i class="fa fa-eye"></i></a></td>
                                                               <td><a class="arc-doc" href="javascript:void()" title="Hide Document" rel="'.$d['id'].'"><i class="fa fa-archive"></i></i></a></td>
                                                               <td><a class="update-doc" href="/documents/update?id='.$d['id'].'" title="Update Document" rel="'.$d['id'].'"><i class="fa fa-pencil-square-o"></i></i></a></td>

                                                               <!--<td><a class="del-doc" href="/documents/delete?id='.$d['id'].'" title="Delete Document" rel="'.$d['id'].'"><i class="fa fa-trash-o"></i></i></a></td>-->
                                                            </tr>';
                        }
                        echo '</tbody>
                                </table>';
                    }else{
                        echo '<p class="alert alert-info">There are no archived files.</p>';
                    }
                    ?>
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
    /*Update document - Need do an actual document Rename via php not just doc metadata*/
    $('.update-doc').on('click',function(e){
        e.preventDefault();
        var form = $(this).attr('href');
        $('#doc-modal').modal('show')
        .find('#doc-modal-content')
        .load(form);

    });
    //Restore Doc
     $('.restore-doc').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var doc_id = $(this).attr('rel');
        var action = 'restore';
        $.get(url,{'id':doc_id,'action':action})
        .done(function(msg){

            $('#doc-modal').modal('show')
            .find('#doc-modal-content')
            .html(msg.note);

        });
        
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

