<?php

date_default_timezone_set("Asia/Taipei");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//include_once("../lib/WebDB.php");

class basePage 
{

    public $_db;
    public function __construct ()
    {
        $this->_db = getDefaultDB();
        //去html tag,加反斜線,去前後空白
        $this->checkInput();

        //做頁面認證
        if( isset( $_POST['page_token']))
        {
            if($_POST['page_token'] !=  $_SESSION['page_token'])
            {
                $URL = $_SERVER['PHP_SELF'];
                $this->redirect($URL ,'頁面認證失敗或逾時，請重新送出。');
            }
        }
        $_SESSION['page_token'] = $this->randPassword(100);
    }  

    //過濾所有POST ,GET值，
    private function checkInput()
    {
        if(count($_POST)>0)
        {
			foreach($_POST as $k=>$v)
			{
                if(strpos($k,"passFilterByChris"))
                {		
                }
                else
                {
                    $_POST[$k] = $this->Filter($_POST[$k]);
                }
			} 
		}
		
		if(count($_GET)>0)
		{
			foreach($_GET as $k=>$v)
			{
				$_GET[$k] = $this->Filter($_GET[$k]);
			} 
		}
    }
    //}
	
    //過濾值
	private function Filter($value)
	{
         //substr( strip_tags(addslashes(trim($_POST['name']))),0,40);
         $value = strip_tags(trim($value));
		// 去除斜杠
		if(!get_magic_quotes_gpc())
		{
		  //$value = stripslashes($value);
		  $value = addslashes($value);
		}
		return $value;
	}

    //產生隨機密碼
    public function randPassword($len)
	{
		//密碼長度
		//$len = 8;
		//o、l、0、1容易混淆，不加入產生字元內
		$Range = 'abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
		$StrLen = strlen($Range);

		$Passwd = '';
		for ($i = 0; $i < $len; $i++) 
		{
			$Passwd .= $Range[rand() % $StrLen];
		}
		return $Passwd;
	}

    //檢查是否登入
    public function isLogin()
    {
//        $this->alert(isset($_SESSION['user_account']));
        if(!isset($_SESSION['fuser_account']))
        {
            $this->alert('請先登入！');
            echo '<script>window.location="index.php";</script>';
            exit;
        }

        if ($_SESSION['fuser_account'] == null )
        {
            $this->alert('請先登入！');
            echo '<script>window.location="index.php";</script>';
            exit;
        }
    }

    //jquery.datatable 參數
    public function addParam ( $sql  )
    {
        //datatable必傳參數
        $echo = $_POST['sEcho'];
		$intStart = $_POST['iDisplayStart']; 
		$intLength = $_POST['iDisplayLength'];

        //先取得不分頁總數量
        $pageResult =  $this->_db->query($sql);
        $total = count($pageResult);

        //取得分頁後資料
        if ( $intLength>=1) {
		  $sql .= " LIMIT $intStart , $intLength ";
		}

        $aaData =  $this->_db->query($sql);
        if(!$aaData)
        {
            $aaData = array();
        } 
		//回傳dattable需要欄位
        $mapMerge = array();
		$mapMerge['sEcho']			= $echo;	
	    $mapMerge['iTotalRecords'] = $total;
		$mapMerge['iTotalDisplayRecords']	= $total;
		$mapMerge['aaData']		= $aaData;
        return $mapMerge;
    }

    //回傳json,為了ajax call回應
    public function jsonView($mapData)
    {
		if(is_array($mapData))
		{
			echo json_encode($mapData);
		} 
		else
		{
			$msg = array();
			$msg['msg'] = $mapData;
			echo json_encode($msg);
		}
		 exit;
    }


    //將DB的資料，對應到model欄位，欄位名稱需和DB一致才行
    public function dbDataToModel($result , $model)
    {
        $model_final = array();
        //將DB 資料對應回model
       
        if($result)
        {
            //var_dump($result);
           
             foreach($model as $k2=>$v2)
            {

                $index = false;
                foreach($result as $k=>$v)
                {
                    
                    if($k2 == $k)
                    {
                        $model_final[$k2] = $this->removeChangeLine( $v );
                        $index = true;
                    }
                }

                if($index == false)
                {
                    $model_final[$k] = '';
                }

            } 

        }
        else
        {
            foreach($model as $k=>$v)
            {
                $model_final[$k] = '';
                 
            }
        }
        //var_dump($model_final);
        return $model_final;
    }

    //傳訊息轉頁，或只轉頁
    public function redirect($url,$alert)
    {
        $str = '<script>';
        if($alert == null)
        {
            $str.= 'window.location="'. $url .'";';
        }
        else
        {
            $str.= 'alert("'. $alert .'");';
            $str.= 'window.location="'. $url .'";';
        }
        $str .= '</script>';
        echo $str;
        //exit;
    }

    //js alert訊息
//    public function alert($msg)
//    {
//        $str = '<script>';
//
//        $str.= 'alert("'. $msg .'");';
//
//        $str .= '</script>';
//        echo $str;
//    }

   public function encrypt($str)
    {
        // 設定金鑰, 負責對資料進行加解密 
        $key = "XJcT5GssghJ8sYzCXYECagbkKI3vAMC7";
        //ZuBurXJcT5GssghJ8sYzCXYECagbkKI3vAMC7MVy8BGQZeQ7wNmYcjCE4aXEbWew6hXakjHJKEQaJFPeJacL4WHVnV9pRUSvufD6

        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);  
        return base64_encode(trim(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB, $iv)));  
    }

        /**
        * 解密函數
        */
    public function decrypt($str)
    {
        // 設定金鑰, 負責對資料進行加解密 
        $key = "XJcT5GssghJ8sYzCXYECagbkKI3vAMC7";

        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($str), MCRYPT_MODE_ECB, $iv));  
    } 

    //移除textarea中的換行符號，避免在JS中出錯
    public function removeChangeLine($str)
    {
        $str=explode("\r\n",$str);
        $str=implode("<br>",$str);
        return $str;
    }

    public function httpGet($url)
    {
        /*
        $ch = curl_init();  
 
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        //網址有https 預設變開，設定傳出去關閉ssl認認，開啟的話server要裝東西，
        //錯誤訊息為 error: SSL connect error 
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
        //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); // set browser/user agent    
        //curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header'); // get header
        //curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
	    //curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        //curl_setopt($ch, CURLOPT_SSLVERSION , 3);
        //curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        //不回傳額外html tag，因為這裡用ajax call
        curl_setopt($ch,CURLOPT_HEADER, false); 
    
        $output = curl_exec($ch);
       
        if(curl_error($ch))
        {
            //echo "Error Number:".curl_errno($ch);
             $output = "Error String:".curl_error($ch);
        }

        curl_close($ch);

        return $output;*/

        //放棄上面curl 會因為主機php 版本和 ssl設定出問題
        try{
            $postdata = http_build_query(
                array(
                    'var1' => 'some content',
                    'var2' => 'doh'
                )
            );

            $opts = array('http' =>
                array(
                    'method'  => 'GET',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );

            $context  = stream_context_create($opts);
            $result = file_get_contents($url, false, $context);
        }
        catch(Exception $e)
        {
            echo $e;
            return $e;
        }
        return $result;
    }
    

    function read_header($ch, $string) {
        print "Received header: $string";
        return strlen($string);
    }

    function httpPost($url,$params)
    {
        $postData = '';
        //create name value pairs seperated by &
        foreach($params as $k => $v) 
        { 
            $postData .= $k . '='.$v.'&'; 
        }
        $postData = rtrim($postData, '&');
    
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, false); 
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
    
        $output=curl_exec($ch);

        if(curl_error($ch))
        {
            return "Error String:".curl_error($ch);
        }
        curl_close($ch);
        return $output;
    }


}
function isFblogin(){
    return !empty($_SESSION['fb_login']);
}


?>