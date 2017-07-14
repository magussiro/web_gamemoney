<?php
require("inc/inc.php");
require("func/func_admin.php");
require("head.php");
//$db->debug();
//取直
$arr_input['ad_mtid'] = ft($_GET['mod'], 0);
$arr_input['ad_name'] = ft($_GET['name'], 1);
$name = $arr_input['ad_name'];
$mod = $arr_input['ad_mtid'];
//$db->debug;
//ini_set("display_errors",1);
//撈資料到表格中 and 分頁
$arr_page['page_id'] = ft($_GET['pageID'], 0); //


$mod = $_GET['mod'];

//var_dump($mod);
//$res_sum = get_Problem_Management($admin_db, $arr_input);
//$arr_page['num'] = $res_sum['0']['cnt'];
$page = new pager($arr_page);
$res = get_questions_answered($admin_db, $arr_input, $page, $mod, $res);
//var_dump($res);
?>
<!--畫面呈現-->
<div class="container-fluid">
    <div class="row-fluid">
        <!--列表-->
        <?php
        require_once "left_menu.php";
        ?>

        <div class="span12">
            <!--標題列-->
            <div class="span12">
                <h3>Q&A管理</h3>
            </div>

            <!--列表-->
            <!--新增按鈕-->
            <div class="row-fluid">
                <div class="pull-left span3 text-left">
                    <button class="btn btn-primary" onclick="dialog_set('questions_answered_add_mod.php?act=add', '新增', 600, 450);">新增</button>
                </div>
                <div class="pull-right text-right">
                    <!--                    <form class="form-search" method="get">
                                            <span>問題 : <input name="name" id="name" class="input-medium search-query" placeholder="請輸入問題標題" type="text" value="<?php echo $name; ?>"/></span>
                                            <input name="mod" id="mod" class="input-medium search-query"  type="hidden" value="<?php echo $mod; ?>"/>
                                            <button type="submit"class="btn"><i class="icon-search"></i>搜尋</button>
                                        </form>-->
                </div>
            </div>
            <!--資料內容-->
            <?php //echo $page->getPageHead();  ?> 

            <div class="row-fluid">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="55">功能</th>
                            <th width="200">問題標題</th>
                            <th width="200">問題內容</th>
                            <th width="200">是否刪除</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($res) > 0) {
                            foreach ($res as $key => $row) {
                                ?>
                                <tr>
                                    <td>
                                        <a class="alphm_obj" title="編輯" onmouseover="$(this).tooltip('show');" href="javascript:void(0);" onclick="dialog_set('questions_answered_add_mod.php?id=<?php echo $row['id']; ?>', '修改', 600, 450);"><i class="icon-edit"></i></a>
                                    </td>
                                    <td>
                                        <?php echo $row['question']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['answer']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['is_del'] == 0) {

                                            echo '<a onclick="member_start(' . $row['id'] . ',' . $row['is_del'] . ');" href="javascript:void(0);" style="color:#080">刪除</a>';
                                        } else {
                                            echo '<a onclick="member_start(' . $row['id'] . ',' . $row['is_del'] . ');" href="javascript:void(0);" style="color:#D00">關閉</a>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6">
                                    <div class="row-fluid text-center">查無資料</div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php echo $page->getPageFoot(); ?>
        </div>
    </div>
</div>

<script Language="JavaScript">

//是否啟動
    function member_start(id, start)
    {
        if (start == 0)
        {
            var str = '刪除';
        } else
        {
            var str = '關閉';
        }
        if (confirm('您確定要' + str))
        {
            window.location.href = 'questions_answered_add_mod_act.php?act=start&id=' + id + '&start=' + start;
        }
    }
</script>	

<?php
require("foot.php");
?>