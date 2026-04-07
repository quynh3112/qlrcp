<?php
class Movie {
    private $conn;
    public function __construct($db){
        $this->conn = $db;
    }
    public function getAll(){
        $sql = "SELECT * FROM movies";
        return $this->conn->query($sql);
    }
    public function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM movies WHERE movie_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function create($data){
        $stmt = $this->conn->prepare("
            INSERT INTO movies(title, genre, duration, release_date, director, language, rating, description, poster_url, trailer_url)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ssisssdsss",
            $data['title'],
            $data['genre'],
            $data['duration'],
            $data['release_date'],
            $data['director'],
            $data['language'],
            $data['rating'],
            $data['description'],
            $data['poster_url'],
            $data['trailer_url']
        );
        return $stmt->execute();
    }
    public function update($data){
        $stmt = $this->conn->prepare("
            UPDATE movies SET
            title=?, genre=?, duration=?, release_date=?, director=?, language=?, rating=?, description=?, poster_url=?, trailer_url=?
            WHERE movie_id=?
        ");
        $stmt->bind_param(
            "ssisssdsssi",
            $data['title'],
            $data['genre'],
            $data['duration'],
            $data['release_date'],
            $data['director'],
            $data['language'],
            $data['rating'],
            $data['description'],
            $data['poster_url'],
            $data['trailer_url'],
            $data['movie_id']
        );

        return $stmt->execute();
    }
    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM movies WHERE movie_id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>