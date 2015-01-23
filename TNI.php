<?php

class TNI {

    var $newsletId;
    var $newsletContent;
    var $newsletCreationDate;
    var $coolCount;
    var $shareCount;
    var $userId;
    var $userName;
    var $alreadyCooled;
    var $alreadyShared;
	var $delete;

    public function getAlreadyCooled() {
        return $this->alreadyCooled;
    }

    public function setAlreadyCooled($alreadyCooled) {
        $this->alreadyCooled = $alreadyCooled;
    }

        public function getAlreadyShared() {
        return $this->alreadyShared;
    }

    public function setAlreadyShared($alreadyShared) {
        $this->alreadyShared = $alreadyShared;
    }

    public function getNewsletId() {
        return $this->newsletId;
    }

    public function setNewsletId($newsletId) {
        $this->newsletId = $newsletId;
    }
    
    public function getNewsletCreationDate() {
        return $this->newsletCreationDate;
    }

    public function setNewsletCreationDate($newsletCreationDate) {
        $this->newsletCreationDate = $newsletCreationDate;
    }

    public function getNewsletContent() {
        return $this->newsletContent;
    }

    public function setNewsletContent($newsletContent) {
        $this->newsletContent = $newsletContent;
    }

    public function getCoolCount() {
        return $this->coolCount;
    }

    public function setCoolCount($coolCount) {
        $this->coolCount = $coolCount;
    }

    public function getShareCount() {
        return $this->shareCount;
    }

    public function setShareCount($shareCount) {
        $this->shareCount = $shareCount;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

// adding-----------
 public function delete($userName) {
        $this->delete = $userName;
    }
}

?>
