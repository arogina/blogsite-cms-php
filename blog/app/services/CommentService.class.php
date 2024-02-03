<?php
    class CommentService {
        private function __construct() {}

        public static function get_num_rows() {
            Database::connect();
            $data = Database::get_connection()->query(
                "SELECT * FROM comment"
            );
            Database::disconnect();

            return $data->num_rows;
        }

        public static function get_all(int $post_id, int $page) {
            $comments = array();
            $start_row = ($page - 1) * COMMENTS_PAGE_LENGTH;

            Database::connect();
            $stmt = Database::get_connection()->prepare(
                "SELECT c.id, c.post_id, u.username, c.text, c.date FROM comment c
                LEFT JOIN user u ON u.id = c.user_id
                WHERE c.post_id = ? AND ISNULL(c.parent_id) = 1
                LIMIT $start_row, " . COMMENTS_PAGE_LENGTH
            );

            $stmt->bind_param("s", $post_id);
            if (!$stmt->execute()) {
                trigger_error("Error executing query: " . $stmt->error);
                Database::disconnect();
                throw new ErrorException("Database error occured!");
            }

            $data = $stmt->get_result();
            Database::disconnect();

            while ($row = $data->fetch_object()) {
                if ($row) {
                    $comment = new Comment(
                        $row->id, 
                        $row->post_id, 
                        $row->username, 
                        $row->text, 
                        date_format(new DateTimeImmutable($row->date), "d.m.Y. H:i:s")
                    );
                    array_push($comments, $comment);
                } 
            }

            return $comments;
        }

        public static function get_replies(int $post_id, int $comment_id) {
            $replies = array();

            Database::connect();
            $stmt = Database::get_connection()->prepare(
                "SELECT c.id, c.post_id, u.username, c.text, c.date FROM comment c
                LEFT JOIN user u ON u.id = c.user_id
                WHERE c.post_id = ? AND c.parent_id = ?"
            );

            $stmt->bind_param("ss", $post_id, $comment_id);
            if (!$stmt->execute()) {
                trigger_error("Error executing query: " . $stmt->error);
                Database::disconnect();
                throw new ErrorException("Database error occured!");
            }

            $data = $stmt->get_result();
            Database::disconnect();

            while ($row = $data->fetch_object()) {
                if ($row) {
                    $reply = new Comment(
                        $row->id, 
                        $row->post_id, 
                        $row->username, 
                        $row->text, 
                        date_format(new DateTimeImmutable($row->date), "d.m.Y. H:i:s")
                    );
                    array_push($replies, $reply);
                } 
            }

            return $replies;
        }

        public static function create_comment(int $user_id, int $post_id, string $text) {
            Database::connect();
            $stmt = Database::get_connection()->prepare("INSERT INTO comment (post_id, user_id, text) VALUES (?,?,?)");
            $stmt->bind_param("iis", $post_id, $user_id, $text);

            if (!$stmt->execute()) {
                trigger_error("Error executing query: " . $stmt->error);
                Database::disconnect();
                return false;
            }

            Database::disconnect();
            return true;
        }
    }