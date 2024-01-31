<?php
    class Post {
        private int $id;
        private string $title;
        private string $content;
        private string $date;
        private string $author;

        function __construct(int $id, string $title, string $content, string $date, string $author) {
            $this->id = $id;
            $this->title = $title;
            $this->content = $content;
            $this->date = $date;
            $this->author = $author;
        }

        public function get_id() {
            return $this->id;
        }
        
        public function get_title() {
            return $this->title;
        }
        
        public function get_content() {
            return $this->content;
        }

        public function get_date() {
            return $this->date;
        }

        public function get_author() {
            return $this->author;
        }
    }