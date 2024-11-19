<?php
include_once "function.php";
$id = $_POST['id'];
$row = find("imgs",$id);
dd($_POST);
dd($row);
$row['descr'] = $_POST['descr'];

// $imgName = $_POST['imgName'];

// exit();
// echo $imgName;

if(isset($_FILES['filename'])){
    if($_FILES['filename']['error']==0){
        unlink("./files/".$row['filename']);
        $row['filename'] = time().time() . $_FILES['filename']['name'];
        move_uploaded_file($_FILES['filename']['tmp_name'],"./files/".$filename);
        // update('imgs',$row);
        // insert('imgs',$row);
        save("imgs", $row);
    } else {
        echo "上傳失敗，請檢查檔案格式或是大小是否符合規定。";
    }
}

header("location:manage.php");
?>