<?php
//var_dump($viewData['activity']);


?>
<script type="javascript">
    /* #md_activity_tab2 START */

    $("#md_activityList").tabs();
    <?php
    $activity = $viewData['activity'];
    foreach ($activity as $act) {

        echo '$("#md_btn_activityGame' . $act['id'] . '") . click(function () {
        $("#show_activity_winners") . load("php/table_activityList.php?m=getPrizelist&act_id=' . $act['id'] . '");
    })';
    }
//   echo' $("#show_activity_winners") . load("php/table_activityList.php")';

    ?>

    //$("#md_btn_activityGame2").click(function() {
    //    $("#show_activity_winners").load("php/table_activityList_2.php");
    //});
    //
    $("#md_btn_activityGame3").click(function() {
        $("#show_activity_winners").load("php/table_activityList_3.php");
    });
    //
    //$("#md_btn_activityGame4").click(function() {
    //    $("#show_activity_winners").load("php/table_activityList_4.php");
    //});
    //
    //$("#md_btn_activityGame5").click(function() {
    //    $("#show_activity_winners").load("php/table_activityList_5.php");
    //});
    //
    //$("#md_btn_activityDate1").click(function() {
    //    $("#md_activityList_tab2 table").load("php/table_activityDate_1.php");
    //});
    //
    //$("#md_btn_activityDate2").click(function() {
    //    $("#md_activityList_tab2 table").load("php/table_activityDate_2.php");
    //});
    //
    //$("#md_btn_activityDate3").click(function() {
    //    $("#md_activityList_tab2 table").load("php/table_activityDate_3.php");
    //});
    //
    //$("#md_btn_activityDate4").click(function() {
    //    $("#md_activityList_tab2 table").load("php/table_activityDate_4.php");
    //});
    //
    //$("#md_btn_activityDate5").click(function() {
    //    $("#md_activityList_tab2 table").load("php/table_activityDate_5.php");
    //});
    //
    //$("#md_btn_activityDate6").click(function() {
    //    $("#md_activityList_tab2 table").load("php/table_activityDate_6.php");
    //});
    //
    //$("#md_btn_activityDate7").click(function() {
    //    $("#md_activityList_tab2 table").load("php/table_activityDate_7.php");
    //});
    //
    //$("#md_btn_activityDate8").click(function() {
    //    $("#md_activityList_tab2 table").load("php/table_activityDate_8.php");
    //});
    /* #md_activity_tab2 END */
</script>
