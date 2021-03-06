<?php

include_once 'config.php';
ini_set('display_errors', 'On');
include_once 'MessageManager.php';

/**
 * Description of UserManager
 *
 * @author ShivaGanesh
 */
class UserManager {

    function validateUser($username, $password) {
        $ramConnection = getRAMConnection();
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

    function saveUser($email, $userName, $password) {
        try {
            getDBConnection();
            $ramConnection = getRAMConnection();
            $userInfoQuery = "INSERT INTO USER_INFO (EMAIL) values ('$email')";
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

    function updateUserInfo($userId, $firstName, $lastName, $mobile, $address, $city, $state, $dateOfBirth, $anniversaryDate) {
        try {
            getDBConnection();
            $fromdob = mysql_real_escape_string($dateOfBirth);
            $dob = date('Y-m-d', strtotime(str_replace('-', '/', $fromdob)));
            $fromannDate = mysql_real_escape_string($anniversaryDate);
            $annDate = date('Y-m-d', strtotime(str_replace('-', '/', $fromannDate)));
            $userInfoQuery = "UPDATE USER_INFO SET FIRST_NAME='$firstName',LAST_NAME='$lastName',MOBILE='$mobile',ADDRESS='$address',CITY='$city',STATE='$state',COUNTRY='INDIA',DATE_OF_BIRTH='$dob',ANNIVERSARY_DATE='$annDate' WHERE USER_ID='$userId'";
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

    function followBiz($userId, $bizId) {
        try {
            getDBConnection();
            $query = "SELECT PUBLIC_PROFILE FROM USER_INFO WHERE USER_ID=" . $bizId;
            $result = mysql_query($query);
            $status = "";
            while ($row = mysql_fetch_array($result)) {
                if ($row[0] == 'N') {
                    $status = "N";
                } else {
                    $status = "A";
                }
            }
            mysql_query("INSERT INTO USER_FOLLOWERS (USER_ID,BUSINESS_ID,STATUS) values ('" . $userId . "','" . $bizId . "','" . $status . "')") or die("Database error:<br />" . mysql_error());
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

    function makeTweetsPublic($userId, $status) {
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

    function unfollowBiz($userId, $bizId) {
        try {
            getDBConnection();
            mysql_query("DELETE USER_FOLLOWERS WHERE USER_ID = '.$userId.'AND BUSINESS_ID = '. $bizId . '");
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

    function getNotifications($userId) {
        $ramConnection = getRAMConnection();
        $notifications = $ramConnection->lrange($userId . '_NOTIFY', 0, 10);
        $notifyUI = '';
        foreach ($notifications as $k => $v) {
            $notifyUI = $notifyUI . '<li><hgroup><h1>';
            $notifyUI = $notifyUI . $v;
            $notifyUI = $notifyUI . '</h1></hgroup></li>';
        }
        return $notifyUI;
    }

    function getAllFolloiwingUsersAndGroups($userId) {
        getDBConnection();
        $data = "";
        $query = "SELECT DISTINCT UF.USER_ID,UF.BUSINESS_ID,ULI.USERNAME FROM USER_FOLLOWERS UF LEFT JOIN USER_LOGIN_INFO ULI ON UF.BUSINESS_ID=ULI.USER_ID WHERE UF.USER_ID=" . $userId . " AND UF.BUSINESS_ID !=" . $userId . " AND UF.BUSINESS_ID>0 AND ULI.USERNAME is not null";
        $result = mysql_query($query);
		
		$num;
		
		$num=mysql_num_rows($result);
		
		//echo $num;
		
        $count = 0;
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                if ($count == 0) {
                    //$data = $data . '<input type="text" id="firstBizId" value="' . $userId . '"/>';
					 $data = $data . '<input type="hidden" id="firstBizId" value="' . $row[1] . '"/>';
                }
                $count++;
                $data = $data . '<div class="stats">';
                $data = $data . '<img src="logos/';
                $data = $data . $row[1];
                $data = $data . '_M.png" onclick="getTweets(';
                $data = $data . $row[1];
                $data = $data . ')"/><br>';
	
                $data = $data .$row[2];
				//}
			
                $data = $data . '</div>';
            }
        }
        $query = "SELECT GROUP_ID,GROUP_NAME FROM GROUPS WHERE GROUP_OWNER =" . $userId;
        $result = mysql_query($query);
        $count = 0;
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                $count++;
                $data = $data . '<div class="stats">';
                $data = $data . '<button class= "blue" onclick="getTweetsByGroup(';
                $data = $data . $row[0];
                $data = $data . ')">' . $row[1] . '</button>';
                $data = $data . '</a></div>';
				
            }
        }
        return $data;
    }

}

?>
