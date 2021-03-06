<section class="content-header">
    <h1>Lihat Akun Instagram</h1>
    <ol class="breadcrumb">
        <li>
            <?php echo $this->Html->link('Daftar', ['controller' => 'Accounts', 'action' => 'index']); ?>
        </li>
        <li class="active">
            Lihat
        </li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <i class="fa fa-mobile"></i> <h3 class="box-title">Profil</h3>
                    <a href="/accounts/edit/<?php echo $account['id']; ?>" class="pull-right">
                        <i class="fa fa-pencil"> </i><span>Ubah</span>
                    </a>
                </div><!--/.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-1">
                            <div class="box box-widget widget-user-2">
                                <div class="widget-user-header bg-blue">
<?php if($pp) { ?>
                                    <div class="widget-user-image">
                                    <img class="img-circle" src="/files/images/profilepicture/<?php echo $account['id'] . '.jpg'; ?>">
                                    </div><!--/.widget-user-image -->
<?php } ?>
                                    <h3 class="widget-user-username"><?php echo $account['fullname']; ?></h3>
                                    <h5 class="widget-user-desc"><?php echo $account['description']; ?></h5>
                                </div><!--/.widget-user-header -->
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-stacked">
                                        <li><a href="#">Posts<span class="pull-right badge bg-aqua"><?php echo $account['contents']; ?></span></a></li>
                                        <li><a href="#">Followers<span class="pull-right badge bg-aqua"><?php echo $account['followers']; ?></span></a></li>
                                        <li><a href="#">Followings<span class="pull-right badge bg-aqua"><?php echo $account['followings']; ?></span></a></li>
                                    </ul><!--/.nav -->
                                </div><!--/.box-footer -->
                            </div><!--/.box-widget -->
                        </div><!--/.col-md-4 -->
                        <div class="col-md-4 col-md-offset-1">
                            <div class="box box-widget widget-user-2">
                                <div class="widget-user-header bg-blue">
                                    <h3 class="widget-user-username">Setup</h3>
                                </div><!--/.widget-user-header -->
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-stacked">
                                        <li><a href="#">Maksimum Like/Comment per Hari<span class="pull-right badge bg-aqua"><?php echo $account['preferences'][0]['maxlikeperday']; ?></span></a></li>
                                        <li><a href="#">Maksimum Follow per Hari<span class="pull-right badge bg-aqua"><?php echo $account['preferences'][0]['maxfollowperday']; ?></span></a></li>
                                        <li><a href="#">Follow Berdasarkan Hashtag<span class="pull-right badge bg-aqua"><?php echo ($account['preferences'][0]['followbyhashtag']) ? 'Ya' : 'Tidak'; ?></span></a></li>
<?php if ($account['preferences'][0]['followbyhashtag']) { ?>
<li><a href="#" class="pull-right">
<?php
for ($i=0;$i<count($hashtaglists);$i++) {
    echo $hashtaglists[$i]['caption'];
    if ($i<(count($hashtaglists)-1)) echo ', ';
}
?>
</a></li>
<?php } ?>
                                    </ul><!--/.nav -->
                                </div><!--/.box-footer -->
                            </div><!--/.box-widget -->
                        </div><!--/.col-md-4 -->
                    </div><!--/.row -->
                </div><!--/.box-body -->
            </div><!--/.box -->
        </div><!--/.col-xs-12 -->
    </div><!--/.row -->
</section>
