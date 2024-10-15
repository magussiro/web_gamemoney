<?php
/**
 * Created by PhpStorm.
 * User: Magus
 * Date: 2017/5/9
 * Time: 下午12:05
 */ ?>
<script type="text/javascript" src="../js/jquery.js"></script>

<script>

    function ajaxCall_Marque() {
        jQuery.ajax({
            method: "GET",
            url: "http://gamemoney.sammicorner.com/testsvn/game.php?m=getMarque",
            cache: false,
            datatype: "json",
        })

            .done(function (msg) {
                var jsonObj = JSON.parse(msg);
                alert(jsonObj.id);
//                $.each(jsonObj, function (id, element) {
//                    var result = element.msg;
//                    $("#marquee" + id).html("【" + result + "】");
//                });
            });
    }
</script>

