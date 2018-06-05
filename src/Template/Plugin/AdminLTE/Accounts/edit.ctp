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
                <div class="box-header">
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
                            <label>Maksimum Follow per Hari, <a href="/documentation/faq#maxfollowperday" target="_blank">saran kami</a></label>
                            <?php echo $this->Form->text('maxfollowperday', ['placeholder' => 'Maksimum Follow per Hari', 'value' => $account['preferences'][0]['maxfollowperday'], 'class' => 'form-control', 'id' => 'maxfollowperday', 'required' => 'true', 'data-required-error' => 'Harus diisi']); ?>
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
                            <label>Maksimum Like/Comment per Hari, <a href="/documentation/faq#maxlikeperday" target="_blank">saran kami</a></label>
                            <?php echo $this->Form->text('maxlikeperday', ['placeholder' => 'Maksimum Like/Comment per Hari', 'value' => $account['preferences'][0]['maxlikeperday'], 'class' => 'form-control', 'id' => 'maxlikeperday', 'required' => 'true', 'data-required-error' => 'Harus diisi']); ?>
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
