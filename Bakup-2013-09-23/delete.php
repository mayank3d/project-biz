<?php

include_once 'config.php';
include_once 'CommentsPOJO.php';
include_once 'TNI.php';
ini_set('display_errors', 'On');

/**
 * Description of UserManager
 *
 * @author ShivaGanesh
 */


  

            getDBConnection();
            $ramConnection = getRAMConnection();
           // $msg = $ramConnection->hget('MSG_INFO', $originalId);
            //$date = date('Y-m-d h:i:s', time());
            //$dateML = date('Ydmhis', strtotime($date));
            $msgInsertQuery = "DELETE FROM BROADCAST_MESSAGES WHERE BID='".$_REQUEST['userId']."'AND BMID='".$_REQUEST['id']."'";
            mysql_query($msgInsertQuery);
			
			//die($msgInsertQuery);
			
			header('location:following.php');
      
	
	?>