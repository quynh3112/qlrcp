<?php
    include "../config/db.php";
    class Reviews {
        public function create($rating, $comment, $reviewdate) {
            global $conn;

            $sql = "INSERT INTO reviews (rating, comment)
                    VALUES ('$rating', '$comment')";
            
            return $conn->query($sql);
        }

        public function delete($id) {
            global $conn;

            $sql = "DELETE FROM reviews WHERE review_id = '$id'";
            
            return $conn->query($sql);
        }

        public function update($rating, $comment) {
            global $conn;

            $sql = "UPDATE reviews SET rating = '$rating', comment = '$comment' WHERE review_id = '$id'";
            
            return $conn->query($sql);
        }

        public function getall() {
            global $conn;

            $sql = "SELECT * FROM Reviews";

            return $conn->query($sql);
        }
    }
?>