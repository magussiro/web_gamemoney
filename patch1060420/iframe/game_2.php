<?php
//var_dump($_SESSION['member_point']);
//var_dump($_COOKIE['member_point']);
//var_dump($_COOKIE['member_account']);
include_once '../lib/config.php';
?>
<iframe id="iframe2" name="iframe2" style="width:100%;height:375px" src="<?php echo $webglroot; ?>index2.html?user=<?php echo $_COOKIE['member_account']; ?>" scrolling="NO"></iframe>
