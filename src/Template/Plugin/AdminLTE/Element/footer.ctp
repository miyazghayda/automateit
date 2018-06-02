<?php
use Cake\Core\Configure;

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'footer.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2018 <a href="https://medium.com/miyazghayda">Miyaz Ghayda</a>.</strong> Keluhan/Saran silahkan melalui Akun Telegram <a href="https://t.me/miyazghayda" target="_blank">@miyazghyada</a>.
</footer>
<?php } ?>
