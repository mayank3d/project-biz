<?php
include_once 'UserManager.php';
$userManager = new UserManager();
//echo 'a';

?>
<script>
function delete_notification(){
alert('<?php echo $_SESSION["userId"];?>');
$.ajax({
type: "POST",
url: "<?php echo SITE_URL;?>ajax.php",
data: { userId: '<?php echo $_SESSION["userId"];?>',mode : 'notify_delete' }
}).done(function( msg ) {
alert( "Data Saved: " + msg );
});
}

function callnotification(){
	/*$.ajax({
	type: "POST",
	url: "<?php echo SITE_URL;?>ajax.php",
	data: { userId: '<?php echo $_SESSION["userId"];?>',mode : 'notify_call' }
	}).done(function( msg ) {
		
	alert( "Data Saved: " + msg );
		//setTimeout('callnotification();',3000);
	});*/
	//alert('dd');
	jQuery.ajax({ 
		type: 'GET',
        url: '<?php echo SITE_URL;?>ajax.php',
        data: { userId: '<?php echo $_SESSION["userId"];?>',mode : 'notify_call' },
        dataType: 'json',
        success: function(data) {
			//alert(data);
			//alert('a');
		//alert(JSON.stringify(data));
		//alert(data.t_notification_msg);
		
		$("#notifyCount").html(data.t_notification);
             //jQuery("#fancybox-loading").css('display','none');
		$(".notice").html(data.t_notification_msg);
		
			setTimeout('callnotification();',3000);		 
          }
      });
	//alert('ok');
	//setTimeout('callnotification();',3000);
}
function notification_count_delete(){
	$.ajax({
	type: "POST",
	url: "<?php echo SITE_URL;?>ajax.php",
	data: { userId: '<?php echo $_SESSION["userId"];?>',mode : 'notify_count_delete' }
	}).done(function( msg ) {
	//alert( "Data Saved: " + msg );
	$("#notifyCount").html(msg);
		
	});
	/*jQuery.ajax({ 
		type: 'GET',
        url: '<?php echo SITE_URL;?>ajax.php',
        data: { userId: '<?php echo $_SESSION["userId"];?>',mode : 'notify_call' },
        dataType: 'json',
        success: function(data) {
			//alert(data);
			//alert('a');
		//alert(JSON.stringify(data));
		//alert(data.t_notification_msg);
		
		$("#notifyCount").html(data.t_notification);
             //jQuery("#fancybox-loading").css('display','none');
		$(".notice").html(data.t_notification_msg);
			
          }
      });*/
	
}

</script>
<!--<button onclick="callnotification();">delete</button>-->

<span class="button dropdown" onclick="notification_count_delete();">
    <a href="javascript:void(0);">Notifications <span class="pip" id="notifyCount">
	<?php
	//echo $userManager->getNotifications($_SESSION["userId"],'Y');
	 
	 echo $userManager->getNotificationsdb('Y',$_SESSION["userId"]);
	
    ?></span></a>
    
    <ul class="notice" style="margin-left:-90px; width:310px;">
        <?php 
		echo $userManager->getNotificationsdb('N',$_SESSION["userId"]);
		//echo $userManager->getNotifications($_SESSION["userId"]); ?>
    </ul>
    <script type="text/javascript">
        //var n = $("li").size();
        //$("#notifyCount").html(n);
		setTimeout('callnotification();',3000);
    </script>
</span> 

