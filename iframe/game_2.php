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
  //     $("#iframe1").css({ "height" : height});
  //   }
  //   window.addEventListener("resize", setIframeSize);
  // })
    function isVideoInFullscreen() {
    if (document.webkitFullscreenElement && document.webkitFullscreenElement.nodeName == 'DIV') {
        console.log('Your game is playing in fullscreen');
        $("#jpot").load("iframe/JpotDataiframe.php");
        $("#jpot").css("display","inline-block");
        $("#quitfull").show();
        $("#enterFullScreen").hide();
       // $("#iframe1").css({"padding-top":"0","height":"89%"});
	   $("#iframe1").css({"padding-top":"0","height":"89%"});
    }else{
        console.log('Your game isn\'t playing in fullscreen');
        $("#jpot").empty();
        $("#jpot").hide();
        $("#quitfull").hide();
        $("#enterFullScreen").show();
        $("#iframe1").css({"padding-top":"35px","height":"100%"});
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
        var enterFullScreen = document.getElementById("enterFullScreen");  
        var quitfull = document.getElementById("quitfull");  
 
        quitfull.addEventListener("click", function() {  
            //   
            cancelFullscreen();  
        });  
  
    }, false);  
    // 進入全螢幕的Event
    document.addEventListener("webkitfullscreenchange", function(e) {
      isVideoInFullscreen();
    });
</script>
<div id="warp" style="background-color: black;height:100%;">
	<div id="enterFullScreen" class="enterFullScreen" onclick="launchFullScreen('warp')">顯示全螢幕</div>
	<div id="quitfull" class="quitfull" onclick="cancelFullscreen()">離開全螢幕</div>
	<div class="closeGame">關閉遊戲</div>
	
	<div  id="jpot" class="jpot" style="visibility:hidden"></div>
	<!--<div id="jpot" class="jpot"></div>-->
	<iframe id="iframe1" name="iframe1" style="width:100%;height:100%;padding-top:35px;" src="<?php echo $win7pkwebgl; ?>index.html?user=<?php echo $_COOKIE['member_account']; ?>&key=<?php echo $frame_value ?>" scrolling="NO"></iframe>
</div>
