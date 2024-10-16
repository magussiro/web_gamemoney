<?php
//==================================================================
//========================資料庫部份=================================
//==================================================================

class WebDB
{
    private $_ip = "127.0.0.1", $_account = "root", $_password = "", $_dbName = "future", $primaryKey, $table;
    private $conn;

    public function __construct($ip, $account, $pass, $db)
    {
        $this->_ip = $ip;
        $this->_account = $account;
        $this->_password = $pass;
        $this->_dbName = $db;

        $this->getConn();
    }

    private function getConn()
    {
        if ($this->conn == null) {
            $conn = mysqli_connect($this->_ip, $this->_account, $this->_password, $this->_dbName);
            mysqli_set_charset($conn, "utf8");

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $this->conn = $conn;
        }

        //return $conn;
    }

    public function query($sql)
    {
        $this->getConn();
        $result = $this->conn->query($sql);

        //判斷DB是不是或sql是不是出錯
        if ($result) {
            //$arrResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $arrResult = array();
            while ($row = $result->fetch_assoc()) {
                $arrResult[] = $row;
            }

            //判斷是不是有資料，無資料回傳false,而不是空陣列
            if ($arrResult == null) {
                return false;
            } else {
                return $arrResult;
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
            exit;
        }
    }


    public function query_check($sql, $arrParam)
    {
        //var_dump($arrParam);
        $conn1 = $this->getConn();

        $arrP = array();
        foreach ($arrParam as $k => $v) {
            //echo '<br>'. $k .'='.$v .'<br>';
            if ($v != null) {
                $arrP[$k] = $this->escape($v);
            } else {
                $arrP[$k] = $v;
            }
        }


        //echo count($arrP);
        foreach ($arrP as $k => $v) {
            //echo '@'.$k . '=' . $v.'<br>';
            $sql = str_replace('@' . $k, "'" . $v . "'", $sql);
        }


        return $this->query($sql);

    }

    public function single_check($sql, $arrParam)
    {
        //var_dump($arrParam);
        $conn1 = $this->getConn();

        $arrP = array();
        foreach ($arrParam as $k => $v) {
            //echo '<br>'. $k .'='.$v .'<br>';
            if ($v != null) {
                $arrP[$k] = $this->escape($v);
            } else {
                $arrP[$k] = $v;
            }
        }


        //echo count($arrP);
        foreach ($arrP as $k => $v) {
            //echo '@'.$k . '=' . $v.'<br>';
            $sql = str_replace('@' . $k, "'" . $v . "'", $sql);
        }

        //var_dump($sql);
        return $this->single($sql);

    }

    function escape($string)
    {
        return $this->conn->real_escape_string($string);
    }

    public function single($sql)
    {
        $this->getConn();
        $result = $this->conn->query($sql);
        //判斷DB是不是或sql是不是出錯
        if ($result) {
            //$arrResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $arrResult = array();
            while ($row = $result->fetch_assoc()) {
                $arrResult[] = $row;
            }


            //判斷是不是有資料，無資料回傳false,而不是空陣列
            if ($arrResult == null) {
                return false;
            } else {
                return $arrResult[0];
            }
        } else {
            if (DEBUG_ENABLE == true) {
                $t = time();
                $file = "testlog/pay.log";
                $file_path = "/var/www/html/gamemoney";

                $f_handle = fopen($file_path . "/" . $file, "a");

                if (!$f_handle) return false;
                $msg = date("Y-m-d H:i:s", $t) . " -- ERROR: $sql" . mysqli_error($this->conn) . "\n";

                fwrite($f_handle, $msg);
                fclose($f_handle);
            } else {

                echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
            }
            exit;
        }
    }


    //取得資料庫資料
    public function execSql($sql)
    {
        $this->getConn();
        $result = $this->conn->query($sql);

        if ($result) {
            return $result;
        } else {
            if (DEBUG_ENABLE == true) {
                $t = time();
                $file = "testlog/pay.log";
                $file_path = "/var/www/html/gamemoney";

                //$f_handle = fopen($file_path . "/" . $file, "a");

                //if (!$f_handle) return false;
                $msg = date("Y-m-d H:i:s", $t) . " -- ERROR: $sql" . mysqli_error($this->conn) . "\n";
                
                //var_dump($msg);
                fwrite($f_handle, $msg);
                fclose($f_handle);
            } else


                echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
            exit;
        }
    }

    //新增
    public function Insert($table, $mapData)
    {
        $values = '';
        $columns = '';
        foreach ($mapData as $k => $v) {
            $columns .= $k . ',';
            if (is_int($v))
                $values .= $v . ",";
            else
                $values .= "'" . $this->escape($v) . "',";

        }
        $columns = substr($columns, 0, strlen($columns) - 1);
        $values = substr($values, 0, strlen($values) - 1);

        $sql = 'insert into `' . $table . '` (' . $columns . ')' .
            ' values(' . $values . ');';

        //echo $sql;
        // ';SELECT LAST_INSERT_ID() as id ;'
        $result = $this->execSql($sql);
        return mysqli_insert_id($this->conn);
        //return $result;
    }

    //更新
    public function Update($table, $where, $mapData)
    {

        $columns = '';
        foreach ($mapData as $k => $v) {
            if (is_int($v))
                $columns .= $k . '=' . $v . ',';
            else
                $columns .= $k . '= \'' . $this->escape($v) . '\',';
        }
        $columns = substr($columns, 0, strlen($columns) - 1);
        //$values = substr($values, 0 , strlen($values) -1);

        $strWhere = '';

        //hash table
        if (is_array($where)) {
            foreach ($where as $k => $v) {
                $strWhere .= $k . ' = \'' . $v . '\'' . ' and ';
            }
            $strWhere = substr($strWhere, 0, strlen($strWhere) - 4);
        }

        //int
        if (is_int($where)) {

        }

        // string
        if (is_string($where)) {
            $strWhere = $where;
        }
        $sql = 'update  `' . $table . '` set ' . $columns . ' where ' . $strWhere;


        //echo $sql;
        $result = $this->execSql($sql);
        return $result;
    }


    //刪除
    static private function Delete($table, $column, $id)
    {

    }
}

function getDefaultDB()
{
    global $db_config;

  // var_dump($expression);
    $db = new WebDB($db_config['ip'], $db_config['account'], $db_config['password'], $db_config['dbName']);
    return $db;
}


class BackendDB
{
    private static $adb;

    function __construct()
    {
        self::$adb = $this->getAdminDB();
    }

   static function  getAdminDB()
    {
       if(self::$adb ==null){
                   global $adb_config;
        self::$adb  = new WebDB($adb_config['ip'], $adb_config['account'], $adb_config['password'], $adb_config['dbName']);
       }

        return  self::$adb ;
    }


}


?>