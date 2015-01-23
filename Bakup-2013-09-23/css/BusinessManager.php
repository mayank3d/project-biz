<?php
session_start();
include_once 'BusinessPOJO.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BusinessManager
 *
 * @author shiva
 */
class BusinessManager {

    function getTopUsers($userId) {
        getDBConnection();
        $ramConnection = getRAMConnection();
        $result = mysql_query("SELECT ULI.USER_ID,ULI.USERNAME,count(UF.USER_ID) AS FOLLOWERS,COUNT(BM.BMID) AS TWEETS FROM   USER_LOGIN_INFO ULI LEFT JOIN BROADCAST_MESSAGES BM ON  ULI.USER_ID=BM.BID LEFT JOIN USER_FOLLOWERS UF ON UF.BUSINESS_ID=BM.BID WHERE LENGTH(ULI.USERNAME)>0 AND ULI.USER_ID >0 AND ULI.USER_ID !='" . $userId . "'GROUP BY ULI.USER_ID ORDER BY FOLLOWERS,TWEETS DESC");
        $matter = "";
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                $matter = $matter . "<tr>";
                $matter = $matter . '<td class="avatar"><img src="upload/' . $row[0] . '_S.png" alt="" height="40" width="40" />' . $row[1] . ' </td>';
                $followerCount = $ramConnection->scard($row[0] . '_FOLLOWING');
                $matter = $matter . '<td>' . $followerCount . '</td>';
                $tweetCount = $ramConnection->zcard($row[0] . '_MSG');
                $matter = $matter . '<td>' . $tweetCount . '</td>';
                if ($ramConnection->sismember($userId . '_FOLLOWING', $row[0])) {
                    $matter = $matter . '<td><button class= "orange" id="' . $userId . $row[0] . '" onclick="unFollowUser(' . $userId . ', ' . $row[0] . ' ) ">UNFOLLOW</button></td>';
                } else {
                    $matter = $matter . '<td><button class= "blue" id="' . $userId . $row[0] . '" onclick="followUser(' . $userId . ', ' . $row[0] . ' ) ">FOLLOW</button></td>';
                }
                $matter = $matter . '<td><button class= "blue" id="' . $userId . $row[0] . '_GROUP" onclick="addToGroup(' . $userId . ', ' . $row[0] . ' ) ">ADD TO GROUP</button></td>';
                $matter = $matter . "</tr>";
            }
        } else {
            echo mysql_error();
        }
        return $matter;
    }
	function getTopUsers_new($userId) {
        getDBConnection();
        $ramConnection = getRAMConnection();
        $result = mysql_query("SELECT ULI.USER_ID,ULI.USERNAME,count(UF.USER_ID) AS FOLLOWERS,COUNT(BM.BMID) AS TWEETS FROM   USER_LOGIN_INFO ULI LEFT JOIN BROADCAST_MESSAGES BM ON  ULI.USER_ID=BM.BID LEFT JOIN USER_FOLLOWERS UF ON UF.BUSINESS_ID=BM.BID WHERE LENGTH(ULI.USERNAME)>0 AND ULI.USER_ID >0 AND ULI.USER_ID !='" . $userId . "'GROUP BY ULI.USER_ID ORDER BY FOLLOWERS,TWEETS DESC");
        $matter = "";
        if ($result) {
			$num = mysql_num_rows($result);
			if($num>0){
            while ($row = mysql_fetch_array($result)) {
				$file_loc = SITE_URL.'upload/' . $row[0] . '_S.png';
				if (file_exists($file_loc)) {
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}else{
					$file_loc = SITE_URL.'upload/un.png';
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}
				//$followerCount = $ramConnection->scard($row[0] . '_FOLLOWING');
				//' . $followerCount . '
				$tweetCount = $ramConnection->zcard($row[0] . '_MSG');
				$matter = $matter . '<div class="subscribed_box" id="subscribed_box_'.$row['USER_ID'].'" style="float:left;width:100%;">
                            <div class="name_class" style="">
							'.$cur_img.'<br> ' . $row[1] . '
							</div>
                            <div class="name_class" >
							' . $row['USERNAME'] . '
							</div>
                            <div class="subscribe_class" style=""> ' . $tweetCount . '</div>';
						if ($ramConnection->sismember($userId . '_FOLLOWING', $row[0])) {		
                            $matter = $matter . '<div class="name_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row[0] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row[0] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "orange" id="subscribe_' . $userId . $row[0] . '" onclick="unFollowUser(' . $userId . ', ' . $row[0] . ' ) ">UNSUBSCRIBED</button></div>';
						} else {
							$matter = $matter . '<div class="name_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row[0] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row[0] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row[0] . '" onclick="followUser(' . $userId . ', ' . $row[0] . ' ) ">SUBSCRIBED</button></div>';
						}
                        $matter = $matter . '</div>';
						
                /*$matter = $matter . "<tr>";
                $matter = $matter . '<td class="avatar"><img src="upload/' . $row[0] . '_S.png" alt="" height="40" width="40" />' . $row[1] . ' </td>';
                $followerCount = $ramConnection->scard($row[0] . '_FOLLOWING');
                $matter = $matter . '<td>' . $followerCount . '</td>';
                $tweetCount = $ramConnection->zcard($row[0] . '_MSG');
                $matter = $matter . '<td>' . $tweetCount . '</td>';
                if ($ramConnection->sismember($userId . '_FOLLOWING', $row[0])) {
                    $matter = $matter . '<td><button class= "orange" id="' . $userId . $row[0] . '" onclick="unFollowUser(' . $userId . ', ' . $row[0] . ' ) ">UNFOLLOW</button></td>';
                } else {
                    $matter = $matter . '<td><button class= "blue" id="' . $userId . $row[0] . '" onclick="followUser(' . $userId . ', ' . $row[0] . ' ) ">FOLLOW</button></td>';
                }
                //$matter = $matter . '<td><button class= "blue" id="' . $userId . $row[0] . '_GROUP" onclick="addToGroup(' . $userId . ', ' . $row[0] . ' ) ">ADD TO GROUP</button></td>';
                $matter = $matter . "</tr>";*/
            }
			}else{
				return false;
			}
        } else {
            echo mysql_error();
        }
        return $matter;
    }

    function getTopUsers22($userId) {
        getDBConnection();
        $ramConnection = getRAMConnection();
        $result = mysql_query("select * from USER_INFO");
        $matter = "";
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                $matter = $matter . "<tr>";
                $matter = $matter . '<td class="avatar"><img src="upload/' . $row[0] . '_S.png" alt="" height="40" width="40" />' . $row[1] . ' </td>';
                $followerCount = $ramConnection->scard($row[0] . '_FOLLOWING');
                $matter = $matter . '<td>' . $followerCount . '</td>';
                $tweetCount = $ramConnection->zcard($row[0] . '_MSG');
                $matter = $matter . '<td>' . $tweetCount . '</td>';
                if ($ramConnection->sismember($userId . '_FOLLOWING', $row[0])) {
                    $matter = $matter . '<td><button class= "orange" id="' . $userId . $row[0] . '" onclick="unFollowUser(' . $userId . ', ' . $row[0] . ' ) ">UNFOLLOW</button></td>';
                } else {
                    $matter = $matter . '<td><button class= "blue" id="' . $userId . $row[0] . '" onclick="followUser(' . $userId . ', ' . $row[0] . ' ) ">FOLLOW</button></td>';
                }
                $matter = $matter . '<td><button class= "blue" id="' . $userId . $row[0] . '_GROUP" onclick="addToGroup(' . $userId . ', ' . $row[0] . ' ) ">ADD TO GROUP</button></td>';
                $matter = $matter . "</tr>";
            }
        } else {
            echo mysql_error();
        }
        return $matter;
    }

    function getNewFollowers($userId) {
        getDBConnection();
        $ramConnection = getRAMConnection();
        $result = mysql_query("SELECT DISTINCT UF.USER_ID,ULI.USERNAME FROM USER_FOLLOWERS UF LEFT JOIN USER_LOGIN_INFO ULI ON UF.USER_ID=ULI.USER_ID WHERE UF.STATUS='N' AND UF.BUSINESS_ID='" . $userId . "' AND UF.USER_ID!='" . $userId . "'");
        $matter = "";
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                $matter = $matter . "<tr id='".$row[0]."_F'>";
                $matter = $matter . '<td class="avatar"><img src="upload/' . $row[0] . '_S.png" alt="" height="40" width="40" />' . $row[1] . ' </td>';
                $matter = $matter . '<td><button class= "blue" id="' . $userId . $row[0] . '_GROUP" onclick="allow(' . $userId . ', ' . $row[0] . ' ) ">ALLOW</button></td>';
                $matter = $matter . '<td><button class= "blue" id="' . $userId . $row[0] . '_GROUP" onclick="block(' . $userId . ', ' . $row[0] . ' ) ">BLOCK</button></td>';
                $matter = $matter . "</tr>";
            }
        } else {
            echo mysql_error();
        }
        return $matter;
    }

    function allowUser($userId, $bizId) {
        getDBConnection();
        $query = "UPDATE USER_FOLLOWERS SET STATUS ='A' WHERE USER_ID='" . $bizId  . "' AND BUSINESS_ID='" . $userId . "'";
        print($query);
        $ramConnection = getRAMConnection();
        mysql_query($query);
        $ramConnection->sadd($userId . '_FOLLOWING', $bizId);
        $ramConnection->sadd($bizId . '_FOLLOWERS', $userId);
        $ramConnection->hset($bizId . "_INFO", "FOLLOWER_COUNT", $ramConnection->scard($bizId . '_FOLLOWERS'));
        $ramConnection->hset($userId . "_INFO", "FOLLOWING_COUNT", $ramConnection->scard($userId . '_FOLLOWING'));
    }

    function blockUser($userId, $bizId) {
        getDBConnection();
        $query = "UPDATE USER_FOLLOWERS SET STATUS ='B' WHERE USER_ID='" . $userId . "' AND BUSINESS_ID='" . $bizId . "'";
        $ramConnection = getRAMConnection();
        mysql_query($query);
    }

 function test123($userId) {
        getDBConnection();
        $query = "SELECT ULI.USER_ID,ULI.USERNAME,count(UF.USER_ID) AS FOLLOWERS,COUNT(BM.BMID) AS TWEETS FROM   USER_LOGIN_INFO ULI LEFT JOIN BROADCAST_MESSAGES BM ON  ULI.USER_ID=BM.BID LEFT JOIN USER_FOLLOWERS UF ON UF.BUSINESS_ID=BM.BID WHERE LENGTH(ULI.USERNAME)>0 AND ULI.USER_ID >0 AND ULI.USER_ID !='" . $userId . "'GROUP BY ULI.USER_ID ORDER BY FOLLOWERS,TWEETS DESC";
        $ramConnection = getRAMConnection();
       $qer = mysql_query($query);
	   $res=mysql_fetch_array($qer);
	     $count=mysql_num_rows($qer);
	   $_SESSION['count']=$count;
	   return $res;
		
    }
	
	function fetchData($id)
	{
        getDBConnection();
        $query = "SELECT * FROM BROADCAST_MESSAGES WHERE BID='".$id."'";
        $ramConnection = getRAMConnection();
       $qer = mysql_query($query);
	   $res=mysql_fetch_array($qer);
	 
	   return $res;
		
    }

}

?>
