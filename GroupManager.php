<?php

include_once 'config.php';

/**
 * Description of UserManager
 *
 * @author ShivaGanesh
 */
class GroupManager {

    function createAndAddtoGroup($groupName, $bizId, $userId) {
        getDBConnection();
        $msgInsertQuery1 = "INSERT INTO GROUPS (GROUP_NAME,GROUP_OWNER) values ('$groupName','$userId')";
        mysql_query($msgInsertQuery1);
        $groupId = mysql_insert_id();
		return $groupId;
       // return $this->addToGroup($groupName, $groupId, $bizId, $userId);
    }

    function addToGroup($groupName, $groupId, $bizId, $userId) {

        try {
            getDBConnection();
            $msgInsertQuery2 = "INSERT INTO GROUP_MEMBERS (GROUP_ID,BIZ_ID) values ('$groupId','$bizId')";
            print($msgInsertQuery2);
            mysql_query($msgInsertQuery2);
            $ramConnection = getRAMConnection();
            $ramConnection->sadd($groupId . '_MEMBERS', $bizId);
            $ramConnection->sadd($userId . '_GROUPS', $groupId);
            $ramConnection->hset('GROUP_INFO', $groupId, $groupName);
            print 'SUCCESS';
            return 'true';
        } catch (Exception $e) {
            return $e;
        }
    }

    function getAllGroupsOfUser($userId) {
        getDBConnection();
        $query = "SELECT DISTINCT GROUP_ID,GROUP_NAME FROM GROUPS WHERE GROUP_OWNER='$userId'";
        $result = mysql_query($query);
        $options = "<option value='0'>SELECT</option>";
        while ($row = mysql_fetch_array($result)) {
            $options = $options . '<option value="' . $row[0] . '">' . $row[1] . '</option>';
        }
        return $options;
    }

}

?>
