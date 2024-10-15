<?php
/**
 * Created by PhpStorm.
 * User: Magus
 * Date: 2016/10/6
 * Time: 下午12:23
 */




//if ( !isset($_POST["k"]) ) die("{\"code\":1}");


class APITest
{
    protected $api;
    var $input;
    var $apiName;
    var $apiUrl;
    var $server_name;
    var $project_name;

    function __construct()
    {

        if ($_SERVER['SERVER_NAME'] == 'localhost'||'127.0.0.1')
            $this->project_name = 'new_ishare';
        else if (empty($_SERVER['SERVER_NAME']))
            $this->project_name = 'iShareServer';

    }

    function setApiName($apiName, $old = false)
    {

        #M1 使用原始根目錄
        if ($old == true)
            $this->apiUrl = ($_SERVER["HTTP_HOST"] . '/' . $this->project_name . '/um/');
        else
            $this->apiUrl = ($_SERVER["HTTP_HOST"] . '/' . $this->project_name . '/api/');
        #M2 使用API目錄

        $this->apiName = $apiName;
        $this->apiUrl = $this->apiUrl . $apiName;
    }
    function setApiUrl($url){
        $this->apiUrl = $url;

    }

    function addApiInput($key, $value)
    {
        if (is_null($this->input)) {
            $this->input = [];
            $this->input[$key] = $value;
        } else
            $this->input[$key] = $value;
    }

    function getApiInput()
    {
        return $this->input;
    }

    function excuteApi()
    {
        var_dump($this->apiUrl);
        var_dump(  $this->getApiInput());
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
            $this->getApiInput()

        ));
        curl_exec($ch);
        curl_close($ch);


    }

    function setCurlApiName($apiName){

        $this->apiUrl = 'ar.sammi.tw/';
        $this->apiUrl = $this->apiUrl . $apiName;

        $this->apiName = $apiName;

    }
}