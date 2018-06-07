<section class="content-header">
    <h1>Tambah Akun Instagram</h1>
    <ol class="breadcrumb">
        <li>
            Akun
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
                    <?php echo $this->Html->link('Daftar', ['controller' => 'Accounts', 'action' => 'index']); ?>
                </div><!--/.box-header -->
                <div class="box-body">
                    <div class="dt-bootstrap">
                    <?php echo $this->Form->create('Accounts.add', ['id' => 'addForm', 'data-toggle' => 'validator']); ?>

                        <div class="form-group">
                            <?php echo $this->Form->text('username', ['placeholder' => 'Username Akun IG, diisi tanpa @, mis. miyazghayda', 'class' => 'form-control', 'id' => 'username', 'required' => 'true', 'data-required-error' => 'Harus diisi']); ?>
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
                            <?php echo $this->Form->text('password', ['placeholder' => 'Password Akun IG', 'class' => 'form-control', 'id' => 'password', 'required' => 'true', 'data-required-error' => 'Harus diisi']); ?>
                            <span class="help-block with-errors"></span>
                        </div><!--/. form-group -->

                        <div class="form-group">
<?php echo $this->Form->submit('Tambah', ['class' => 'btn btn-primary btn-block']); ?>
                        </div><!--/. form-group -->
                    </div><!--/.form-inline -->
                </div><!--/.box-body -->
            </div><!--/.box -->
        </div><!--/.col-xs-12 -->
    </div><!--/.row -->
</section>
