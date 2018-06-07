<section class="content-header">
    <h1>Hapus Akun Instagram</h1>
    <ol class="breadcrumb">
        <li>
            Akun
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
                <div class="box-header with-border">
                    <?php echo $this->Html->link('Daftar Akun', ['controller' => 'Accounts', 'action' => 'index']); ?>
                </div><!--/.box-header -->
                <div class="box-body">
                    <div class="dt-bootstrap">
                    <?php
echo $this->Form->create('Accounts.delete', ['id' => 'addForm', 'data-toggle' => 'validator']);

echo $this->Form->hidden('id', ['value' => $account['id']]);
                    ?>
                        <p style="font-weight: 400">Yakin akan menghapus akun <strong><?php echo $account['username']; ?></strong> (<?php echo $account['fullname']; ?>)?</p>

                        <div class="form-group">
<?php echo $this->Form->submit('Hapus', ['class' => 'btn btn-primary btn-block']); ?>
                        </div><!--/. form-group -->
                    </div><!--/.form-inline -->
                </div><!--/.box-body -->
            </div><!--/.box -->
        </div><!--/.col-xs-12 -->
    </div><!--/.row -->
</section>
