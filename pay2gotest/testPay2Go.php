<?php
/**
 * Created by PhpStorm.
 * User: Magus
 * Date: 2017/3/1
 * Time: 下午1:44
 */

require "pay2go_inc.php";
//每次點進這頁 產生資料到DB紀錄


$mid = uniqid();
$t = time();
//$data = 'HashKey=SZiHER7CA7NTODXxA0y8gnwaApxzp8eh' .
//    '&Amt=200' .
//    '&MerchantID=316120815' .
//    '&MerchantOrderNo=' . $mid .
//    '&TimeStamp=' . $t .
//    '&Version=1.2' .
//    '&HashIV=8xZMo6oZecS2PQAq';
$data = 'HashIV=8xZMo6oZecS2PQAq' .
    '&Amt=200' .
    '&MerchantID=316120815' .
    '&MerchantOrderNo=' . $mid .
    '&TimeStamp=' . $t .
    '&Version=1.2' .
    '&HashKey=SZiHER7CA7NTODXxA0y8gnwaApxzp8eh';

// 用PHP 內建的 hash() SHA256 編碼後再轉成大寫
//var_dump($data);
$checkValue = strtoupper(hash('sha256', $data));
//var_dump(hash('sha256', $data));
//var_dump(hash('sha256', $data));
$check_code = array(
    "MerchantID" => '316120815',
    "Amt" => '100',
    "MerchantOrderNo" => $mid,
//    "TradeNo" => '14061313541640927',
    "TimeStamp" => $t,
    "Version" => '1.2',
);
ksort($check_code);
$check_str = http_build_query($check_code);
//var_dump($check_str);
$CheckCode = "HashIV=8xZMo6oZecS2PQAq&$check_str&HashKey=SZiHER7CA7NTODXxA0y8gnwaApxzp8eh";
var_dump($CheckCode);
$CheckCode = strtoupper(hash("sha256", $CheckCode));


//var_dump($checkValue);
var_dump($CheckCode);


$pay2go_item = [];
//後端接到長這樣
//
//
//$json_string = '{"Status":"SUCCESS","Message":"\u4fe1\u7528\u5361\u6388\u6b0a\u6210\u529f","Result":"{\"MerchantID\":\"3430112\",\"Amt\":30,\"TradeNo\":\"14073109503001857\",\"MerchantOrderNo\":\"201407310950239561\",\"RespondType\":\"JSON\",\"CheckCode\":\"C3E6ED72D3641558DA5F701DEFB01B4A9636F1D100F06BEC06027BF5D8873733\",\"PaymentType\":\"CREDIT\",\"RespondCode\":\"54\",\"Auth\":\"\",\"Card6No\":\"457958\",\"Card4No\":\"5509\",\"ECI\":\"\",\"PayTime\":\"2014-07-3109:50:38\"}"}';
//var_dump(json_decode($json_string));
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"> <!-- 請設定 utf8 另外這檔案儲存時也要是 UTF-8 檔首無BOM-->
    <title>智付寶 金流串接測試</title>
</head>
https://api.pay2go.com/MPG/mpg_gateway
<body>
<form method="post" action="https://api.pay2go.com/MPG/mpg_gateway">             <!-- 測試環境用的網址 正式的不一樣請注意 -->
    <input type="hidden" name="MerchantID" value="<?= $pay2go_setting['MerchantID']?>">            <!-- 店家代號 -->
    <input type="hidden" name="RespondType" value="<?= $pay2go_setting['RespondType']?>"/>          <!-- 回傳資料的格式 -->
    <input type="hidden" name="CheckValue" value="<?php echo $CheckCode; ?>">     <!-- 驗證資料是否一致 -->
    <input type="hidden" name="TimeStamp" value="<?php echo $t; ?>">               <!-- 訂單產生時間 -->
    <input type="hidden" name="Version" value="<?= $pay2go_setting['Version']?>">                <!-- api 版本 請看最新版說明文件 -->
    <input type="hidden" name="LangType" value="<?= $pay2go_setting['LangType']?>">               <!-- 訂單產生時間 -->
    <input type="hidden" name="MerchantOrderNo" value="<?php echo $mid; ?>">   <!-- 店家產生的訂單編號 不可重覆 -->
    <input type="hidden" name="Amt" value="<?= $pay2go_item['Amt']?>">                    <!-- 商品價格 -->
    <input type="hidden" name="ItemDesc" value="<?= $pay2go_item['ItemDesc']?>">                           <!-- 商品名稱 -->
    <input type="hidden" name="TradeLimit" value="<?=$pay2go_setting['TradeLimit']?>">                   <!-- 限制交易的秒數，當秒數倒數至 0 時，交易當做失敗 -->
    <input type="hidden" name="ExpireDate" value="60">                   <!-- (適用於非即時交易)格式為 date('Ymd') ，例：20140620 2.此參數若為空值，系統預設為 7 天 -->
    <input type="hidden" name="ExpireTime" value="60">                   <!-- 1.僅適用於超商代碼繳費 2.格式為 date('His') ，例：235959 -->
    <input type="hidden" name="ReturnURL" value="">                   <!--交易完成後，以 Form Post 方式導回商店頁面 -->
    <input type="hidden" name="NotifyURL" value="">                   <!--以幕後方式回傳給商店相關支付結果資料 -->
    <input type="hidden" name="CustomerURL" value="">                   <!--.系統取號後以 form post 方式將結果導回商店指定的網址，請參考 七、取號完成系統回傳參數說明。 -->
    <input type="hidden" name="ClientBackURL" value="">                   <!--交易取消時，平台會出現返回鈕，使消費者依以此參數網址返回商店指定的頁面 -->
    <input type="hidden" name="Email" value="test@gmail.com">                   <!-- 付款成功會寄通知信到這個email -->
    <input type="hidden" name="EmailModify" value="1">                   <!-- 可以在致富保頁面修改email -->
    <input type="hidden" name="LoginType" value="0"><!-- 是否需要登入智付寶會員才能付款 0 不用 1 要，廢話這一定要填0的丫 -->
    <input type="hidden" name="OrderComment" value="TEST OrderComment"><!-- 將會於 MPG 頁面呈現商店備註內容。 -->
    <button type="submit">付款</button>
<!--<form method="post" action="https://api.pay2go.cm/MPG/mpg_getway">             <!-- 測試環境用的網址 正式的不一樣請注意 -->-->
<!--    <input type="hidden" name="MerchantID" value="12312910">            <!-- 店家代號 -->-->
<!--    <input type="hidden" name="RespondType" value="JSON"/>          <!-- 回傳資料的格式 -->-->
<!--    <input type="hidden" name="CheckValue" value="--><?php //echo $checkValue; ?><!--">     <!-- 驗證資料是否一致 -->-->
<!--    <input type="hidden" name="TimeStamp" value="--><?php //echo $t; ?><!--">               <!-- 訂單產生時間 -->-->
<!--    <input type="hidden" name="Version" value="1.2">                <!-- api 版本 請看最新版說明文件 -->-->
<!--    <input type="hidden" name="MerchantOrderNo" value="--><?php //echo $mid; ?><!--">   <!-- 店家產生的訂單編號 不可重覆 -->-->
<!--    <input type="hidden" name="Amt" value="200">                    <!-- 商品價格 -->-->
<!--    <input type="hidden" name="ItemDesc" value="玩具車">                           <!-- 商品名稱 -->-->
<!--    <input type="hidden" name="Email" value="test@gmail.com">                   <!-- 付款成功會寄通知信到這個email -->-->
<!--    <input type="hidden" name="LoginType" value="0">-->
<!--    <!-- 是否需要登入智付寶會員才能付款 0 不用 1 要，廢話這一定要填0的丫 -->-->
<!--    <button type="submit">付款</button>-->
</form>
</body>

</html>
