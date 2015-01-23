<?php
//session_start();
include_once 'config.php';
include_once 'CommentsPOJO.php';
include_once 'TNI.php';
//

/**
 * Description of UserManager
 *
 * @author ShivaGanesh
 */
class MessageManager {

    function postNewslet($userId, $msg) {
        return $this->saveMsg($userId, $msg, null);
    }

    function reNewslet($userId, $originalId) {
        try {
            getDBConnection();
            $ramConnection = getRAMConnection();
            $msg = $ramConnection->hget('MSG_INFO', $originalId);
            $date = date('Y-m-d h:i:s', time());
            $dateML = date('Ydmhis', strtotime($date));
            $msgInsertQuery = "INSERT INTO BROADCAST_MESSAGES (BID,STATUS,BMESSAGE,ORIGINAL_ID,MESSAGE_DATE_TIME) values ('$userId','A','$msg','$originalId',now())";
            mysql_query($msgInsertQuery);
			//----------------------------notification ---------------------------------
			/*$notification_msg = 'Unsubscribe Notifications'; 
			$notification_area = 'Subscribed';
			$notification = "INSERT INTO notification set from_id='".$userId."',msg_id='".$msgId."',notification='".$notification_msg."',read_status='N',post_date=now(),notification_area='".$notification_area."'";
			mysql_query($notification);*/
			//----------------------------notification ---------------------------------
            $msgId = mysql_insert_id();
			$msgUserGetQuery= "SELECT ui.FIRST_NAME, ui.LAST_NAME FROM BROADCAST_MESSAGES AS bm INNER JOIN USER_INFO AS ui ON ui.USER_ID= bm.BID WHERE bm.BMID=".$originalId;
			$userResult=mysql_query($msgUserGetQuery);
			$userInfo= @mysql_fetch_assoc($userResult);
			$userName= @$userInfo['FIRST_NAME'].' '.@$userInfo['LAST_NAME'];
			$ramConnection->hset('MSG_INFO', $msgId, $msg);
			$ramConnection->hincrbyfloat('RETWEETS', $msgId, 1);
			$ramConnection->zadd($userId . '_MSG', $dateML, $msgId);
			$ramConnection->hset('MSG_USER_ORIGNAL_ID',$msgId, $originalId);
			$ramConnection->hset('MSG_USER_ORIGNAL_NAME',$msgId, $userName);
			$ramConnection->sadd($userId . '_RETWEETS', $msgId);
			return intval($ramConnection->hget('RETWEETS', $msgId));
        } catch (Exception $e) {
            // print($e->getMessage());
        }
    }

    function saveMsg($userId, $msg, $originalId) {
	
	
        try {
		//die($msg);
		//$msg=highlight_string($msg);
            getDBConnection();
            $ramConnection = getRAMConnection();
             $date = date('Y-m-d h:i:s', time());
	     return date_default_timezone_get();
            $dateML = date('Ydmhis', strtotime($date));
			//echo $msg;
			//die();
            $msgInsertQuery = "INSERT INTO BROADCAST_MESSAGES (BID,STATUS,BMESSAGE,ORIGINAL_ID,MESSAGE_DATE_TIME) values ('$userId','A','".mysql_real_escape_string($msg)."','$originalId','$date')";
			//echo $msgInsertQuery;
            mysql_query($msgInsertQuery);
            $msgId = mysql_insert_id();
			
			//die($msg);
			//echo 'aaaaa';
			
            $ramConnection->hset('MSG_INFO', $msgId, $msg);
	    $ramConnection->hset('MSG_CREATION_DATE', $msgId, date('d-m-Y h:i A', time()));
            $pieces = explode(" ", $msg);
            foreach ($pieces AS $pieceItem) {
                if (strpos($pieceItem, '#') !== false) {
                    $ramConnection->zincrby("TRENDS", 1, $pieceItem);
                    $ramConnection->zadd($pieceItem, $dateML, $msgId);
                }
            }
            $ramConnection->hset('USERID_MSGID', $userId, $msgId);
            $ramConnection->hset('MSGID_USERID', $msgId, $userId);
            $ramConnection->zadd($userId . '_MSG', $dateML, $msgId);
			return $msgId;
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }
	
	function deleteMsg($msgId,$userId) {
	
	
        try {
		//die($msg);
		//$msg=highlight_string($msg);
            getDBConnection();
            $ramConnection = getRAMConnection();
           
			
			//die($msg);
			
			
            $ramConnection->hDel('MSG_INFO', $msgId);
            $ramConnection->hDel('USERID_MSGID', $userId);
            $ramConnection->hDel('MSGID_USERID', $msgId);
			
            //$ramConnection->zadd($userId . '_MSG', $dateML, $msgId);
			//------------------db
			if($msgId){
        
				$msgInsertQuery = "delete from BROADCAST_MESSAGES where BMID='".$msgId."'";
				mysql_query($msgInsertQuery);
			}
			//------------------db
			return true;
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }
	
    public static function getMessageInfo($msgId) {
        $msgId = str_replace('i', '', $msgId);
        $ramConnection = getRAMConnection();
        return $ramConnection->hget('MSG_INFO', $msgId);
    }

    function deactivateMsg($userId, $msgId) {
        try {
            getDBConnection();
            $ramConnection = getRAMConnection();
            $userInfoQuery = "UPDATE BROADCAST_MESSAGES SET STATUS='I' WHERE BMID='$msgId'";
            mysql_query($userInfoQuery);
            $ramConnection->hdel('MSG_INFO', $msgId);
            $ramConnection->zrem($userId . '_MSG', $msgId);
            return true;
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }

    function getMsgofBiz($bizId, $session_id) {
        try {
            $ramConnection = getRAMConnection();
            $follwingUsers = $ramConnection->smembers($bizId . '_FOLLOWING');
            $ramConnection->zunionstore($session_id, 2, $bizId . '_MSG', $bizId . '_MSG');
            foreach ($follwingUsers as $eachUser) {
                $ramConnection->zunionstore($session_id, 2, $eachUser . '_MSG', $session_id);
            }
            $data = $ramConnection->zrevrangebyscore($session_id, -1, 0);
            $msgInfo = $ramConnection->hmget('MSG_INFO', $data);
            $jsonArray = array();
            foreach ($msgInfo as $k => $v) {
                $jsonArray[$data[$k] . 'i'] = $v;
            }
            print_r(json_encode(array('msg' => $jsonArray)));
            return json_encode(array('msg' => $jsonArray));
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }

    function coolMessage($msgId, $userId) {
        try {
            getDBConnection();
            $ramConnection = getRAMConnection();
			
			$qq = "select BID from BROADCAST_MESSAGES where BMID='".$msgId."'";
			//echo $qq;
			//die();
			$user_id = mysql_query($qq);
			$user_info_id = mysql_fetch_array($user_id);
			if($user_info_id['BID']){
				$notification_msg = 'Cool Notifications'; 
				$notification_area = 'Cool';
				$notification = "INSERT INTO notification set from_id='".$userId."',to_id='".$user_info_id['BID']."',notification='".$notification_msg."',read_status='N',post_date=now(),notification_area='".$notification_area."'";
				mysql_query($notification);
			}
			
            $userInfoQuery = "INSERT INTO COOL_MESSAGES (MSG_ID,USER_ID) values ('" . $msgId . "','" . $userId . "')";
			//echo $userInfoQuery;
            mysql_query($userInfoQuery);
			
			/*$notification_msg = 'Unsubscribe Notifications'; 
			$notification_area = 'Subscribed';
			$notification = "INSERT INTO notification set from_id='".$userId."',msg_id='".$msgId."',notification='".$notification_msg."',read_status='N',post_date=now(),notification_area='".$notification_area."'";
			mysql_query($notification);*/
			
            $ramConnection->sadd($userId . '_COOLS', $msgId);
            $ramConnection->hincrbyfloat('COOLCOUNT', $msgId, 1);
            $newsLetOwnerId = $ramConnection->hget('MSGID_USERID', $msgId);
            $cooledPersonName = $ramConnection->hget('USER_ID_NAME', $userId);
            if ($ramConnection->llen($newsLetOwnerId . '_NOTIFY') == 10) {
                $ramConnection->rpop($newsLetOwnerId . '_NOTIFY');
            }
            $ramConnection->lpush($newsLetOwnerId . '_NOTIFY', $cooledPersonName . ' Starred your Newslet');
            return $ramConnection->hget('COOLCOUNT', $msgId);
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }

    function unCoolMessage($msgId, $userId) {
        try {
            getDBConnection();
            $ramConnection = getRAMConnection();
			$qq = "select BID from BROADCAST_MESSAGES where BMID='".$msgId."'";
			//echo $qq;
			//die();
			$user_id = mysql_query($qq);
			$user_info_id = mysql_fetch_array($user_id);
			if($user_info_id['BID']){
				$notification_msg = 'UnCool Notifications'; 
				$notification_area = 'UnCool';
				$notification = "INSERT INTO notification set from_id='".$userId."',to_id='".$user_info_id['BID']."',notification='".$notification_msg."',read_status='N',post_date=now(),notification_area='".$notification_area."'";
				mysql_query($notification);
			}
			
            $userInfoQuery = "delete from COOL_MESSAGES WHERE MSG_ID='".$msgId."' AND USER_ID='".$userId."'";
            mysql_query($userInfoQuery);
			
			
			
			//die();
			//echo $msgId;
			$ramConnection->srem($userId . '_COOLS', $msgId);
			(int)$current_msg_no = $ramConnection->hget('COOLCOUNT', $msgId);
			//echo $current_msg_no.'--';
			//$tni = new TNI();
			//echo $tni->getCoolCount($msgId);
			//echo '--'; 
			//var_dump($tni->getAlreadyCooled());
			///var_dump($tni->setAlreadyCooled("y"));
			//$tni->setAlreadyCooled("n");
			
			//echo $msgId->getAlreadyCooled();
			
			if($current_msg_no > 0){
				//echo $current_msg_no.'--';
			 	$set_msg =  -1;
				$ramConnection->hincrbyfloat('COOLCOUNT', $msgId, $set_msg);
			}else{
				$set_msg = $current_msg_no ;
			}
			//die();
           // echo $set_msg.'--';
            
            return $ramConnection->hget('COOLCOUNT', $msgId);
			//echo $ramConnection->hget('COOLCOUNT', $msgId);
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }

    function encryptPassword($userPassword) {
        return md5($userPassword);
    }

    function getUserInfo($userId) {
        getDBConnection();
        $result = mysql_query("SELECT * FROM USER_INFO WHERE USER_ID=" . $userId);

        $userInfo = mysql_fetch_assoc($result);
        return $userInfo;
    }

    function commentMessage($userId, $msgId, $comment) {
        try {
            getDBConnection();
            $ramConnection = getRAMConnection();
			$qq = "select BID from BROADCAST_MESSAGES where BMID='".$msgId."'";
			//echo $qq;
			//die();
			$user_id = mysql_query($qq);
			$user_info_id = mysql_fetch_array($user_id);
			if($user_info_id['BID']){
				$notification_msg = 'remarks Notifications'; 
				$notification_area = 'remarks';
				$notification = "INSERT INTO notification set from_id='".$userId."',to_id='".$user_info_id['BID']."',notification='".$notification_msg."',read_status='N',post_date=now(),notification_area='".$notification_area."'";
				mysql_query($notification);
			}
			
            $date = date('Y-m-d h:i:s', time());
            $dateML = date('Ydmhis', strtotime($date));
            $userInfoQuery = "INSERT INTO COMMENTS (MSG_ID,USER_ID,COMMENT,CREATEDTIME) values('$msgId','$userId','$comment','$date')";
            //return $userInfoQuery;
            mysql_query($userInfoQuery);
            $commentId = mysql_insert_id();
            $ramConnection->hset('COMMENTS', $commentId, $comment);
            $ramConnection->hincrbyfloat('COMMENTCOUNT', $msgId, 1);
            $ramConnection->zadd($msgId . '_COMMENTS', $dateML, $commentId);
            $ramConnection->sadd('COMMENTS_BY_' . $userId, $commentId);
            $ramConnection->hset('USER_COMMENTS', $commentId, $userId);
            $newsLetOwnerId = $ramConnection->hget('MSGID_USERID', $msgId);
            $sharedPersonName = $ramConnection->hget('USER_ID_NAME', $userId);
            if ($ramConnection->llen($newsLetOwnerId . '_NOTIFY') == 10) {
                $ramConnection->rpop($newsLetOwnerId . '_NOTIFY');
            }
            $ramConnection->lpush($newsLetOwnerId . '_NOTIFY', $sharedPersonName . ' has Remarks on your Newslet');
			
			return $commentId;			
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }

    function deleteComment($userId, $msgId, $commentId) {
        try {
            getDBConnection();
            $ramConnection = getRAMConnection();
            $userInfoQuery = "UPDATE COMMENTS SET STATUS ='I' WHERE COMMENT_ID=' $commentId '";
            mysql_query($userInfoQuery);
            $ramConnection->hdel('COMMENTS', $commentId);
            $ramConnection->hincrbyfloat('COMMENTCOUNT', $msgId, -1);
            $ramConnection->zrem($msgId . '_COMMENTS', $commentId);
            $ramConnection->srem('COMMENTS_BY_' . $userId, $commentId);
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }

    function getCommentsMap($msgId, $userId,$get_number='') {

        $commentsMap = array();
        $ramConnection = getRAMConnection();
        $commentInfo = $ramConnection->zrange($msgId . '_COMMENTS', 0, -1);
		//var_dump($commentInfo);
		$cccomment = count($commentInfo);
		if($get_number == ''){
			if($cccomment>0){
			$commentContent = $ramConnection->hmget('COMMENTS', $commentInfo);
			$userCommentInfo = $ramConnection->hmget('USER_COMMENTS', $commentInfo);
			$userInfo = $ramConnection->hmget('USER_ID_NAME', $userCommentInfo);
			//echo '<pre>';
			//var_dump($commentInfo);
			//die();
			//echo 'asds';
			//$ramConnection->sadd('COMMENTS_BY_' . $userId, $commentId);
			foreach ($commentInfo as $key => $value) {
				$eachComment = new Comment;
				//$eachComment->setCommentId($key);
				$eachComment->setCommentId($value);
				$eachComment->setComment($commentContent[$key]);
				$ownerId = $ramConnection->hget("USERNAME_ID",$userInfo[$key]);
				$eachComment->setUserId($ownerId);
				$eachComment->setUsername($userInfo[$key]);
				$eachComment->setCommentDate($value);
				if ($userId==$ownerId) {
					$eachComment->setSelfComment('Y');
				} else {
					$eachComment->setSelfComment('N');
				}
				array_push($commentsMap, $eachComment);
			}
			
			return $commentsMap;
			}else{
				return false;
			}
		}else{
			return $cccomment;
		}
    }

    function getNewsletsMapOfBiz($bizId, $session_id) {
        $newsletsMap = array();
        try {
            $ramConnection = getRAMConnection();
            $follwingUsers = $ramConnection->smembers($bizId . '_FOLLOWING');
            $ramConnection->zunionstore($session_id, 2, $bizId . '_MSG', $bizId . '_MSG');
            foreach ($follwingUsers as $eachUser) {
                $ramConnection->zunionstore($session_id, 2, $eachUser . '_MSG', $session_id);
            }
            $data = $ramConnection->zrevrangebyscore($session_id, -1, 0);
            $msgInfo = $ramConnection->hmget('MSG_INFO', $data);
            $tni = new TNI();
        } catch (Exception $e) {
            //***
            //print($e->getMessage());
        }
        return $newsletsMap;
    }

    function getTrends() {
        try {
            $ramConnection = getRAMConnection();
            $trendyNews = $ramConnection->zrevrange("TRENDS", 0, -1);
            return $trendyNews;
        } catch (Exception $e) {
            print($e->getMessage());
            return $e;
        }
    }

    function getTrendNewslet($trend) {
        try {
            $ramConnection = getRAMConnection();
            $trendyNews = $ramConnection->zrange($trend, 0, -1);
            return $trendyNews;
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }

}

?>
