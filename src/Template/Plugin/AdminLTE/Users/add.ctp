<?php echo $this->Form->create('Users.add', ['id' => 'addForm', 'data-toggle' => 'validator', 'role' => 'form']); ?>

<div class="form-group">
<?php echo $this->Form->text('username', [
    'placeholder' => 'Username',
    'class' => 'form-control',
    'id' => 'username',
    'required' => 'true',
    'data-required-error' => 'Harus diisi'
]); ?>
    <span class="help-block with-errors">
</div>

<div class="form-group">
<?php echo $this->Form->text('fullname', [
    'placeholder' => 'Nama Lengkap',
    'class' => 'form-control',
    'id' => 'fullname',
    'required' => 'true',
    'data-required-error' => 'Harus diisi'
]); ?>
    <span class="help-block with-errors">
</div>

<div class="form-group">
<?php echo $this->Form->email('email', [
    'placeholder' => 'Email',
    'class' => 'form-control',
    'id' => 'email',
    'required' => 'true',
    'data-error' => 'Harus diisi dengan format email yang benar'
]); ?>
    <span class="help-block with-errors">
</div>

<div class="form-group">
<?php echo $this->Form->password('password', [
    'placeholder' => 'Password',
    'class' => 'form-control',
    'id' => 'password',
    'required' => 'true',
    'data-required-error' => 'Harus diisi'
]); ?>
    <span class="help-block with-errors">
</div>

<div class="form-group">
<?php echo $this->Form->password('confirm', [
    'placeholder' => 'Password Lagi',
    'class' => 'form-control',
    'id' => 'confirm',
    'required' => 'true',
    'data-required-error' => 'Harus diisi',
    'data-match' => '#password',
    'data-match-error' => 'Password tidak sama'
]); ?>
    <span class="help-block with-errors">
</div>

<div class="form-group">
<?php echo $this->Form->submit('Daftar', ['class' => 'btn btn-primary btn-block']); ?>
</div>
