<?php
    class PostService {
        private final function __construct() {}
        
        public static function get_all(int $page) {
            $posts = array();

            Database::connect();
            $data = Database::get_connection()->query(
                "SELECT p.id, p.title, p.content, p.date, u.username as author FROM post p
                LEFT JOIN user u on u.id = p.author"
            );
            Database::disconnect();

            while ($row = $data->fetch_object()) {
                if ($row) {
                    $post = new Post($row->id, $row->title, $row->content, $row->date, $row->author);
                    array_push($posts, $post);
                } 
            }

            return $posts;
        }

    }