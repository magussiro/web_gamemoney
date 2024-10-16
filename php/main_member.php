<?php
include('func/func_main_mid_member.php');
?>

<main id="md" class="big_white_block" style="min-height: 655px;">
    <h3>會員專區</h3>
    <div id="md_member">
        <ul class="white_bottom_line tab_level_1">
            <?php if (!isFblogin()) { ?>
                <li><a href="#md_member_tab1">帳號資訊修改</a></li>
                <li><a href="#md_member_tab3">密碼修改</a></li>
                <li><a href="#md_member_tab2">我的檔案</a></li>
                <li><a href="#md_member_tab4">我的卡別</a></li>
                <li><a href="#md_member_tab5">卡別優惠</a></li>
                <li><a href="#md_member_tab11"></a></li>
                <li><a href="#md_member_tab12"></a></li>
            <?php } else { ?>
                <li><a href="#md_member_tab1">帳號資訊</a></li>
                <li><a href="#md_member_tab2">我的檔案</a></li>
                <li><a href="#md_member_tab4">我的卡別</a></li>
                <li><a href="#md_member_tab5">卡別優惠</a></li>
                <li><a href="#md_member_tab11"></a></li>
                <li><a href="#md_member_tab12"></a></li>
            <?php } ?>
        </ul>


        <div id="md_member_tab1">
            <form action="member.php?m=nickname" method="POST">
                <label for="mbId">帳　　號：</label>
                <span style="height: auto"><?php echo $viewData['member']['account']; ?></span>
                <br>
                <input type="hidden" id="mbId" readonly value="<?php echo $viewData['member']['account']; ?>">
                <?php if (!isFblogin()) { ?>
                    <label for="mbNickname">暱　　稱：</label>
                    <input type="text" id="mbNickname" name="nick_name"
                           value="<?php echo $viewData['member']['name']; ?>">
                    <br>
                <?php } else { ?>


                    <label for="mbNickname">暱　　稱：</label>
                    <span style="height: auto"><?php echo $viewData['member']['name']; ?></span>
                    <br>
                    <?php
                }
                if (!isFblogin()) {
                    ?>
                    <input type="submit" value="儲存修改" class="save_btn">
                <?php } ?>
            </form>
        </div>

        <div id="md_member_tab2">
            <div id="md_mb_profile">
                <ul>
                    <li><a href="#md_mb_profile1">我的資料</a></li>
                    <li><a href="#md_mb_profile2">我的存摺</a></li>
                    <li><a href="#md_mb_profile3">我的好友</a></li>
                    <li><a href="#md_mb_profile4">遊戲紀錄</a></li>
                    <?php
                    if (!isFblogin()) {
                        ?>
                        <li><a href="#md_mb_profile5">頭像上傳</a></li>
                        <?php
                    }
                    ?>

                    <li><a href="#md_mb_profile">調閱遊戲影片</a></li>
                    <li><a href="#md_mb_profile">禮物中心紀錄</a></li>
                    <li><a href="#md_mb_profile">產包購買紀錄</a></li>

                    <!--                    <li><a href="#md_mb_profile5">調閱遊戲影片</a></li>
                                        <li><a href="#md_mb_profile6">禮物中心紀錄</a></li>
                                        <li><a href="#md_mb_profile7">產包購買紀錄</a></li>-->
                </ul>
                <div id="md_mb_profile1" class="tab_level_2">
                    <form action="member.php?m=save_account" method="POST">
                        <label for="mbName">姓名：</label>
                        <input type="text" id="mbName" name="name" value="<?php echo $viewData['member']['name']; ?>">
                        <br>
                        <label for="mbBday">生日：</label>
                        <input type="date" id="mbBday" name="birthday"
                               value="<?php echo $viewData['member']['birthday']; ?>">
                        <br>
                        <label for="mbTel">連絡電話：</label>
                        <input type="tel" id="mbTel" name="tel" value="<?php echo $viewData['member']['tel']; ?>">
                        <br>
                        <label for="mbNation">國別：</label>
                        <input type="text" placeholder="台灣(Taiwan) +886" id="mbNation" name="country" readonly>
                        <br>
                        <label for="mbMobile">手機：</label>
                        <span style="height: auto">&nbsp&nbsp&nbsp<?php echo $viewData['member']['phone']; ?></span>
                        <br>
                        <label for="mbEmail">Email：</label>
                        <input type="email" id="mbEmail" name="email"
                               value="<?php echo $viewData['member']['email']; ?>">
                        <br>
                        <label for="mbAdd">聯絡地址：</label>
                        <div id="mbAdd"></div>
                        <input type="text" placeholder="路名/巷/號/樓" name="address"
                               value="<?php echo $viewData['member']['address']; ?>">
                        <br>
                        <label for="">發票形式：</label>
                        <input type="radio" name="mdReceipt" value="receipt_donate" checked>將發票捐給創世基金會
                        <input type="radio" name="mdReceipt" value="receipt_electr">我要索取電子發票
                        <input type="radio" name="mdReceipt" value="receipt_paperR">我要索取紙本發票
                        <br>
                        <label for="mbReceiver">發票收件人：</label>
                        <input type="text" id="mbReceiver" name="invoice_name"
                               value="<?php echo $viewData['member']['invoice_name']; ?>">
                        <br>
                        <label for="mbReceiptAdd">發票地址：</label>
                        <div id="mbReceiptAdd"></div>
                        <input type="text" placeholder="路名/巷/號/樓" name="invoice_address"
                               value="<?php echo $viewData['member']['invoice_address']; ?>">
                        <br>
                        <input type="submit" value="儲存修改" class="save_btn">
                    </form>
                </div>
                <div id="md_mb_profile2" class="tab_level_2">
                    <h4 class="ml_20">聯盟幣</h4>
                    <table>
                        <tr>
                            <th>序號</th>
                            <th>日期</th>
                            <th>科目名稱</th>
                            <th>對方暱稱</th>
                            <th>狀態</th>
                            <th>收入</th>
                            <th>支出</th>
                            <th>餘額</th>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                    </table>
                    <h4 class="ml_20 mt_20">發財金/幸運金領取紀錄</h4>
                    <table>
                        <tr>
                            <th>序號</th>
                            <th>活動名稱</th>
                            <th>日期</th>
                            <th>科目名稱</th>
                            <th>收入</th>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                    </table>
                    <h4 class="ml_20 mt_20">包月查詢</h4>
                    <table>
                        <tr>
                            <th>序號</th>
                            <th>包月日期</th>
                            <th>包月起始日</th>
                            <th>包月到期日</th>
                            <th>方案</th>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                    </table>
                </div>
                <div id="md_mb_profile3" class="tab_level_2">
                    <h4 class="ml_20">我的好友</h4>
                    <form action="member.php?m=save_friend" method="POST" class="ml_20 mb_20">
                        <label for="mbFriend"><span style="letter-spacing: 4px;">新增好</span>友：</label>
                        <input type="hidden" id="mbName" name="name" value="<?php echo $viewData['member']['id']; ?>">
                        <input type="text" id="mbFriend" class="mr_10" name="mbFriend">

                        <input type="submit" value="確　認" class="yellow_btn">
                    </form>
                    <table>
                        <tr>
                            <th>暱稱</th>
                            <th>加入好友時間</th>
                            <th>暱稱</th>
                            <th>加入好友時間</th>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>

                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                    </table>
                    <h4 class="ml_20 mt_20">我的黑名單</h4>
                    <form action="member.php?m=save_badfriend" method="POST" class="ml_20 mb_20">
                        <label for="mbBlacklist">新增黑名單：</label>
                        <input type="text" id="mbBlacklist" class="mr_10" name="">
                        <input type="hidden" id="mbName" name="name" value="<?php echo $viewData['member']['id']; ?>">
                        <input type="submit" value="確　認" class="yellow_btn">
                    </form>
                    <table>
                        <tr>
                            <th>暱稱</th>
                            <th>加入黑名單時間</th>
                            <th>暱稱</th>
                            <th>加入黑名單時間</th>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                        <tr>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                            <td>XXX</td>
                        </tr>
                    </table>
                </div>
                <div id="md_mb_profile4" class="tab_level_2">
                    <form id="saveReportForm" class="ml_20 mb_20">
                        <div class="mb_10">
                            <label for="mbGameType">遊戲類別：</label>
                            <select name="mbGameType" id="mbGameType" method="POST">
                                <option value="gt0">全部</option>
                                <option value="gt1">西遊記</option>
                            </select>
                            <label for="mbGameName" class="ml_20">遊戲名稱：</label>
                            <select name="mbGameName" id="mbGameName">
                                <option value="gn0">全部</option>
                                <option value="gn1" class="gt1">西遊記</option>
                            </select>
                        </div>
                        <div>
                            <label for="">查詢期間：</label>
                            <input type="datetime-local" name="start_date" id="start_date">
                            <span class="ml_10 mr_10">到</span>
                            <input type="datetime-local" class="mr_10" name="end_date" id="end_date">
                            <input type="hidden" id="mbName" name="name"
                                   value="<?php echo $viewData['member']['id']; ?>">
                        </div>
                        <input id="btnTOGGLE" type="button" value="查詢" onClick="Submit()" class="yellow_btn">
                        <!--                        <input  id= "uplist" type="button" value="下一頁"  onClick="uplist()" class="yellow_btn" >-->
                    </form>

                    <table class="md_rank_table" id="game_log">
                    </table>
                </div>
                <script type="text/JavaScript">
                    start_date = document.getElementById('start_date');
                    end_date = document.getElementById('end_date');
                    mbGameType = document.getElementById('mbGameType');

                    var Submit = function () {
                    if (mbGameType.value == "gt0") {
                    $.ajax({
                    url: "game_log.php",
                    data: $('#saveReportForm').serialize(),
                    type: "POST",
                    dataType: 'text',

                    success: function (msg) {
                    x = document.getElementById('game_log');
                    //alert(msg);
                    x.innerHTML = msg;

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                    }
                    });
                    }
                    else {
                    if (start_date.value == "" || end_date.value == "")
                    alert("請輸入日期");
                    }
                    }

                </script>

                <?php
                if (!isFblogin()) {
                    ?>
                    <div id="md_mb_profile5" class="tab_level_2">
                        <form action="php/game_log_1.php" method="post" id="showDataForm" enctype="multipart/form-data" onsubmit="return saveReport();">
                            <div class="control-group">
                                <label class="control-label" for="input01">頭像上傳<span class="red">*</span>：</label>
                                <div class="controls">
                                    <input type="file" placeholder="excel" value=""
                                           name="img_upload" id="img_upload">
                                </div>
                            </div>
                            <input type="submit" value="送出" class="btn-primary btn">
                        </form>
                    </div>
                    <?php
                }
                ?>

                <script type="text/javascript">
                    function saveReport() {
                        // jquery 表单提交  
                        $("#showDataForm").ajaxSubmit(function (message) {
                            // 对于表单提交成功后处理，message为提交页面saveReport.htm的返回内容  
                        });
                        return false; // 必须返回false，否则表单会自己再做一次提交操作，并且页面跳转  
                    }
                </script>
                <!-- 2017-1-5 lin  -->
                <div id="md_mb_profile" class="tab_level_2">
                    <form action="" method="POST" class="ml_20 mb_20">

                        <h4>尚未開放</h4>
                        <!--                            <label for="mbGameType">尚未開放：</label>-->
                    </form>

                </div>


                <!--            <div id="md_mb_profile5" class="tab_level_2">
                                 <h4>調閱遊戲影片</h4> 
                                <form action="" method="POST" class="ml_20 mb_20">
                                    <div class="mb_10">
                                        <label for="mbGameTypeV">遊戲類別：</label>
                                        <select name="mbGameTypeV" id="mbGameTypeV">
                                            <option value="gt0">全部</option>
                                            <option value="gt1">真人</option>
                                            <option value="gt2">電子</option>
                                            <option value="gt3">對戰</option>
                                        </select>
                                        <label for="mbGameNameV" class="ml_20">遊戲名稱：</label>
                                        <select name="mbGameNameV" id="mbGameNameV">
                                            <option value="gn0">全部</option>
                                            <option value="gn1" class="gt1">真人遊戲1</option>
                                            <option value="gn2" class="gt1">真人遊戲2</option>
                                            <option value="gn3" class="gt1">真人遊戲3</option>
                                            <option value="gn4" class="gt2">電子遊戲1</option>
                                            <option value="gn5" class="gt2">電子遊戲2</option>
                                            <option value="gn6" class="gt2">電子遊戲3</option>
                                            <option value="gn7" class="gt3">對戰遊戲1</option>
                                            <option value="gn8" class="gt3">對戰遊戲2</option>
                                            <option value="gn9" class="gt3">對戰遊戲3</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="">查詢期間：</label>
                                        <input type="datetime-local">
                                        <span class="ml_10 mr_10">到</span>
                                        <input type="datetime-local" class="mr_10">
                                        <button type="button" class="yellow_btn">調閱牌局</button>
                                    </div>
                                </form>
                            </div>-->
                <!--            <div id="md_mb_profile6" class="tab_level_2">
                                <div id="md_content_2_6_1">
                                    <h4 class="ml_20">實體禮物紀錄</h4>
                                    <table>
                                        <tr>
                                            <th>日期</th>
                                            <th>活動名稱</th>
                                            <th>獎項</th>
                                            <th>是否寄出/使用</th>
                                        </tr>
                                        <tr>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                        </tr>
                                        <tr>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                        </tr>
                                        <tr>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="md_content_2_6_2">
                                    <h4 class="ml_20 mt_20">獎項兌換方式</h4>
                                    <table>
                                        <tr>
                                            <th>獎項</th>
                                            <th>兌換方式</th>
                                        </tr>
                                        <tr>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                        </tr>
                                        <tr>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                        </tr>
                                        <tr>
                                            <td>XXX</td>
                                            <td>XXX</td>
                                        </tr>
                                    </table>
                                    <h4 class="ml_20 mt_20">現金、7-11禮券、家樂福禮券兌換方式</h4>
                                    <p class="ml_20 mb_20" style="line-height: 1.5em;">於網站活動中獲得的現金、7-11禮券、家樂福禮券皆可以1:100兌換成平台幣。<br>如：1張100元的7-11禮券，可兌換平台幣10,000點！
                                    </p>
                                </div>
                            </div>-->
                <!--            <div id="md_mb_profile7" class="tab_level_2">
                                <h4 class="ml_20">產包購買紀錄</h4>
                                <table>
                                    <tr>
                                        <th>項次</th>
                                        <th>購買日期</th>
                                        <th>購買內容</th>
                                        <th>購買數量</th>
                                        <th>儲值方式</th>
                                        <th>序號</th>
                                        <th>交易金額</th>
                                        <th>交易結果</th>
                                        <th>狀態</th>
                                    </tr>
                                    <tr>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                    </tr>
                                    <tr>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                    </tr>
                                    <tr>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                        <td>XXX</td>
                                    </tr>
                                </table>
                            </div>-->
            </div>

        </div>
        <?php if (!isFblogin()) { ?>
            <div id="md_member_tab3">
                <form action="member.php?m=save_password" method="POST">
                    <br>
                    <label for="mbPw1">修改密碼：</label>
                    <input type="password" id="mbPw1" name="new_pass" value="">
                    <br> <br>
                    <label for="mbPw2">確認密碼：</label>
                    <input type="password" id="mbPw2" name="comfirm_pass">
                    <br><br>
                    <input type="submit" value="儲存修改" class="save_btn">
                </form>
            </div>
        <?php } ?>
        <div id="md_member_tab4">
            <h4>尚未開放</h4>
        </div>
        <div id="md_member_tab5">    
            <h4>尚未開放</h4>
        </div>

        <!--    <div id="md_member_tab11">
                <h4>本月身分：<a href=""><span id="md_card_type_get"></span>會員</a></h4>
                <div id="md_card">
                    <p>7、8月累積儲值額</p>
                    <p id="md_card_type"><span id="md_card_type_now">一般</span><span>普卡</span><span>銀卡</span></p>
                    <p>
                        <span id="md_card_credit"></span>
                        <span id="md_slider"></span>
                    </p>
                    <p id="md_card_credit_max"></p>
                </div>
                <h4 class="mt_20">我的卡別紀錄</h4>
                <table>
                    <tr>
                        <th>2016年</th>
                        <th>1月</th>
                        <th>2月</th>
                        <th>3月</th>
                        <th>4月</th>
                        <th>5月</th>
                        <th>6月</th>
                        <th>7月</th>
                        <th>8月</th>
                        <th>9月</th>
                        <th>10月</th>
                        <th>11月</th>
                        <th>12月</th>
                    </tr>
                    <tr>
                        <td>卡別</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                    </tr>
                    <tr>
                        <td>卡別</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                    </tr>
                    <tr>
                        <td>卡別</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                        <td>XXX</td>
                    </tr>
                </table>
            </div>    
        
            <div id="md_member_tab12">
                <h4>會員卡別優惠</h4>
                <table>
                    <tr>
                        <th>點選看優惠</th>
                        <th class="md_mb_card_pointer md_mb_card_1">白金卡會員</th>
                        <th class="md_mb_card_pointer md_mb_card_2">金卡會員</th>
                        <th class="md_mb_card_pointer md_mb_card_3">銀卡會員</th>
                        <th class="md_mb_card_pointer md_mb_card_4">普卡會員</th>
                        <th class="md_mb_card_pointer md_mb_card_5 md_mb_card_select">一般會員</th>
                    </tr>
                    <tr>
                        <td>方案一</td>
                        <td class="md_mb_card_pointer md_mb_card_1">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_2">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_3">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_4">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_5 md_mb_card_select">XXX</td>
                    </tr>
                    <tr>
                        <td>方案二</td>
                        <td class="md_mb_card_pointer md_mb_card_1">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_2">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_3">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_4">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_5 md_mb_card_select">XXX</td>
                    </tr>
                    <tr>
                        <td>有效期限</td>
                        <td class="md_mb_card_pointer md_mb_card_1">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_2">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_3">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_4">XXX</td>
                        <td class="md_mb_card_pointer md_mb_card_5 md_mb_card_select md_mb_card_select_last">XXX</td>
                    </tr>
                </table>
                <div id="md_mb_card_content"><span>一般會員</span> 的卡別內容</div>
            </div>    -->


    </div>
</main>


