<?php
echo date_default_timezone_get()."<br>";
echo date("d-m-Y H:i:s")."<br>";
date_default_timezone_set("Asia/Kolkata")."<br>";
echo date("d-m-Y H:i:s");

?>