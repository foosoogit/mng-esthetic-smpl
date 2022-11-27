<?php

$dbHost = "mysql1404b.xserver.jp";
$dbUser = "foosoo_keys";
$dbPass = "b2ku5ykt";
$dbName = "foosoo_musicacademy";
 
//$filePath = "/home/foosoo/foosoo.xsrv.jp/db_bk/";
$filePath = "db_bk/";
$fileName = date('ymd').'_'.date('His').'.sql';
$command = "mysqldump ".$dbName." --host=".$dbHost." --user=".$dbUser." --password=".$dbPass." > ".$filePath.$fileName;
system($command);
file_put_contents("db_bk/test.txt", "HELLO WORLD");
//保存したらダウンロード
/*
$dlFile = $filePath . $fileName;    //ファイルパス
header('Content-Type: application/octet-stream');   //ダウンロードの指示
header('Content-Disposition: attachment; filename="' . $fileName . '"');    //ダウンロードするファイル名
header('Content-Length: '.filesize($dlFile));       //ファイルサイズを指定することでプログレスバーが表示される。
readfile($dlFile);
*/

/*
$today = date("YmdHis");
define("_saveFileName_", "../data/".$fileName);
define("_bkFileName_", "listRegist_".$today.".csv");
if(copy(_saveFileName_,_bkFileName_))
{
     echo "コピー出来ました";
}
else
{
     echo "失敗しました";
}
*/
?>