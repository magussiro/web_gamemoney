﻿function randomNum(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

function onlyNum() {
    if (!((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)))
    //考慮小鍵盤上的數字鍵
        event.returnvalue = false;
}

function onlyEng() {
    if (!(event.keyCode >= 65 && event.keyCode <= 90))
        event.returnvalue = false;
}


//====================================
//檢查表單欄位-開始
//====================================
var validateSuccess = true; //檢查成功
var arrErrorMsg = new Array(); //所有錯誤訊息

function checkaccount(id) {
    if ($("#" + id).val().length > 0) {
        // if (!checklen(fmobj, "帳號", 6, 30)) return false;
        re = /^\w{1,30}$/;
        if (!re.test($("#" + id).val())) {
            setError(id, "只能由英文數字及底線")
                //alert("帳號格式有問題,只能由英文數字及底線");
                //document.getElementById(fmobj).focus();
                //return false;
        }
    }

}

function checkID(id) {
    var cid = $("#" + id).val();

    if (cid) {
        var index = false;

        tab = "ABCDEFGHJKLMNPQRSTUVXYWZIO"
        A1 = new Array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3);
        A2 = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5);
        Mx = new Array(9, 8, 7, 6, 5, 4, 3, 2, 1, 1);

        if (cid.length != 10)
            index = true;
        i = tab.indexOf(cid.charAt(0));
        if (i == -1)
            index = true;
        sum = A1[i] + A2[i] * 9;

        for (i = 1; i < 10; i++) {
            v = parseInt(cid.charAt(i));
            if (isNaN(v))
                index = true;
            sum = sum + v * Mx[i];
        }

        if (sum % 10 != 0) {
            index = true;
        }

        if (index)
            setError(id, "格式不正確")

    }
    //return true;
}

function checknum(id) {
    if ($("#" + id).val() != "") {
        re = /^([0-9]*[.0-9])$/;
        if (!re.test($("#" + id).val())) {
            setError(id, "需為數字")
        }
    }

}

function checkemail(id) {
    if ($("#" + id).val() != "") {
        re = /^[^\s]+@[^\s]+\.[^\s]{2,3}$/;

        if (!re.test($("#" + id).val())) {
            setError(id, "格式不正確")
        }
    }
    //return true;
}

function checkempty(id) {

    var type = $("#" + id).attr("type");
    var value = $("#" + id).val();
    if (type == null)
        type = $("#" + id).get(0).tagName;
    type = type.toLowerCase();

    switch (type) {
        case "text":
            if (value == "") {
                setError(id, "需輸入");
            }
            break;
        case "password":
            if (value == "") {
                setError(id, "需輸入");
            }
            break;
        case "select":
            if (value == "" || value == "0") {
                setError(id, "需輸入");
            }
            break;
    }
}


function checklen(id, lenmin, lenmax) {
    if ($("#" + id).val() != "") {
        if (($("#" + id).val().length < lenmin)) {
            setError(id, "需超過" + lenmin + "個字")
        }
        if (($("#" + id).val().length > lenmax)) {
            setError(id, "不能超過過" + lenmax + "個字")
        }
    }
}

function checkDate(id) {
    var re = new RegExp("^([0-9]{4})[./]{1}([0-9]{1,2})[./]{1}([0-9]{1,2})$");
    var strDataValue;
    var infoValidation = true;

    var str = $("#" + id).val();

    if (str != "") {
        if ((strDataValue = re.exec(str)) != null) {
            var i;
            i = parseFloat(strDataValue[1]);
            if (i <= 0 || i > 9999) { // 年
                infoValidation = false;
            }
            i = parseFloat(strDataValue[2]);
            if (i <= 0 || i > 12) { // 月
                infoValidation = false;
            }
            i = parseFloat(strDataValue[3]);
            if (i <= 0 || i > 31) { // 日
                infoValidation = false;
            }
        } else {
            //infoValidation = false;
            setError(id, "格式不正確")
        }
    }

}

function setError(id, msg) {
    var title = "";
    var title = $("#" + id).parent().parent().find("label").html();
    $("#" + id).parent().parent().addClass("has-error");

    if (title == null) {
        title = $("#" + id).parent().parent().parent().parent().parent().parent().find("label").html();
        $("#" + id).parent().parent().parent().parent().parent().parent().addClass("has-error");
    }

    title = RemoveHTML(title);

    if (title) {
        title = title.replace(":", "");
    }
    if (title) {
        title = title.replace('*', "");
    }

    $("#" + id).focus();
    validateSuccess = false;
    arrErrorMsg.push(title + msg);
}

function AllErrorStr() {
    var total = "";
    for (i = 0; i < arrErrorMsg.length; i++) {
        total = total + arrErrorMsg[i] + "、";
    }
    if (total.length > 0)
        total = total.substring(0, total.length - 1);

    arrErrorMsg = new Array();
    return total;
}

function ajaxCheck(id, url) {
    return $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: url,
        error: function(xhr, ajaxOptions, thrownError) {},
        success: function(response) {
            //統一回傳值,status=-1 為檢核不過
            if (response.status == "-1") {
                setError(id, "重複");
            } else {}
        },
        complete: function(data) {}
    });

}

function custValidate() {
    //重置錯誤CLASS和值
    validateSuccess = true;
    $(".has-error").each(function() {
            $(this).removeClass("has-error");
        })
        //檢查必埴
    var arrayChk = new Array();
    $(".required").each(function() {
        var id = $(this).attr("id");


        var type = $(this).attr("type");

        if (type == "checkbox") {

            var chkIndex = true;
            for (var i = 0; i < arrayChk.length; i++) {
                //alert(arrayChk[i].name + "," + $(this).attr("groupName"));
                if (arrayChk[i].name == $(this).attr("groupName")) {
                    if ($(this).prop("checked") == true) {
                        arrayChk[i].check = true;
                    }
                    chkIndex = false;
                } else {

                }
            }

            if (chkIndex) {
                var newType = {};
                newType.name = $(this).attr("groupName");
                newType.id = $(this).attr("id");
                if ($(this).prop("checked") == true) {
                    newType.check = true;
                } else {
                    newType.check = false;
                }
                arrayChk.push(newType);
            }
        } else {
            checkempty(id);
        }
    });
    for (var j = 0; j < arrayChk.length; j++) {
        var isCheck = arrayChk[j].check;
        if (isCheck == false) {
            setError(arrayChk[j].id, "需選取");
        }
    }


    //檢查長度
    $(".length").each(function() {
        var id = $(this).attr("id");
        var length = $(this).attr("length");
        var arr = length.split(",");
        var min = arr[0];
        var max = arr[1];
        checklen(id, Number(min), Number(max));
    });
    //檢查MAIL
    $(".mail").each(function() {
        var id = $(this).attr("id");
        checkemail(id);
    });

    //檢查帳號
    $(".account").each(function() {
        var id = $(this).attr("id");
        checkaccount(id);
    });

    //檢查數字
    $(".number").each(function() {
        var id = $(this).attr("id");
        checknum(id);
    });


    //檢查數字
    $(".date").each(function() {
        var id = $(this).attr("id");
        checkDate(id);
    });


    //檢查身份證字號
    $(".cid").each(function() {
        var id = $(this).attr("id");
        checkID(id);
    });





}

function checkBoxRequired(className) {
    var id;
    var index = false;
    $("." + className).each(function() {
        id = $(this).attr("id");
        if ($(this).prop("checked") == true)
            index = true;
    });

    if (index == false)
        setError(id, "需選取");

}


//====================================
//檢查表單欄位-結尾
//====================================




//====================================
//產生控制項-開始
//====================================

function AddChangeEvent(id) {
    $("#" + id).change(function() {
        model[id] = $(this).val();
    });
    $("#" + id).click(function() {
        model[id] = $(this).val();
    });

    $("#" + id).blur(function() {
        model[id] = $(this).val();
    });

    $("#" + id).focus(function() {
        model[id] = $(this).val();
    });
}

function AddFckChange(id) {
    var editor = CKEDITOR.replace(id);
    // The "change" event is fired whenever a change is made in the editor.
    editor.on('change', function(evt) {
        // getData() returns CKEditor's HTML content.
        //console.log('Total bytes: ' + evt.editor.getData().length);
        model[id] = evt.editor.getData();
    });
}

function AddCheckboxChange(id) {

    $(".ChkGroup_" + id).each(function() {
        $(this).change(function() {
            var gValue = "";
            $(".ChkGroup_" + id).each(function() {
                if ($(this).prop("checked")) {
                    var cid = $(this).attr("id");
                    cid = cid.replace("chk_", "");
                    gValue += cid + ",";
                }
            });
            if (gValue.length > 0)
                gValue = gValue.substring(0, gValue.length - 1);
            model[id] = gValue;
        });
    });
}

function AddTimeChange(id) {
    $("#" + id + "_h").change(function() {
        var h = $(this).val();
        if (h.length == 1)
            h = "0" + h;

        var m = $("#" + id + "_m").val();
        if (m.length == 1)
            m = "0" + m;

        model[id] = h + ":" + m;
    });

    $("#" + id + "_m").change(function() {
        var h = $("#" + id + "_h").val();
        if (h.length == 1)
            h = "0" + h;

        var m = $(this).val();
        if (m.length == 1)
            m = "0" + m;

        model[id] = h + ":" + m;
    });
}

function GenFile(id, value, name) {
    var imgStr = '<img id="oldImage" width="100" src="/Uploads/' + value + '" />';
    if (value == "")
        imgStr = "";
    var strControl = ' <div id="fine-uploader-gallery"></div>' + imgStr;
    AddContent(strControl, name, 8);
}

function GenFck(id, value, name) {
    var strControl = ' <script src="/ckeditor/ckeditor.js" type="text/javascript"><!--mce:2--></script> <textarea id="' + id + '" name="' + id + '" class="ckeditor"  cols="50" rows="20">' + value + '</textarea>';
    AddContent(strControl, name, 8);
}

function GenLabel(id, value, name, validate, options) {
    var strControl = "";

    if (options != "") {
        for (var index in options) {
            if (options[index].value == value) {
                strControl = '<label id="' + id + '" class="form-control" >' + options[index].text + '</label>';
            }
        }
    } else {
        strControl = '<label id="' + id + '" class="form-control" >' + value + '</label>';
    }

    strControl += '<input id="' + id + '" type="hidden" value="' + value + '" class="form-control" />';

    AddContent(strControl, name);
}

function GenText(id, value, name, validate, options) {
    var strLength = checkLengthValidate(validate, options);
    var strControl = '<input id="' + id + '" type="text" value="' + value + '" class="form-control ' + validate + '" ' + strLength + ' />';


    AddContent(strControl, name);
}

function GenLongText(id, value, name, validate, options) {
    var strLength = checkLengthValidate(validate, options);

    var strControl = '<input id="' + id + '" type="text" value="' + value + '" class="form-control ' + validate + '" ' + strLength + ' />';
    AddContent(strControl, name, 8);
}

function GenCheckbox(id, value, name, validate, options) {
    var strControl = '<table style="width:100%;" ><tr>';
    var arrIDs = value.split(",");
    var count = 0;
    for (var index in options) {
        count = count + 1;
        var checked = "";
        for (var i = 0; i < arrIDs.length; i++) {
            if (options[index].value == arrIDs[i]) {
                checked = "checked";
            }
        }

        strControl += '<td><input id="chk_' + options[index].value + '" type="checkbox" value="' + value + '" ' + checked + ' groupName="' + id + '" class="' + validate + ' ChkGroup_' + id + '"  />';
        strControl += '<span> ' + options[index].text + '</span></td>';
        if (index == 0) {

        } else {
            if (count % 5 == 0) {
                strControl += "</tr><tr>";
                count = 0;
            }
        }


    }
    strControl += "</tr></table>";
    AddContentWithoutIcon(strControl, name, 8);
}


function GenHidden(id, value) {
    var strControl = '<input id="' + id + '" type="hidden" value="' + value + '" class="form-control" />';
    //AddContent(strControl, name);
    $("#form_content").append(strControl);
}


function GenPassword(id, value, name, validate, options) {
    var strLength = checkLengthValidate(validate, options);
    var strControl = '<input id="' + id + '" type="password" value="' + value + '" class="form-control ' + validate + '" ' + strLength + ' />';
    AddContent(strControl, name);
}

function GenSelect(id, value, name, validate, options) {
    var strControl = '<select id="' + id + '"  value="' + value + '" class="form-control ' + validate + '">';
    var indexCh = false;
    for (var index in options) {
        var selected = "";
        //alert(options[index].value + "," + value + (options[index].value == value));
        //這用來排掉server Null到這裡轉成""字串,JAVASCRIPT比對0和空字串,將0轉成字串為空字串,所以等號恆成立
        if (value.length > 0) {
            if (options[index].value == value) {
                selected = "selected";
                indexCh = true;
            }
        }
        strControl += '<option value="' + options[index].value + '" ' + selected + '>' + options[index].text + '</option>';
    }
    strControl += "</select>";
    AddContent(strControl, name);
    //若DB的值和下拉值對不上,則先給MODEL下拉的預設值
    //alert(id + "," + indexCh + "," + $("#" + id).val());
    if (indexCh == false) {
        model[id] = $("#" + id).val();
    }

}

function GenTime(id, value, name, validate, options_h, options_m) {

    var arr = value.split(":");
    var strControl = '<select id="' + id + '_h"  value="' + arr[0] + '" class="form-control ' + validate + '">';
    for (var h in options_h) {
        var selected = "";
        if (options_h[h] == Number(arr[0])) {
            selected = "selected";
        }
        strControl += '<option value="' + options_h[h] + '" ' + selected + '>' + options_h[h] + '</option>';
    }
    strControl += "</select>";
    strControl += '<span class="input-group-addon" style="background-color:white;border:none;">:</span>'

    strControl += '<select id="' + id + '_m"  value="' + arr[1] + '"   class="form-control" style="float:left;" >';

    for (var m in options_m) {
        var selected = "";
        //alert(options_m[m]);
        if (options_m[m] == Number(arr[1])) {
            selected = "selected";
        }
        strControl += '<option value="' + options_m[m] + '" ' + selected + '>' + options_m[m] + '</option>';
    }
    strControl += "</select>";
    AddContent(strControl, name);
}

function checkLengthValidate(validate, options) {
    if (validate != null) {
        var arrValidate = validate.split(" ");
        var strLength = "";
        var index = "0";
        for (var i = 0; i < arrValidate.length; i++) {
            if (arrValidate[i] == "length") {
                index = "1";
            }
        }
        if (index == "1") {
            strLength = "length='" + options + "'";
        }
        return strLength;
    } else {
        return "";
    }
}


//判斷是否必埴
function ifRequired(validate) {
    if (validate != null) {
        var arrValidate = validate.split(" ");
        var index = "0";
        for (var i = 0; i < arrValidate.length; i++) {
            if (arrValidate[i] == "required") {
                index = "1";
            }
        }
        if (index == "1") {
            return true;
        }
    } else {
        return false;
    }
}

//每筆欄位的固定樣式(ROW)
function AddContent(controler, name, controlLength) {
    if (controler.indexOf("required") > 0) {
        name = name + " <span style='color:red;'>*</span>";
    }


    if (controlLength == null)
        controlLength = 4;
    var html = '<div class="form-group">' + '<div class="col-sm-2 col-sm-offset-1">' + '<label class=" control-label" for="nvcName">' + name + ':</label>' + '</div>' + '<div class="col-sm-' + controlLength + ' input-group">'

    +'<span class="input-group-addon">' + GetIcon(controler, name) + '</span>' + controler + '</div>' + '</div>'

    $("#form_content").append(html);
}

function AddContentWithoutIcon(controler, name, controlLength) {
    if (controler.indexOf("required") > 0) {
        name = name + " <span style='color:red;'>*</span>";
    }
    if (controlLength == null)
        controlLength = 4;

    var html = '<div class="form-group">' + '<div class="col-sm-2 col-sm-offset-1">' + '<label class=" control-label" for="nvcName">' + name + ':</label>' + '</div>' + '<div class="col-sm-' + controlLength + ' input-group">'

    // + '<span class="input-group-addon"><span class="glyphicon glyphicon-font" aria-hidden="true"></span></span>'
    +controler
        + '</div>' + '</div>'

    $("#form_content").append(html);
}

function AddLine(name) {
    var html = '<div class="form-group">'

    +'<div style="background-color:#f1f1f1;padding-top:10px;padding-bottom:10px;margin-bottom:10px;margin-top:30px;" class="col-sm-10 col-sm-offset-1 input-group"><div style="padding-left:20px;margin-bottom:0px;;font-size:18px;font-weight:bold;color:gray;">《' + name + '》</div>'

    + '</div>' + '</div>'

    $("#form_content").append(html);
}


function GetIcon(controler, name) {
    var returnValue = "";
    var icons = ['<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>',
        '<span class="glyphicon glyphicon-tags" aria-hidden="true"></span>',
        '<span class="glyphicon glyphicon-user" aria-hidden="true"></span>',
        '<img src="/images/key.png" width="15" />',
        '<span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>',
        '<span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>',
        '<img src="/images/calendar.png" width="15" />',
        '<img src="/images/point.png" width="15" />',
        '<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>',
        '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
        '<span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>',
        '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>',
        '<img src="/images/img.png" width="15" />',
        '<img src="/images/money.png" width="15" />',
        '<img src="/images/text-file-icon.png" width="15" />',
        '<span class="glyphicon glyphicon-font" aria-hidden="true"></span>'

    ];
    var num = randomNum(0, 11);
    if (name.indexOf("手機") > -1)
        returnValue = icons[10];
    else if (name.indexOf("到期日") > -1 || name.indexOf("起始日") > -1 || name.indexOf("時間") > -1 || name.indexOf("日期") > -1 || name.indexOf("扣款日") > -1 || name.indexOf("生日") > -1 || name.indexOf("日期") > -1)
        returnValue = icons[6];
    else if (name.indexOf("mail") > -1 || name.indexOf("郵件") > -1 || name.indexOf("信件") > -1)
        returnValue = icons[8];
    else if (name.indexOf("電話") > -1)
        returnValue = icons[5];
    else if (name.indexOf("狀態") > -1 || name.indexOf("描述") > -1 || name.indexOf("內容") > -1)
        returnValue = icons[11];
    else if (name.indexOf("類別") > -1 || name.indexOf("重新入會") > -1)
        returnValue = icons[11];
    else if (name.indexOf("姓名") > -1)
        returnValue = icons[2];
    else if (name.indexOf("密碼") > -1)
        returnValue = icons[3];
    else if (name.indexOf("帳號") > -1)
        returnValue = icons[1];
    else if (name.indexOf("編號") > -1)
        returnValue = icons[0];
    else if (name.indexOf("身份證字號") > -1)
        returnValue = icons[4];
    else if (name.indexOf("顧問") > -1 || name.indexOf("聯絡人") > -1)
        returnValue = icons[2];
    else if (name.indexOf("地址") > -1 || name.indexOf("住址") > -1)
        returnValue = icons[7];
    else if (name.indexOf("照片") > -1 || name.indexOf("像片") > -1 || name.indexOf("圖片") > -1)
        returnValue = icons[12];

    else if (name.indexOf("費用") > -1 || name.indexOf("月費") > -1 || name.indexOf("金額") > -1 || name.indexOf("手續費") > -1 || name.indexOf("入會費") > -1 || name.indexOf("訂金") > -1 || name.indexOf("總額") > -1)
        returnValue = icons[13];
    else
        returnValue = icons[15];

    return returnValue;

}

function BulidControler(fieldParameters) {

    //產生控制項
    for (var p = 0; p < fieldParameters.length; p++) {
        var fname = fieldParameters[p].name;
        var fshow = fieldParameters[p].show;
        var fControler = fieldParameters[p].controler;
        var fValidate = fieldParameters[p].validate;
        var fOption = fieldParameters[p].option;


        var fCount = 0;
        for (var fid in model) {

            if (fieldParameters[p].dbname == fid) {

                if (fshow == false) {
                    fCount++;
                    continue;
                }
                switch (fControler) {
                    case "label":
                        GenLabel(fid, model[fid], fname, fValidate, fOption);
                        break;
                    case "hidden":
                        GenHidden(fid, model[fid]);
                        AddChangeEvent(fid);
                        break;
                    case "password":
                        GenPassword(fid, model[fid], fname, fValidate, fOption);
                        AddChangeEvent(fid);
                        break;

                    case "text":
                        GenText(fid, model[fid], fname, fValidate, fOption);
                        AddChangeEvent(fid);
                        break;

                    case "longtext":
                        GenLongText(fid, model[fid], fname, fValidate, fOption);
                        AddChangeEvent(fid);
                        break;

                    case "select":
                        //alert(fid);
                        GenSelect(fid, model[fid], fname, fValidate, fOption);
                        AddChangeEvent(fid);
                        break;

                    case "date":
                        GenText(fid, MVC_GetDate(model[fid]), fname, fValidate);
                        $("#" + fid).datepicker({ dateFormat: 'yy/mm/dd' });

                        AddChangeEvent(fid);
                        break;

                    case "time":
                        var arrH = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24"];
                        var arrM = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59"];
                        GenTime(fid, model[fid], fname, fValidate, arrH, arrM);

                        AddTimeChange(fid);

                        break;
                    case "timeInterval":
                        var arrH = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24"];
                        var arrM = ["00", "10", "20", "30", "40", "50"];
                        GenTime(fid, model[fid], fname, fValidate, arrH, arrM);

                        AddTimeChange(fid);

                        break;

                    case "checkbox":
                        GenCheckbox(fid, model[fid], fname, fValidate, fOption);
                        AddCheckboxChange(fid);
                        break;

                    case "fck":
                        GenFck(fid, model[fid], fname, fValidate);
                        AddFckChange(fid);
                        break;
                    case "file":
                        GenFile(fid, model[fid], fname, fValidate);
                        //AddFckChange(fid);
                        initUploader("fine-uploader-gallery", fid);
                        break;

                }
                fCount++;
            }
        }
        if (fControler == "line") {
            AddLine(fname);
        }

    }

}

function initUploader(id, fid) {
    $('#' + id).fineUploader({
        template: 'qq-template-gallery',
        request: {
            endpoint: '/backend/api/upload'
        },
        thumbnails: {
            placeholders: {
                waitingPath: '/images/waiting-generic.png',
                notAvailablePath: '/images/not_available-generic.png'
            }
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
        },
        callbacks: {
            onComplete: function(id, name, response) {
                var serverPathToFile = response.filePath,
                    fileItem = this.getItemByFileId(id);
                //alert(id+","+name+","+JSON.stringify(response));
                if (response.success) {
                    //var viewBtn = qq(fileItem).getByClass("view-btn")[0];
                    model[fid] = response.name;
                    $("#oldImage").remove();
                    //viewBtn.setAttribute("href", serverPathToFile);
                    //qq(viewBtn).removeClass("hide");
                }
            }
        }
    });
}

function ajaxSave(model, url) {
    //alert(JSON.stringify(model));
    return $.ajax({
        type: 'post',
        dataType: 'json', // to client
        contentType: "application/x-www-form-urlencoded;", //to server
        url: url,
        cache: false,
        data: model,
        error: function(xhr, ajaxOptions, thrownError) {
            console.log("server msg:" + JSON.stringify(xhr));
            console.log("msg:" + thrownError);
            //alert(JSON.stringify(xhr) + "," + thrownError);
            //alert("error");
        },
        success: function(response) {
            //return JSON.parse(response);

        },
        complete: function(data) {}
    });
}

//編輯頁面,儲存成功統一做的事,更新ID回畫面,show訊息,重整列表
function ajaxSaveEditSuccess(key) {
    $("#intID").val(key);
    if (model)
        model["intID"] = key;
    //showMsg("儲存成功");
    parent.close();
    parent.reload();
}

function GetLoginUrl() {
    var strKeyword = window.location.toString().toLowerCase();

    if (strKeyword.indexOf("backend") > -1)
        return "/backend/login";
    else
        return "/Flogin";
}
//====================================
//產生控制項-結尾
//====================================


//====================================
//   其它共用function
//====================================



function PopWindow(path, w, h, title) {

    var iWidth = Number(getBrowserWidth());
    var iHeight = Number(getBrowserHeight());

    $("#tallModal iframe").attr('src', path);
    $("#tallModal iframe").css('height', iHeight - 250);
    //$("#tallModal iframe").css('width', iWidth-160);
    //alert(iWidth + "," + iHeight);

    $(this).find(".modal-body").css("max-height", iHeight - 250);
    $(this).find(".modal-body").css("max-width", iWidth - 200);
    $("#tallModelTitle").html(title);

    $("#tallModal").modal('show');

    //$("#tallModal").on("show.bs.modal", function () {
    //var height = $(window).height() - 200;
    //});

    //$.colorbox({
    //    iframe: "true", href: path, width: fw, height: fh,
    //    onComplete: function () {
    //    }
    //});
}


function delWindow(path, w, h) {

    var iWidth = Number(getBrowserWidth());
    var iHeight = Number(getBrowserHeight());

    $("#delModal iframe").attr('src', path);
    $("#delModal iframe").css('height', 250);

    $(this).find(".modal-body").css("max-height", 250);
    $(this).find(".modal-body").css("max-width", iWidth - 200);

    $("#delModal").modal('show');
}

function showMsg(msg) {
    $("#divMsg").stop();
    $("html, body").animate({ scrollTop: 0 }, "slow");
    $("#divMsg span").html(msg);
    $("#divMsg").fadeIn().delay(5000).fadeOut();
}

function showErrorMsg(msg) {
    $("#divErrorMsg").stop();
    $("html, body").animate({ scrollTop: 0 }, "slow");
    $("#divErrorMsg #msgText").html(msg);
    $("#divErrorMsg").fadeIn().delay(5000).fadeOut();
}
//產生唯一ID
function GetUniqeID(preStr) {
    var reID = '';
    for (i = 0; i < 1000; i++) {
        if ($("#" + preStr + i).length > 0) {
            continue;
        } else if ($("." + preStr + i).length > 0) {
            continue;
        } else {
            reID = preStr + i;
            break;
        }
    }
    return reID;
}

//去字串左右空白
function trim(str) {
    var start = -1,
        end = str.length;
    while (str.charCodeAt(--end) < 33);
    while (str.charCodeAt(++start) < 33);
    return str.slice(start, end + 1);
}

//選取字串
function getSelText() {
    var txt = '';
    if (window.getSelection) {
        txt = window.getSelection();
    } else if (document.getSelection) {
        txt = document.getSelection();
    } else if (document.selection) {
        txt = document.selection.createRange().text;
    }
    return txt;
}

//取得瀏覽器視窗高度
function getBrowserHeight() {
    if ($.browser.msie) {
        return document.compatMode == "CSS1Compat" ? document.documentElement.clientHeight :
            document.body.clientHeight;
    } else {
        return self.innerHeight;
    }
}

//取得瀏覽器視窗寬度
function getBrowserWidth() {
    if ($.browser.msie) {
        return document.compatMode == "CSS1Compat" ? document.documentElement.clientWidth :
            document.body.clientWidth;
    } else {
        return self.innerWidth;
    }
}

//呼叫列表機
function printScreen(objID) {
    var value = $("#" + objID).html();
    var printPage = window.open("", "printPage", "");
    printPage.document.open();
    printPage.document.write("<HTML><head>");
    printPage.document.write("<link href=\"css/igot_interactive.css\" rel=\"stylesheet\" type=\"text/css\">");
    printPage.document.write("<link href=\"css/igot_base.css\" rel=\"stylesheet\" type=\"text/css\">");
    printPage.document.write("</head>");
    printPage.document.write("<BODY onload='window.print();window.close()'>");
    printPage.document.write(value);
    printPage.document.close("</BODY></HTML>");
}

//去HTML TAG
function RemoveHTML(strText) {
    var regEx = /<[^>]*>/g;
    return strText.replace(regEx, "");
}

//取得GET參數
function QueryString(name) {
    var AllVars = window.location.search.substring(1);
    var Vars = AllVars.split("&");
    for (i = 0; i < Vars.length; i++) {
        var Var = Vars[i].split("=");
        if (Var[0] == name) return Var[1];
    }
    return "";
}


//傳進來為MVC的DATE 格式  EX:1982/4/11 上午 12:00:00
function MVC_GetDate(strDate) {
    var arr = strDate.split(" ");
    //return arr[0];
    if (strDate.trim() == "") {
        return "";
    } else {
        return moment(arr[0]).format('YYYY/MM/DD');
    }
}

function MVC_GetDatetime(strDate) {
    var arr = strDate.split(" ");
    var sDate = arr[0];
    var sAMPM = arr[1];
    var sTIME = arr[2];
    var newHour = 0;


    var arrTime = sTIME.split(":");

    if (sAMPM == "上午" && sTIME == "12:00:00")
        sTIME = "00:00:00"
    if (sAMPM == "下午") {
        newHour = Number(arrTime[0]) + 12;
    }

    return sDate + " " + newHour + ":" + arrTime[1] + ":" + arrTime[2];
}


function MVC_URL_ID() {
    var arrUrl = window.location.toString().split("/");
    var id = arrUrl[arrUrl.length - 1];
    if (id.indexOf("?") >= 0) {
        var arrP = id.split("?");
        id = arrP[0];
    }
    return id;
}

//======================================================
//html table匯出至csv下載(IE11 chrome OK)
function exportTableToCSV($table, filename) {
    var $rows = $table.find('tr:has(td),tr:has(th)'),
        // Temporary delimiter characters unlikely to be typed by keyboard
        // This is to avoid accidentally splitting the actual contents
        tmpColDelim = String.fromCharCode(11), // vertical tab character
        tmpRowDelim = String.fromCharCode(0), // null character
        // actual delimiter characters for CSV format
        colDelim = '","',
        rowDelim = '"\r\n"',
        // Grab text from table into CSV formatted string
        csv = '"' + $rows.map(function(i, row) {
            var $row = $(row),
                $cols = $row.find('td,th');
            return $cols.map(function(j, col) {
                var $col = $(col),
                    text = $col.text();
                return text.replace(/"/g, '""'); // escape double quotes
            }).get().join(tmpColDelim);
        }).get().join(tmpRowDelim)
        .split(tmpRowDelim).join(rowDelim)
        .split(tmpColDelim).join(colDelim) + '"',
        // Data URI
        csvData = 'data:application/csv;charset=utf-8,\ufeff' + encodeURIComponent(csv);
    console.log(csv);

    if (window.navigator.msSaveBlob) { // IE 10+
        //alert('IE' + csv);
        window.navigator.msSaveOrOpenBlob(new Blob(["\ufeff" + csv], { type: "text/plain;charset=utf-8;" }), "csvname.csv")
    } else {
        $(this).attr({ 'download': filename, 'href': csvData, 'target': '_blank' });
    }
}