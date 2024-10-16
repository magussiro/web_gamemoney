<?php include_once("lib/config.php"); ?>
<?php include_once("func/func_game.php");
var_dump($_COOKIE);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>遊戲 | Game Money</title>
    <style type="text/css">
        body {
            opacity: 0;
            transition: opacity 0.5s;
        }
    </style>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/game.css">
    <!-- JS by Chris -->
    <script type="text/javascript" src="<?php echo $webroot; ?>/js/jquery.js"></script>

    <script>
        $(function() {

            $("#game_1").click(function () {
//                $("#main_game").load("iframe/game_1.php",function () {
                $("#main_game").load("iframe/game_1.php", function() {
                    $("#main_game").css("display", "block");
                    $("#main_hall").css("display", "none");
                    $("#main_func").css("display", "none");
                    $("#butLogout").css("display", "none");
                    $("#btn_leave").css("display", "inline-block");
                    $(".new_iframe").css("display", "inline-block");

                    $(window.frames['iframe1'].document).ready(function() {
                        var $iframe1 = $(this).find("#iframe1");

                        $(".new_iframe").click(function() {
                            $("#main_game").css("display", "inline-block");
                            $("#main_game").css({"height":"50%","width":"45%","margin":"0px 3.333%"});
//                            $("#main_game")
                            $iframe1.get(0).contentWindow.iframeCanvas();
                            $("#main_game2").load("iframe/game_2.php",function(){

                                $("#main_game2").css("display", "inline-block");
                                $("#main_game>#iframe1").css("height","375");


                            });

                        });

                    });


                });


            });


        });
        $(document).ready(function () {
            $('#butSend').click(function () {
                var inputMsg = $('#msg').val();
                var name = $('#pname').val();

                doSend(name + ':' + inputMsg);
                $('#msg').val('');
            });


            $("#msg").keypress(function (e) {
                code = (e.keyCode ? e.keyCode : e.which);
                if (code == 13) {
                    var inputMsg = $('#msg').val();
                    var name = $('#pname').val();

                    doSend(name + ':' + inputMsg);
                    $('#msg').val('');

                }
            });

            $('#butLogout').click(function () {
                if (confirm("確定要登出？")) {
                    $('#main_game').hide();
                    $('#iframe1').attr('src', '');
                    $('#main_text').show();
                    $(location).attr("href", "login.php?m=logout");
                }
            });
        setInterval(ajaxCall_JpotData, 1000);
        setInterval(ajaxCall_Marque, 5000);

        });


        var wsUri = "ws://60.250.122.220:8003";

        //建立web socket
        var ws = BuildWebSocket();

        function BuildWebSocket() {
            ws = new WebSocket(wsUri);
            ws.onopen = function (evt) {
                onOpen(evt)
            };
            ws.onclose = function (evt) {
                onClose(evt)
            };
            ws.onmessage = function (evt) {
                onMessage(evt)
            };
            ws.onerror = function (evt) {
                onError(evt)
            };
            return ws;
        }

        function onOpen(evt) {
            console.log('連線已建立');
            //ar token = QueryString('token');
            // writeToScreen("CONNECTED");
            //doSend('{"cmd":"login" ,"token":"' + token + '"}');
            //$('#loading').fadeOut("slow", function() {});
            //render(token);
            ws.send($('#pname').val() + ':剛剛進入聊天室');
        }


        function onClose(evt) {
            console.log('離線');
            //render('closed');
            //$('#loading').show();
            //ws =  BuildWebSocket() ;
            //writeToScreen("DISCONNECTED");
            //window.location = 'login';
            ws.send($('#pname').val() + ':剛剛離開聊天室');
        }

        function onError(evt) {
            //writeToScreen('ERROR: ' + evt.data);
        }

        function doSend(message) {
            //writeToScreen("SENT: " + message);
            ws.send(message);
        }

        //接收訊息
        function onMessage(evt) {
            //var obj = JSON.parse(evt.data);
            console.log(evt.data);
            var msg = evt.data;
            var arrMsg = msg.split(':');

            var html = '  <div class="rt1_cvst_div">';
            html += '<img src="img/game_rt_icon.png" alt="user_icon">';
            html += '<div>';
            html += '<p>' + arrMsg[0] + '</p>';
            html += '<p class="rt1_cvst_talk">' + arrMsg[1] + '</p>';
            html += '</div></div>';

            $('#rt1_mid').prepend(html);

        }

        //金礦彩金連線即時更新
        function ajaxCall_JpotData() {
            jQuery.ajax({
                  method: "GET",
                  url: "game.php?m=getJpotData",
                  cache: false,
                  datatype: "json",
                })

            .done(function( msg ) {
              var jsonObj = JSON.parse(msg);
                $.each(jsonObj,function(id,element){
                  var result = element.accumulation.replace(/\d+?(?=(?:\d{3})+$)/img, "$&,");
                  if ( result == "" ) {
                    window.open(location, '_self', '');
                  }
                  else {
                    $("#md_money_num"+id).html(result);
                  }
                  //console.log(result);
                });
              });
        }

        //跑馬燈即時更新
        function ajaxCall_Marque() {
            jQuery.ajax({
                  method: "GET",
                  url: "game.php?m=getMarque",
                  cache: false,
                  datatype: "json",
                })

            .done(function( msg ) {
              var jsonObj = JSON.parse(msg);
                $.each(jsonObj,function(id,element){
                  var result = element.msg;
                  $("#marquee"+id).html("【"+result+"】");
                });
              });
          }

    </script>
</head>

<body>
<input id="pname" type="hidden" value="<?php if (isset($viewData['member'])) {
    echo $viewData['member']['name'];
} ?>"/>

<main>
    <div id="left">
        <!-- <div id="lt_top" class="height_5p"> -->
        <div id="lt_top">
            <a href="index.php" id="logo"></a>
            <div class="marquee">
              <marquee>
              <?php
                for( $i=0 ; $i<10 ; $i++ ){
                  echo " <span id='marquee".$i."'></span>";
                }
              ?>
              </marquee>
            </div>
            <div id="func_btns">
                <button type="button" class="inline_mid green_btn"><i class="fa fa-volume-up"
                                                                      style="font-size:24px"></i></button>
                <button type="button" class="inline_mid green_btn"><i class="fa fa-arrows-alt"
                                                                      style="font-size:24px"></i></button>

                <button id="butLogout" type="button" class="inline_mid">登出</button>
                <button id="btn_leave" type="button" class="inline_mid" style="display: none;">離開</button>
            </div>
            <img src="img/game_rt_icon.png" alt=""
                 style="width: 50px;height: 50px;border-radius: 50%;vertical-align: middle;margin-left: 10px;">
        </div>
        <div id="lt_top_md_money">
            <ul id="md_money_ul" style="text-align: right; margin-left:45px;">  <!--width:90%;-->
            <?php
               for( $i=0 ; $i<4 ; $i++ ){
                echo "<li>JP".($i+1)."<span class='md_money_num' id='md_money_num".$i."'></span></li>";
               }
            ?>
            </ul>
        </div>
        <div class="new_iframe" style="display: none;"><p style="display:inline-block; margin: 1% 5% 2% 0px; line-height: 1.5em;">新增iframe</p></div>
        <div id="main_content">
            <div id="main_hall" class="height_100p">
                <div class="gameIconDiv_1">
                    <img id="game_1" src="img/BaseSymbol8.png" alt="" class="gameIconStyle_1">
                    <div class="gameIconNameStyle_1">西遊記</div>
                    <div class="gameIconTagStyle_1">攻略</div>
                </div>
                <!--  <div class="gameIconDiv_1">
                      <img src="img/game_icon1.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">水果吧</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img src="img/game_icon2.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">Vegas</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img src="img/game_icon3.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">超八</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img src="img/game_icon4.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">幸運鑽石</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img src="img/game_icon5.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">海洋世界</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img src="img/game_icon6.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">雷神</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img id="game_1" src="img/BaseSymbol8.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">西遊記</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img src="img/game_icon1.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">水果吧</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img src="img/game_icon2.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">Vegas</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img src="img/game_icon3.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">超八</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img src="img/game_icon4.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">幸運鑽石</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img src="img/game_icon5.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">海洋世界</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>
                  <div class="gameIconDiv_1">
                      <img src="img/game_icon6.png" alt="" class="gameIconStyle_1">
                      <div class="gameIconNameStyle_1">雷神</div>
                      <div class="gameIconTagStyle_1">攻略</div>
                  </div>-->
            </div>
            <div id="main_game" style="display: none;">

            </div>
            <div id="main_game2" style="display: none;height:50%;width:45%;">

            </div>
            <!-- <div id="main_text">
                    <div class="inline_top borderBasic width_10p height_100p">
                        <p>西遊記</p>
                        <a href="http://60.248.141.144/web/Slot_WebGL/index.html?user=<?php //echo $viewData['member']['account'];?>&mo=<?php //echo $viewData['member']['money'];?>" target="_blink">點擊進入</a>
                    </div>
                    <div class="inline_top borderBasic width_80p height_100p">
                        <div id="gameHall_A">
                            <div class="gameIconDiv_1 fontSize_0 floatLeft">
                                <div class="inline_bottom gameIconTagStyle_1">攻略</div>
                                <a href="http://60.248.141.144/web/Slot_WebGL/index.html?user=<?php //echo $viewData['member']['account'];?>&mo=<?php //echo $viewData['member']['money'];?>" target="_blink" class="inline_bottom gameIconStyle_1"><img src="img/BaseSymbol8.png"" alt=""></a>
                                <div class="gameIconNameStyle_1">西遊記</div>
                            </div>
                        </div>
                    </div>
                </div> -->
            <div id="main_func">
                <a class="nav_item" target="_blank" href="intro.php?tab=0">新手教學</a>
                <a class="nav_item" target="_blank" href="activity.php?tab=0">熱門活動</a>
                <a class="nav_item" target="_blank" href="point.php?tab=0">儲值購點</a>
                <a class="nav_item" target="_blank" href="point.php?tab=1">遊戲幣轉帳</a>
                <a class="nav_item" target="_blank" href="">虛擬寶箱</a>
                <!-- <button id="treasure_box_btn"></button>
                <button class="chip_btn" id="chip_btn_1">儲值</button>
                <button class="chip_btn" id="chip_btn_4">轉帳</button> -->
            </div>
        </div>

    </div>
    <div id="right">
        <div id="rightTabs">
            <ul>
                <li><a href="#rightTab1">即時動態</a></li>
                <li><a href="#rightTab2">聊天訊息</a></li>
                <li><a href="#rightTab3">好友列表</a></li>
                <!--                <li id="rightTab4"><a href="intro.php?tab=1">說明</a></li>-->
                <li><a href="rightTab4">說明</a></li>
            </ul>
            <!-- 即時動態 -->
            <div id="rightTab1">
                <div id="rt1_top" class="rt_top">
                    <div id="rt1_top1">
                        <select name="" id="rt1_channels">
                            <option value="rt1_channel1" data-channel="1">頻道1</option>
                            <option value="rt1_channel2" data-channel="2">頻道2</option>
                            <option value="rt1_channel3" data-channel="3">頻道3</option>
                        </select>
                        <button type="button" id="rt1_btn_player_list">玩家列表</button>
                    </div>
                    <div id="rt1_top2">
                        <h3>玩家列表</h3>
                        <button type="button" id="rt1_btn_back">回即時動態</button>
                    </div>
                </div>
                <div id="rt1_mid_and_btm">
                    <div id="rt1_mid1">
                        <div id="rt1_mid">
                        </div>
                        <div id="rt1_bottom">
                            <button type="button" id="face_btn"><img src="img/smiley_face_s.png" alt=""
                                                                     style="width: 25px;"></button>
                            <!-- <form action="" method="POST" onsubmit="return false;"> -->
                            <!-- <input type="text" value="" id="msg" > -->
                            <textarea name="" id="msg"></textarea>
                            <input type="button" id="butSend" value="傳送">
                            <!-- </form> -->
                        </div>
                    </div>
                    <div id="rt1_mid2" style="display: none;">
                        <form action="" class="searchForm">
                            <input type="search" placeholder="搜尋">
                        </form>
                        <div id="rt1_players">
                            <div class="rt1_player">
                                <img src="img/game_rt_icon.png" alt="Player Icon">
                                <p>玩家暱稱</p>
                                <button type="button">加好友</button>
                            </div>
                            <div class="rt1_player">
                                <img src="img/game_rt_icon.png" alt="Player Icon">
                                <p>玩家暱稱</p>
                                <button type="button">加好友</button>
                            </div>
                            <div class="rt1_player">
                                <img src="img/game_rt_icon.png" alt="Player Icon">
                                <p>玩家暱稱</p>
                                <button type="button">加好友</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 聊天訊息 -->
            <div id="rightTab2">
                <div class="rt_top">
                    <div id="rt2_top1">
                        <button type="button" id="rt2_btn_music">提示音效</button>
                        <button type="button" id="rt2_btn_group_list">群組列表</button>
                    </div>
                    <div id="rt2_top2">
                        <h3>群組列表</h3>
                        <button type="button" id="rt2_btn_back">回聊天訊息</button>
                    </div>
                </div>
                <form action="" class="searchForm">
                    <input type="search" placeholder="搜尋">
                </form>
                <div id="rt2_mid1">
                    <h4>官方服務（ 2 ）</h4>
                    <div class="rt2_msg_div">
                        <div class="rt2_msg_div1">
                            <img src="img/game_rt_icon2.png" alt="Player Icon 2" class="player_icon">
                            <div class="rt2_msg">
                                <p class="rt2_msg_name">客服中心</p>
                                <p class="rt2_msg_preview">XXXX</p>
                            </div>
                        </div>
                        <div class="rt2_msg_div2">
                            <p class="rt2_msg_time">上午 10:35</p>
                            <div class="rt2_msg_no">2</div>
                        </div>
                    </div>
                    <div class="rt2_msg_div" style="border-bottom: none;">
                        <div class="rt2_msg_div1">
                            <img src="img/game_rt_icon2.png" alt="Player Icon 2" class="player_icon">
                            <div class="rt2_msg">
                                <p class="rt2_msg_name">贈獎中心</p>
                                <p class="rt2_msg_preview">XXXX</p>
                            </div>
                        </div>
                        <div class="rt2_msg_div2">
                            <p class="rt2_msg_time">上午 10:35</p>
                            <div class="rt2_msg_no">2</div>
                        </div>
                    </div>
                    <h4>聊天（ 15 ）</h4>
                    <div id="rt2_msg_list">
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                        <div class="rt2_msg_div">
                            <div class="rt2_msg_div1">
                                <img src="img/game_rt_icon3.png" alt="Player Icon 3" class="player_icon">
                                <div class="rt2_msg">
                                    <p class="rt2_msg_name">XXX</p>
                                    <p class="rt2_msg_preview">XXXXXXXXXX</p>
                                </div>
                            </div>
                            <div class="rt2_msg_div2">
                                <p class="rt2_msg_time">上午 10:35</p>
                                <div class="rt2_msg_no">1</div>
                                <button type="button" class="rt2_msg_deleteBtn">刪除</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="rt2_mid2" style="display: none;">
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                    <div class="rt2_group_div">
                        <p>XXXXXXX<span>20人</span></p>
                    </div>
                </div>
            </div>
            <div id="rightTab3">
                <div class="rt_top">
                    <button type="button">聊　天</button>
                </div>
                <form action="" class="searchForm">
                    <input type="search" placeholder="搜尋">
                </form>
                <div id="rt3_mid1">
                    <div>
                        <p>還沒有好友嗎？</p>
                        <p>快去找朋友</p>
                        <button type="button" id="rt3_btn_goFindFriend">立即去</button>
                    </div>
                </div>
            </div>
            <div id="rightTab4">
                <div class="rt_top">
                    <button type="button">說明</button>
                </div>

                <div id="rt4_mid1">
                    <div>
                        <p>這裡是說明</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="js/jquery-3.1.0.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<!-- JS by Maicca -->
<script type="text/javascript">
    /* left */
    function setMainHallHeight() {
        document.getElementById("main_hall").style.height = window.innerHeight - 171 + "px";
    }

    window.addEventListener("load", setMainHallHeight);
    window.addEventListener("resize", setMainHallHeight);



    $("#btn_leave").click(function () {
        $("#main_game").empty();
        $("#main_game").css("display", "none");
        $("#main_hall").css("display", "block");
        $("#main_func").css("display", "block");
        $("#butLogout").css("display", "inline-block");
        $("#btn_leave").css("display", "none");
        $(".new_iframe").css("display", "none");
    });

    /* right */
    $("#rightTabs").tabs();

    $("#rightTabs #rightTab4 a").unbind('click');

    /* #rightTab1 START */

    function setRt1MidDefaultData() {
        $("#rt1_mid").load("php/game_channel_1.php", setRt1MidToBtm);
    }

    function setRt1MidToBtm() {
        $("#rt1_mid").scrollTop($("#rt1_mid")[0].scrollHeight);
    }
    window.addEventListener("load", setRt1MidDefaultData);

    function setRt1MidHeight() {
        var rt1_mid_height = window.innerHeight - 147 + "px";
        $("#rt1_mid").css("height", rt1_mid_height);
    }
    window.addEventListener("load", setRt1MidHeight);
    window.addEventListener("resize", setRt1MidHeight);

    function setRt1PlayersHeight() {
        var rt1_mid_height = window.innerHeight - 148 + "px";
        $("#rt1_players").css("height", rt1_mid_height);
    }
    window.addEventListener("load", setRt1PlayersHeight);
    window.addEventListener("resize", setRt1PlayersHeight);

    $("#rt1_channels").change(function () {
        if ($(this).val() == "rt1_channel2") {
            $("#rt1_mid").load("php/game_channel_2.php", setRt1MidToBtm);
        } else if ($(this).val() == "rt1_channel3") {
            $("#rt1_mid").load("php/game_channel_3.php", setRt1MidToBtm);
        } else {
            $("#rt1_mid").load("php/game_channel_1.php", setRt1MidToBtm);
        }
    });

    $("#rt1_btn_player_list").click(function () {
        $("#rt1_top2").css("display", "block");
        $("#rt1_top1").css("display", "none");

        $("#rt1_mid2").css("display", "block");
        $("#rt1_mid1").css("display", "none");
    });

    $("#rt1_btn_back").click(function () {
        $("#rt1_top1").css("display", "block");
        $("#rt1_top2").css("display", "none");

        $("#rt1_mid1").css("display", "block");
        $("#rt1_mid2").css("display", "none");
    });

    /* #rightTab1 END */

    /* #rightTab2 START */

    function setRt2MsgListHeight() {
        var rt2_msgList_height = window.innerHeight - 441 + "px";
        $("#rt2_msg_list").css("height", rt2_msgList_height);
    }
    window.addEventListener("load", setRt2MsgListHeight);
    window.addEventListener("resize", setRt2MsgListHeight);

    function setRt2Mid2Height() {
        var rt2_mid2_height = window.innerHeight - 148 + "px";
        $("#rt2_mid2").css("height", rt2_mid2_height);
    }
    window.addEventListener("load", setRt2Mid2Height);
    window.addEventListener("resize", setRt2Mid2Height);

    function setRt3Mid1Height() {
        var rt3_mid1_height = window.innerHeight - 148 + "px";
        $("#rt3_mid1").css("height", rt3_mid1_height);
    }
    window.addEventListener("load", setRt3Mid1Height);
    window.addEventListener("resize", setRt3Mid1Height);

    $("#rt2_btn_group_list").click(function () {
        $("#rt2_top2").css("display", "block");
        $("#rt2_top1").css("display", "none");

        $("#rt2_mid2").css("display", "block");
        $("#rt2_mid1").css("display", "none");
    });

    $("#rt2_btn_back").click(function () {
        $("#rt2_top1").css("display", "block");
        $("#rt2_top2").css("display", "none");

        $("#rt2_mid1").css("display", "block");
        $("#rt2_mid2").css("display", "none");
    });

    /* #rightTab2 END */

    /* #rightTab3 START */

    $("#rt3_btn_goFindFriend").click(function () {
        $("#rightTabs").tabs({active: 0});
        $("#rt1_btn_player_list").trigger("click");
    });

    /* #rightTab3 END */
</script>
<script type="text/javascript">
    window.onload = function () {
        $("body").css("opacity", "1");
    };
</script>
</body>

</html>
