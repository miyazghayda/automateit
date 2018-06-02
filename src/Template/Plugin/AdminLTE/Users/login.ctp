<?php echo $this->Form->create('Users.login', ['id' => 'loginForm', 'data-toggle' => 'validator']); ?>

<div class="form-group">
    <?php echo $this->Form->text('username', ['placeholder' => 'Username', 'class' => 'form-control', 'id' => 'username', 'required' => 'true', 'data-required-error' => 'Harus diisi']); ?>
    <span class="help-block with-errors">
</div>

<div class="form-group">
<?php echo $this->Form->password('password', ['placeholder' => 'Password', 'class' => 'form-control', 'required' => 'true', 'data-required-error' => 'Harus diisi']); ?>
    <span class="help-block with-errors">
</div>

<div class="form-group">
<?php echo $this->Form->submit('Login', ['class' => 'btn btn-primary btn-block']); ?>
</div>

<?php echo $this->Form->end(); ?>
