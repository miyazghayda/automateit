<section class="content-header">
    <h1>Hapus Konten</h1>
    <ol class="breadcrumb">
        <li>
            Konten
        </li>
        <li class="active">
            Hapus
        </li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-header">
                    <?php echo $this->Html->link('Daftar Konten akan di-Post', ['controller' => 'Cargos', 'action' => 'queue']); ?>
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
<?php
    echo $this->Form->create('Cargos.delete', ['id' => 'addForm', 'data-toggle' => 'validator']);

    echo $this->Form->hidden('id', ['value' => $cargo['id']]);
?>
                        <p style="font-weight: 400">Yakin akan menghapus konten dengan caption <strong><?php echo $cargo['caption']; ?></strong> di atas?</p>

                        <div class="form-group">
<?php echo $this->Form->submit('Hapus', ['class' => 'btn btn-primary btn-block']); ?>
                        </div><!--/. form-group -->
                    </div><!--/.form-inline -->
                </div><!--/.box-body -->
            </div><!--/.box -->
        </div><!--/.col-xs-12 -->
    </div><!--/.row -->
</section>
