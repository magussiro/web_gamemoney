<?php
//var_dump($_SESSION['member_point']);
//var_dump($_COOKIE['member_point']);
//var_dump($_COOKIE['member_account']);
include_once '../lib/config.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
//$(function(){
//    $('#iframe1').ready(function(){
//        var $iframe = $(this),
//            $contents = $iframe.contents();
//
//            console.log($contents.find("#btn3").val());
//        });
//
//
//});

</script>
<iframe id="iframe1" name="iframe1" style="width:100%;height:800px" src="<?php echo $webglroot; ?>index.html?user=<?php echo $_COOKIE['member_account']; ?>" scrolling="NO"></iframe>

