<?php include_once('func/func_main_left.php');?>
<aside id="lt">
    <div>
        <h3 class="lt_h3">我的資訊</h3>
        <div id="lt_myInfo" class="lt_white_bg">
            <?php if($viewData['member']){?>
        
            <p>會員暱稱:<?php if($viewData['member']){ echo $viewData['member']['name'];}?> <span>(0)</span></p>
            <p>LV.1</p>
            <p><a href="">進入遊戲免費玩</a></p>
            <p>我的身分：<a href="">一般會員</a></p>
            <a href="member.php"><button type="button">帳號設定</button></a>
            <a href="login.php?m=logout"><button type="button">登出</button></a>
            <?php }else {?>

            <a href="login.php"><button type="button">登入</button></>
            <?php }?>
        </div>
    </div>
    <hr>
    <div>
        <h3 class="lt_h3">電腦典藏版</h3>
        <div id="lt_pc">
            <button type="button">點我下載</button>
            <p><a href="">典藏版安裝教學</a></p>
        </div>
    </div>
    <hr>
    <div>
        <h3 class="lt_h3">APP立即下載</h3>
        <div id="lt_app">
            <button type="button">老子儲值版APK</button>
            <p>儲值版包含完整儲值功能：線上購點、MyCard儲值、GASH、FunPay全家立即儲、辣椒卡、產包、序號儲值，台灣地區首次使用還可獲得老幣唷!立即掃描下載GO!</p>
            <img src="img/main_left_qrcode.png" alt="QR Code">
            <p><a href="">下載APK至PC</a></p>
            <button type="button">APK安裝教學</button>
            <button type="button">Google Play</button>
            <button type="button">App Store</button>
        </div>
    </div>
    <hr>
    <div>
        <h3 class="lt_h3">儲值購點</h3>
        <div>
            <button type="button">序號儲值</button>
            <button type="button">線上購點</button>
            <button type="button">超值包月</button>
        </div>
    </div>
    <hr>
    <div>
        <h3 class="lt_h3">卡別資訊</h3>
        <div id="lt_card" class="lt_white_bg">
            <p>7、8月累積儲值額</p>
            <p id="lt_card_type"><span id="lt_card_type_now">一般</span><span>普卡</span><span>銀卡</span></p>
            <p>
                <span id="lt_card_credit"></span>
                <span id="lt_slider"></span>
            </p>
            <p id="lt_card_credit_max"></p>
        </div>
    </div>
    <hr>
    <div>
        <button type="button">FB粉絲團</button>
    </div>
    <hr>
    <div id="lt_mtTime">
        <h3 class="lt_h3">全網站維護時間</h3>
        <div>
            <p><span class="lt_week">每週四</span><span class="lt_time">08:00 ~ 10:00</span></p>
        </div>
        <h3 class="lt_h3">視訊館維護時間</h3>
        <div>
            <p><span class="lt_week">每週一</span><span class="lt_time">11:20 ~ 12:30</span></p>
            <p><span class="lt_week">每週二~日</span><span class="lt_time">11:20 ~ 11:40</span></p>
        </div>
    </div>
</aside>