<section class="content-header">
    <h1>Hapus Konten</h1>
    <ol class="breadcrumb">
        <li>
            Konten
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
                    <?php echo $this->Html->link('Daftar Konten akan di-Post', ['controller' => 'Cargos', 'action' => 'queue']); ?>
<?php if (!$cargo['uploaded']) { ?>
                    <a href="/cargos/edit/<?php echo $cargo['id']; ?>" class="pull-right">
                        <i class="fa fa-pencil"></i> <span>Ubah</span>
                    </a>
<?php } ?>
                </div><!--/.box-header -->
                <div class="box-body">

                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
<?php
$i = 0;
foreach($cargo['reaps'] as $reap) {
?>
                            <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>" class="<?php if($i==0) echo 'active';?>"></li>
<?php
    $i++;
}
?>
                        </ol><!--/.carousel-indicators -->

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
<?php
$i = 0;
foreach($cargo['reaps'] as $reap) {
?>
                            <div class="item <?php if($i==0) echo 'active'; ?>">
                                <img src="<?php echo $imagePath . $reap['id'] . '.' . $reap['extension']; ?>" alt="<?php echo $cargo['caption']; ?>">
                                <div class="carousel-caption"><?php echo $cargo['caption']; ?></div>
                            </div><!--/.item -->
<?php
    $i++;
}
?>
                        </div><!--/.carousel-inner -->

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div><!--/.carousel-example-generic -->

                    <div class="dt-bootstrap">
                        <blockquote>
                            <p style="font-weight: 400;"><?php echo $cargo['caption']; ?></p>
                            <small style="font-weight: 400;">
                                Akan diupload pada <span id="schedule" style="font-weight: 700;"><?php echo $this->Time->format($cargo['schedule'], 'dd-MM-yyyy HH:mm'); ?></span> oleh Akun <a href="/accounts/view/<?php echo $cargo['account']['id']; ?>"><?php echo $cargo['account']['username']; ?></a>.
                            </small>
                        </blockquote>
                    </div><!--/.dt-bootstrap -->
                </div><!--/.box-body -->
            </div><!--/.box -->
        </div><!--/.col-xs-12 -->
    </div><!--/.row -->
</section>
<script type="text/javascript">
$(document).ready(function() {
    console.log($('#schedule').text());
    $('#schedule').text(moment($('#schedule').text(), 'DD-MM-YYYY HH:mm').format("dddd, DD MMMM YYYY HH:mm"));
});
</script>
