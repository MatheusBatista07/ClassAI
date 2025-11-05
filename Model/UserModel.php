<?php

class UserModel {
    private $db; 

    public function __construct() {
        require_once '../Config/Configuration.php';
        $this->db = (new Configuration())->getDb();
    }


    /**
     * @param int $userId
     * @param int $courseId
     */
    public function addFavoriteCourse($userId, $courseId) {
        $stmt = $this->db->prepare("INSERT IGNORE INTO user_favorites (user_id, course_id) VALUES (?, ?)");
        $stmt->execute([$userId, $courseId]);
    }

    /**
     * @param int $userId
     * @param int $courseId
     */
    public function removeFavoriteCourse($userId, $courseId) {
        $stmt = $this->db->prepare("DELETE FROM user_favorites WHERE user_id = ? AND course_id = ?");
        $stmt->execute([$userId, $courseId]);
    }
}
