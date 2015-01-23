<?php
include_once 'UserManager.php';
$userManager = new UserManager();
if($_REQUEST['mode']=='notify_delete'){
	echo '<pre>';
	print_r($userManager->deleteNotifications($userId));
	echo '1';
}else{
?>
<script>
function delete_notification(){
alert('<?php echo $_SESSION["userId"];?>');
$.ajax({
type: "POST",
url: "Notifications.php",
data: { userId: '<?php echo $_SESSION["userId"];?>',mode : 'notify_delete' }
}).done(function( msg ) {
alert( "Data Saved: " + msg );
});
}
</script>
<button onclick="delete_notification();">delete</button>
<span class="button dropdown">
    <a href="#">Notifications <span class="pip" id="notifyCount"><?php
	echo $userManager->getNotifications($_SESSION["userId"],'Y');
    ?></span></a>
    <ul class="notice">
        <?php echo $userManager->getNotifications($_SESSION["userId"]); ?>
    </ul>
    <script type="text/javascript">
        var n = $("li").size();
        $("#notifyCount").html(n);
    </script>
</span> 

<?php
}
?>