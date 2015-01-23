<?php

class Comment {

    var $commentId;
    var $comment;
    var $commentDate;
    var $selfComment;
    var $username;
    var $userId;

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getCommentId() {
        return $this->commentId;
    }

    public function setCommentId($commentId) {
        $this->commentId = $commentId;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function getCommentDate() {
        return $this->commentDate;
    }

    public function setCommentDate($commentDate) {
        $this->commentDate = $commentDate;
    }

    public function getSelfComment() {
        return $this->selfComment;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setSelfComment($selfComment) {
        $this->selfComment = $selfComment;
    }

}

?>
