<?php echo $this->Html->css('bootstrap-tagsinput'); ?>
<style>
label {
    font-weight: 400;
}
.bootstrap-tagsinput {
    width: 100%;
}
.bootstrap-tagsinput input {
    width: 100%;
}
</style>
<section class="content-header">
    <h1>Ubah Akun Instagram</h1>
    <ol class="breadcrumb">
        <li>
            Akun
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
                    <?php echo $this->Html->link('Daftar', ['controller' => 'Accounts', 'action' => 'index']); ?>
                </div><!--/.box-header -->
                <div class="box-body">
                    <div class="dt-bootstrap">
                    <?php echo $this->Form->create('Accounts.edit', ['id' => 'addForm', 'data-toggle' => 'validator']); ?>

                        <div class="form-group">
                            <label>Username</label>
                            <?php echo $this->Form->text('username', ['placeholder' => 'Username Akun IG', 'value' => $account['username'], 'class' => 'form-control', 'id' => 'username', 'required' => 'true', 'data-required-error' => 'Harus diisi', 'disabled' => 'disabled']); ?>
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->


                        <div class="form-group">
                            <label>Password</label>
                            <?php echo $this->Form->text('password', ['placeholder' => 'Password Akun IG', 'value' => $account['password'], 'class' => 'form-control', 'id' => 'password', 'required' => 'true', 'data-required-error' => 'Harus diisi']); ?>
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
                            <label>Maksimum Follow per Hari, <a href="/documentation/faq#maxfollowperday" target="_blank">saran kami</a>. Gunakan <strong>0</strong> jika ingin menonaktifkan fitur ini.</label>
                            <?php echo $this->Form->text('maxfollowperday', ['placeholder' => 'Maksimum Follow per Hari', 'value' => $account['preferences'][0]['maxfollowperday'], 'class' => 'form-control', 'id' => 'maxfollowperday', 'required' => 'true', 'data-required-error' => 'Harus diisi']); ?>
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
                            <label>Maksimum Like/Comment per Hari, <a href="/documentation/faq#maxlikeperday" target="_blank">saran kami</a>. Gunakan <strong>0</strong> jika ingin menonaktifkan fitur ini.</label>
                            <?php echo $this->Form->text('maxlikeperday', ['placeholder' => 'Maksimum Like/Comment per Hari', 'value' => $account['preferences'][0]['maxlikeperday'], 'class' => 'form-control', 'id' => 'maxlikeperday', 'required' => 'true', 'data-required-error' => 'Harus diisi']); ?>
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
                            <label>Follow Berdasarkan Hashtag</label>
                            <br/>
                            <?php echo $this->Form->checkbox('followbyhashtagcheckbox', ['hiddenField' => false, 'id' => 'followbyhashtagcheckbox']); ?>
                            <?php echo $this->form->hidden('followbyhashtag', ['id' => 'followbyhashtag']); ?>
                        </div><!--/. form-group -->

                        <div class="form-group hashtag-follow">
                            <label>Hashtag di-Follow, tanpa <strong>#</strong>, pisahkan dengan koma.</label>
                            <?php echo $this->Form->text('hashtagtofollow', ['value' => $hashtagWhiteString, 'placeholder' => 'Akun IG yang mengirim foto/video dengan hashtag ini akan di-follow', 'id' => 'hashtagtofollow', 'class' => 'form-control', 'required' => 'false', 'data-required-error' => 'Harus diisi', 'data-role' => 'tagsinput']); ?>
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
<?php echo $this->Form->submit('Ubah', ['class' => 'btn btn-primary btn-block']); ?>
                        </div><!--/. form-group -->
                    </div><!--/.form-inline -->
                </div><!--/.box-body -->
            </div><!--/.box -->
        </div><!--/.col-xs-12 -->
    </div><!--/.row -->
</section>
<?php echo $this->Html->script('bootstrap-tagsinput.min'); ?>
<?php echo $this->Html->script('bootstrap-checkbox.min'); ?>
<script>
$(function() {
    $('#followbyhashtagcheckbox').checkboxpicker({
        offLabel: 'Tidak',
        onLabel: 'Ya'
}).on('change', function() {
    if($(this).prop('checked')) {
        $('#followbyhashtag').val(1);
        $('.hashtag-follow').show(1000);
        $('#hashtagtofollow').attr('required', 'true');
    } else {
        $('#followbyhashtag').val(0);
        $('.hashtag-follow').hide(1000);
        $('#hashtagtofollow').removeAttr('required');
    }
});

<?php if ($account['preferences'][0]['followbyhashtag']) { ?>
$('#followbyhashtag').val(1);
$('#followbyhashtagcheckbox').prop('checked', true);
$('#hashtagtofollow').attr('required', 'true');
//$('#addForm').validator('update');
<?php } else {?>
$('#followbyhashtag').val(0);
$('#followbyhashtagcheckbox').prop('checked', false);
$('.hashtag-follow').hide();
$('#hashtagtofollow').removeAttr('required');
<?php } ?>

$('#hashtagtofollow').on('change', function(){
    console.log($(this).val());
});

// To remove comma after label
$('#hashtagtofollow').on('itemAdded', function(event) {
    let $field = $(this).siblings('.bootstrap-tagsinput').find('input');
    setTimeout(function() {
        $field.val('');
    });
});
});
</script>
