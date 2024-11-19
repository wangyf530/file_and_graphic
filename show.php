<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>相簿</title>
    <style>
        .album{

        }
    </style>
</head>
<body>
    <h1> 相簿 </h1>
    <div class="album">
<?php
    include_once "function.php";
    $rows = all('imgs');

    foreach ($rows as $file) {
        if ($file['sh']==1) {
            echo "<div class='item'>";
            echo "<img src='files/{$file['filename']}'> <br>";
            echo "{$file['descr']}";
            echo "</div>";
        }
    }

?>
    </div>
    
</body>
</html>