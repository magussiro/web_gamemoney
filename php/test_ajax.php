<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <mce:script type="text/javascript" src="js/jquery-1.4.2.min.js" mce_src="js/jquery-1.4.2.min.js"></mce:script>
    <title></title>
    <mce:script type="text/javascript">
        function GetData() {
            if ($('#Text1').val() == '') {
                alert('请输入内容!');
                return;
            }
            $.ajax({
                type: "GET",
                url: "ContentHandler.ashx?name=" + $('#Text1').val(),
                cache: false,
                data: {sex: "男"},
                success: function (output) {
                    if (output == "" || output == undefined) {
                        alert('返回值为空!');
                    }
                    else {
                        output = eval("(" + output + ")");
                        $('#divmsg').html("姓名:" + output.name + "----" + "日期:" + output.dt);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("获取数据异常");
                }
            });
        }
    </mce:script>
</head>
<body>
<form id="form1" runat="server">
    <div>
        ajax使用demo
    </div>
    <div>
        <input id="Text1"
               type="text"/>
        <input id="Button1" type="button" value="获取数据" onclick="GetData()"/>
    </div>
    <div id='divmsg'>
    </div>
</form>
</body>
</html>