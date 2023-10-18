<?php
    require_once "./app/helpers/db.helper.php";

class PeliculasModel {
    private $db;
    private $table;

    public function __construct() {
        $this->db = DbHelper::connect_db();
        $this->table = "peliculas";
    }

    public function getById($id) {
        $query = $this->db->prepare('SELECT * FROM '.$this->table.' WHERE id = ?');
        $query->execute([$id]);
        $data = $query->fetch(PDO::FETCH_OBJ);

        return $data;
    }
    public function getAll() {
        $query = $this->db->prepare('SELECT * FROM '.$this->table);
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    function getAllByDirector($id) {
        $query = $this->db->prepare('SELECT * FROM '.$this->table.' WHERE director = ?');
        $query->execute([$id]);
        $data = $query->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
    public function insert($data){
        $query = $this->db->prepare('INSERT INTO '.$this->table.' (titulo, genero, year, director) values (?,?,?,?)');
        return $query->execute([$data["titulo"], $data["genero"], $data["year"], $data["director"]]);
    }
    public function putById($id, $data) {
        $query = $this->db->prepare('UPDATE '.$this->table.' SET titulo = ?, genero = ?, year = ?, director = ? WHERE id = ?');
        return $query->execute([$data["titulo"], $data["genero"], $data["year"], $data["director"], $id]);
    }
    public function deleteById($id){
        $query = $this->db->prepare('DELETE FROM '.$this->table.' WHERE id = ?');
        return $query->execute([$id]);
    }
    public function deleteAllByDirectorId($id){
        $query = $this->db->prepare('DELETE FROM '.$this->table.' WHERE director = ?');
        return $query->execute([$id]);
    }
}