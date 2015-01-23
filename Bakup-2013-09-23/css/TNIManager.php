<?php

/**
 * Description of TNLManager
 *
 * @author shiva
 */
include_once 'TNI.php';
include_once 'MessageManager.php';

class TNIManager {

    function getNewsletsUI($userId, $session_id) {
        $jsonArray = $this->getNewsLetIdsByUserId($userId, $session_id);
        $inter = "";
        foreach ($jsonArray as $k) {
			$file_loc = SITE_URL.'upload/' . $k->getUserId() . '_S.png';
			if (file_exists($file_loc)) {
				$file_loc = $file_loc;
			}else{
				$file_loc = SITE_URL.'upload/un.png';
			}
            $inter .= '<div class="tl-post"  ><span class="icon"><img src="' . $file_loc . '" /></span>';
            $inter .= ' <p align="justify" >';
            $inter .= $k->getUserName() . ' says ' . $k->getTweetContent();
            $inter .= '<span class="cools" id="' . $k->getTweetId() . 'msgId">' . $k->getCoolCount() . ' cools </span>';
            if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                $inter .= '<a href="#" id="' . $k->getTweetId() . 'coolBtn" onclick="coolMessage(\'' . $k->getTweetId() . '\')">cool!</a>';
            } else {
                $inter .= '<a href="#" id="' . $k->getTweetId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getTweetId() . '\')">uncool!</a>';
            }
            $inter .= '<span class="cools" id="' . $k->getTweetId() . 'msgIdshares">' . $k->getShareCount() . ' shares  </span>';
            if (strcmp($k->getAlreadyShared(), "y") < 0) {
                $inter .= '<a href="#" id="' . $k->getTweetId() . 'shareBtn" onclick="reTweet(\'' . $k->getTweetId() . '\')" >share</a>';
            }
			$inter .= '<a href="#" onclick="window.location.href=\'delete.php?id=' . $k->getTweetId() .'&userId=' .$userId. '\'"> | Delete  </a>';
            $inter .= '<a href="#" onclick="window.location.href=\'commentSection.php?id=' . $k->getTweetId() . '\'"> | comment  </a></p></div>';
       }
    
        return $inter;
    }

    function getNewsletsUIByBizId($userId, $session_id) {
        $jsonArray = $this->getNewsLetIdsByBizId($userId, $session_id);
        $inter = "";
        if (sizeof($jsonArray) > 0) {
            foreach ($jsonArray as $k) {
				$file_loc = SITE_URL.'upload/' . $k->getUserId() . '_S.png';
				if (file_exists($file_loc)) {
					$file_loc = $file_loc;
				}else{
					$file_loc = SITE_URL.'upload/un.png';
				}
                $inter .= '<div class="tl-post"  ><span class="icon"><img src="' . $file_loc . '" /></span>';
                $inter .= ' <p align="justify" >';
                $inter .= $k->getUserName() . ' says ' . $k->getTweetContent();
                $inter .= '<span class="cools" id="' . $k->getTweetId() . 'msgId">' . $k->getCoolCount() . ' cools</span>';
                if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                    $inter .= '<button class="blue" id="' . $k->getTweetId() . 'coolBtn" onclick="coolMessage(\'' . $k->getTweetId() . '\')">cool!</button>';
                } else {
                    $inter .= '<button class="blue" id="' . $k->getTweetId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getTweetId() . '\')">uncool!</button>';
                }
                $inter .= '<span class="cools" id="' . $k->getTweetId() . 'msgIdshares">' . $k->getShareCount() . ' shares </span>';
                if (strcmp($k->getAlreadyShared(), "y") < 0) {
                    $inter .= '<a href="#" id="' . $k->getTweetId() . 'shareBtn" onclick="reTweet(\'' . $k->getTweetId() . '\')" >share</a>';
                }
                $inter .= '<button class="red" onclick="window.location.href=\'commentSection.php?id=' . $k->getTweetId() . '\'">comment</button></p></div>';
            }
        }
        if (strlen($inter) == 0) {
            $inter = "NO TWEETS YET !!!";
        }
        return $inter;
    }

    function getNewsletsUIByTrends($userId, $session_id, $trendId) {
        $jsonArray = $this->getNewsLetIdsByTrends($userId, $session_id, '#' . $trendId);
        $inter = "";
        foreach ($jsonArray as $k) {
			$file_loc = SITE_URL.'upload/' . $k->getUserId() . '_S.png';
				if (file_exists($file_loc)) {
					$file_loc = $file_loc;
				}else{
					$file_loc = SITE_URL.'upload/un.png';
				}
            $inter .= '<div class="tl-post"><span class="icon"><img src="' .$file_loc . '" /></span>';
            $inter .= ' <p align="justify">';
            $inter .= $k->getUserName() . ' says ' . $k->getTweetContent();
            $inter .= '<span class="cools" id="' . $k->getTweetId() . 'msgId">' . $k->getCoolCount() . ' cools</span>';
            if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                $inter .= '<button class="blue" id="' . $k->getTweetId() . 'coolBtn" onclick="coolMessage(\'' . $k->getTweetId() . '\')">cool!</button>';
            } else {
                $inter .= '<button class="blue" id="' . $k->getTweetId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getTweetId() . '\')">uncool!</button>';
            }
            $inter .= '<span class="cools" id="' . $k->getTweetId() . 'msgIdshares">' . $k->getShareCount() . ' shares </span>';
            if (strcmp($k->getAlreadyShared(), "y") < 0) {
                $inter .= '<a href="#" id="' . $k->getTweetId() . 'shareBtn" onclick="reTweet(\'' . $k->getTweetId() . '\')" >share</a>';
            }
            $inter .= '<button class="red" onclick="window.location.href=\'commentSection.php?id=' . $k->getTweetId() . '\'">comment</button></p></div>';
        }
        return $inter;
    }

    function getNewsletsUIByGroupId($userId, $session_id, $groupId) {
        $jsonArray = $this->getNewsLetIdsByGroup($userId, $session_id, $groupId);
        $inter = "";
        if (sizeof($jsonArray) > 0) {
            foreach ($jsonArray as $k) {
				$file_loc = SITE_URL.'upload/' . $k->getUserId() . '_S.png';
				if (file_exists($file_loc)) {
					$file_loc = $file_loc;
				}else{
					$file_loc = SITE_URL.'upload/un.png';
				}
                $inter .= '<div class="tl-post"  ><span class="icon"><img src="' .$file_loc . '" /></span>';
                $inter .= ' <p align="justify" >';
                $inter .= $k->getUserName() . ' says ' . $k->getTweetContent();
                $inter .= '<span class="cools" id="' . $k->getTweetId() . 'msgId">' . $k->getCoolCount() . ' cools</span>';
                if (strcmp($k->getAlreadyCooled(), "y") < 0) {
                    $inter .= '<button class="blue" id="' . $k->getTweetId() . 'coolBtn" onclick="coolMessage(\'' . $k->getTweetId() . '\')">cool!</button>';
                } else {
                    $inter .= '<button class="blue" id="' . $k->getTweetId() . 'coolBtn" onclick="unCoolMessage(\'' . $k->getTweetId() . '\')">uncool!</button>';
                }
                $inter .= '<span class="cools" id="' . $k->getTweetId() . 'msgIdshares">' . $k->getShareCount() . ' shares </span>';
                if (strcmp($k->getAlreadyShared(), "y") < 0) {
                    $inter .= '<a href="#" id="' . $k->getTweetId() . 'shareBtn" onclick="reTweet(\'' . $k->getTweetId() . '\')" >share</a>';
                }
                $inter .= '<button class="red" onclick="window.location.href=\'commentSection.php?id=' . $k->getTweetId() . '\'">comment</button></p></div>';
            }
        }
        if (strlen($inter) == 0) {
            $inter = "NO TWEETS YET !!!";
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
            $msgInfo = $ramConnection->hmget('MSG_INFO', $data);
            foreach ($msgInfo as $k => $v) {
                $tni = new TNI();
                $tni->setTweetId($data[$k]);
                $tni->setTweetContent($v);
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
			/*echo '<pre>';
			//print_r($follwingUsers);
			var_dump($follwingUsers);
			echo '</pre>';*/
            foreach ($follwingUsers as $eachUser) {
                $ramConnection->zunionstore($session_id, 2, $eachUser . '_MSG', $session_id);
            }
            $data = $ramConnection->zrevrangebyscore($session_id, 100000000000000000000000, 0);
            $msgInfo = $ramConnection->hmget('MSG_INFO', $data);
            $jsonArray = array();
			echo '<pre>';
			var_dump($msgInfo);
			echo '</pre>';
            foreach ($msgInfo as $k => $v) {
                $tni = new TNI();
                $tni->setTweetId($data[$k]);
                $tni->setTweetContent($v);
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
			/*echo '<pre>';
			var_dump($jsonArray);
			echo '</pre>';*/
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
                $tni->setTweetId($data[$k]);
                $tni->setTweetContent($v);
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
                $tni->setTweetId($data[$k]);
                $tni->setTweetContent($v);
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

}

?>
