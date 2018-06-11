<?php
use Cake\Core\Configure;

$file = Configure::read('Theme.folder'). DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'aside' . DS . 'sidebar-menu.ctp';
if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<ul class="sidebar-menu">
    <li class="header">FITUR</li>
    <li class="treeview">
        <a href="<?php echo $this->Url->build('/accounts'); ?>">
        <i class="fa fa-users"></i> <span>Akun</span>
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-camera-retro"></i>
            <span>Auto Post</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/cargos/queue'); ?>"><i class="fa fa-hourglass-2"></i> Konten akan di-Post</a></li>
            <li><a href="<?php echo $this->Url->build('/cargos/index'); ?>"><i class="fa fa-image"></i> Konten telah di-Post</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-user-plus"></i>
            <span>Auto Follow</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/followinglists/index'); ?>"><i class="fa fa-child"></i> Akun telah di-Follow</a></li>
        </ul>
    </li>
    <!--<li class="treeview">
        <a href="#">
            <i class="fa fa-thumbs-up"></i> <span>Auto Like/Comment</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/pages/forms/general'); ?>"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/forms/advanced'); ?>"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="<?php echo $this->Url->build('/pages/forms/editors'); ?>"><i class="fa fa-circle-o"></i> Editors</a></li>
        </ul>
    </li>--><!--/. treeview -->
    <li><a href="<?php echo $this->Url->build('/documentation/faq'); ?>"><i class="fa fa-question-circle"></i> <span>FAQ</span></a></li>
    <!--<li><a href="<?php echo $this->Url->build('/documentation/info'); ?>"><i class="fa fa-info"></i> <span>Informasi Sistem</span></a></li>-->
</ul>
<?php } ?>
