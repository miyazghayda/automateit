<section class="content-header">
    <h1>Daftar Akun Instagram</h1>
    <ol class="breadcrumb">
        <li class="active">
            Akun
        </li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <?php echo $this->Html->link('Tambah', ['controller' => 'Accounts', 'action' => 'add']); ?>
                </div><!--/.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php if (count($accounts) < 1) {?>
                                <h1>Belum terdapat data, <?php echo $this->Html->link('Tambah', ['controller' => 'Accounts', 'action' => 'add']); ?></h1>
                            <?php } else {?>
                            <table id="dataTable" class="table table-bordered table-striped dataTable" role="grid">
                                <thead>
                                    <tr>
                                        <td>Username</td>
                                        <td>Fullname</td>
                                        <td>Url</td>
                                        <!--<td>Keterangan</td>
                                        <td>Menu</td>-->
                                </thead>
                                <tbody>
                                    <?php foreach ($accounts as $account) { ?>
                                        <tr>
                                            <td><?php echo $account['member']['username']; ?></td>
                                            <td><?php echo $account['member']['fullname']; ?></td>
                                            <td><?php echo $this->Html->link('https://instagram.com/' . $account['member']['username'], 'https://instagram.com/' . $account['member']['username'], ['target' => '_blank']); ?></td>
                                            <!--<td><?php echo $account['note']; ?></td>
                                            <td>
                                                <a href="<?php echo $this->Url->build('/accounts/view/' . $account['id']); ?>">
                                                    <i class="fa fa-desktop"></i> <span>Lihat</span>
                                                </a>
                                                <a href="<?php echo $this->Url->build('/accounts/edit/' . $account['id']); ?>">
                                                    <i class="fa fa-pencil"></i> <span>Ubah</span>
                                                </a>
                                                <a href="<?php echo $this->Url->build('/accounts/delete/' . $account['id']); ?>">
                                                    <i class="fa fa-trash"></i> <span>Hapus</span>
                                                </a>
                                            </td>-->
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php }?>
                        </div><!--/.col-sm-12 -->
                    </div><!--/.row table body -->
                </div><!--/.box-body -->
            </div><!--/.box -->
        </div><!--/.col-xs-12 -->
    </div><!--/.row -->
</section>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
