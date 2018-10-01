<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\DashboardAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;

DashboardAsset::register($this);

?>
<?php $this->beginPage();
$session = Yii::$app->session;
$identity=Yii::$app->user->identity;

Modal::begin([
    'header' => 'Switch Account Mode Dialogue',
    'id' => 'switch-modal',
    'size' => ''
]);
echo "<div id='modal-content'></div>";
Modal::end();

if(Yii::$app->user->isGuest){
    //echo 'not logged int';exit;
}
//$image = 'https://via.placeholder.com/160x160?text=user pic.';
if(!\Yii::$app->user->isGuest):
$image = is_file('./profile/'.$identity->profile->avatar)?'/profile/'.$identity->profile->avatar:'https://via.placeholder.com/160x160?text=user pic.';
endif;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">


    <header class="main-header">
        <!-- Logo -->
        <a href="/site/index" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>ERC E-Board</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">

                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->

                    <!-- Notifications: style can be found in dropdown.less -->

                    <!-- Tasks: style can be found in dropdown.less -->
                    <?php if(!\Yii::$app->user->isGuest): ?>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= $image ?>" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= ucwords($identity->username )?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?= $image ?>" class="img-circle" alt="User Image">

                                <p>
                                    <?= $identity->profile->designation ?>
                                    <small>Granted Access since : <?= $identity->profile->created_at ?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!--<li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </div>
                                <!-- /.row -->
                            <!--</li>-->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/profile/view?id=<?= $identity->profile->id ?>" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="/site/logout" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <!-- Control Sidebar Toggle Button -->

                </ul>

            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-laptop"></i>
                        <span>Admin Setups</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">

                        <li><?= Html::a('<i class="fa fa-folder-o"></i>&nbsp;&nbsp;Parent Folders',['/parent-document-type'],['target'=>'_blank']) ?></li>
                        <li><?= Html::a('<i class="fa fa-folder"></i>&nbsp;&nbsp;Sub-folders',['/child-document-types'],['target'=>'_blank']) ?></li>
                        <li><?= Html::a('<i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Upload Documents',['/documents/create'],['target'=>'_blank']) ?></li>
                        <li><?= Html::a('<i class="fa fa-users"></i>&nbsp;&nbsp;Manage Users',['/users'],['target'=>'_blank']) ?></li>
                        <li><?= Html::a('<i class="fa fa-users"></i>&nbsp;&nbsp;User Types',['/user-type'],['target'=>'_blank']) ?></li>


                    </ul>
                </li>
            </ul>
        </section>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <!--employee details here just a summary-->
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>

                <li><?= $this->params['breadcrumbs'][] = $this->title ; ?></li>


            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <?= $content ?>
        </section>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ERC E-Board <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
