<?php

ini_set('display_errors', 1);
/**
 * Description of TNLManager
 *
 * @author shiva
 */
include_once 'TNI.php';
include_once 'MessageManager.php';

class TNIManager {

    function getNewsletsUI($userId, $session_id) {
        getDBConnection();
        $jsonArray = $this->getNewsLetIdsByUserId($userId, $session_id);
        $inter = "";
        //echo count($jsonArray);
        /* echo '<pre>';
          print_r($jsonArray);
          die(); */
        foreach ($jsonArray as $k) {
            /* echo '<pre>';
              print_r($k); */

            $ccuser = $k->getUserId();
            //var_dump($ccuser);
            if ($ccuser == $userId) {
                //var_dump($ccuser);
                $userinfo = $this->getUserInfo($k->getUserId());
                //var_dump($k);
                //die();
                // $k->userId;
                //print_r($_SESSION['userId']);
                //die();
                $path = getcwd();
                $file_loc = SITE_URL . 'upload/' . $k->getUserId() . '_S.png';
                $path_validate = $path . '/upload/' . $k->getUserId() . '_S.png';
                //echo $file_loc;
                //echo file_exists($file_loc);
                if (file_exists($path_validate)) {
                    $file_loc = $file_loc;
                } else {
                    $file_loc = SITE_URL . 'upload/un.png';
                }
                /* $inter .= '<div class="tl-post" id="mystream_msg_'.$k->getNewsletId().'">
                  <span class="icon"><img src="' . $file_loc . '" /></span>';

                  $inter .= '<p align="justify" ><div class="">';

                  if($k->getUserName()){
                  $user = '<div><strong>'.$k->getUserName() . '  :</strong></div>';
                  }else{
                  $user = '<div><strong> Guest :</strong></div>';
                  }
                  $inter .=  $user . '<div>'.$k->getNewsletContent().'</div>';
                  $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' cools </span>';
                  if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                  $inter .= '<a href="#" id="' . $k->getNewsletId() . 'coolBtn" onclick="coolMessage(\'' . $k->getNewsletId() . '\')">cool!</a>';
                  } else {
                  $inter .= '<a href="#" id="' . $k->getNewsletId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getNewsletId() . '\')">uncool!</a>';
                  }
                  $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->getShareCount() . ' shares  </span>';
                  if (strcmp($k->getAlreadyShared(), "y") < 0) {
                  $inter .= '<a href="#" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a>';
                  }
                  if($_SESSION['userId']==$k->userId){
                  $inter .= ' | <a href="javascript:delete_msg(\''.$k->getNewsletId().'\',\''.$k->userId.'\');" > Delete  </a>';
                  }
                  $inter .= ' | <a href="#" onclick="window.location.href=\'commentSection.php?id=' . $k->getNewsletId() . '\'"> comment  </a>

                  </div>
                  </p>
                  </div>'; */
                $inter .= '<div class="tl-post" id="mystream_msg_' . $k->getNewsletId() . '">
			<span class="icon"><img src="' . $file_loc . '" /></span>';

                $inter .= '<p align="justify" >';

                if ($k->getUserName()) {
                    if (empty($userinfo['FIRST_NAME']) && empty($userinfo['FIRST_NAME'])) {
                        $user = '<strong>' . $ccuser . '  : </strong>';
                    } else {
                        $user = '<strong>' . $userinfo['FIRST_NAME'] . ' ' . $userinfo['LAST_NAME'] . '  : </strong>';
                    }
                } else {
                    $user = '<strong> Guest :</strong>';
                }
                //$k->getNewsletContent();
                //$content = $k->getNewsletContent();
                $content = $k->newsletContent;

                if (!empty($content)) {
                    $inter .= $user . '' . $content;
                } else {
                    $inter .= $user . '' . var_dump($content);
                }
                $inter .= '<br><br>';
                //
                //$inter .= '<div>';
                if (strcmp($k->alreadyCooled, "y") < 0) {
                    $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;"><a href="#" id="' . $k->getNewsletId() . 'coolBtn" onclick="coolMessage(\'' . $k->getNewsletId() . '\')">Star</a></span>';
                } else {
                    $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;"><a href="#" id="' . $k->getNewsletId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getNewsletId() . '\')">Unstar</a></span>';
                }
                $inter .= ' <span style="width: 100px; margin-left: 15px; margin-right: 15px;"> <a href="' . SITE_URL . 'commentSection.php?id=' . $k->getNewsletId() . '" > Remarks  </a></span>';

                if ($_SESSION['userId'] == $k->userId) {
                    $inter .= ' <span style="width: 100px; margin-left: 15px; margin-right: 15px;"> <a href="javascript:delete_msg(\'' . $k->getNewsletId() . '\',\'' . $k->userId . '\');" > Delete  </a></span>';
                } else {

                    if (strcmp($k->getAlreadyShared(), "y") < 0) {
                        $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;"><a href="#" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a></span>';
                    }
                }
                $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' Star </span>';
                //$msgManager = new MessageManager;
                //$iidd = str_replace('i', '', $_GET['id']);
                //$commentsMap = $msgManager->getCommentsMap($iidd , $_SESSION['userId']);
                $remark = $this->get_remarks_count($k->getNewsletId());
                $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $k->getNewsletId() . 'msgId">' . $remark . ' Remarks </span>';
                if ($_SESSION['userId'] != $k->userId) {
                    $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->shareCount . ' shares  </span>';
                }
                //$inter .= '<div>';
                $inter .= '</p>
			</div>';
            }
        }

        return $inter;
    }

    function get_remarks_count($id) {
        //echo $id;
        $msgManager = new MessageManager;
        $iidd = str_replace('i', '', $id);
        $commentsMap = $msgManager->getCommentsMap($iidd, $_SESSION['userId'], 'Y');
        return $commentsMap;
    }

    function getUserInfo($userId) {
        getDBConnection();
        $result = mysql_query("SELECT * FROM USER_INFO WHERE USER_ID=" . $userId);

        $userInfo = mysql_fetch_array($result);
        return $userInfo;
    }

    function getNewsletsUIByBizId($userId, $session_id, $filter) {
        getDBConnection();
        //echo $userId.'--'. $session_id.'--'.$filter;
        if ($filter == 'G') {
            $groupid = $userId;
            $grsq = "select BUSINESS_ID from USER_FOLLOWERS where USER_ID='" . $session_id . "' and group_id='" . $groupid . "'";
            //echo $grsq;
            $grec = mysql_query($grsq);
            $jsonArray = array();
            while ($grow = mysql_fetch_array($grec)) {
                $user = '';
                $user = $grow['BUSINESS_ID'];
                //echo $user;
                $jsonArray1 = $this->getNewsLetIdsByBizId($user, $session_id);

                $jsonArray = array_merge($jsonArray, $jsonArray1);
                //echo '<pre>';
            }
            //var_dump($jsonArray);
            //die();
            //$user_id = implode(',',$userid);
            //echo $user_id;
        } else {
            //die();
            $jsonArray = $this->getNewsLetIdsByBizId($userId, $session_id);
        }
        //echo '<pre>';
        //print_r($jsonArray);
        //echo '</pre>';
        $inter = "";
        //echo $filter;
        $path = getcwd();
        if (sizeof($jsonArray) > 0) {
            foreach ($jsonArray as $k) {
                $ccuser = $k->getUserName();
                if (!empty($ccuser)) {
                    //var_dump($k);
                    //die();
                    $ccuser;

                    $user = $this->getUserInfo($k->getUserId());

                    //$inter .= "aaaaaa".print_r($user);;
                    //die();
                    $path_validate = $path . '/upload/' . $k->getUserId() . '_S.png';
                    $file_loc = SITE_URL . 'upload/' . $k->getUserId() . '_S.png';
                    if (file_exists($path_validate)) {
                        $file_loc = $file_loc;
                    } else {
                        $file_loc = SITE_URL . 'upload/un.png';
                    }

                    /* $inter .= '<div class="tl-post"  ><span class="icon"><img src="' . $file_loc . '" /></span>';
                      $inter .= ' <p align="justify" >';
                      $inter .= $k->getUserName() . '  ' . $k->getNewsletContent();
                      $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' cools</span>';
                      if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                      $inter .= '<button class="blue" id="' . $k->getNewsletId() . 'coolBtn" onclick="coolMessage(\'' . $k->getNewsletId() . '\')">cool!</button>';
                      } else {
                      $inter .= '<button class="blue" id="' . $k->getNewsletId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getNewsletId() . '\')">uncool!</button>';
                      }
                      $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->getShareCount() . ' shares </span>';
                      if (strcmp($k->getAlreadyShared(), "y") < 0) {
                      $inter .= '<a href="#" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a>';
                      }
                      $inter .= '<button class="red" onclick="window.location.href=\'commentSection.php?id=' . $k->getNewsletId() . '\'">comment</button></p></div>'; */
                    $inter .= '<div class="tl-post" id="mystream_msg_' . $k->getNewsletId() . '">
			<span class="icon"><img src="' . $file_loc . '" /></span>';

                    $inter .= '<p align="justify" >';

                    if ($k->getUserName()) {
                        //$k->getUserName()
                        if (empty($user['FIRST_NAME']) && empty($user['FIRST_NAME'])) {
                            $user = '<strong>' . $ccuser . '  : </strong>';
                        } else {
                            $user = '<strong>' . $user['FIRST_NAME'] . ' ' . $user['LAST_NAME'] . '  : </strong>';
                        }
                    } else {
                        $user = '<strong> Guest : </strong>';
                    }
                    $inter .= $user . '' . $k->getNewsletContent() . '';
                    $inter .= '<br><br>';
                    //$inter .= $k->getAlreadyCooled().'<br>'.strcmp($k->getAlreadyCooled(), "y");
                    //
			//$inter .= '<div>';
                    if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                        $inter .= '<span style="display:block; float:left ; width: 50px; margin-left: 10px; margin-right: 10px;">
				
				<a href="javascript:coolMessage(\'' . $k->getNewsletId() . '\');" id="' . $k->getNewsletId() . 'coolBtn" >Star</a>
				</span>';
                    } else {
                        $inter .= '<span style="display:block; float:left ; width: 50px; margin-left: 10px; margin-right: 10px;">
				
				<a href="javascript:unCoolMessage(\'' . $k->getNewsletId() . '\');" id="' . $k->getNewsletId() . 'coolBtn" >Unstar</a>
				</span>';
                    }
                    $inter .= ' <span style="width: 100px; margin-left: 10px; margin-right: 10px;"> <a href="' . SITE_URL . 'commentSection.php?id=' . $k->getNewsletId() . '" > Remarks  </a></span>';

                    if ($_SESSION['userId'] == $k->userId) {
                        $inter .= ' <span style="width: 100px; margin-left: 10px; margin-right: 10px;"> <a href="javascript:delete_msg(\'' . $k->getNewsletId() . '\',\'' . $k->userId . '\');" > Delete  </a></span>';
                    } else {

                        if (strcmp($k->getAlreadyShared(), "y") < 0) {
                            $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;"><a href="javascript:void(0);" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a></span>';
                        }
                    }
                    $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;" class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' Star </span>';
                    //$msgManager = new MessageManager;
                    //$iidd = str_replace('i', '', $_GET['id']);
                    //$commentsMap = $msgManager->getCommentsMap($iidd , $_SESSION['userId']);
                    $remark = $this->get_remarks_count($k->getNewsletId());
                    $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;" class="cools" id="' . $k->getNewsletId() . 'msgId">' . $remark . ' Remarks </span>';
                    if ($_SESSION['userId'] != $k->userId) {
                        $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;" class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->shareCount . ' shares  </span>';
                    }
                    if ($this->isArchived($k->getNewsletId())) {
                        $inter .= ' <span style="width: 100px; margin-left: 10px; margin-right: 10px;">Archived</span>';
                    } else {
                        $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;"><a href="javascript:void(0);" id="' . $k->getNewsletId() . 'archiveBtn" onclick="archiveNewslet(\'' . $k->getNewsletId() . '\')" >Archive</a></span>';
                    }
                    //$inter .= '<div>';
                    $inter .= '</p>
			</div>';
                }
            }
        }
        if (strlen($inter) == 0) {
            $inter = "Your Stream looks little...Dry !!";
        }
        return $inter;
    }

    function getNewsletsUIByuserid($userId, $session_id, $filter) {
        getDBConnection();
        //echo $userId.'--'. $session_id.'--'.$filter;
        if ($filter == 'G') {
            $groupid = $userId;
            $grsq = "select BUSINESS_ID from USER_FOLLOWERS where USER_ID='" . $session_id . "' and group_id='" . $groupid . "'";
            //echo $grsq;
            $grec = mysql_query($grsq);
            $jsonArray = array();
            while ($grow = mysql_fetch_array($grec)) {
                $user = '';
                $user = $grow['BUSINESS_ID'];
                //echo $user;
                $jsonArray1 = $this->getNewsLetIdsByBizId($user, $session_id);

                $jsonArray = array_merge($jsonArray, $jsonArray1);
                //echo '<pre>';
            }
            //var_dump($jsonArray);
            //die();
            //$user_id = implode(',',$userid);
            //echo $user_id;
        } else {
            //die();
            $jsonArray = $this->getNewsLetIdsByBizId($userId, $session_id);
        }
        //echo '<pre>';
        //print_r($jsonArray);
        //echo '</pre>';
        $inter = "";
        //echo $filter;
        $path = getcwd();
        if (sizeof($jsonArray) > 0) {
            foreach ($jsonArray as $k) {
                $ccuser = $k->getUserName();
                if (!empty($ccuser)) {
                    //var_dump($k);
                    //die();
                    $path_validate = $path . '/upload/' . $k->getUserId() . '_S.png';
                    $file_loc = SITE_URL . 'upload/' . $k->getUserId() . '_S.png';
                    if (file_exists($path_validate)) {
                        $file_loc = $file_loc;
                    } else {
                        $file_loc = SITE_URL . 'upload/un.png';
                    }

                    /* $inter .= '<div class="tl-post"  ><span class="icon"><img src="' . $file_loc . '" /></span>';
                      $inter .= ' <p align="justify" >';
                      $inter .= $k->getUserName() . '  ' . $k->getNewsletContent();
                      $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' cools</span>';
                      if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                      $inter .= '<button class="blue" id="' . $k->getNewsletId() . 'coolBtn" onclick="coolMessage(\'' . $k->getNewsletId() . '\')">cool!</button>';
                      } else {
                      $inter .= '<button class="blue" id="' . $k->getNewsletId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getNewsletId() . '\')">uncool!</button>';
                      }
                      $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->getShareCount() . ' shares </span>';
                      if (strcmp($k->getAlreadyShared(), "y") < 0) {
                      $inter .= '<a href="#" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a>';
                      }
                      $inter .= '<button class="red" onclick="window.location.href=\'commentSection.php?id=' . $k->getNewsletId() . '\'">comment</button></p></div>'; */
                    $inter .= '<div class="tl-post" id="mystream_msg_' . $k->getNewsletId() . '">
			<span class="icon"><img src="' . $file_loc . '" /></span>';

                    $inter .= '<p align="justify" >';

                    if ($k->getUserName()) {
                        $user = '<strong>' . $k->getUserName() . '  : </strong>';
                    } else {
                        $user = '<strong> Guest : </strong>';
                    }
                    $inter .= $user . '' . $k->getNewsletContent() . '';
                    $inter .= '<br><br>';
                    //$inter .= $k->getAlreadyCooled().'<br>'.strcmp($k->getAlreadyCooled(), "y");
                    //
			//$inter .= '<div>';
                    if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                        $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;"><a href="javascript:coolMessage(\'' . $k->getNewsletId() . '\');" id="' . $k->getNewsletId() . 'coolBtn" >Star</a></span>';
                    } else {
                        $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;"><a href="javascript:unCoolMessage(\'' . $k->getNewsletId() . '\');" id="' . $k->getNewsletId() . 'coolBtn" >Unstar</a></span>';
                    }
                    $inter .= ' <span style="width: 100px; margin-left: 10px; margin-right: 10px;"> <a href="' . SITE_URL . 'commentSection.php?id=' . $k->getNewsletId() . '" > Remarks  </a></span>';

                    if ($_SESSION['userId'] == $k->userId) {
                        $inter .= ' <span style="width: 100px; margin-left: 10px; margin-right: 10px;"> <a href="javascript:delete_msg(\'' . $k->getNewsletId() . '\',\'' . $k->userId . '\');" > Delete  </a></span>';
                    } else {

                        if (strcmp($k->getAlreadyShared(), "y") < 0) {
                            $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;"><a href="javascript:void(0);" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a></span>';
                        }
                    }
                    $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;" class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' Star </span>';
                    //$msgManager = new MessageManager;
                    //$iidd = str_replace('i', '', $_GET['id']);
                    //$commentsMap = $msgManager->getCommentsMap($iidd , $_SESSION['userId']);
                    $remark = $this->get_remarks_count($k->getNewsletId());
                    $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;" class="cools" id="' . $k->getNewsletId() . 'msgId">' . $remark . ' Remarks </span>';
                    if ($_SESSION['userId'] != $k->userId) {
                        $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;" class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->shareCount . ' shares  </span>';
                    }
                    //$inter .= '<div>';
                    $inter .= '</p>
			</div>';
                }
            }
        }
        if (strlen($inter) == 0) {
            $inter = "Your Stream looks little...Dry !!";
        }
        return $inter;
    }

    function getNewsletsUIByBizIdtest($userId, $session_id, $filter) {
        getDBConnection();
        //echo $userId.'--'. $session_id.'--'.$filter;
        if ($filter == 'G') {
            $groupid = $userId;
            $grsq = "select BUSINESS_ID from USER_FOLLOWERS where USER_ID='" . $session_id . "' and group_id='" . $groupid . "'";
            //echo $grsq;
            $grec = mysql_query($grsq);
            $jsonArray = array();
            while ($grow = mysql_fetch_array($grec)) {
                $user = '';
                $user = $grow['BUSINESS_ID'];
                //echo $user;
                $jsonArray1 = $this->getNewsLetIdsByBizId($user, $session_id);

                $jsonArray = array_merge($jsonArray, $jsonArray1);
                //echo '<pre>';
            }
            //var_dump($jsonArray);
            //die();
            //$user_id = implode(',',$userid);
            //echo $user_id;
        } else {
            //die();
            $jsonArray = $this->getNewsLetIdsByBizId($userId, $session_id);
        }
        /* echo '<pre>';
          print_r($jsonArray);
          echo '</pre>';
          die(); */
        $inter = "";
        //echo $filter;
        $path = getcwd();
        if (sizeof($jsonArray) > 0) {
            foreach ($jsonArray as $k) {
                $ccuser = $k->getUserName();
                if (!empty($ccuser)) {
                    //var_dump($k);
                    //die();
                    $path_validate = $path . '/upload/' . $k->getUserId() . '_S.png';
                    $file_loc = SITE_URL . 'upload/' . $k->getUserId() . '_S.png';
                    if (file_exists($path_validate)) {
                        $file_loc = $file_loc;
                    } else {
                        $file_loc = SITE_URL . 'upload/un.png';
                    }

                    /* $inter .= '<div class="tl-post"  ><span class="icon"><img src="' . $file_loc . '" /></span>';
                      $inter .= ' <p align="justify" >';
                      $inter .= $k->getUserName() . '  ' . $k->getNewsletContent();
                      $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' cools</span>';
                      if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                      $inter .= '<button class="blue" id="' . $k->getNewsletId() . 'coolBtn" onclick="coolMessage(\'' . $k->getNewsletId() . '\')">cool!</button>';
                      } else {
                      $inter .= '<button class="blue" id="' . $k->getNewsletId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getNewsletId() . '\')">uncool!</button>';
                      }
                      $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->getShareCount() . ' shares </span>';
                      if (strcmp($k->getAlreadyShared(), "y") < 0) {
                      $inter .= '<a href="#" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a>';
                      }
                      $inter .= '<button class="red" onclick="window.location.href=\'commentSection.php?id=' . $k->getNewsletId() . '\'">comment</button></p></div>'; */
                    $inter .= '<div class="tl-post" id="mystream_msg_' . $k->getNewsletId() . '">
			<span class="icon"><img src="' . $file_loc . '" /></span>';

                    $inter .= '<p align="justify" >';

                    if ($k->getUserName()) {
                        $user = '<strong>' . $k->getUserName() . '  : </strong>';
                    } else {
                        $user = '<strong> Guest : </strong>';
                    }
                    $contt = $k->getNewsletContent();
                    //if($contt){
                    $inter .= $user . '' . $k->getNewsletContent() . '';
                    //}
                    $inter .= '<br><br>';
                    //$inter .= $k->getAlreadyCooled().'<br>'.strcmp($k->getAlreadyCooled(), "y");
                    //
			//$inter .= '<div>';
                    if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                        $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;"><a href="javascript:coolMessage(\'' . $k->getNewsletId() . '\');" id="' . $k->getNewsletId() . 'coolBtn" >Star</a></span>';
                    } else {
                        $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;"><a href="javascript:unCoolMessage(\'' . $k->getNewsletId() . '\');" id="' . $k->getNewsletId() . 'coolBtn" >Unstar</a></span>';
                    }
                    $inter .= ' <span style="width: 100px; margin-left: 10px; margin-right: 10px;"> <a href="' . SITE_URL . 'commentSection.php?id=' . $k->getNewsletId() . '" > Remarks  </a></span>';

                    if ($_SESSION['userId'] == $k->userId) {
                        $inter .= ' <span style="width: 100px; margin-left: 10px; margin-right: 10px;"> <a href="javascript:delete_msg(\'' . $k->getNewsletId() . '\',\'' . $k->userId . '\');" > Delete  </a></span>';
                    } else {

                        if (strcmp($k->getAlreadyShared(), "y") < 0) {
                            $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;"><a href="javascript:void(0);" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a></span>';
                        }
                    }
                    $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;" class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' Star </span>';
                    //$msgManager = new MessageManager;
                    //$iidd = str_replace('i', '', $_GET['id']);
                    //$commentsMap = $msgManager->getCommentsMap($iidd , $_SESSION['userId']);
                    $remark = $this->get_remarks_count($k->getNewsletId());
                    $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;" class="cools" id="' . $k->getNewsletId() . 'msgId">' . $remark . ' Remarks </span>';
                    if ($_SESSION['userId'] != $k->userId) {
                        $inter .= '<span style="width: 100px; margin-left: 10px; margin-right: 10px;" class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->shareCount . ' shares  </span>';
                    }
                    //$inter .= '<div>';
                    $inter .= '</p>
			</div>';
                }
            }
        }
        if (strlen($inter) == 0) {
            $inter = "Your Stream looks little...Dry !!";
        }
        return $inter;
    }

    function getNewsletsUIByTrends($userId, $session_id, $trendId) {
        $jsonArray = $this->getNewsLetIdsByTrends($userId, $session_id, '#' . $trendId);
        $inter = "";

        foreach ($jsonArray as $k) {


            $ccuser = $k->getUserName();
            if (!empty($ccuser)) {
                $user = $this->getUserInfo($k->getUserId());

                $path = getcwd();
                $file_loc = SITE_URL . 'upload/' . $k->getUserId() . '_S.png';
                $path_validate = $path . '/upload/' . $k->getUserId() . '_S.png';

                if (file_exists($path_validate)) {
                    $file_loc = $file_loc;
                } else {
                    $file_loc = SITE_URL . 'upload/un.png';
                }

                $inter .= '<div class="tl-post" id="mystream_msg_' . $k->getNewsletId() . '">
			<span class="icon"><img src="' . $file_loc . '" /></span>';

                $inter .= '<p align="justify" >';

                if ($k->getUserName()) {
                    if (empty($user['FIRST_NAME']) && empty($user['FIRST_NAME'])) {
                        $user = '<strong>' . $ccuser . '  : </strong>';
                    } else {
                        $user = '<strong>' . $user['FIRST_NAME'] . ' ' . $user['LAST_NAME'] . '  : </strong>';
                    }
                } else {
                    $user = '<strong> Guest :</strong>';
                }
                $inter .= $user . '' . $k->getNewsletContent() . '';
                $inter .= '<br><br>';

                if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                    $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;"><a href="#" id="' . $k->getNewsletId() . 'coolBtn" onclick="coolMessage(\'' . $k->getNewsletId() . '\')">Star</a></span>';
                } else {
                    $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;"><a href="#" id="' . $k->getNewsletId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getNewsletId() . '\')">Unstar</a></span>';
                }
                $inter .= ' <span style="width: 100px; margin-left: 15px; margin-right: 15px;"> <a href="' . SITE_URL . 'commentSection.php?id=' . $k->getNewsletId() . '" > Remarks  </a></span>';

                if ($_SESSION['userId'] == $k->userId) {
                    $inter .= ' <span style="width: 100px; margin-left: 15px; margin-right: 15px;"> <a href="javascript:delete_msg(\'' . $k->getNewsletId() . '\',\'' . $k->userId . '\');" > Delete  </a></span>';
                } else {

                    if (strcmp($k->getAlreadyShared(), "y") < 0) {
                        $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;"><a href="#" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a></span>';
                    }
                }
                $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' Star </span>';
                $remark = $this->get_remarks_count($k->getNewsletId());
                $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $k->getNewsletId() . 'msgId">' . $remark . ' Remarks </span>';
                if ($_SESSION['userId'] != $k->userId) {
                    $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->shareCount . ' shares  </span>';
                }
                $inter .= '</p>
			</div>';

                /*  $inter .= '<div class="tl-post"><span class="icon"><img src="' .$file_loc . '" /></span>';
                  $inter .= ' <p align="justify">';
                  $inter .= $k->getUserName() . '  ' . $k->getNewsletContent();
                  $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' cools</span>';
                  if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                  $inter .= '<button class="blue" id="' . $k->getNewsletId() . 'coolBtn" onclick="coolMessage(\'' . $k->getNewsletId() . '\')">cool!</button>';
                  } else {
                  $inter .= '<button class="blue" id="' . $k->getNewsletId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getNewsletId() . '\')">uncool!</button>';
                  }
                  $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->getShareCount() . ' shares </span>';
                  if (strcmp($k->getAlreadyShared(), "y") < 0) {
                  $inter .= '<a href="#" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a>';
                  }
                  $inter .= '<button class="red" onclick="window.location.href=\'commentSection.php?id=' . $k->getNewsletId() . '\'">comment</button></p></div>'; */
            }
        }
        return $inter;
    }

    function getNewsletsUIByGroupId($userId, $session_id, $groupId) {
        $jsonArray = $this->getNewsLetIdsByGroup($userId, $session_id, $groupId);
        $inter = "";
        if (sizeof($jsonArray) > 0) {
            foreach ($jsonArray as $k) {
                $file_loc = SITE_URL . 'upload/' . $k->getUserId() . '_S.png';
                if (file_exists($file_loc)) {
                    $file_loc = $file_loc;
                } else {
                    $file_loc = SITE_URL . 'upload/un.png';
                }
                $inter .= '<div class="tl-post"  ><span class="icon"><img src="' . $file_loc . '" /></span>';
                $inter .= ' <p align="justify" >';
                $inter .= $k->getUserName() . '  ' . $k->getNewsletContent();
                $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' cools</span>';
                if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                    $inter .= '<button class="blue" id="' . $k->getNewsletId() . 'coolBtn" onclick="coolMessage(\'' . $k->getNewsletId() . '\')">cool!</button>';
                } else {
                    $inter .= '<button class="blue" id="' . $k->getNewsletId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getNewsletId() . '\')">uncool!</button>';
                }
                $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->getShareCount() . ' shares </span>';
                if (strcmp($k->getAlreadyShared(), "y") < 0) {
                    $inter .= '<a href="#" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a>';
                }
                $inter .= '<button class="red" onclick="window.location.href=\'commentSection.php?id=' . $k->getNewsletId() . '\'">comment</button></p></div>';
            }
        }
        if (strlen($inter) == 0) {
            $inter = "Your Stream looks little....Dry!";
        }
        return $inter;
    }

    static function getNewsLetIdsByBizId($userId, $session_id) {
        $jsonArray = array();
        try {
            $ramConnection = getRAMConnection();
            $coolMsgOfUser = $ramConnection->smembers($userId . '_COOLS');
            $shareMsgOfUser = $ramConnection->smembers($userId . '_RETWEETS');
            $ramConnection->zunionstore($session_id, 2, $userId . '_MSG', $userId . '_MSG');
            $data = $ramConnection->zrevrangebyscore($session_id, 100000000000000000000000, 0);
            //echo '<pre>';
            //var_dump($data);
            //die();
            $msgInfo = $ramConnection->hmget('MSG_INFO', $data);


            //echo $ramConnection->hDel('MSG_INFO','483');
            /* echo '<pre>';
              var_dump($msgInfo);
              echo '</pre>'; */
            //$ramConnection->hDel('MSG_INFO','537');
            //$ramConnection->delete('MSG_INFO',123);
            /* $msgId = '465';
              //hgetall
              echo '<pre>';
              var_dump( $ramConnection->hgetall('MSG_INFO')); */


            //echo $data[$k];
            foreach ($msgInfo as $k => $v) {
                $tni = new TNI();
                $tni->setNewsletId($data[$k]);
                $tni->setNewsletContent($v);
                $coolCount = $ramConnection->hget('COOLCOUNT', $data[$k]);
                if ($coolCount == null) {
                    $coolCount = 0;
                }
                $tni->setCoolCount($coolCount);
                $shareCount = $ramConnection->hget('RETWEETS', $data[$k]);
                if ($shareCount == null) {
                    $shareCount = 0;
                }
                $tni->setShareCount($shareCount);
                $tni->setUserId($ramConnection->hget('MSGID_USERID', $data[$k]));
                $tni->setUserName($ramConnection->hget('USER_ID_NAME', $tni->getUserId()));
                $tni->setAlreadyCooled("n");
                $tni->setAlreadyShared("n");
                if (in_array($data[$k], $coolMsgOfUser)) {
                    $tni->setAlreadyCooled("y");
                }
                if (in_array($data[$k], $shareMsgOfUser)) {
                    $tni->setAlreadyShared("y");
                }



                array_push($jsonArray, $tni);
            }
            $userId = '37';
            $msgId = '486';
            //$ramConnection->hDel();
            echo $ramConnection->delete(array('MSG_INFO', 'USERID_MSGID'));
            echo $ramConnection->hKeys('MSG_INFO');
            $ramConnection->hDel('MSG_INFO', $msgId);
            $ramConnection->hDel('USERID_MSGID', $userId);
            $ramConnection->hDel('MSGID_USERID', $msgId);
        } catch (Exception $e) {
            
        }
        return $jsonArray;
    }

    static function getNewsLetIdsByUserId($userId, $session_id) {
        try {
            $ramConnection = getRAMConnection();
            $follwingUsers = $ramConnection->smembers($userId . '_FOLLOWING');
            $coolMsgOfUser = $ramConnection->smembers($userId . '_COOLS');
            $shareMsgOfUser = $ramConnection->smembers($userId . '_RETWEETS');
            $ramConnection->zunionstore($session_id, 2, $userId . '_MSG', $userId . '_MSG');
            /* echo '<pre>';
              //print_r($follwingUsers);
              var_dump($follwingUsers);
              echo '</pre>'; */
            foreach ($follwingUsers as $eachUser) {
                $ramConnection->zunionstore($session_id, 2, $eachUser . '_MSG', $session_id);
            }
            $data = $ramConnection->zrevrangebyscore($session_id, 100000000000000000000000, 0);
            $msgInfo = $ramConnection->hmget('MSG_INFO', $data);
            $jsonArray = array();
            /* echo '<pre>';
              var_dump($msgInfo);
              echo '</pre>'; */
            foreach ($msgInfo as $k => $v) {
                $tni = new TNI();
                $tni->setNewsletId($data[$k]);
                $tni->setNewsletContent($v);
                //echo  $data[$k].'<br>';

                $coolCount = $ramConnection->hget('COOLCOUNT', $data[$k]);
                if ($coolCount == null) {
                    $coolCount = 0;
                }
                $tni->setCoolCount($coolCount);
                $shareCount = $ramConnection->hget('RETWEETS', $data[$k]);
                if ($shareCount == null) {
                    $shareCount = 0;
                }

                $tni->setShareCount($shareCount);
                $tni->setUserId($ramConnection->hget('MSGID_USERID', $data[$k]));
                $tni->setUserName($ramConnection->hget('USER_ID_NAME', $tni->getUserId()));

                $tni->setAlreadyCooled("n");
                $tni->setAlreadyShared("n");
                if (in_array($data[$k], $coolMsgOfUser)) {
                    $tni->setAlreadyCooled("y");
                }
                if (in_array($data[$k], $shareMsgOfUser)) {
                    $tni->setAlreadyShared("y");
                }

                array_push($jsonArray, $tni);
                /* echo '<pre>';
                  var_dump($jsonArray);
                  echo '</pre>'; */
                //$tni->delete( $data[$k] );
                //die();
            }


            return $jsonArray;
        } catch (Exception $e) {
            
        }
    }

    static function getNewsLetIdsByTrends($userId, $session_id, $trendId) {
        try {
            $ramConnection = getRAMConnection();
            $coolMsgOfUser = $ramConnection->smembers($userId . '_COOLS');
            $shareMsgOfUser = $ramConnection->smembers($userId . '_RETWEETS');
            $ramConnection->zunionstore($session_id, 2, $userId . '_MSG', $userId . '_MSG');
            $messageManager = new MessageManager();
            $data = $messageManager->getTrendNewslet($trendId);
            $msgInfo = $ramConnection->hmget('MSG_INFO', $data);
            $jsonArray = array();
            foreach ($msgInfo as $k => $v) {
                $tni = new TNI();
                $tni->setNewsletId($data[$k]);
                $tni->setNewsletContent($v);
                $coolCount = $ramConnection->hget('COOLCOUNT', $data[$k]);
                if ($coolCount == null) {
                    $coolCount = 0;
                }
                $tni->setCoolCount($coolCount);
                $shareCount = $ramConnection->hget('RETWEETS', $data[$k]);
                if ($shareCount == null) {
                    $shareCount = 0;
                }
                $tni->setShareCount($shareCount);
                $tni->setUserId($ramConnection->hget('MSGID_USERID', $data[$k]));
                $tni->setUserName($ramConnection->hget('USER_ID_NAME', $tni->getUserId()));
                $tni->setAlreadyCooled("n");
                $tni->setAlreadyShared("n");
                if (in_array($data[$k], $coolMsgOfUser)) {
                    $tni->setAlreadyCooled("y");
                }
                if (in_array($data[$k], $shareMsgOfUser)) {
                    $tni->setAlreadyShared("y");
                }

                array_push($jsonArray, $tni);
            }
            return $jsonArray;
        } catch (Exception $e) {
            
        }
    }

    static function getNewsLetIdsByGroup($userId, $session_id, $groupId) {
        try {
            $ramConnection = getRAMConnection();
            $coolMsgOfUser = $ramConnection->smembers($userId . '_COOLS');
            $shareMsgOfUser = $ramConnection->smembers($userId . '_RETWEETS');
            $groupUsers = $ramConnection->smembers($groupId . '_MEMBERS');
            $ramConnection->zunionstore($session_id, 2, $userId . '_MSG', $userId . '_MSG');
            foreach ($groupUsers as $eachUser) {
                $ramConnection->zunionstore($session_id, 2, $eachUser . '_MSG', $session_id);
            }
            $data = $ramConnection->zrevrangebyscore($session_id, 100000000000000000000000, 0);
            $msgInfo = $ramConnection->hmget('MSG_INFO', $data);
            $jsonArray = array();
            foreach ($msgInfo as $k => $v) {
                $tni = new TNI();
                $tni->setNewsletId($data[$k]);
                $tni->setNewsletContent($v);
                $coolCount = $ramConnection->hget('COOLCOUNT', $data[$k]);
                if ($coolCount == null) {
                    $coolCount = 0;
                }
                $tni->setCoolCount($coolCount);
                $shareCount = $ramConnection->hget('RETWEETS', $data[$k]);
                if ($shareCount == null) {
                    $shareCount = 0;
                }
                $tni->setShareCount($shareCount);
                $tni->setUserId($ramConnection->hget('MSGID_USERID', $data[$k]));
                $tni->setUserName($ramConnection->hget('USER_ID_NAME', $tni->getUserId()));
                $tni->setAlreadyCooled("n");
                $tni->setAlreadyShared("n");
                if (in_array($data[$k], $coolMsgOfUser)) {
                    $tni->setAlreadyCooled("y");
                }
                if (in_array($data[$k], $shareMsgOfUser)) {
                    $tni->setAlreadyShared("y");
                }

                array_push($jsonArray, $tni);
            }
            return $jsonArray;
        } catch (Exception $e) {
            
        }
    }

    function getNewsletsUIArchives($userId, $session_id) {
        $msgInfo = array();
        try {
            getDBConnection();
            // $ramConnection = getRAMConnection();
            // $msg = $ramConnection->hget('MSG_INFO', $originalId);
            // $date = date('Y-m-d h:i:s', time());
            // $dateML = date('Ydmhis', strtotime($date));
            $msgSelectQuery = "SELECT * FROM ARCHIVE WHERE user_id=$userId";
            $result = mysql_query($msgSelectQuery);
            // echo "<pre>";
            while ($row = mysql_fetch_array($result)) {
                $msgInfo[$row["news_id"]]["news_id"] = $row["news_id"];
                $msgSelectQuery2 = "SELECT * FROM BROADCAST_MESSAGES WHERE BMID=" . $row["news_id"];
                // echo $msgSelectQuery2 . "<br>";
                $msgInfo[$row["news_id"]]["news_content"] = '';
                $result2 = mysql_query($msgSelectQuery2);
                if (!empty($result2)) {
                    $row2 = mysql_fetch_array($result2);
                    $msgInfo[$row["news_id"]]["news_content"] = $row2["BMESSAGE"];
                    $date = new DateTime($row2["MESSAGE_DATE_TIME"]);
                    $msgInfo[$row["news_id"]]["date"] = $date->format("M d, Y h:i A");
                }
            }
        } catch (Exception $e) {
            // print($e->getMessage());
        }
        $inter = "";
        // print_r($msgInfo);
        //echo count($jsonArray);
        /* echo '<pre>';
          print_r($jsonArray);
          die(); */
        foreach ($msgInfo as $id => $v) {
            $ccuser = $userId;
            //var_dump($ccuser);
            if ($ccuser == $userId) {
                $userinfo = $this->getUserInfo($userId);
                $path = getcwd();
                $file_loc = SITE_URL . 'upload/' . $userId . '_S.png';
                $path_validate = $path . '/upload/' . $userId . '_S.png';
                //echo $file_loc;
                //echo file_exists($file_loc);
                if (file_exists($path_validate)) {
                    $file_loc = $file_loc;
                } else {
                    $file_loc = SITE_URL . 'upload/un.png';
                }
                /* $inter .= '<div class="tl-post" id="mystream_msg_'.$k->getNewsletId().'">
                  <span class="icon"><img src="' . $file_loc . '" /></span>';

                  $inter .= '<p align="justify" ><div class="">';

                  if($k->getUserName()){
                  $user = '<div><strong>'.$k->getUserName() . '  :</strong></div>';
                  }else{
                  $user = '<div><strong> Guest :</strong></div>';
                  }
                  $inter .=  $user . '<div>'.$k->getNewsletContent().'</div>';
                  $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgId">' . $k->getCoolCount() . ' cools </span>';
                  if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                  $inter .= '<a href="#" id="' . $k->getNewsletId() . 'coolBtn" onclick="coolMessage(\'' . $k->getNewsletId() . '\')">cool!</a>';
                  } else {
                  $inter .= '<a href="#" id="' . $k->getNewsletId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getNewsletId() . '\')">uncool!</a>';
                  }
                  $inter .= '<span class="cools" id="' . $k->getNewsletId() . 'msgIdshares">' . $k->getShareCount() . ' shares  </span>';
                  if (strcmp($k->getAlreadyShared(), "y") < 0) {
                  $inter .= '<a href="#" id="' . $k->getNewsletId() . 'shareBtn" onclick="reNewslet(\'' . $k->getNewsletId() . '\')" >share</a>';
                  }
                  if($_SESSION['userId']==$k->userId){
                  $inter .= ' | <a href="javascript:delete_msg(\''.$k->getNewsletId().'\',\''.$k->userId.'\');" > Delete  </a>';
                  }
                  $inter .= ' | <a href="#" onclick="window.location.href=\'commentSection.php?id=' . $k->getNewsletId() . '\'"> comment  </a>

                  </div>
                  </p>
                  </div>'; */
                $inter .= '<div class="tl-post" id="mystream_msg_' . $v["news_id"] . '">
			<span class="icon"><img src="' . $file_loc . '" /></span>';

                $inter .= '<p align="justify" >';

                // if($k->getUserName()){
                if (empty($userinfo['FIRST_NAME']) && empty($userinfo['FIRST_NAME'])) {
                    $user = '<strong> Guest :</strong>';
                } else {
                    $user = '<strong>' . $userinfo['FIRST_NAME'] . ' ' . $userinfo['LAST_NAME'] . '  : </strong>';
                }
                // }else{
                // $user = '<strong> Guest :</strong>';
                // }
                //$k->getNewsletContent();
                //$content = $k->getNewsletContent();
                $content = $v["news_content"];

                if (!empty($content)) {
                    $inter .= $user . '' . $content;
                } else {
                    $inter .= $user . '' . var_dump($content);
                }

                $creationDate = $v["date"];

                if (!empty($creationDate)) {
                    $inter .= '<span class="cDate"> @ ' . date('M j, Y h:i a', strtotime($creationDate)) . '</span>';
                }

                $inter .= '<br><br>';
                //
                //$inter .= '<div>';
                // if (strcmp($k->alreadyCooled, "y") < 0) {
                // $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;"><a href="#" id="' . $v["news_id"] . 'coolBtn" onclick="coolMessage(\'' . $v["news_id"] . '\')">Star</a></span>';
                // } else {
                $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;"><a href="#" id="' . $v["news_id"] . 'coolBtn" onclick="unCoolMessage(\'' . $v["news_id"] . '\')">Unstar</a></span>';
                // }
                $inter .= ' <span style="width: 100px; margin-left: 15px; margin-right: 15px;"> <a id="remark_lnk_' . $v["news_id"] . '" href="javascript:;" data-id="' . $v["news_id"] . '" class="btn_remarks" > Remarks  </a></span>';

                if ($_SESSION['userId'] == $userId) {
                    $inter .= ' <span style="width: 100px; margin-left: 15px; margin-right: 15px;"> <a href="javascript:delete_msg(\'' . $v["news_id"] . '\',\'' . $userId . '\');" > Remove Archive  </a></span>';
                } else {

                    // if (strcmp($k->getAlreadyShared(), "y") < 0) {
                    // $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;"><a href="#" id="' . $v["news_id"] . 'shareBtn" onclick="reNewslet(\'' . $v["news_id"] . '\')" >share</a></span>';
                    // }
                }
                // if($k->getCoolCount() > 0)
                // $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $v["news_id"] . 'msgId">' .$k->getCoolCount() . ' Stars </span>';
                // else
                $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $v["news_id"] . 'msgId"></span>';
                //$msgManager = new MessageManager;
                //$iidd = str_replace('i', '', $_GET['id']);
                //$commentsMap = $msgManager->getCommentsMap($iidd , $_SESSION['userId']);
                $remark = $this->get_remarks_count($v["news_id"]);
                if ($remark > 0)
                    $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $v["news_id"] . 'msgId">' . $remark . ' Remarks </span>';
                else
                    $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $v["news_id"] . 'msgId"></span>';
                //if($_SESSION['userId']!=$k->userId){
                $share = $this->get_shares_count($v["news_id"]);
                if ($share > 0)
                    $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $v["news_id"] . 'msgIdshares">' . $share . ' Shares  </span>';
                else
                    $inter .= '<span style="width: 100px; margin-left: 15px; margin-right: 15px;" class="cools" id="' . $v["news_id"] . 'msgIdshares"></span>';
                //}
                //$inter .= '<div>';
                $inter .= '</p>
			</div>';
            }
        }

        return $inter;
    }

    function deleteArchiveMessage($userId, $msg_id) {
        $msgInfo = array();
        try {
            getDBConnection();
            $msgSelectQuery = "DELETE FROM ARCHIVE WHERE user_id=$userId AND news_id=$msg_id";
            $result = mysql_query($msgSelectQuery);
            echo '1';
            // return '1';
            exit();
        } catch (Exception $e) {
            echo '0';
            exit();
            // print($e->getMessage());
        }
    }

    function isArchived($newsId) {
        $userId = $_SESSION["userId"];
        getDBConnection();
        $result = mysql_query("SELECT * FROM ARCHIVE WHERE user_id=" . $userId . " AND news_id=" . $newsId);

        $userInfo = mysql_num_rows($result);
        return $userInfo;
    }

    function archiveNewslet($newsId) {
        $userId = $_SESSION["userId"];
        getDBConnection();
        $result = mysql_query("SELECT * FROM ARCHIVE WHERE user_id=" . $userId . " AND news_id=" . $newsId);

        $userInfo = mysql_num_rows($result);
        if (!$userInfo) {
            $result = mysql_query("INSERT INTO ARCHIVE (user_id, news_id, date_added) VALUES (" . $userId . ", " . $newsId . ",'" . date("Y-m-d H:i:s") . "')");
            return 1;
        } else {
            return 0;
        }
    }
	
	function get_shares_count($id){
		//echo $id;
		$sharesMap=0;
		$msgManager = new MessageManager;
		$iidd = str_replace('i', '', $id);
		$msgShareGetQuery= "SELECT count(*) FROM BROADCAST_MESSAGES WHERE ORIGINAL_ID=".$iidd;
		$shareResult=mysql_query($msgShareGetQuery);
		$sharesMap= @mysql_fetch_assoc($shareResult);
		return $sharesMap["count(*)"];
	}

}

?>
