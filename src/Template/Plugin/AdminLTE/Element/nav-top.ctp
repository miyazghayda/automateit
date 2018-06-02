<?php
use Cake\Core\Configure;

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'nav-top.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <?php echo $this->Html->image('robot-waving-md.png', array('class' => 'user-image', 'alt' => 'User Image')); ?>
            <span class="hidden-xs"><?php echo $user['username']; ?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <?php echo $this->Html->image('robot-waving-md.png', array('class' => 'img-circle', 'alt' => 'User Image')); ?>

            <p>
                <?php echo $user['fullname']; ?>
                <small id="lastLogin"><?php echo $this->Time->format($user['lastlog'], 'yyyy-MM-dd'); ?></small>
            </p>
          </li>
          <!-- Menu Body -->
          <li class="user-body">
            <!--<div class="row">
              <div class="col-xs-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Friends</a>
              </div>
            </div>-->
            <!-- /.row -->
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
<!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
            </div>
            <div class="pull-right">
                <?php echo $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn btn-warning btn-flat']); ?>
            </div>
          </li>
        </ul>
      </li>
      <!-- Control Sidebar Toggle Button -->
      <li>
        <!--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
      </li>
    </ul>
  </div>
</nav>
<?php
}
?>
