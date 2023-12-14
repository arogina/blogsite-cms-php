<?php
    class Post {
        private int $id;
        private string $title;
        private string $content;
        private string $author;

        function __construct(int $id, string $title, string $content, string $author) {
            $this->id = $id;
            $this->title = $title;
            $this->content = $content;
            $this->author = $author;
        }

        public function getId() {
            return $this->id;
        }
        
        public function getTitle() {
            return $this->title;
        }
        
        public function getContent() {
            return $this->content;
        }

        public function getAuthor() {
            return $this->author;
        }
    }