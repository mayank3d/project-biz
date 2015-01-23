<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BusinessPOJO
 *
 * @author shiva
 */
class BusinessPOJO {

    //put your code here
    var $businessId;
    var $businessName;
    var $fullName;
    var $followerCount;
    var $newsletCount;

    public function getBusinessId() {
        return $this->businessId;
    }

    public function setBusinessId($businessId) {
        $this->businessId = $businessId;
    }

    public function getBusinessName() {
        return $this->businessName;
    }

    public function setBusinessName($businessName) {
        $this->businessName = $businessName;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    public function getFollowerCount() {
        return $this->followerCount;
    }

    public function setFollowerCount($followerCount) {
        $this->followerCount = $followerCount;
    }

    public function getNewsletCount() {
        return $this->newsletCount;
    }

    public function setNewsletCount($newsletCount) {
        $this->newsletCount = $newsletCount;
    }

}

?>
