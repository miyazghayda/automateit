<?php echo $this->Html->css('jquery.bsPhotoGallery'); ?>
<style>
ul {
    padding: 0 0 0 0;
    margin: 0 0 0 0;
}

ul li {
    list-style: none;
    margin-bottom: 25px;
}

ul li img {
    cursor: pointer;
}
</style>
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
                <div class="box-header with-border">
                    <?php echo $this->Html->link('Tambah Konten', ['controller' => 'Cargos', 'action' => 'add']); ?>
                    <div class="col-xs-4 pull-right">

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <?php echo $this->Form->select('account_id', $accounts, ['class' => 'form-control', 'id' => 'accountId', 'default' => 0]); ?>
                            </div><!--/.input-group -->
                        </div><!--/. form-group -->

                    </div><!--/.col-xs-4 -->
                </div><!--/.box-header -->
                <div class="box-body">
                    <?php if (count($cargos) < 1) { ?>
                        <p style="font-weight: 400">Belum ada konten.</p>
                    <?php } else { ?>
                        <ul class="first">
                            <?php foreach($cargos as $cargo) { ?>
                            <li id="<?php echo $cargo['id']; ?>">
                            <img alt="<?php echo $cargo['caption']; ?>" src="<?php echo $imagePath . $cargo['reaps'][0]['id'] . '.' . $cargo['reaps'][0]['extension']; ?>">
                            <p class="text"><?php echo $this->Time->format($cargo['schedule'], 'dd-MM-yyyy HH:mm'); ?></p>
                            </li>
                            <?php } ?>
                        </ul><!--/.first -->
                    <?php } ?>
                </div><!--/.box-body -->
            </div><!--/.box -->
        </div><!--/.col-xs-12 -->
    </div><!--/.row -->
</section>

<?php echo $this->Html->script('jquery.bsPhotoGallery'); ?>
<script>
$(function() {
    $('ul.first').bsPhotoGallery({
        'classes': 'col-lg-2 col-md-4 col-sm-3 col-xs-4 col-xxs-12',
        'hasModal': true
    });

    $('li.bspHasModal').on('click', function(){
        let liId = $(this).attr('id');
        $('#bsp-view').attr('href', '/cargos/view/' + liId);
        $('#bsp-edit').attr('href', '/cargos/edit/' + liId);
        $('#bsp-delete').attr('href', '/cargos/delete/' + liId);
    });

    $('#accountId').on('change', function() {
        console.log($(this).val());
        window.location.replace('/cargos/index/' + $(this).val());
    });
});
</script>
