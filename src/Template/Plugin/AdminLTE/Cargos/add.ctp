<style>
.bar {
    height: 18px;
    background: green;
}
</style>

<?php
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->JqueryFileUpload->loadCss();
?>

<section class="content-header">
    <h1>Tambah Konten</h1>
    <ol class="breadcrumb">
        <li>
            Post
        </li>
        <li class="active">
            Tambah
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
                    <div class="dt-bootstrap">
                    <?php echo $this->Form->create('Cargos.add', ['id' => 'addForm', 'data-toggle' => 'validator']); ?>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <?php echo $this->Form->select('account_id', $accounts, ['class' => 'form-control', 'id' => 'accountId', 'required' => 'true']); ?>
                            </div><!--/.input-group -->
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
                            <label class="pull-right">Unggah File JPEG/PNG, Maksimum 10 File dengan besar maksimum masing-masing file 20MB</label>
                            <span class="btn btn-success fileinput-button ">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Pilih File</span>
                                <input id ="fileupload" type="file" name="files[]" multiple>
                            </span>
                            <div id="progress" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="bar" style="width: 0%;"></div>
                            </div><!--/.progress -->
                            <div id="uploadFileNameDisplay">
                                <ul class="products-list products-list-in-box" id="productList">
                                <ul>
                            </div>
                        </div><!--/.form-group -->

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <?php echo $this->Form->text('scheduleShow', ['class' => 'form-control', 'id' => 'scheduleShow', 'required' => 'false', 'placeholder' => 'Jadwal upload', 'required' => 'required', 'data-required-error' => 'Harus diisi']); ?>
                                <?php echo $this->Form->hidden('schedule', ['id' => 'schedule']);?>
                                <?php echo $this->Form->hidden('reaps', ['id' => 'reaps', 'required' => 'true', 'data-required-error' => 'Pilih Minimal Satu File']); ?>
                            </div><!--/.input-group -->
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
                            <?php echo $this->Form->textarea('caption', ['placeholder' => 'Caption, dapat dikosongkan', 'class' => 'form-control', 'id' => 'caption', 'required' => 'false']); ?>
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
<?php echo $this->Form->submit('Tambah', ['class' => 'btn btn-primary btn-block']); ?>
                        </div><!--/. form-group -->
                    </div><!--/.dt-bootstrap -->
                </div><!--/.box-body -->
            </div><!--/.box -->
        </div><!--/.col-xs-12 -->
    </div><!--/.row -->
</section>

<div id="modalWarning" class="modal modal-warning fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hiddent="True">x</span></button>
                <h4 class="modal-title">Perhatian</h4>
            </div><!--/.modal-header -->
            <div class="modal-body">
                <p>Pilih minimal satu file</p>
            </div><!--/.modal-body -->
            <div class="modal-footer">
                <button class="btn btn-outline pull-right" type="button" data-dismiss="modal">Tutup</button>
            </div><!--/.modal-footer -->
        </div><!--/.modal-content -->
    </div><!--/.modal-dialog -->
</div><!--/.modalWarning -->
<?php
echo $this->Html->script('bootstrap-datetimepicker.min');

echo $this->JqueryFileUpload->loadScripts();
?>
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
    //console.log($('#schedule').val());
    //console.log(reaps);
});

var reaps = [];
$('#fileupload').fileupload({
    limitMultiFileUploads: 2,
    maxNumberOfFiles: 2,
    url: '/cargos/upload',
    dataType: 'json',
    done: function (e, data) {
        $.each(data.result.files, function (index, file) {
            let li = '<li class="item"><div class="product-img">';
            li = li + '<img src="' + file.thumbnailUrl + '">';
            li = li + '</div><div class="product-info">';
            li = li + '<span class="product-description">' + file.name + '</span>';
            li = li + '</div></li>';
            $('#productList').append(li);

            reaps.push(file.name);
        });
        $('#progress .bar').css('width', '0%');
    },
    progressall: function (e, data) {
        let progress = parseInt(data.loaded/data.total*100, 10);
        $('#progress .bar').css(
            'width',
            progress + '%'
        );
    },
    option: {
        acceptFileTypes: /(\.|\/)(jpe?g|png)$/i,
        maxFileSize: 20000000,
        maxNumberOfFiles: 2
    }
});

$('#addForm').submit(function() {
    $('#reaps').val(reaps.toString());
    if ($('#reaps').val() == '') {
        $('#modalWarning').modal();
        return false;
    }
});
});
</script>
