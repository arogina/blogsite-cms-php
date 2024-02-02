<?php
    enum Position {
        case CURRENT;
        case PREVIOUS;
        case NEXT;
    }

    class PostService {
        private final function __construct() {}

        public static function get_num_rows() {
            Database::connect();
            $data = Database::get_connection()->query(
                "SELECT * FROM post"
            );
            Database::disconnect();

            return $data->num_rows;
        }

        public static function get(int $id, Position $position) {
            Database::connect();
            $operator = "=";
            $orderby = "";
            if ($position == Position::PREVIOUS) {
                $operator = "<";
                $orderby = "order by p.id desc limit 1";
            } else if ($position == Position::NEXT) {
                $operator = ">";
                $orderby = "order by p.id limit 1";
            }

            $sql = "SELECT p.id, p.title, p.content, p.date, u.username as author FROM post p
            LEFT JOIN user u on u.id = p.author
            WHERE p.id $operator ? " . $orderby;

            $stmt = Database::get_connection()->prepare($sql);
            $stmt->bind_param("s", $id);

            if (!$stmt->execute()) {
                trigger_error("Error executing query: " . $stmt->error);
                Database::disconnect();
                throw new ErrorException("Database error occured!");
            }

            $result = $stmt->get_result();
            Database::disconnect();

            $post = null;
            while ($row = $result->fetch_object()) {
                if ($row) {
                    $post = new Post(
                        $row->id, 
                        $row->title, 
                        $row->content, 
                        date_format(new DateTimeImmutable($row->date), "d.m.Y. H:i:s"), 
                        $row->author
                    );
                } 
            }

            if (!isset($post)) throw new ErrorException("Error: Post not found!");
            
            return $post;
        }
        
        public static function get_all(int $page) {
            $posts = array();
            $start_row = ($page - 1) * PAGE_LENGTH;

            Database::connect();
            $data = Database::get_connection()->query(
                "SELECT p.id, p.title, p.content, p.date, u.username as author FROM post p
                LEFT JOIN user u on u.id = p.author
                ORDER BY p.date desc
                LIMIT $start_row, " . PAGE_LENGTH
            );
            Database::disconnect();

            while ($row = $data->fetch_object()) {
                if ($row) {
                    $post = new Post(
                        $row->id, 
                        $row->title, 
                        $row->content, 
                        date_format(new DateTimeImmutable($row->date), "d.m.Y. H:i:s"), 
                        $row->author
                    );
                    array_push($posts, $post);
                } 
            }

            return $posts;
        }
    }