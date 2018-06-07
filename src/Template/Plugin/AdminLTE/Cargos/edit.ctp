<?php echo $this->Html->css('bootstrap-datetimepicker.min'); ?>

<section class="content-header">
    <h1>Ubah Konten</h1>
    <ol class="breadcrumb">
        <li>
            Konten
        </li>
        <li class="active">
            Ubah
        </li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
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

                    <div class="dt-bootstrap" style="margin-top: 10px;">

                    <?php echo $this->Form->create('Cargos.edit', ['id' => 'addForm', 'data-toggle' => 'validator']); ?>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <?php echo $this->Form->select('account_id', $accounts, ['class' => 'form-control', 'id' => 'accountId', 'required' => 'true', 'default' => $cargo['account_id']]); ?>
                            </div><!--/.input-group -->
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <?php echo $this->Form->text('scheduleShow', ['class' => 'form-control', 'id' => 'scheduleShow', 'required' => 'false', 'placeholder' => 'Jadwal upload', 'required' => 'required', 'data-required-error' => 'Harus diisi', 'value' => $this->Time->format($cargo['schedule'], 'yyyy-MM-dd HH:mm')]); ?>
                                <?php echo $this->Form->hidden('schedule', ['id' => 'schedule', 'value' => $this->Time->format($cargo['schedule'], 'yyyy-MM-dd HH:mm')]);?>
                            </div><!--/.input-group -->
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
                            <?php echo $this->Form->textarea('caption', ['placeholder' => 'Caption, dapat dikosongkan', 'class' => 'form-control', 'id' => 'caption', 'required' => 'false', 'value' => $cargo['caption']]); ?>
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
<?php echo $this->Form->submit('Ubah', ['class' => 'btn btn-primary btn-block']); ?>
                        </div><!--/. form-group -->

                    </div><!--/.dt-bootstrap -->
                </div><!--/.box-body -->
            </div><!--/.box -->
        </div><!--/.col-xs-12 -->
    </div><!--/.row -->
</section>

<?php echo $this->Html->script('bootstrap-datetimepicker.min'); ?>
<script>
$(function() {
let schedule = $('#scheduleShow').datetimepicker({
    locale: 'id',
    sideBySide: true,
    format: 'YYYY-MM-DD HH:mm'
});

schedule.on('dp.change', function(e) {
    let scheduleTime = $('#scheduleShow').val() + ':00';
    if (scheduleTime == ':00') scheduleTime = '';
    $('#schedule').val(scheduleTime);
});
});
</script>
