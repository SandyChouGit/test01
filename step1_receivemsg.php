<?php
  $json_str=file_get_contents('php://input');
  $json_obj=json_decode($json_str);

  $myfile=fopen("log.txt","w+");
  fwrite($myfile,"\xEF\xBB\xBF".$json_str);
?>
