<section class="content-header">
    <h1>Konten akan di-Post</h1>
    <ol class="breadcrumb">
        <li class="active">Konten</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with border">
                    <?php echo $this->Html->link('Tambah Konten', ['controller' => 'Cargos', 'action' => 'add']); ?>
                </div><!--/.box-header -->
                <div class="box-body">
                    <?php if (count($cargos) < 1) { ?>
                        <p style="font-weight: 400">Belum ada konten.</p>
                    <?php } else { ?>
                        <?php print_r($cargos); ?>
                    <?php } ?>
                </div><!--/.box-body -->
            </div><!--/.box -->
        </div><!--/.col-xs-12 -->
    </div><!--/.row -->
</section>
