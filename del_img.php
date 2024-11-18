<?php
include_once "function.php";
$id = $_GET['id'];

// $imgName = find('imgs',$id)['filename'];
$row = find('imgs',$id);
$imgName = $row['filename'];
// 刪除檔案
unlink("./files/$imgName");
// 刪除資料
del("imgs",$id);
// 返回頁面
header("location:manage.php");

?>