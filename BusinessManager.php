<?php
//session_start();
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
                $newsletCount = $ramConnection->zcard($row[0] . '_MSG');
                $matter = $matter . '<td>' . $newsletCount . '</td>';
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
	function get_group_dropdown() {
		getDBConnection();
		$ssql = "select GROUP_ID,GROUP_NAME from GROUPS where GROUP_OWNER='".$_SESSION['userId']."'";
		//echo $ssql;
		$recc = mysql_query($ssql);
		$numm = mysql_num_rows($recc);
		$dd = '';
        	$dd .= '<select name="group_id" id="group_id" style="border:1px solid #333;">
            <option value="">Select Group</option>';
            
			if($numm>0){
				while($roww=mysql_fetch_array($recc)){

            $dd .= '<option value="'.$roww['GROUP_ID'].'">'.$roww['GROUP_NAME'].'</option>';

				}
			}

           $dd .= '</select>';
		return $dd;
		
	}
	function getTopUsers_new($userId, $groupid) {
        getDBConnection();
        $ramConnection = getRAMConnection();
		//echo $sql;
		$sql = "select * from USER_FOLLOWERS where USER_ID ='" . $userId . "' and group_id='".$groupid."' order by individual desc";
        $result = mysql_query($sql);
        $matter = "";
        //if ($result) {
			$num = mysql_num_rows($result);
			//echo $num;
			if($num>0){
				while ($row = mysql_fetch_array($result)) {
				//echo 'user'.$row[0];	
				$use = $this->user_info($row['BUSINESS_ID']);
				//if ($ramConnection->sismember($userId . '_FOLLOWING', $row['BUSINESS_ID'])) {
				$path = getcwd();
				$path_validate = $path.'/upload/' . $row['BUSINESS_ID'] . '_S.png';
				$file_loc = SITE_URL.'upload/' . $row['BUSINESS_ID'] . '_S.png';
				if (file_exists($path_validate)) {
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}else{
					$file_loc = SITE_URL.'upload/un.png';
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}
				//$followerCount = $ramConnection->scard($row[0] . '_FOLLOWING');
				//' . $followerCount . '
				$newsletCount = $ramConnection->zcard($row['BUSINESS_ID'] . '_MSG');
				$use['individual'];
				
				if($row['individual']!=0){
					$group = 'Individual';
					$username = '@'.$use['USERNAME'];
					$full_name = $use['FIRST_NAME'] . ' ' . $use['LAST_NAME'] ;
					$button = '<div class="groupname_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row['BUSINESS_ID'] . '" onclick="unFollowUser(' . $userId . ', ' . $row['BUSINESS_ID'] . ' ) ">SUBSCRIBE</button></div>';
							
				}else if($row['group_id']!=0){
					//GROUP_NAME
					$username = '@Group';
					$username = '@'.$use['USERNAME'];
					$gr = $this->group_info($row['group_id']);
					//$group = $gr['GROUP_NAME'];
					$group = 'Group';
					$group = 'Individual';
					$full_name = $gr['GROUP_NAME'] ;
					$full_name = $use['FIRST_NAME'] . ' ' . $use['LAST_NAME'] ;
					$button = '<div class="groupname_class" ><button  style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row['BUSINESS_ID'] . '" onclick="unFollowUser(' . $userId . ', ' . $row['BUSINESS_ID'] . ' ) ">Delete </button></div>';
					$button = '<div class="groupname_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row['BUSINESS_ID'] . '" onclick="unFollowUser(' . $userId . ', ' . $row['BUSINESS_ID'] . ' ) ">SUBSCRIBE</button></div>';	
				}
					
								
				$matter = $matter . '<div class="subscribed_box" id="subscribed_box_'.$row['BUSINESS_ID'].'" style="float:left;width:100%;">
                            <div class="picture_class" style="">
							'.$cur_img.'
							</div>
							<div class="name_class" style="">
							 ' . $full_name . '
							</div>
                            <div class="username_class" >
							' . $username . '
							</div>
                            <div class="subscribe_class_bold" style=""> ' . $newsletCount . '</div>';
							$matter = $matter . $button;
							$matter .= '<div class="name_class_bold" >
							'.$group.'
							</div>';
                        $matter = $matter . '</div>';
               
            }
			}else{
				return false;
			}
        return $matter;
    }
	function getTopUsers_new_indivisual($userId , $idivisualid) {
        getDBConnection();
        $ramConnection = getRAMConnection();
		$sql = "select * from USER_FOLLOWERS where USER_ID ='" . $userId . "' and BUSINESS_ID='".$idivisualid."' order by individual desc";
		//echo $sql;
		//subscribe_check
        $result = mysql_query($sql);
		//$result = mysql_query("SELECT ULI.USER_ID,ULI.USERNAME,count(UF.USER_ID) AS FOLLOWERS,COUNT(BM.BMID) AS TWEETS FROM   USER_LOGIN_INFO ULI LEFT JOIN BROADCAST_MESSAGES BM ON  ULI.USER_ID=BM.BID LEFT JOIN USER_FOLLOWERS UF ON UF.BUSINESS_ID=BM.BID WHERE  LENGTH(ULI.USERNAME)>0 AND ULI.USER_ID >0 AND ULI.USER_ID !='" . $userId . "'GROUP BY ULI.USER_ID ORDER BY FOLLOWERS,TWEETS DESC");
        $matter = "";
        //if ($result) {
			$num = mysql_num_rows($result);
			//echo $num;
			if($num>0){
				while ($row = mysql_fetch_array($result)) {
				//echo 'user'.$row[0];	
				$use = $this->user_info($row['BUSINESS_ID']);
				//if ($ramConnection->sismember($userId . '_FOLLOWING', $row['BUSINESS_ID'])) {
				$path = getcwd();
				$path_validate = $path.'/upload/' . $row['BUSINESS_ID'] . '_S.png';
				$file_loc = SITE_URL.'upload/' . $row['BUSINESS_ID'] . '_S.png';
				if (file_exists($path_validate)) {
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}else{
					$file_loc = SITE_URL.'upload/un.png';
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}
				//$followerCount = $ramConnection->scard($row[0] . '_FOLLOWING');
				//' . $followerCount . '
				$newsletCount = $ramConnection->zcard($row['BUSINESS_ID'] . '_MSG');
				$use['individual'];
				
				if($row['individual']!=0){
					$group = 'Individual';
					$username = '@'.$use['USERNAME'];
					$full_name = $use['FIRST_NAME'] . ' ' . $use['LAST_NAME'] ;
					$button = '<div class="groupname_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row['BUSINESS_ID'] . '" onclick="unFollowUser(' . $userId . ', ' . $row['BUSINESS_ID'] . ' ) ">SUBSCRIBE</button></div>';
							
				}else if($row['group_id']!=0){
					//GROUP_NAME
					$username = '@Group';
					$gr = $this->group_info($row['group_id']);
					//$group = $gr['GROUP_NAME'];
					$group = 'Group';
					$full_name = $gr['GROUP_NAME'] ;
					$button = '<div class="groupname_class" ><button  style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row['BUSINESS_ID'] . '" onclick="unFollowUser(' . $userId . ', ' . $row['BUSINESS_ID'] . ' ) ">Delete </button></div>';
						
				}
					
								
				$matter = $matter . '<div class="subscribed_box" id="subscribed_box_'.$row['BUSINESS_ID'].'" style="float:left;width:100%;">
                            <div class="picture_class" style="">
							'.$cur_img.'
							</div>
							<div class="name_class" style="">
							 ' . $full_name . '
							</div>
                            <div class="username_class" >
							' . $username . '
							</div>
							
                            <div class="subscribe_class_bold" style=""> ' .$this->subscribe_check_indivisual($userId,$row['BUSINESS_ID']). '</div>';
						//if ($ramConnection->sismember($userId . '_FOLLOWING', $row[0])) {	
							//$matter = $matter . '<div class="name_class_bold" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row['BUSINESS_ID'] . '" onclick="unFollowUser(' . $userId . ', ' . $row['BUSINESS_ID'] . ' ) ">SUBSCRIBE</button></div>';
							$matter = $matter . $button;
							$matter .= '<div class="name_class_bold" >
							'.$group.'
							</div>';
								//followUser	
                            //$matter = $matter . '<div class="name_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row[0] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row[0] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "orange" id="subscribe_' . $userId . $row[0] . '" onclick="unFollowUser(' . $userId . ', ' . $row[0] . ' ) ">UNSUBSCRIBED</button></div>';
						//} else {
							//$matter = $matter . '<div class="name_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row[0] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row[0] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row[0] . '" onclick="followUser(' . $userId . ', ' . $row[0] . ' ) ">SUBSCRIBE</button></div>';
						//}
                        $matter = $matter . '</div>';
				//}else{
				//	}
                /*$matter = $matter . "<tr>";
                $matter = $matter . '<td class="avatar"><img src="upload/' . $row[0] . '_S.png" alt="" height="40" width="40" />' . $row[1] . ' </td>';
                $followerCount = $ramConnection->scard($row[0] . '_FOLLOWING');
                $matter = $matter . '<td>' . $followerCount . '</td>';
                $newsletCount = $ramConnection->zcard($row[0] . '_MSG');
                $matter = $matter . '<td>' . $newsletCount . '</td>';
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
        /*} else {
            echo mysql_error();
        }*/
        return $matter;
    }
	function getTopUsers_new_group($userId,$group_id) {
        getDBConnection();
        $ramConnection = getRAMConnection();
		//$sql = "SELECT ULI.USER_ID,ULI.USERNAME,count(UF.USER_ID) AS FOLLOWERS,COUNT(BM.BMID) AS TWEETS FROM   USER_LOGIN_INFO ULI LEFT JOIN BROADCAST_MESSAGES BM ON  ULI.USER_ID=BM.BID LEFT JOIN USER_FOLLOWERS UF ON UF.BUSINESS_ID=BM.BID WHERE LENGTH(ULI.USERNAME)>0 AND ULI.USER_ID >0 AND ULI.USER_ID ='" . $userId . "'GROUP BY ULI.USER_ID ORDER BY FOLLOWERS,TWEETS DESC";
		//echo $sql;
		$sql = "select * from USER_FOLLOWERS where USER_ID ='" . $userId . "' order by individual desc";
		//echo $sql;
		//subscribe_check
        $result = mysql_query($sql);
		//$result = mysql_query("SELECT ULI.USER_ID,ULI.USERNAME,count(UF.USER_ID) AS FOLLOWERS,COUNT(BM.BMID) AS TWEETS FROM   USER_LOGIN_INFO ULI LEFT JOIN BROADCAST_MESSAGES BM ON  ULI.USER_ID=BM.BID LEFT JOIN USER_FOLLOWERS UF ON UF.BUSINESS_ID=BM.BID WHERE  LENGTH(ULI.USERNAME)>0 AND ULI.USER_ID >0 AND ULI.USER_ID !='" . $userId . "'GROUP BY ULI.USER_ID ORDER BY FOLLOWERS,TWEETS DESC");
        $matter = "";
        //if ($result) {
			$num = mysql_num_rows($result);
			//echo $num;
			if($num>0){
				while ($row = mysql_fetch_array($result)) {
				//echo 'user'.$row[0];	
				$use = $this->user_info($row['BUSINESS_ID']);
				//if ($ramConnection->sismember($userId . '_FOLLOWING', $row['BUSINESS_ID'])) {
				$path = getcwd();
				$path_validate = $path.'/upload/' . $row['BUSINESS_ID'] . '_S.png';
				$file_loc = SITE_URL.'upload/' . $row['BUSINESS_ID'] . '_S.png';
				if (file_exists($path_validate)) {
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}else{
					$file_loc = SITE_URL.'upload/un.png';
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}
				//$followerCount = $ramConnection->scard($row[0] . '_FOLLOWING');
				//' . $followerCount . '
				$newsletCount = $ramConnection->zcard($row['BUSINESS_ID'] . '_MSG');
				$use['individual'];
				
				if($row['individual']!=0){
					$group = 'Individual';
					$username = '@'.$use['USERNAME'];
					$full_name = $use['FIRST_NAME'] . ' ' . $use['LAST_NAME'] ;
					$button = '<div class="groupname_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row['BUSINESS_ID'] . '" onclick="unFollowUser(' . $userId . ', ' . $row['BUSINESS_ID'] . ' ) ">SUBSCRIBE</button></div>';
							
				}else if($row['group_id']!=0){
					//GROUP_NAME
					$username = '@Group';
					$gr = $this->group_info($row['group_id']);
					//$group = $gr['GROUP_NAME'];
					$group = 'Group';
					$full_name = $gr['GROUP_NAME'] ;
					$button = '<div class="groupname_class" ><button  style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row['BUSINESS_ID'] . '" onclick="unFollowUser(' . $userId . ', ' . $row['BUSINESS_ID'] . ' ) ">Delete </button></div>';
						
				}
					
								
				$matter = $matter . '<div class="subscribed_box" id="subscribed_box_'.$row['BUSINESS_ID'].'" style="float:left;width:100%;">
                            <div class="picture_class" style="">
							'.$cur_img.'
							</div>
							<div class="name_class" style="">
							 ' . $full_name . '
							</div>
                            <div class="username_class" >
							' . $username . '
							</div>
							
                            <div class="subscribe_class_bold" style=""> ' . $newsletCount . '</div>';
						//if ($ramConnection->sismember($userId . '_FOLLOWING', $row[0])) {	
							//$matter = $matter . '<div class="name_class_bold" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row['BUSINESS_ID'] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row['BUSINESS_ID'] . '" onclick="unFollowUser(' . $userId . ', ' . $row['BUSINESS_ID'] . ' ) ">SUBSCRIBE</button></div>';
							$matter = $matter . $button;
							$matter .= '<div class="name_class_bold" >
							'.$group.'
							</div>';
								//followUser	
                            //$matter = $matter . '<div class="name_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row[0] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row[0] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "orange" id="subscribe_' . $userId . $row[0] . '" onclick="unFollowUser(' . $userId . ', ' . $row[0] . ' ) ">UNSUBSCRIBED</button></div>';
						//} else {
							//$matter = $matter . '<div class="name_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row[0] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row[0] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row[0] . '" onclick="followUser(' . $userId . ', ' . $row[0] . ' ) ">SUBSCRIBE</button></div>';
						//}
                        $matter = $matter . '</div>';
				//}else{
				//	}
                /*$matter = $matter . "<tr>";
                $matter = $matter . '<td class="avatar"><img src="upload/' . $row[0] . '_S.png" alt="" height="40" width="40" />' . $row[1] . ' </td>';
                $followerCount = $ramConnection->scard($row[0] . '_FOLLOWING');
                $matter = $matter . '<td>' . $followerCount . '</td>';
                $newsletCount = $ramConnection->zcard($row[0] . '_MSG');
                $matter = $matter . '<td>' . $newsletCount . '</td>';
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
        /*} else {
            echo mysql_error();
        }*/
        return $matter;
    }
	function searchTopsubscription($userId,$content) {
        getDBConnection();
        $ramConnection = getRAMConnection();
		//echo $content ;
		//$sql = "SELECT ULI.USER_ID,ULI.USERNAME,count(UF.USER_ID) AS FOLLOWERS,COUNT(BM.BMID) AS TWEETS FROM   USER_LOGIN_INFO ULI LEFT JOIN BROADCAST_MESSAGES BM ON  ULI.USER_ID=BM.BID LEFT JOIN USER_FOLLOWERS UF ON UF.BUSINESS_ID=BM.BID WHERE LENGTH(ULI.USERNAME)>0 AND ULI.USER_ID >0 AND (BM.BMESSAGE like '%".$content."%' || ULI.USERNAME like '%".$content."%') GROUP BY ULI.USER_ID ORDER BY FOLLOWERS,TWEETS DESC";
		
		//echo $sql;
		//"select ui.FIRST_NAME,ui.LAST_NAME, uli.USER_ID,uli.USERNAME,count(uf.BUSINESS_ID) as tot, from USER_INFO as ui, USER_LOGIN_INFO as uli left join USER_FOLLOWERS as uf on uli.USER_ID=uf.USER_ID where ui.USER_ID=uli.USER_ID group by USERNAME ORDER BY USERNAME";
		//$sql = "select uf.USER_ID,uf.FIRST_NAME,uf.LAST_NAME,uli.USERNAME from USER_INFO as uf,USER_LOGIN_INFO as uli where uli.USER_ID=uf.USER_ID and (FIRST_NAME like '%".$content."%' || 	LAST_NAME like '%".$content."%' || USERNAME like '%".$content."%')";
		$sql ="select uf.USER_ID,uf.FIRST_NAME,uf.LAST_NAME,uli.USERNAME,count(ui.	BUSINESS_ID) as tot from USER_INFO as uf,USER_LOGIN_INFO as uli left join USER_FOLLOWERS as ui on ui.USER_ID=uli.USER_ID where uli.USER_ID=uf.USER_ID and (FIRST_NAME like '%".$content."%' || 	LAST_NAME like '%".$content."%' || USERNAME like '%".$content."%') group by USER_ID order by USERNAME";
		//and ULI.USER_ID ='" . $userId . "'
		//echo $sql;
        $result = mysql_query($sql);
		//$result = mysql_query("SELECT ULI.USER_ID,ULI.USERNAME,count(UF.USER_ID) AS FOLLOWERS,COUNT(BM.BMID) AS TWEETS FROM   USER_LOGIN_INFO ULI LEFT JOIN BROADCAST_MESSAGES BM ON  ULI.USER_ID=BM.BID LEFT JOIN USER_FOLLOWERS UF ON UF.BUSINESS_ID=BM.BID WHERE  LENGTH(ULI.USERNAME)>0 AND ULI.USER_ID >0 AND ULI.USER_ID !='" . $userId . "'GROUP BY ULI.USER_ID ORDER BY FOLLOWERS,TWEETS DESC");
        $matter = "";
        if ($result) {
			$num = mysql_num_rows($result);
			//echo $num; 
			if($num>0){
					while ($row = mysql_fetch_array($result)) {

					$path = getcwd();
					$path_validate = $path.'/upload/' . $row[0] . '_S.png';
					$file_loc = SITE_URL.'upload/' . $row[0] . '_S.png';
					if (file_exists($path_validate)) {
						$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
					}else{
						$file_loc = SITE_URL.'upload/un.png';
						$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
					}
					//$followerCount = $ramConnection->scard($row[0] . '_FOLLOWING');
					//' . $followerCount . '
					$newsletCount = $ramConnection->zcard($row[0] . '_MSG');
					$matter = $matter . '<div class="subscribed_box" id="subscribed_box_'.$row['USER_ID'].'" style="float:left;width:100%;">
								<div class="name_class" style="">
								'.$cur_img.'<br> ' . $row[1] . '
								</div>
								<div class="name_class" >
								' . $row['USERNAME'] . '
								</div>'.$row[0];
								//<div class="subscribe_class" style=""> '.$row['tot'].'</div>';
							//if ($ramConnection->sismember($userId . '_FOLLOWING', $row[0])) {	
							$matter .= $this->subscribe_check($userId,$row[0]);
								//$matter = $matter . '<div class="name_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row[0] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row[0] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row[0] . '" onclick="unFollowUser(' . $userId . ', ' . $row[0] . ' ) ">SUBSCRIBE</button></div>';
								//$matter .= '<div class="name_class" ><button  style="padding:10px 5px;font-size:11px; margin:0px;" class= "orange" id="subscribe_' . $userId . $row[0] . '" onclick="unFollowUser( ' . $row[0] . ' ) ">SUBSCRIBE</button></div>';
									//followUser	
								//$matter = $matter . '<div class="name_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row[0] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row[0] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "orange" id="subscribe_' . $userId . $row[0] . '" onclick="unFollowUser(' . $userId . ', ' . $row[0] . ' ) ">UNSUBSCRIBED</button></div>';
							//} else {
								//$matter = $matter . '<div class="name_class" ><button onmouseover="open_unsubscribe(\'subscribe_' . $userId . $row[0] . '\');" onmouseout="open_subscribe(\'subscribe_' . $userId . $row[0] . '\');" style="padding:10px 5px;font-size:11px; margin:0px;" class= "bluechange" id="subscribe_' . $userId . $row[0] . '" onclick="followUser(' . $userId . ', ' . $row[0] . ' ) ">SUBSCRIBE</button></div>';
								//$matter = $matter . '<div class="name_class" ><button style="padding:10px 5px;font-size:11px; margin:0px;" class= "blue" id="subscribe_' . $userId . $row[0] . '" onclick="followUser( ' . $row[0] . ' ) ">UNSUBSCRIBED</button></div>';
							//}
							$matter = $matter . '</div>';
					
				   
				}
			}else{
				return false;
			}
        } else {
            echo mysql_error();
        }
        return $matter;
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
				<div style="width:20%; float:left;">';
                $data .= '<img src="'.$file_loc_in.'" /></div>
				<div style="float: left; text-align: centre; width: 15%; margin: 0px;">'.$name['FIRST_NAME'].' '.$name['LAST_NAME'].'
				</div>
				<div style="float: left; text-align: centre; width: 15%; margin: 0px;"> @'.$name['USERNAME'].'
				</div>
				<div style="float: left; margin: 15px 0px 0px; width: 15%; border: 0px solid #ccc;">'.$this->subscribe_check_indivisual($row_in['USER_ID'],$row_in['BUSINESS_ID']).'</div>
				';
				$data .= '<div style="float: left; margin: 15px 0px 0px; width: 15%; border: 0px solid #ccc;"> ';
				$data .= '<button class="blue" onclick="javascript:document.location.href=\'MySubscription.php?indivisualid='.$row_in['BUSINESS_ID'].'\';" id="search_button">View</button>';
				$data .= '</div>';
				$data .= '<div style="float: left; margin: 15px 0px 0px; width: 20%; border: 0px solid #ccc;"> <button class="blue" onclick="javascript:unFollowUser_refresh(\''.$row_in['USER_ID'].'\',\''.$row_in['BUSINESS_ID'].'\');" id="delete_button">Delete</button></div>';
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
				<div style="width:20%; float:left;">';
                $data .= '<img src="'.$file_loc.'" /></div>
				<div style="float: left; text-align: centre; width: 15%; margin: 0px;">'.$row['GROUP_NAME'].'</div>
				<div style="float: left; text-align: centre; width: 15%; margin: 0px;">@Group</div>';
				 $data .= '<div style="float: left; margin: 15px 0px 0px; width: 15%; border: 0px solid #ccc;">'.$this->group_check($userId,$row['GROUP_ID']).'</div>';
				 $data .= '<div style="float: left; margin: 15px 0px 0px; width: 15%; border: 0px solid #ccc;"> <button class="blue" onclick="javascript:document.location.href=\'MySubscription.php?groupid='.$row['GROUP_ID'].'\';" id="search_button">View</button></div>';
				$data .= '<div style="float: left; margin: 15px 0px 0px; width: 20%; border: 0px solid #ccc;"> <button class="blue" onclick="javascript:delete_droup('.$row['GROUP_ID'].');" id="delete_button">Delete</button></div>';
                $data .= '</div></div>';
				//'.$row['tot'].'
            }
        }
        return $data;
    }
	function get_business_user_info($id){
		 getDBConnection();
        $result = mysql_query("select ui.FIRST_NAME,ui.LAST_NAME,uli.USERNAME from USER_INFO as ui,USER_LOGIN_INFO uli where uli.USER_ID=ui.USER_ID and ui.USER_ID='".$id."'");
            return mysql_fetch_array($result);
	}
	function searchTopsubscription_new($userId,$content) {
        getDBConnection();
        $ramConnection = getRAMConnection();
		$sql ="select uf.USER_ID,uf.FIRST_NAME,uf.LAST_NAME,uli.USERNAME,count(ui.	BUSINESS_ID) as tot from USER_INFO as uf,USER_LOGIN_INFO as uli left join USER_FOLLOWERS as ui on ui.USER_ID=uli.USER_ID where uli.USER_ID=uf.USER_ID and (FIRST_NAME like '%".$content."%' || 	LAST_NAME like '%".$content."%' || USERNAME like '%".$content."%') group by USER_ID order by USERNAME";
        $result = mysql_query($sql);
        $matter = "";
        if ($result) {
			$num = mysql_num_rows($result);
			//echo $num; 
			if($num>0){
					while ($row = mysql_fetch_array($result)) {

					$path = getcwd();
					$path_validate = $path.'/upload/' . $row[0] . '_S.png';
					$file_loc = SITE_URL.'upload/' . $row[0] . '_S.png';
					if (file_exists($path_validate)) {
						$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
					}else{
						$file_loc = SITE_URL.'upload/un.png';
						$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
					}
					//$followerCount = $ramConnection->scard($row[0] . '_FOLLOWING');
					//' . $followerCount . '
					$newsletCount = $ramConnection->zcard($row[0] . '_MSG');
					$matter = $matter . '<div class="subscribed_box" id="subscribed_box_'.$row['USER_ID'].'" style="float:left;width:100%;">
								<div class="name_class" style="">
								'.$cur_img. '
								</div>
								<div class="name_class" style="">
								'. $row[1] . '
								</div>
								<div class="name_class" >
								@' . $row['USERNAME'] . '
								</div>';
								//<div class="subscribe_class" style=""> '.$row['tot'].'</div>';
							//if ($ramConnection->sismember($userId . '_FOLLOWING', $row[0])) {	
							$matter .= $this->subscribe_check($userId,$row[0]);
								
							$matter = $matter . '</div>';
					
				   
				}
			}else{
				return false;
			}
        } else {
            echo mysql_error();
        }
        return $matter;
    }
	function subscribe_check_indivisual($login_id,$subscriberid) {
        getDBConnection();
		if($login_id==$subscriberid){
		}else if($login_id!=$subscriberid){
			
			$sqls = "select STATUS from USER_FOLLOWERS where USER_ID='".$subscriberid."' or BUSINESS_ID='".$subscriberid."'";
			//echo $sqls;
			$results = mysql_query($sqls);
			$nns = mysql_num_rows($results);
			
			
			return $nns;
		}
	}
	function subscribe_check($login_id,$subscriberid) {
        getDBConnection();
		if($login_id==$subscriberid){
		}else if($login_id!=$subscriberid){
			$sql = "select STATUS from USER_FOLLOWERS where USER_ID='".$login_id."' and BUSINESS_ID='".$subscriberid."'";
			//echo $sql; 
			$result = mysql_query($sql);
			$nn = mysql_num_rows($result);
			//echo $nn;
			$sqls = "select STATUS from USER_FOLLOWERS where USER_ID='".$subscriberid."' or BUSINESS_ID='".$subscriberid."'";
			$results = mysql_query($sqls);
			$nns = mysql_num_rows($results);
			$but = '';
			$but .= '<div class="subscribe_class" id="" style="subscribe_class_'.$subscriberid.'"> '.$nns.'</div>';
			//echo ;
			if($nn == 0){
				//UNSUBSCRIBED
				$but .= '<div class="name_class" ><button style="padding:10px 5px;font-size:11px; margin:0px;" class= "blue" id="subscribe_' . $login_id.$subscriberid . '" onclick="followUser( ' . $subscriberid . ' ) ">SUBSCRIBE</button></div>';
			}else{
				$but .= '<div class="name_class" ><button  style="padding:10px 5px; background:linear-gradient(to bottom, #0C0 0%, #0C0 100%) repeat scroll 0 0 transparent;  font-size:11px; margin:0px;" class= "blue" id="subscribe_' . $login_id.$subscriberid . '" onclick="unFollowUser( ' . $subscriberid . ' ) ">SUBSCRIBED</button></div>';
			}
			return $but;
		}
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
                $newsletCount = $ramConnection->zcard($row[0] . '_MSG');
                $matter = $matter . '<td>' . $newsletCount . '</td>';
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
		$path = getcwd();
        $ramConnection = getRAMConnection();
		//$sql = "SELECT DISTINCT UF.USER_ID,ULI.USERNAME FROM USER_FOLLOWERS UF LEFT JOIN USER_LOGIN_INFO ULI ON UF.USER_ID=ULI.USER_ID WHERE UF.STATUS='N' AND UF.BUSINESS_ID='" . $userId . "' AND UF.USER_ID!='" . $userId . "'";
		$sql = "select * from USER_FOLLOWERS where BUSINESS_ID='" . $userId . "' and STATUS='A'";
		//echo $sql ;
        $result = mysql_query($sql);
		$num = mysql_num_rows($result);
        $matter = "";
        if ($num > 0) {
            while ($row = mysql_fetch_array($result)) {
				$path_validate = $path.'/upload/' . $row['USER_ID'] . '_S.png';
				$file_loc = SITE_URL.'upload/' . $row['USER_ID'] . '_S.png';
				if (file_exists($path_validate)) {
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}else{
					$file_loc = SITE_URL.'upload/un.png';
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}
				//$use = $this->user_info($row['BUSINESS_ID']);
				
				$buser = $this->user_info($row['USER_ID']);
				$row['BUSINESS_ID'];
                $matter = $matter . "<tr id='".$row['USER_ID']."_F'>";
                $matter = $matter . '<td class="avatar"><div style="width:400px; float:left;"><div style="width:120px; float:left;"><div style="width:118px; float:left;">'.$cur_img.'</div> <div style="width:118px; float:left;">' . $buser['USERNAME'] . '</div></div> <div style="float:left;">' . $buser['FIRST_NAME'] . ' '.$buser['LAST_NAME'].'</div></div> </td>';
                //$matter = $matter . '<td><button class= "blue" id="' . $userId . $row['USER_ID'] . '_GROUP" onclick="allow( ' . $row['USER_ID'] . ' ) ">ALLOW</button></td>';
				$matter = $matter . '<td>@ '.$buser['USERNAME'].'</td>';
                $matter = $matter . '<td><button class= "blue" id="' . $userId . $row['USER_ID'] . '_GROUP" onclick="block( ' . $row['USER_ID'] . ' ) ">BLOCK</button></td>';
                $matter = $matter . "</tr>";
            }
        } else {
			$matter .='<tr><td class="avatar" colspan="3" align="center" style="font-weight:bold;">There are no subscribers. </td></tr>';
            //echo mysql_error();
        }
        return $matter;
    }
	 function getPendingFollowers($userId) {
        getDBConnection();
		$path = getcwd();
        $ramConnection = getRAMConnection();
		//$sql = "SELECT DISTINCT UF.USER_ID,ULI.USERNAME FROM USER_FOLLOWERS UF LEFT JOIN USER_LOGIN_INFO ULI ON UF.USER_ID=ULI.USER_ID WHERE UF.STATUS='N' AND UF.BUSINESS_ID='" . $userId . "' AND UF.USER_ID!='" . $userId . "'";
		$sql = "select * from USER_FOLLOWERS where BUSINESS_ID='" . $userId . "' and STATUS='N'";
		//echo $sql ;
        $result = mysql_query($sql);
		$num = mysql_num_rows($result);
        $matter = "";
        if ($num > 0) {
            while ($row = mysql_fetch_array($result)) {
				$path_validate = $path.'/upload/' . $row['USER_ID'] . '_S.png';
				$file_loc = SITE_URL.'upload/' . $row['USER_ID'] . '_S.png';
				if (file_exists($path_validate)) {
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}else{
					$file_loc = SITE_URL.'upload/un.png';
					$cur_img = '<img src="'.$file_loc.'" alt="" height="40" width="40" />';
				}
				$buser = $this->user_info($row['USER_ID']);
				$row['BUSINESS_ID'];
                $matter = $matter . "<tr id='".$row['USER_ID']."_F'>";
                $matter = $matter . '<td class="avatar"><div style="width:400px; float:left;"><div style="width:120px; float:left;"><div style="width:118px; float:left;">'.$cur_img.'</div> <div style="width:118px; float:left;">' . $buser['USERNAME'] . '</div></div> <div style="float:left;">' . $buser['FIRST_NAME'] . ' '.$buser['LAST_NAME'].'</div></div> </td>';
                $matter = $matter . '<td><button class= "blue" id="' . $userId . $row['USER_ID'] . '_GROUP" onclick="allow( ' . $row['USER_ID'] . ' ) ">ALLOW</button></td>';
                $matter = $matter . '<td><button class= "blue" id="' . $userId . $row['USER_ID'] . '_GROUP" onclick="block( ' . $row['USER_ID'] . ' ) ">BLOCK</button></td>';
                $matter = $matter . "</tr>";
            }
        } else {
			$matter .='<tr><td class="avatar" colspan="3" align="center" style="font-weight:bold;">There are no pending subscribers. </td></tr>';
            //echo mysql_error();
        }
        return $matter;
    }

    function allowUser($userId, $bizId) {
        getDBConnection();
        $query = "UPDATE USER_FOLLOWERS SET STATUS ='A' WHERE USER_ID='" . $bizId  . "' AND BUSINESS_ID='" . $userId . "'";
        //print($query);
        $ramConnection = getRAMConnection();
        mysql_query($query);
		$notification_msg = 'Subscription Allowed'; 
			$notification_area = 'MySubscription.php';
			$notification = "INSERT INTO notification set from_id='".$userId."',to_id='".$bizId."',notification='".$notification_msg."',read_status='N',post_date=now(),notification_area='".$notification_area."'";
			mysql_query($notification);
			
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
	function user_info($userId) {
        getDBConnection();
        $query = "SELECT i.USER_ID,i.FIRST_NAME,i.LAST_NAME,i.EMAIL,i.MOBILE,i.ADDRESS,i.CITY,i.STATE,i.COUNTRY,i.DATE_OF_BIRTH,ui.USERNAME FROM USER_INFO as i,USER_LOGIN_INFO as ui where ui.USER_ID = i.USER_ID and ui.USER_ID='".$userId."'  ";
       $qer = mysql_query($query);
	   $res=mysql_fetch_array($qer);
	   return $res;
    }
	function group_info($gId) {
        getDBConnection();
        $query = "select GROUP_NAME from GROUPS where GROUP_ID='".$gId."'  ";
       $qer = mysql_query($query);
	   $res=mysql_fetch_array($qer);
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
	function group_check($userId,$GROUP_ID){
	getDBConnection();
		
			
			$sqls = "select STATUS from USER_FOLLOWERS where USER_ID='".$userId."' and group_id='".$GROUP_ID."'";
			$results = mysql_query($sqls);
			$nns = mysql_num_rows($results);
			
			
			return $nns;
		
	}
}

?>
