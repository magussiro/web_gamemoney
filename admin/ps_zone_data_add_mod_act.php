<?php

//載入程式設定檔
$id_id = "login";
require("inc/inc.php");
require("func/func_play_station.php");
//ini_set("display_errors",1);
//========= 參數接收 op ==========


global $win7pk_push;

$act = ft($_POST['act'], 1);
$id = ft($_POST['id'], 0);
$zoneId = ft($_POST['zone'], 0);
if ($act == null) {
    $act = ft($_GET['act'], 1);
    $id = ft($_GET['id'], 0);
}


//var_dump($_POST);
//die;
//七朵花
//$array_print['flush7'] = $_POST['flush7'];
//大柳
$array_print['rf'] = (int) $_POST['straight_flush'];
//五枚
$array_print['5k'] = (int) $_POST['five_kind'];
//小柳
$array_print['sf'] = (int) $_POST['royal_straight_flush'];
//鐵支
$array_print['4k'] = (int) $_POST['four_kind'];
//葫蘆
$array_print['fh'] = (int) $_POST['full_house'];

//同花
$array_print['flush'] = (int) $_POST['flush'];
//兩對
$array_print['min2p'] = (int) $_POST['min2p'];

//
//$add_sprint['full_house'] = $_POST['full_house'];
//$add_sprint['four_kind'] = $_POST['four_kind'];
//$add_sprint['royal_straight_flush'] = $_POST['royal_straight_flush'];
//$add_sprint['five_kind'] = $_POST['five_kind'];
//$add_sprint['straight_flush'] = $_POST['straight_flush'];
//$add_sprint['flush'] = $_POST['flush'];
//$add_sprint['min2p'] = $_POST['min2p'];
//$array_print['fh'] = $_POST['full_house'];
//$array_print['four_kind'] = $_POST['four_kind'];
//$array_print['royal_straight_flush'] = $_POST['royal_straight_flush'];
//$array_print['straight_flush'] = $_POST['straight_flush'];
//$array_print['full_house'] = $_POST['full_house'];
//$array_print['five_kind'] = $_POST['five_kind'];
//
//
//
//
//
//var_dump($_POST);
//die;
//========= 參數接收 ed ==========
switch ($act) {
    //新增
    case 'add':
        $ps_input['psz_id'] = $zoneId;
        $ps_input['ps_name'] = ft($_POST['ps_name'], 1);
        $add_id = add_play_station($win7pk_db, $ps_input);
        //die;
        if ($add_id) {
            $arr_input['ps_id'] = $add_id;
            $arr_input = fill_ps_prob_data($win7pk_db, $zoneId, $arr_input);
            $arr_input = fill_ps_zone_data($win7pk_db, $zoneId, $arr_input);
            add_play_station_prob($win7pk_db, $arr_input);

            $data_input['ps_id'] = $add_id;
            add_play_station_data($win7pk_db, $data_input);

            //$shift_member = get_shift_member($win7pk_db);
            // $log_input['mo_ml_id'] = $shift_member[0]['cs_mlid'];
            // $log_input['mo_ps_id'] = $id;
            // $log_input['mo_op_type'] = 2;
            // $log_input['mo_time'] = date("Y-m-d H:i:s");
            // $log_input['mo_note'] = json_encode($arr_input);
            //add_member_op_log($win7pk_db, $log_input);
            reload_js_top_href('更新成功!', 'slot_machine.php?game=ps_list');
            //  die;
        } else {
            reload_js_top_href('更新失敗或沒有更新!', 'slot_machine.php?game=ps_list');
        }
        break;
    //更新
    case 'mod':

        // $url = "http://127.0.0.1:8080/7pk/1/";
        $url = $win7pk_push . $id;
        //var_dump($array_print);
        // var_dump($url);
        //die;
        $res = excuteApi($url, $array_print);
//        foreach ($res as $key => $value) {
//            var_dump($value);
//        }
        echo '<pre>';
        //var_dump($res);
        $res = json_decode($res,true);
        if($res == 2)
        {
            reload_js_top_href('參數錯誤!', 'slot_machine.php?game=ps_list');
        }
        
//        var_dump($res['rf']);
//        var_dump($res->rf);
        //var_dump($res);
        
        $add_sprint['full_house'] = $res['rf'];
        $add_sprint['four_kind'] = $res['4k'];
        $add_sprint['royal_straight_flush'] = $res['sf'];
        $add_sprint['five_kind'] = $res['5k'];
        $add_sprint['straight_flush'] = $res['rf'];
        $add_sprint['flush'] = $res['flush'];
        $add_sprint['min2p'] = $res['min2p'];

        $mod_ps_zone_date = mod_ps_gift_date1($win7pk_db, $add_sprint, $id);
//        $res = excuteApi($url, $array_print['rf'],$array_print['5k'],$array_print['sf'],$array_print['4k'],$array_print['fh'],$array_print['flush'],$array_print['min2p']);
        // var_dump($res);
        //die;
        //var_dump($res);
        if ($mod_ps_zone_date) {
            reload_js_top_href('更新成功!', 'slot_machine.php?game=ps_list');
        } else {
            reload_js_top_href('更新失敗或沒有更新!', 'slot_machine.php?game=ps_list');
        }
        break;
    //刪除
    default:
        reload_js_top_href('異常', 'ps_list.php');
        exit('異常');
}

function excuteApi($url, $simple) {
    //var_dump($this->apiUrl);
    //var_dump($this->getApiInput());
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
//    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($simple));
//    if (curl_exec($ch) === false) {
//        echo 'Curl error: ' . curl_error($ch);
//        
//    }
//    //  var_dump($ch);
//    $result = curl_exec($ch);
//    curl_close($ch);
//    return $result;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
    //$simple = json_encode($simple);
    //var_dump($simple);
    //var_dump($url);
    //var_dump($simple['rf']);
    // echo '<pre>';
    //var_dump($simple);
    $simple1 = json_encode($simple);
    // $simple = '{"rf":16,"5k":16,"sf":16,"4k":16,"fh":16,"flush":16,"min2p":10}';
    // $simple1 = '{"rf":'.(string)$simple['rf'].',"5k":'.(string)$simple['5k'].',"sf":'.(string)$simple['sf'].',"4k":'.(string)$simple['4k'].',"fh":'.(string)$simple['fh'].',"flush":'.(string)$simple['flush'].',"min2p":'.(string)$simple['min2p'].'}';
    // var_dump($simple);
    // var_dump($simple1);
    //echo $simple; 
    //echo $simple1; 
    // 
    // 
    // $simple1= '{"rf":16,"5k":16,"sf":16,"4k":16,"fh":16,"flush":16,"min2p":10}';
    //var_dump($simple1);
    // die;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $simple1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
    $result = curl_exec($ch);
    
    //var_dump($result);
//    if (curl_exec($ch) === false) {
//        
//        var_dump($ch);
//        //echo 'Curl error: ' . curl_error($ch);
//        return 2;
//    }
    // var_dump($result);
    return $result;
}

?>