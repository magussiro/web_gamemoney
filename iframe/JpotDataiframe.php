<?php include_once("lib/config.php"); ?>
<?php include_once("func/func_game.php");?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="<?php echo $webroot; ?>/js/jquery.js"></script>
    <script>
        $(function () {
//            setInterval('window.reload()', 3600000);
            setInterval(ajaxCall_JpotData, 1000);
            function ajaxCall_JpotData() {
                jQuery.ajax({
                    method: "POST",
                    url: "game.php?m=getJpotData",
                    //url: "gamemoney/game.php?m=getJpotData",
                    cache: false,
                    datatype: "json",
                })

                    .done(function( msg ) {
                        var jsonObj = JSON.parse(msg);
                        $.each(jsonObj,function(id,element){
                            var result = element.accumulation.replace(/\d+?(?=(?:\d{3})+$)/img, "$&,");
                            if ( result == "" ) {
                                window.open(location, '_self', '');
                            }
                            else {
                                $(".md_money_num"+id).html(result);
                            }
                            //console.log(result);
                        });
                    });
            }
        })
    </script>
</head>
<body>
<ul id="md_money_ul" style="text-align: right; margin-left:45px;">  <!--width:90%;-->
    <?php
    for( $i=0 ; $i<4 ; $i++ ){
        echo "<li>JP".($i+1)."<span class='md_money_num md_money_num".$i."' id='md_money_num'></span></li>";
    }
    ?>
</ul>
</body>
</html>