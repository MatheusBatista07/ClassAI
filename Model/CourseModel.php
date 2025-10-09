<?php
// Model/CourseModel.php

class CourseModel {
    private $db;

    public function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $this->db = new PDO($dsn, DB_USER, DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllCourses() {
        $stmt = $this->db->query("SELECT nome_curso, instrutor, instrutor_foto_url, curso_foto_url, status FROM cursos_avaliados");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>