<?php

function redirect($url) {
    echo "<script>document.location.href='" . $url . "'</script>";
    exit;
}
function fancy_load($jquery='Y',$sitelink=''){
	if(!empty($sitelink)){
		$sitelink = $sitelink;
	}else{
		$sitelink = '';
	}
	if($jquery=='Y'){
	?>
    <script type="text/javascript" src="<?php echo $sitelink;?>fancybox/jquery-1.9.0.min.js"></script>
    <?php
	}
	?>
    <script type="text/javascript" src="<?php echo $sitelink;?>fancybox/jquery.fancybox.js?v=2.1.4"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $sitelink;?>fancybox/jquery.fancybox.css?v=2.1.4" media="screen" />
    <?php
}

?>
