<?php
include(WEB_PATH . '/views/header.php');
?>
<form enctype="multipart/form-data" action="index.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="1300000" />
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>
<?php
include(WEB_PATH . '/views/footer.php');
?>
