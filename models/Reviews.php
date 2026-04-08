<?php
    include "../config/db.php";
    class Reviews {
        public function create($movieid, $userid, $rating, $comment, $reviewdate) {
            global $conn;

            $sql = "INSERT INTO reviews (movie_id, user_id, rating, comment, review_date)
                    VALUES ('$movieid', '$userid', '$rating', '$comment', '$reviewdate')";
            
            return $conn->query($sql);
        }

        public function delete($id) {
            global $conn;

            $sql = "DELETE FROM reviews WHERE review_id = '$id'";
            
            return $conn->query($sql);
        }

        public function update($id, $rating, $comment) {
            global $conn;

            $sql = "UPDATE reviews SET rating = '$rating', comment = '$comment' 
                    WHERE review_id = '$id'";
            
            return $conn->query($sql);
        }

        public function getall($id) {
            global $conn;

            $sql = "SELECT * FROM Reviews WHERE movie_id = '$id'";

            return $conn->query($sql);
        }
    }
?>