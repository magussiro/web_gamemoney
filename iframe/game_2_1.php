<?php
//var_dump($_SESSION['member_point']);
//var_dump($_COOKIE['member_point']);
//var_dump($_COOKIE['member_account']);
$frame_value = $_GET['key'];
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
  // $(function(){
  //   setIframeSize();
  //   function setIframeSize() {
  //     var height = window.innerHeight - 130 + "px";
  //     $("#iframe2").css({ "height" : height});
  //   }
  //   window.addEventListener("resize", setIframeSize);
  // })    function isVideoInFullscreen() {
    function isVideoInFullscreen2() {
    if (document.webkitFullscreenElement && document.webkitFullscreenElement.nodeName == 'DIV') {
        console.log('Your game is playing in fullscreen');
        $("#jpot2").load("iframe/JpotDataiframe.php");
        $("#jpot2").css("display","inline-block");
        $("#quitfull2").show();
        $("#enterFullScreen2").hide();
        $("#iframe2").css({"padding-top":"0","height":"89%"});
    }else{
        console.log('Your game isn\'t playing in fullscreen');
        $("#jpot2").empty();
        $("#jpot2").hide();
        $("#quitfull2").hide();
        $("#enterFullScreen2").show();
        $("#iframe2").css({"padding-top":"35px","height":"100%"});
    }
  }
    // 進入全螢幕(需要被全螢幕的DOM元素)  
    function launchFullScreen(elm) {  
      // 檢測瀏覽器基本
      var element = document.getElementById(elm);
      if(element.requestFullScreen) {  
        element.requestFullScreen();  
      } else if(element.mozRequestFullScreen) {  
        // 其次，檢測Mozilla的方法  
        element.mozRequestFullScreen();  
      } else if(element.webkitRequestFullScreen) {  
        // if 檢測 webkit的API  
        element.webkitRequestFullScreen();
      } 
    };  
    // 退出全螢幕,不用管是哪個元素，因爲螢幕是唯一的。
    function cancelFullscreen() {  
      if(document.cancelFullScreen) {  
        document.cancelFullScreen();  
      } else if(document.mozCancelFullScreen) {  
        document.mozCancelFullScreen();
      } else if(document.webkitCancelFullScreen) {  
        document.webkitCancelFullScreen();  
      }  
    };  
    // 設定事件監聽，DOM内容Load完成，和jQuery的$.ready() 效果差不多
    window.addEventListener("DOMContentLoaded", function() {  
        // 取得DOM元素  
        var enterFullScreen = document.getElementById("enterFullScreen2");  
        var quitfull = document.getElementById("quitfull2");  
 
        quitfull.addEventListener("click", function() {  
            //   
            cancelFullscreen();  
        });  
  
    }, false);  
    // 進入全螢幕的Event
    document.addEventListener("webkitfullscreenchange", function(e) {
      isVideoInFullscreen2();
    });
</script>
<div id="warp2" style="background-color: black;height:100%;">
  <div id="enterFullScreen2" class="enterFullScreen" onclick="launchFullScreen('warp2')">顯示全螢幕</div>
  <div id="quitfull2" class="quitfull" onclick="cancelFullscreen()">離開全螢幕</div>
  <!--<div id="jpot2" class="jpot"></div>-->
  <div class="closeGame2">關閉遊戲</div>
	<iframe id="iframe2" name="iframe2" style="width:100%;height:100%" src="<?php echo $win7pkwebgl; ?>index2.html?user=<?php echo $_COOKIE['member_account']; ?>&key=<?php echo $frame_value ?>" scrolling="NO"></iframe>
</div>