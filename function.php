<?php
// 定義
define("DBNAME","file");

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
    /**
     * 建立資料庫的連線變數
     * @param string $db 資料庫名稱
     * @return object
     */
    function pdo($db) {
        $dsn = "mysql:host=localhost; charset=utf8; dbname=$db";
        // 也可以再param帳號密碼
        $pdo = new PDO($dsn, 'root', '');
        return $pdo;
    }

    /* 
     * all()-給定資料表名後，會回傳整個資料表的資料
     * @param string $table 資料表名稱
     * @return array 
     */

    function all($table){
        // 連線資料庫
        $pdo = pdo(DBNAME);
        // 去找有沒有全域 但比較浪費記憶體 可以的話不建議
        // global $pdo;
        // 判斷是否有該資料庫
        $sql = "SELECT * FROM $table";
        $rows= $pdo -> query($sql) -> fetchALL(PDO::FETCH_ASSOC);
        return $rows;

        // if(有){
        //     // 返回資料庫信息
        // } else {
        //     // 回傳錯誤信息
        // }
        // return '整個資料夾的資料';
    }

    /**
     * find()-會回傳指定資料表 的 特定id的 單筆資料
     * @param string $table 資料表名稱
     * @param integer/array $id 資料表ID
     * @return array
     */
    function find($table, $id) {
        $sql = "SELECT * FROM $table WHERE ";
        $pdo = pdo(DBNAME);
        if(is_array($id)){
            // 檢查帳號密碼
            $tmp = [];
            foreach ($id as $key => $value) {
                // sprintf(" `%s`='%s' ", $key, $value);
                $tmp[] = "`$key` = '$value'";
            }
            $sql = $sql.join("&&", $tmp);
        } else {
            // 拉取指定ID的資料
            $sql = $sql." `id` = $id";
        }
        $row = $pdo -> query($sql) -> fetch(PDO::FETCH_ASSOC);
        return $row;
    }


    /**
     * 新增或更新資料
     */
    function save($table,$array){
        if(isset($array['id'])){
            // update
            update($table, $array);
        } else {
            // insert
            insert($table, $array);
        }
    }




    /**
     * 更新指定條件的資料
     * @param string $table 資料表名稱
     * @param array $array 更新的欄位以及內容
     * @param array/integer $id 條件(數字或陣列)
     * @return boolean 
     */
    function update($table, $array) {
        $sql = "UPDATE $table SET ";
        $pdo = pdo(DBNAME);
        // 要更新的東西
        $tmp = [];
        if(isset($array['id'])){
            // 加上where的部分
            $id = $array['id'];
            unset($array['id']);

            foreach ($array as $key => $value) {
                // sprintf(" `%s`='%s' ", $key, $value);
                $tmp[] = "`$key` = '$value'";
            }
            $sql = $sql. join(",", $tmp) . " WHERE `id` = '$id'";
        }
        return $pdo -> exec($sql);
    }

    /* 
        function update($table, $array, $id) {
        $sql = "UPDATE $table SET ";
        $pdo = pdo(DBNAME);
        // 要更新的東西
        $tmp = [];
        foreach ($array as $key => $value) {
            // sprintf(" `%s`='%s' ", $key, $value);
            $tmp[] = "`$key` = '$value'";
        }
        // set `acc`='acc', `pw`='pw'
        $sql = $sql.join(",", $tmp);

        // 如果給的id是字串
        if(is_array($id)){
            // 加上where的部分
            $tmp = [];
            foreach ($id as $key => $value) {
                // sprintf(" `%s`='%s' ", $key, $value);
                $tmp[] = "`$key` = '$value'";
            }
            $sql = $sql. " WHERE ".join("&&", $tmp);
        } else {
            // 加上where的部分
            $sql = $sql." WHERE `id` = $id";
        }
        return $pdo -> exec($sql);
    }
    */

    /**
     * 新增資料
     * @param string $table 資料表名稱
     * @param string $cols 新增的欄位字串
     * @param string $values 新增的數值字串
     * @param array $array 
     * @return boolean
     */
    // function insert($table, $cols, $values){
    function insert($table, $array){
        $pdo = pdo(DBNAME);
        $sql = "INSERT INTO $table ";
        // $sql = $sql . $cols;
        // $sql = $sql. "values ". $values;
        $keys = array_keys($array);
        $sql = $sql . "(`" . join("`,`",$keys) . "`) values ('" . join("','",$array) . "')";

        return $pdo -> exec($sql);
    }

    /**
     * update 跟 insert 可以合併 -> save
     * 差別在id 可以用 isset 區分開來
     */
    
    /**
     * del()-給定條件後，會去刪除指定的資料
     * @param string $table 資料表名稱
     * @param integer/array $id 條件(數字或陣列)
     * @return boolean 是否有刪除成功
     */
    function del($table, $id) {
        $sql = "DELETE FROM $table WHERE ";
        $pdo = pdo(DBNAME);
        if(is_array($id)){
            // 檢查帳號密碼
            $tmp = [];
            foreach ($id as $key => $value) {
                // sprintf(" `%s`='%s' ", $key, $value);
                $tmp[] = "`$key` = '$value'";
            }
            $sql = $sql.join("&&", $tmp);
        } else {
            // 拉取指定ID的資料
            $sql = $sql."`id` = $id";
        }
        // 返回TRUE如果成功刪除 FALSE如果刪除失敗
        return $pdo -> exec($sql);
    }
    ?>
</body>
</html>