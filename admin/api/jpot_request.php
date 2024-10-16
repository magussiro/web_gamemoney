<?php

/**
 * Created by PhpStorm.
 * User: Magus
 * Date: 2017/1/16
 * Time: 上午11:41
 */
require '../class/API.php';
require '../class/JpotData.php';
require '../func/func_member.php';
require '../func/func_sys_comm.php';
require '../func/func_game.php';
require '../../lib/Carbon.php';

use \API\API\API;
use Carbon\Carbon;

class JpotRequest extends API
{
    /*     * *
     *
     * Php server回傳:
     * Jp 1~4可抽次數
     * Jp 金額1~4
     * 是否中jp1~4
     *
     * input:
     * api_key:
     * acc:
     * spin_amount:
     * game_id:
     *
     *
     *
     * output:
     * code:
     * get_jpot:0~4
     * jpot_amount:
     *
     *  倍率：100,避免float不精確的問題
     *
     * 全域廣播:需確認廣播時間
     * 使用活動時間判斷 在目前時間內吐給跑馬燈
     * 四個獎金都是獨立計算 但只有一個中獎
     *
     */


    /***
     * 1.條件是 "Ｂｏｕｎｓ =>全盤"
    Bouns結束後跑馬燈表示 ： 恭喜 %d 於 Bouns Game 開出 %s 全盤獎 得分 %f 分

    2.條件是"銀角到孫悟空全盤"
    中獎後 跑馬燈表示 ： 恭喜 %d 於 西遊記 開出 %s 全盤獎 得分 %f 分
     */
    var $jpotDatas;
    var $player_id;
    var $game_id;
    var $member;

    const SLOT_GAME_ID = 1;
    const WIN_7PK = 4;

    function initJpot($player_id, $game_id)
    {

        $sql = 'select a.accumulation , b.* from jpot as a LEFT outer join jpot_setting as b on a.id = b.jpot_id ';
        $res = $this->admin_db->dbSelectPrepare($sql, []);

        $jpots = [];
        foreach ($res as $jpot) {
            $jp = new JpotData();
            $jp->initData($jpot);
            $jp->setGameID($game_id);
            $jp->setPlayeID($player_id);
            $jpots[$jpot['jpot_id']] = $jp;
        }
        $this->jpotDatas = $jpots;
    }

    function setJpot(JpotData $jp, $id)
    {

        $this->jpotDatas[$id] = $jp;
    }

    function addJpotAcc($id, $acc_amount)
    {

//        var_dump($acc_amount);
        return $this->jpotDatas[$id]->addAccumulation($acc_amount, $this->admin_db);
    }

    function luckyDraw($id, $acc_amount, $member_id)
    {
        return $this->jpotDatas[$id]->dealLuckyDraw($acc_amount, $this->member, $this->admin_db, $this->admin_db);

//        $member,DB $jpot_db,DB $admin_db
    }

    function verifyApiKey($input)
    {
        $sql = 'select api_key from api_setting limit 1 ';
        $res = $this->admin_db->dbSelectPrepare($sql, []);
        $apikey = $this->admin_db->getSingleValue($res);
        return $apikey == $input;
    }

//    function saveJpot($id)
//    {
//
//        $this->jpotDatas[$id]->saveData($this->admin_db);
//    }

    function broadCastAdd($acc, $win_jpot_id, $win_amount, $game_id)
    {
        //todo:廣播中獎資訊
        $player_name = $acc['name'];

        $res = get_game($this->admin_db, $game_id);
        $game = $res['name'];

        $string = '恭喜玩家 %s 在 %s 遊戲中中JPOT%s獎!獨得獎金%s聯盟幣!';
        $msg = sprintf($string, $player_name, $game, $win_jpot_id, $win_amount);
//        var_dump($msg);
//        echo $msg;
//        $msg = "恭喜玩家「$player_name 」在「$game 」遊戲中中JPOT$win_jpot_id 獎!獨得獎金 $win_amount 聯盟幣!";

        $start_date = Carbon::now()->toDateTimeString();
        $end_date = Carbon::now()->addMinutes(7)->toDateTimeString();
        $priority = 1;
        $title = 'JPOT' . $win_jpot_id . 'WIN';
        $sql = 'insert into marquee';
        $sql_input = [];
        $sql_input['title'] = $title;
        $sql_input['msg'] = $msg;
        $sql_input['m_start_date'] = $start_date;
        $sql_input['m_end_date'] = $end_date;
        $sql_input['m_created_at'] = $start_date;
        $sql_input['m_priority'] = $priority;
        $sql_input['m_del'] = 0;
//        var_dump($this->admin_db);
//        $this->admin_db->debug();
//        $this->admin_db = new DB();
        $this->admin_db->dbInsertPrepare($sql, $sql_input);
        $link = $this->admin_db->getMysqliLink();
        $link->commit();


//        $this->jpotWinRecord($acc, $win_jpot_id, $win_amount, $game_id);
    }

//    function jpotWinRecord($acc, $win_jpot_id, $win_amount, $game_id)
//    {
////        $this->admin_db = new DB;
//        $bank_original = $acc['point'];
//        $bank_point = $bank_original + $win_amount;
//
//
//        mod_member($this->admin_db, ['point' => $bank_point], $acc['id']);
//        $sql = 'insert into jpot_win_record';
//        $sql_input = [];
//        $sql_input['jpot_id'] = $win_jpot_id;
//        $sql_input['game_id'] = $game_id;
//        $sql_input['win_amount'] = $win_amount;
//        $sql_input['member_id'] = $acc['id'];
//        $sql_input['created_at'] = date('Y-m-d H:i:s');
//
//        $this->admin_db->dbInsertPrepare($sql, $sql_input);
//
//    }


    function test()
    {


        $sql1 = "update member set point = point + 100 where id = 1 ;";
        $sql2 = "update jpot set accumulation = accumulation - 9 where id = 4 ; ";
        $sql3 = "select * from member";
        $sql = $sql1 . $sql2 . $sql3;
        try {
            $this->admin_db->debug();
            $this->admin_db->multiQuery($sql, 'w');
//            foreach ( $this->admin_db->multiQuery($sql,'w') as $key => $value ) {
//                echo $key, $value, PHP_EOL;
//            }
        } catch (Exception $e) {
            throw new Exception($e);
        };
    }

    function dealSlotExp($acc, $spin_input)
    {
        $lv_exp = get_member_by_exp($this->admin_db, $acc['id'])[0];

        //計算經驗值與等級更新

//
        //  if ($acc['m_vip'] >= 1) {
        if (empty($lv_exp)) {
            $lv_exp = $spin_input;
            $add_exp = add_member_exp($this->admin_db, "insert", $acc['id'], $lv_exp);
        } else {
            $lv_exp = $spin_input;
            $add_exp = add_member_exp($this->admin_db, "update", $acc['id'], $lv_exp);
        }
//            if ($lv_exp == "") {
//                $add_exp = add_member_exp($this->admin_db, "insert", $acc['id'], $lv_exp);
//            }
//            if ($lv_exp != "") {
//                $add_exp = add_member_exp($this->admin_db, "update", $acc['id'], $lv_exp);
//            }


        if ($acc['m_lv'] <= 9) {

            for ($i = 1; $i <= 9; $i++) {
                if ($acc['m_lv'] == $i) {
                    // $lv_exp = $lv_exp['exp_value'] + $spin_input;
                    if ($lv_exp['exp_value'] > $acc['m_lv'] . "0000") {
                        if ($lv_exp['exp_value'] >= 100000) {
                            $lv = $lv_exp['exp_value'] / 10000;
                            $lv = intval($lv);
                            $update_lv = update_member_lv($this->admin_db, $acc['id'], $lv);
                        }
                        // var_dump($lv_exp);
                        if ($lv_exp['exp_value'] < 100000) {
                            $lv = substr($lv_exp['exp_value'], 1);
                            //   var_dump($lv);
                            $update_lv = update_member_lv($this->admin_db, $acc['id'], $lv);
                        }
                    }
                }
            }
        }
        if ($acc['m_lv'] >= 10) {

            //var_dump($lv_exp);
            $lv = $lv_exp['exp_value'] / 10000;
            $lv = intval($lv);
            $update_lv = update_member_lv($this->admin_db, $acc['id'], $lv);
        }


    }

    function deal7PKExp($acc, $pk_amount)
    {
        $lv_exp = get_member_by_exp($this->admin_db, $acc['id'])[0];


        $lv_exp = $lv_exp['exp_value'] + $pk_amount;

        if ($acc['m_lv'] <= 9) {
            // $lv_exp = get_member_by_exp($this->admin_db, $acc['id'])[0];
            for ($i = 1; $i <= 9; $i++) {
                if ($acc['m_lv'] == $i) {
                    // $lv_exp = $lv_exp['exp_value'] + $spin_input;
                    if ($lv_exp > $acc['m_lv'] . "0000") {
                        if ($lv_exp >= 100000) {
                            $lv = $lv_exp / 10000;
                            $lv = floor($lv);
                            $update_lv = update_member_lv($this->admin_db, $acc['id'], $lv);
                        }
                        if ($lv_exp < 100000) {
                            $lv = substr($lv_exp, 1);
                            $update_lv = update_member_lv($this->admin_db, $acc['id'], $lv);
                        }
                    }
                }
            }
        }
        if ($acc['m_lv'] >= 10) {
            $lv = $lv_exp / 10000;
            $lv = floor($lv);
            $update_lv = update_member_lv($this->admin_db, $acc['id'], $lv);
        }
        if ($lv_exp == "") {
            $add_exp = add_member_exp($this->admin_db, "insert", $acc['id'], $lv_exp);
        }
        if ($lv_exp != "") {
            $add_exp = add_member_exp($this->admin_db, "update", $acc['id'], $lv_exp);
        }

    }

    function main()
    {
//        parent::main(); //
        $test_mode = 0;

        if ($test_mode) {

            $spin_input = 4500;
            $acc_input = 'magus.siro@gmail.com';
            $api_key = '1111';
            $game_id = 1;
//            $this->test();
//            die;
        } else {

            $spin_input = ft($_REQUEST['spin_amount'], 0);
            $pk_amount = ft($_REQUEST['7pk_amount'], 0);
            $api_key = $_REQUEST['api_key'];
            $acc_input = ft($_REQUEST['acc'], 1);
            $game_id = ft($_REQUEST['game_id'], 0);
        }

        $acc = get_member_by_account($this->admin_db, $acc_input)[0];
        switch ($game_id) {
            case self::SLOT_GAME_ID:


                $spin_amount = $spin_input * 100;


                if (!$acc)
                    $this->response(['code' => 111, 'desc' => 'account dosent exist']);
                if (!$this->verifyApiKey($api_key)) {
//            $this->recordIlligaleOp();
                    $this->response(['code' => 999, 'desc' => 'u dont have permission']);
                }


                $this->dealSlotExp($acc, $spin_input);


                $this->member = $acc;
                $this->initJpot($acc['id'], $game_id);

                for ($i = 1; $i <= 4; $i++) {
                    $this->addJpotAcc($i, $spin_amount);
                }
                $win_jpot_id = 0;
                $win_amount = 0;
                for ($i = 1; $i <= 4; $i++) {
                    $win = $this->luckyDraw($i, $spin_amount, $acc['id']);
                    if ($win) {
                        $win_amount = $this->jpotDatas[$i]->getPlayerWinPoint();
                        $win_jpot_id = $this->jpotDatas[$i]->getJpotId();
                        $this->broadCastAdd($acc, $win_jpot_id, $win_amount, $game_id);
//                var_dump('win:' . $win_jpot_id.'win amount'.$win_amount);
                        break;
                    }
                }
//        for ($i = 1; $i <= 4; $i++)
//            $this->saveJpot($i);

                $result = [
                    'code' => 0,
                    'get_jpot' => (int)$win_jpot_id,
                    'jpot_amount' => (int)$win_amount
                ];
                break;
            case self::WIN_7PK:
                $this->deal7PKExp($acc, $pk_amount);
                // }

                $result = [
                    'code' => 0,
                ];
                break;
            default:
                $result = ['code' => -1];

        }

//        var_dump($result);
//
        $this->response($result);
    }

}

$api = new JpotRequest();
$api->execute();

//for ($i = 0; $i < 10; $i++) {
//    var_dump(time());
//    var_dump(date('Y-m-d H:i:s'));
//    var_dump(time());
//    var_dump(date('Y-m-d H:i:s'));
//}


/**
 * 效能測試
 * one request
 * 60.248.141.143
 *
 * 1484816317
 * 0.39548400
 *
 * 1484816317
 * 0.56614400
 *
 */


