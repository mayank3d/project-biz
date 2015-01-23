<?php

include_once 'config.php';
//ini_set('display_errors', 'On');
include_once 'MessageManager.php';

/**
 * Description of UserManager
 *
 * @author ShivaGanesh
 */
class UserManager {

    function validateUser($username, $password) {
        $ramConnection = getRAMConnection();
		//var_dump($ramConnection->hget('USER_LOGIN', $username));
		
        if ($this->encryptPassword($password) == $ramConnection->hget('USER_LOGIN', $username)) {
            $userId = $ramConnection->hget('USERNAME_ID', $username);
            $email = $ramConnection->hget('USER_ID_EMAIL', $userId);
            $person = array("userId" => $userId, "isValid" => 'true', "email" => $email, "username" => $username);
            return $person;
        }
    }

    function resetPassword($userName) {
        getDBConnection();
        $ramConnection = getRAMConnection();
        //$randomPassword = $this->randomString();
        $randomPassword = 'v';
        $encryptedPassword = $this->encryptPassword($randomPassword);
        $ramConnection->hset('USER_LOGIN', $userName, $encryptedPassword);
        $userLoginInfoquery = "UPDATE USER_LOGIN_INFO SET PASSWORD='$randomPassword' WHERE USERNAME='$userName'";

        $userId = $ramConnection->hget('USERNAME_ID', $userName);
        print $userId . '<br>';
        $email = $ramConnection->hget('USER_ID_EMAIL', $userId);
        print 'PASSWORD HAS BEEN RESET TO' . $randomPassword;
        print $email;
        print $this->sendMail($email, 'PASSWORD RESET', 'PASSWORD HAS BEEN RESET TO' . $randomPassword);
        mysql_query($userLoginInfoquery) or die("Database error:<br />" . mysql_error());
    }

    function sendMail($to, $subject, $message) {
        try {
            $from = "admin@thenewsid.com";
            $headers = "From:" . $from;
            mail($to, $subject, $message, $headers);
            return "TRUE";
        } catch (Exception $e) {
            return $e;
        }
    }

    function userNameValidation($userName) {
        try {
            $ramConnection = getRAMConnection();
            return $ramConnection->hexists('USERNAME_ID', $userName);
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }

    function randomString() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    function saveUser($email, $userName, $password,$fname ,$lname) {
        try {
            getDBConnection();
            $ramConnection = getRAMConnection();
            $userInfoQuery = "INSERT INTO USER_INFO (EMAIL,FIRST_NAME,LAST_NAME) values ('".$email."','".$fname."','".$lname."')";
            mysql_query($userInfoQuery) or die("Database error:<br />" . mysql_error());
            $userId = mysql_insert_id();
			
            $encryptedPassword = $this->encryptPassword($password);
            $ramConnection->hset('USER_LOGIN', $userName, $encryptedPassword);
            $ramConnection->hset('USER_EMAIL_ID', $email, $userId);
            $ramConnection->hset('USER_ID_EMAIL', $userId, $email);
            $ramConnection->sadd('PUBLIC_PROFILES', $userId);
            $ramConnection->sadd('PUBLIC_TWEETS', $userId);
            $ramConnection->hset('USERNAME_ID', $userName, $userId);
            $ramConnection->hset('USER_ID_NAME', $userId, $userName);
            $date = date('Y-m-d H:i:s');
            $userLoginInfoquery = "INSERT INTO USER_LOGIN_INFO (USER_ID,USERNAME,PASSWORD,CREATED_DATE_TIME,CREATED_BY,UPDATED_DATE_TIME,UPDATED_BY,IS_ACTIVE,LAST_LOGGED_IN_TIME) values ('$userId','$userName','$encryptedPassword','$date','$userId','$date','$userId','A','$date')";
            mysql_query($userLoginInfoquery) or die("Database error:<br />" . mysql_error());
            $person = array("email" => $email, "userId" => $userId, "isSaved" => 'true', "username" => $userName);
            mysql_close();
            return $person;
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }

    function updateUserInfo($userId, $firstName, $lastName, $mobile, $address, $city, $state, $dateOfBirth, $anniversaryDate,$public_profile,$country,$timezone,$email) {
        try {
            getDBConnection();
            $fromdob = mysql_real_escape_string($dateOfBirth);
            $dob = date('Y-m-d', strtotime(str_replace('-', '/', $fromdob)));
            $fromannDate = mysql_real_escape_string($anniversaryDate);
            $annDate = date('Y-m-d', strtotime(str_replace('-', '/', $fromannDate)));
            $userInfoQuery = "UPDATE USER_INFO SET FIRST_NAME='$firstName',LAST_NAME='$lastName',MOBILE='$mobile',ADDRESS='$address',CITY='$city',COUNTRY='".$country."',TIME_ZONE='".$timezone."',STATE='$state',DATE_OF_BIRTH='$dob',ANNIVERSARY_DATE='$annDate',PUBLIC_PROFILE='".$public_profile."', EMAIL='".$email."' WHERE USER_ID='$userId'";
			//echo $userInfoQuery;
            mysql_query($userInfoQuery);
            return true;
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }

    function updatePassword($userId, $password) {
        try {
            getDBConnection();
			
            $userInfoQuery = "UPDATE USER_LOGIN_INFO SET PASSWORD='" . $this->encryptPassword($password) . "' WHERE USER_ID='$userId'";
            mysql_query($userInfoQuery);
            return true;
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }
	function updatePasswordmatchold($userId, $npassword, $opassword) {
        try {
            getDBConnection();
			$sql = "select USERNAME from USER_LOGIN_INFO where PASSWORD='" . $this->encryptPassword($opassword) . "' and USER_ID='$userId'";
			$rec = mysql_query($sql);
			$num = mysql_num_rows($rec);
			if($num == 1){
				$userInfoQuery = "UPDATE USER_LOGIN_INFO SET PASSWORD='" . $this->encryptPassword($npassword) . "' WHERE USER_ID='$userId'";
				mysql_query($userInfoQuery);
				return true;
			}else{
				return false;
			}
            
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

    function getAllBusinessPeople() {
        getDBConnection();
        $result = mysql_query("SELECT USER_ID,FIRST_NAME FROM USER_INFO ORDER BY USER_ID DESC");
        while ($savedResult = mysql_fetch_array($result)) {
            $savedArray[$savedResult[0]] = $savedResult[1];
        }

        return $savedArray;
    }

    function followBiz($userId, $bizId,$individual,$groupid) {
        try {
            getDBConnection();
			if($individual == 'Y'){
				$ind = 1;
			}else{
				$ind = 0;
			}
			if(!empty($groupid)){
				$groupid = $groupid;
			}else{
				$groupid = 0;
			}
            $query = "SELECT PUBLIC_PROFILE FROM USER_INFO WHERE USER_ID=" . $bizId;
            $result = mysql_query($query);
            $status = "";
            while ($row = mysql_fetch_array($result)) {
                if ($row[0] == 'N') {
                    $status = "N";
					$notification_area = 'Pending';
                } else {
                    $status = "A";
					$notification_area = 'Subscribed';
                }
            }
            mysql_query("INSERT INTO USER_FOLLOWERS (USER_ID,group_id,individual,BUSINESS_ID,STATUS) values ('" . $userId . "','".$groupid."','".$ind."','" . $bizId . "','" . $status . "')") or die("Database error:<br />" . mysql_error());
			$notification_msg = 'Subscribe Notifications'; 
			$notification = "INSERT INTO notification set from_id='".$userId."',to_id='".$bizId."',notification='".$notification_msg."',read_status='N',post_date=now(),notification_area='".$notification_area."'";
			mysql_query($notification);
			
            $ramConnection = getRAMConnection();
            if ($status == 'A') {
                $ramConnection->sadd($userId . '_FOLLOWING', $bizId);
                $ramConnection->sadd($bizId . '_FOLLOWERS', $userId);
                $ramConnection->hincrbyfloat($bizId . "_INFO", "FOLLOWER_COUNT", 1);
                $ramConnection->hincrbyfloat($userId . "_INFO", "FOLLOWING_COUNT", 1);
            }
            mysql_close();
        } catch (Exception $e) {
            print($e);
        }
        return true;
    }

    function makeProfilePublic($userId, $status) {
        try {
            getDBConnection();
            mysql_query("UPDATE USER_INFO SET PUBLIC_PROFILE ='.$status.' WHERE USER_ID=" . $userId . '"');
            $ramConnection = getRAMConnection();
            if ($status == 'Y') {
                $ramConnection->sadd('PUBLIC_PROFILES', $userId);
            } else {
                $ramConnection->srem('PUBLIC_PROFILES', $userId);
            }
            mysql_close();
        } catch (Exception $e) {
            
        }
        return true;
    }

    function makeNewsletsPublic($userId, $status) {
        try {
            getDBConnection();
            mysql_query("UPDATE USER_INFO SET PUBLIC_TWEETS ='.$status.' WHERE USER_ID=" . $userId . '"');
            $ramConnection = getRAMConnection();
            if ($status == 'Y') {
                $ramConnection->sadd('PUBLIC_TWEETS', $userId);
            } else {
                $ramConnection->srem('PUBLIC_TWEETS', $userId);
            }
            mysql_close();
        } catch (Exception $e) {
            
        }
        return true;
    }
	
	function blockfollowBiz($userId, $bizId) {
        try {
            getDBConnection();
			$sq = "DELETE from  USER_FOLLOWERS WHERE  BUSINESS_ID= '".$userId."'AND USER_ID = '".$bizId."'";
			//echo $sq;
            mysql_query($sq);
            $ramConnection = getRAMConnection();
            /*$ramConnection->srem($userId . '_FOLLOWING', $bizId);
            $ramConnection->srem($bizId . '_FOLLOWERS', $userId);
            $ramConnection->hincrbyfloat($bizId . "_INFO ", "FOLLOWER_COUNT", -1);
            $ramConnection->hincrbyfloat($userId . "_INFO ", "FOLLOWING_COUNT", -1);*/
            mysql_close();
        } catch (Exception $e) {
            
        }
        return true;
    }
	function blockfollowBizUnblock($userId, $bizId) {
        try {
            getDBConnection();
			$sq = "DELETE from  USER_FOLLOWERS WHERE  USER_ID= '".$userId."'AND  BUSINESS_ID= '".$bizId."'";
			//echo $sq;
            mysql_query($sq);
            $ramConnection = getRAMConnection();
            $ramConnection->srem($userId . '_FOLLOWING', $bizId);
            $ramConnection->srem($bizId . '_FOLLOWERS', $userId);
            $ramConnection->hincrbyfloat($bizId . "_INFO ", "FOLLOWER_COUNT", -1);
            $ramConnection->hincrbyfloat($userId . "_INFO ", "FOLLOWING_COUNT", -1);
            mysql_close();
        } catch (Exception $e) {
            
        }
        return true;
    }
	
	function deletegroupBizUnblock($userId, $groupid) {
        try {
            getDBConnection();
			
			$sq = "select group_id,individual,BUSINESS_ID from USER_FOLLOWERS where USER_ID ='".$userId."' and group_id='".$groupid."' order by individual desc ";
			//echo $sq;
            $rec = mysql_query($sq);
			$num = mysql_num_rows($rec);
			if($num>0){
				$userManager = new UserManager;
				while($row=mysql_fetch_array($rec)){
					echo $row['BUSINESS_ID'].'-';
					$userManager->blockfollowBizUnblock($userId, $row['BUSINESS_ID']);
				}
			}
			
			if($groupid){
			$sql = "delete from GROUPS where GROUP_ID='".$groupid."'";
			mysql_query($sql);
			}
			
			
			return true;
			
            
            mysql_close();
        } catch (Exception $e) {
         return false;   
        }
        
    }

    function unfollowBiz($userId, $bizId) {
        try {
            getDBConnection();
			$sq = "DELETE from  USER_FOLLOWERS WHERE USER_ID = '".$userId."'AND BUSINESS_ID = '".$bizId."'";
			//echo $sq;
            mysql_query($sq);
			
			$notification_msg = 'Unsubscribe Notifications'; 
			$notification_area = 'UnSubscribed';
			$notification = "INSERT INTO notification set from_id='".$userId."',to_id='".$bizId."',notification='".$notification_msg."',read_status='N',post_date=now(),notification_area='".$notification_area."'";
			mysql_query($notification);
			
            $ramConnection = getRAMConnection();
            $ramConnection->srem($userId . '_FOLLOWING', $bizId);
            $ramConnection->srem($bizId . '_FOLLOWERS', $userId);
            $ramConnection->hincrbyfloat($bizId . "_INFO ", "FOLLOWER_COUNT", -1);
            $ramConnection->hincrbyfloat($userId . "_INFO ", "FOLLOWING_COUNT", -1);
            mysql_close();
        } catch (Exception $e) {
            
        }
        return true;
    }

    function blockUsers($userId
    , $targetId) {
        try {
            getDBConnection();
            mysql_query(" INSERT INTO USER_BLOCKERS (USER_ID, BLOCKED_USER_ID) values ('" . $userId . "', '" . $targetId . "' ) ") or die("Database error:<br />" . mysql_error());
            $ramConnection = getRAMConnection();
            $ramConnection->sadd($userId . '_BLOCKED', $targetId);
            mysql_close();
        } catch (Exception $e) {
            
        }
        return true;
    }

    function createAllUsersTable($userId) {
        getDBConnection();
        $result = mysql_query("SELECT a.USERNAME, COUNT(b.BMID), a.USER_ID FROM thenewsid.USER_LOGIN_INFO a left join BROADCAST_MESSAGES b on a.USER_ID = b.BID where LENGTH(a.USERNAME) >0 GROUP BY a.USER_ID ORDER by COUNT(b.BMID)");
        $matter = "";
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                $matter = $matter . "<tr>";
                $matter = $matter . '<td class="avatar"><img src="images/uiface1.png" alt="" height="40" width="40" /> John Doe</td>';
                $matter = $matter . '<td>' . $row[0] . '</td>';
                $matter = $matter . '<td>' . $row[1] . '</td>';
                $matter = $matter . '<td><button class= "blue" id="' . $userId . $row[2] . '"onclick="followUser(' . $userId . ', ' . $row[2] . ' ) ">FOLLOW</button></td>';
                $matter = $matter . '<td><button class= "blue" id="create-user" onclick="addToGroup(' . $userId . ', ' . $row[2] . ' ) ">ADD TO GROUP</button></td>';
                $matter = $matter . "</tr>";
            }
        } else {
            echo mysql_error();
        }
        return $matter;
    }

    function getNotifications($userId, $count) {
        $ramConnection = getRAMConnection();
        $notifications = $ramConnection->lrange($userId . '_NOTIFY', 0, 10);
		//$redis->lset('a0', 'ccc', 0);
        $notifyUI = '';
		
		if($count=='Y'){
			$noti = count($notifications);
			return $noti;
		}else{
			foreach ($notifications as $k => $v) {
				$notifyUI .=  '<li><hgroup><h1>';
				$notifyUI .=  $v;
				$notifyUI .=  '</h1></hgroup></li>';
			}
			return $notifyUI;
		}
    }
	function getNotificationscountdelete($uid) {
		 getDBConnection();
	 $sql_update = "update notification set read_status='Y' where to_id='".$uid."'";
	 $result = mysql_query($sql_update);
	 echo 0;
    }
	function getNotificationsdb($count,$uid) {
		 getDBConnection();
		 $sql = "select nt.from_id,nt.notification,nt.read_status,nt.notification_area,ui.USERNAME from notification as nt,USER_LOGIN_INFO as ui where  nt.from_id=ui.USER_ID and nt.to_id='".$uid."' and nt.read_status='N'";
		 //return $sql;
        $result = mysql_query($sql);
        $matter = "";
       
        $notifyUI = '';
		
		$noti = mysql_num_rows($result);
		
		if($count=='Y'){
			
			return $noti;
		}else{
			//$notifyUI .= $noti;
			 $date = date('Y-m-d');
			$sql = "select nt.from_id,nt.notification,nt.read_status,nt.notification_area,ui.USERNAME from notification as nt,USER_LOGIN_INFO as ui where  nt.from_id=ui.USER_ID and nt.to_id='".$uid."' and post_date like '".$date."%' order by post_date desc";
		// return $sql;
        $result = mysql_query($sql);
        $matter = "";
       
        $notifyUI = '';
		
		$noti = mysql_num_rows($result);
		
			if($noti > 0){

				while($v = mysql_fetch_array($result)) {
					$notifyUI .=  '<li><hgroup><h1>';
					if($v['notification_area']=='Subscribed'){
						$link = '';
						$user_info = $this->get_business_user_info($v['from_id']);
						$notification_msg = $user_info['FIRST_NAME'].' '.$user_info['LAST_NAME'].' has Subscribed to you';
					}else if($v['notification_area']=='UnSubscribed'){
						$link = '';
						$user_info = $this->get_business_user_info($v['from_id']);
						$notification_msg = $user_info['FIRST_NAME'].' '.$user_info['LAST_NAME'].' has UnSubscribed to you';
					}else if($v['notification_area']=='Pending'){
						$link = 'MySubscription.php';
						$user_info = $this->get_business_user_info($v['from_id']);
						$notification_msg = $user_info['FIRST_NAME'].' '.$user_info['LAST_NAME'].' has Subscribed to you';
					}else if($v['notification_area']=='UnCool'){
						$link = 'NewsStream.php';
						$user_info = $this->get_business_user_info($v['from_id']);
						$notification_msg = $user_info['FIRST_NAME'].' '.$user_info['LAST_NAME'].' has UnStar on your Newslet';
					}else if($v['notification_area']=='Cool'){
						$link = 'NewsStream.php';
						$user_info = $this->get_business_user_info($v['from_id']);
						$notification_msg = $user_info['FIRST_NAME'].' '.$user_info['LAST_NAME'].' has Star on your Newslet';
					}else if($v['notification_area']=='remarks'){
						$link = 'NewsStream.php';
						$user_info = $this->get_business_user_info($v['from_id']);
						$notification_msg = $user_info['FIRST_NAME'].' '.$user_info['LAST_NAME'].' has Remarks on your Newslet';
					}else{
						$link = 'javascript:void(0);';
						$notification_msg = $v['notification'];
					}
					$notifyUI .=  '<a href="'.$link.'">'.$notification_msg.'</a>';
					
					$notifyUI .=  '</h1></hgroup></li>';
				}
			}else{
				$notifyUI .=  '<li><hgroup><h1>';
					$notifyUI .=  'No notification found.';
					$notifyUI .=  '</h1></hgroup></li>';
			}
			return $notifyUI;
		}
    }
	function deleteNotifications($userId) {
        $ramConnection = getRAMConnection();
        //$notifications = $ramConnection->lrange($userId . '_NOTIFY', 0, 10);
		//$redis->lset('a0', 'ccc', 0);
		 //return $ramConnection->lrange($userId . '_NOTIFY', 0, 15);
		//return print_r($ramConnection->keys('*'), true);
		return $ramConnection->rpop($userId . '_NOTIFY');
       // $ramConnection->pop($userId . '_NOTIFY',false);
    }
    function getAllFolloiwingUsersAndGroups($userId) {
        getDBConnection();
        $data = "";
        //$query = "SELECT DISTINCT UF.USER_ID,UF.BUSINESS_ID,ULI.USERNAME FROM USER_FOLLOWERS UF LEFT JOIN USER_LOGIN_INFO ULI ON UF.BUSINESS_ID=ULI.USER_ID WHERE UF.USER_ID=" . $userId . " AND UF.BUSINESS_ID !=" . $userId . " AND UF.BUSINESS_ID>0 AND ULI.USERNAME is not null";
		//$query_in = "select g.GROUP_ID,g.GROUP_NAME,g.image,count(uf.group_id) as tot from GROUPS as g LEFT JOIN USER_FOLLOWERS as uf  ON uf.group_id=g.GROUP_ID where  g.GROUP_OWNER='".$userId."' and uf.individual='1' group by GROUP_NAME order by GROUP_NAME";
		$query_in = "select ul.USERNAME,ul.USER_ID,uf.BUSINESS_ID from USER_LOGIN_INFO as ul , USER_FOLLOWERS as uf where uf.USER_ID=ul.USER_ID and uf.USER_ID='".$userId."' and uf.individual='1'  order by BUSINESS_ID";
 		//echo $query_in;
        $result_in = mysql_query($query_in);
		
		$num;
		
		$num_in=mysql_num_rows($result_in);
		
		//echo $num_in;
		$path = getcwd();
        $count_in = 0;
		$data = '';
        if ($num_in>0) {
			//echo 'hii';
			//print_r(mysql_fetch_array($result_in));
			$i = 1;
            while($row_in=mysql_fetch_array($result_in)){
			//echo 'a';	
			$file_loc_in = SITE_URL.'upload/' . $row_in['BUSINESS_ID'] . '_S.png';
			$path_validate_in = $path.'/upload/' . $row_in['BUSINESS_ID'] . '_S.png';
			//echo $file_loc;
			
			//echo $path_validate_in;
			if (file_exists($path_validate_in)){
				$file_loc_in = $file_loc_in;
			}else{
				$file_loc_in = SITE_URL.'upload/un.png';
			}
              //  $count++;
				$name = $this->get_business_user_info($row_in['BUSINESS_ID']);
				
                $data .=  '<div class="stats" style="cursor:pointer; " onclick="getNewslets(\'I\','.$row_in['BUSINESS_ID'].')">
				<div style="float: left; width: 99%; margin-bottom: 15px; margin-top: 15px;">
				<div style="width:25%; float:left;">';
                $data .= '<img src="'.$file_loc_in.'" /></div>
				<div style="float: left; text-align: left; width: 50%; margin: 0px;">'.$name['FIRST_NAME'].' '.$name['LAST_NAME'].'<br>
				@'.$name['USERNAME'].'
				</div>
				<div style="float: left; margin: 15px 0px 0px; width: 15%; border: 1px solid #ccc;">'.$this->subscribe_check($row_in['USER_ID'],$row_in['BUSINESS_ID']).'</div>
				';
                $data .= '</div></div>';
				
				$i++;
            }
        }
		//=============================================================
		//die();
		$query = "select g.GROUP_ID,g.GROUP_NAME,g.image,count(uf.group_id) as tot from GROUPS as g LEFT JOIN USER_FOLLOWERS as uf  ON uf.group_id=g.GROUP_ID where  g.GROUP_OWNER='".$userId."' group by GROUP_NAME order by GROUP_NAME";
 
        $result = mysql_query($query);
		
		$num;
		
		$num=mysql_num_rows($result);
		
		//echo $num;
		
        $count = 0;
		//$data = '';
        if ($num>0) {
			
            while ($row = mysql_fetch_array($result)) {
                if($count == 0){
                    //$data = $data . '<input type="text" id="firstBizId" value="' . $userId . '"/>';
					// $data = $data . '<input type="hidden" id="firstBizId" value="' . $row[1] . '"/>';
                }
				//38_group_S.png
			$file_loc = SITE_URL.'upload/' . $row['GROUP_ID'] . '_group_S.png';
			$path_validate = $path.'/upload/' . $row['GROUP_ID'] . '_group_S.png';
			//echo $file_loc;
			
			//echo file_exists($file_loc);
			if (file_exists($path_validate)){
				$file_loc = $file_loc;
			}else{
				$file_loc = SITE_URL.'upload/un.png';
			}
                $count++;
                $data .= '<div class="stats" style="cursor:pointer;" onclick="getNewslets(\'G\','.$row['GROUP_ID'].')">
				<div style="float: left; width: 100%; margin-bottom: 15px; margin-top: 15px;">
				<div style="width:25%; float:left;">';
                $data .= '<img src="'.$file_loc.'" /></div>
				<div style="float: left; text-align: left; width: 50%; margin: 0px;">'.$row['GROUP_NAME'].'<br>@Group</div>';
				/*<div style="float: left; margin: 15px 0px 0px; width: 15%; border: 1px solid #ccc;">'.$this->group_check($userId,$row['GROUP_ID']).'</div>*/
				
                $data .= '</div></div>';
				//'.$row['tot'].'
            }
        }
		
        /*$query = "SELECT GROUP_ID,GROUP_NAME FROM GROUPS WHERE GROUP_OWNER =" . $userId;
        $result = mysql_query($query);
        $count = 0;
		
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                $count++;
                $data = $data . '<div class="stats">';
                $data = $data . '<button class= "blue" onclick="getNewsletsByGroup(';
                $data = $data . $row[0];
                $data = $data . ')">' . $row[1] . '</button>';
                $data = $data . '</a></div>';
				
            }
        }*/
        return $data;
    }
	function get_business_user_info($id){
		 getDBConnection();
        $result = mysql_query("select ui.FIRST_NAME,ui.LAST_NAME,uli.USERNAME from USER_INFO as ui,USER_LOGIN_INFO uli where uli.USER_ID=ui.USER_ID and ui.USER_ID='".$id."'");
            return mysql_fetch_array($result);
	}
	function subscribe_check($login_id,$subscriberid) {
        getDBConnection();
		if($login_id==$subscriberid){
		}else if($login_id!=$subscriberid){
			
			$sqls = "select STATUS from USER_FOLLOWERS where USER_ID='".$subscriberid."' or BUSINESS_ID='".$subscriberid."'";
			$results = mysql_query($sqls);
			$nns = mysql_num_rows($results);
			
			
			return $nns;
		}
	}
function group_check($userId,$GROUP_ID){
	getDBConnection();
		
			
			$sqls = "select STATUS from USER_FOLLOWERS where USER_ID='".$userId."' and group_id='".$GROUP_ID."'";
			$results = mysql_query($sqls);
			$nns = mysql_num_rows($results);
			
			
			return $nns;
		
}
}

?>
