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

class MaqqRequest extends API
{
    /***
     * 1.條件是 "Ｂｏｕｎｓ =>全盤"
     * Bouns結束後跑馬燈表示 ： 恭喜 %d 於 Bouns Game 開出 %s 全盤獎 得分 %f 分
     *
     * 2.條件是"銀角到孫悟空全盤"
     * 中獎後 跑馬燈表示 ： 恭喜 %d 於 西遊記 開出 %s 全盤獎 得分 %f 分
     */
    var $player_id;
    var $game_id;
    var $member;

    const SLOT_GAME_ID = 1;
    const WIN_7PK = 4;


    var $slot_award_list = [
        'YinJiao' => '銀角全盤獎',//1
        'JinJiao' => '金角全盤獎',//2
        'BaiGuJing' => '骷顱全盤獎',//3
        'HuLiJing' => '狐狸精全盤獎',//4
        'NiuMoWang' => '牛魔王全盤獎',//5
        'ShaWuJing' => '沙悟淨全盤獎',//6
        'ZhuBaJie' => '豬八戒全盤獎',//7
        'TangSanZang' => '唐山藏全盤獎',//8
        'SunWuKong' => '孫悟空全盤獎',//9
    ];

    var $win7pk_award_list = [
        //1.大柳 2.五梅 3.小柳 4.鐵支
        'TrueRoyalFlush' => '大柳',
        'RoyalFlush' => '大柳',
        'TrueStraightFlush' => '小柳',
        'StraightFlush' => '大柳',
        'TrueFiveKind' => '五梅',
        'FiveKind' => '五梅',
        'TrueFourKind' => '鐵支',
        'FourKind' => '鐵支',
    ];


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

    function broadCastAdd($acc, $award_title, $win_amount, $game_title, $priority = 1)
    {
        $player_name = $acc['name'];
        //恭喜sammi於西遊記開出牛魔王全盤獎得分XXX分
        //恭喜sammi於Win7pk開出鐵支得分XXX分
        $string = '恭喜玩家 %s 於 %s 開出 %s 得分%s分!';
        $msg = sprintf($string, $player_name, $game_title, $award_title, $win_amount);
//        var_dump($msg);
//        echo $msg;
//        $msg = "恭喜玩家「$player_name 」在「$game 」遊戲中中JPOT$win_jpot_id 獎!獨得獎金 $win_amount 聯盟幣!";

        $start_date = Carbon::now()->toDateTimeString();
        $end_date = Carbon::now()->addMinutes(3)->toDateTimeString();
        $title = $award_title;
        $sql = 'insert into marquee';
        $sql_input = [];
        $sql_input['title'] = $title;
        $sql_input['msg'] = $msg;
        $sql_input['m_start_date'] = $start_date;
        $sql_input['m_end_date'] = $end_date;
        $sql_input['m_created_at'] = $start_date;
        $sql_input['m_priority'] = $priority;
        $sql_input['m_del'] = 0;
        $this->admin_db->dbInsertPrepare($sql, $sql_input);
        $link = $this->admin_db->getMysqliLink();
        $link->commit();


    }


    function main()
    {


        $api_key = $_REQUEST['api_key'];
        $acc_input = ft($_REQUEST['acc'], 1);
        $game_id = ft($_REQUEST['game_id'], 0);
        $act = ft($_REQUEST['act'], 1);

        $acc = get_member_by_account($this->admin_db, $acc_input)[0];
        if (!$acc)
            $this->response(['code' => 111, 'desc' => 'account dosent exist']);
        if (!$this->verifyApiKey($api_key)) {
            $this->response(['code' => 999, 'desc' => 'u dont have permission']);
        }
        $this->member = $acc;

        switch ($act) {
            case 'bonus_maqq'://接bonus重全盤

                $bonus_amount = ft($_REQUEST['bonus_amount'], 0);
                $bonus_result = ft($_REQUEST['bonus_result'], 1);

                if (array_key_exists($bonus_result, $this->slot_award_list) == false) {
                    $result = ['code' => -1, 'bonus_amount' => $bonus_amount, 'bonus_result' => $bonus_result];
                    $result =$_REQUEST;
                    break;
                }
                $award_title = $this->slot_award_list[$bonus_result];

                $game_title = 'Bouns Game';


                $this->broadCastAdd($acc, $award_title, $bonus_amount, $game_title);
                $result = [
                    'code' => 0,
                ];
                break;
            case 'all_win_maqq'://接全盤中獎
                $win_amount = ft($_REQUEST['win_amount'], 0);
                $win_result = ft($_REQUEST['win_result'], 1);
                if (array_key_exists($win_result, $this->slot_award_list) == false) {
                    $result = ['code' => -1, 'win_result' => $win_result, 'win_amount' => $win_amount];
//                    $result =$_REQUEST;

                    break;
                }
                $award_title = $this->slot_award_list[$win_result];
                $res = get_game($this->admin_db, $game_id);
                $game_title = $res['name'];

                $this->broadCastAdd($acc, $award_title, $win_amount, $game_title);
                $result = [
                    'code' => 0,
                ];

                break;

            case 'win7pk_maqq':
                $win7pk_amount = ft($_REQUEST['win7pk_amount'], 0);
                $win7pk_result = ft($_REQUEST['win7pk_result'], 1);

                if (array_key_exists($win7pk_result, $this->win7pk_award_list) == false) {
                    $result = ['code' => -1, 'win7pk_amount' => $win7pk_amount, 'win7pk_result' => $win7pk_result];
//                    $result =$_REQUEST;

                    break;
                }
                $award_title = $this->win7pk_award_list[$win7pk_result];
                $res = get_game($this->admin_db, $game_id);
                $game_title = $res['name'];
                $this->broadCastAdd($acc, $award_title, $win7pk_amount, $game_title);
                $result = [
                    'code' => 0,
                ];
                break;
            default:
                $result = ['code' => -1];
//                $result =$_REQUEST;

        }
        $this->response($result);
    }

}

$api = new MaqqRequest();
$api->execute();


