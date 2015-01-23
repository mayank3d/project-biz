<?php

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
if(mail('mukeshsoni151@gmail.com','Test','Hi',$headers))
echo "success";
else
echo "not sucess";

?>