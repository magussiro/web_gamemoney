<?php

include_once "lib/config.php";
include_once 'lib/basePage.php';
include_once 'lib/WebDB.php';
class game_log extends basePage {

    function gam_log() {
        // var_dump(123);
        //die();
        $id = $_POST['name'];
        $mbGameType = $_POST['mbGameType'];
        $mbGameName = $_POST['mbGameName'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
            $adb =BackendDB::getAdminDB();
        if ($start_date != "") {
            $start_date = explode("T", $start_date);
            $start_date = "$start_date[0] $start_date[1]";
            $end_date = explode("T", $end_date);
            $end_date = "$end_date[0] $end_date[1]";


            $res = $adb->query("SELECT * FROM `spin_log` WHERE sl_time BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND gml_id =" . $id ." ORDER BY `spin_log`.`sl_time` DESC");
        } else {
                        
//            var_dump($this->adb);
          
  //                      var_dump($adb);
          //  var_dump($this->adb);
          //var_dump("SELECT * FROM `spin_log` WHERE gml_id =" . '1'." ORDER BY `spin_log`.`sl_time` DESC");
            $res = $adb->query("SELECT * FROM `spin_log` WHERE gml_id =" . $id." ORDER BY `spin_log`.`sl_time` DESC");
        }

        if ($res == FALSE) {
            echo '
     <tr>
    <th>機台編號</th>
    <th>押注金額</th>
    <th>拉霸中獎金額</th>
    <th>獎勵遊戲遊玩次數</th>
    <th>獎勵遊戲中獎金額</th>
    <th>總中獎金額</th>
    <th>時間</th>
</tr>
';
echo "<tr style=overflow:hidden;height:23px>
    <td></td>
    <td>無資料</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>";
        } else {
echo '<tr style=overflow:hidden;height:23px>
     <tr>
    <th>機台編號</th>
    <th>押注金額</th>
    <th>拉霸中獎金額</th>
    <th>獎勵遊戲遊玩次數</th>
    <th>獎勵遊戲中獎金額</th>
    <th>總中獎金額</th>
    <th>時間</th>
</tr>
';
echo "<tr style=overflow:hidden;height:23px>";

   foreach ($res as $key => $value) {
   echo"<td>".$value['sm_id']."</td>
    <td>".$value['bet']."</td>
    <td>".$value['spin_win']."</td>
    <td>".$value['bonus_count']."</td>
    <td>".$value['bonus_win']."</td>
    <td>".$value['total_win']."</td>
    <td>".$value['sl_time']."</td>
</tr>";
            }
        }
    }
}

$aa = new game_log();
$aa->gam_log();
?>


