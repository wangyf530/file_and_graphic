<?php
/**
 * 1.建立資料庫及資料表來儲存檔案資訊
 * 2.建立上傳表單頁面
 * 3.取得檔案資訊並寫入資料表
 * 4.製作檔案管理功能頁面
 */


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>檔案管理功能</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table{
            width: 500px;
            margin:20px auto;
        }

        td{
            padding: 5px 10px;
        }

        td img{
            width: 120px;
        }

        table a{
            display:inline-block;
            padding: 5px 10px;
            border: 1px solid #ccc;
            margin: 5px;
            border-radius:8px;
        }
        
        a:hover{
            background-color:skyblue;
        }
        
        .addMore{
            margin:auto;
            background-color:pink;
            width: 100px;
            height: 30px;
            border-radius:20px;
            text-align: center;
            padding:4px;
        }

    </style>
</head>
<body>
<h1 class="header">檔案管理練習</h1>
<!----建立上傳檔案表單及相關的檔案資訊存入資料表機制----->
<?php
include_once "function.php";
// no need 
// echo $_POST['name'];
// echo "<br>";
// dd($_FILES);

if(isset($_FILES['filename'])){
    if($_FILES['filename']['error']==0){
        $filename = time() . $_FILES['filename']['name'];
        move_uploaded_file($_FILES['filename']['tmp_name'],"./files/".$filename);
        $descr = $_POST['descr'];
        // insert("imgs",['filename'=>$filename, 'descr'=>$descr]);
        save("imgs",['filename'=>$filename, 'descr'=>$descr]);
    } else {
        // 前面會需要更多判定去檢查
        echo "上傳失敗，請檢查檔案格式或是大小是否符合規定。";
    }
}
?>

<!----透過檔案讀取來顯示檔案的資訊，並可對檔案執行更新或刪除的工作----->
<!-- first attempt -->
<?php
// open the folder first - menu path
$dirpath = "./files";

// open directory handle - 檔案要處理的狀態
// 返回resourse - 資源: 包含 檔案
// $dir = opendir($dirpath);

// 因為沒有要更改所以用scan就好
$items = scandir($dirpath);
// 如果要判斷要再加程式碼
$items = array_diff($items, array('.','..'));

// print every file in $dirpath
// dd($items);

// print every pic file in dirpath
// 1 pic every row
/* foreach ($items as $file) {
    echo "<div class='item'>";
    echo "<img src='{$dirpath}/{$file}'>";
    echo "<a href='del_img.php?file={$file}'>刪除</a>";
    echo "<a href='re_upload.php?file={$file}'>重新上傳</a>";
    echo "</div>";
}
*/

$rows = all('imgs');
echo "<table>";
foreach ($rows as $file) {
    // dd($file);
    echo "<tr>";
    echo "<td> <img src='files/{$file['filename']}'> </td>";
    echo "<td>  {$file['descr']} </td>";
    echo "<td> <a href='del_img.php?id={$file['id']}'>刪除</a> </td>";
    echo "<td> <a href='show_img.php?id={$file['id']}'>";
    // 如果當前圖片是顯示(1)的話就寫隱藏
    echo ($file['sh']==1)?"隱藏":"顯示";
    echo"</a> </td>";
    echo "<td> <a href='re_upload.php?id={$file['id']}'>重新上傳</a> </td>";
    echo "</tr>";
}
echo "</table>";

?>

<!----透過資料表來顯示檔案的資訊，並可對檔案執行更新或刪除的工作----->


<div class="addMore">
    <a href="./upload.php">繼續新增</a>
</div>

</body>
</html>