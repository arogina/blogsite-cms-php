<?php
    class Comment {
        private int $id;
        private int $post_id;
        private string $user;
        private string $text;
        private string $date;

        public function __construct(int $id, int $post_id, string $user, string $text, string $date) {
            $this->id = $id;
            $this->post_id = $post_id;
            $this->user = $user;
            $this->text = $text;
            $this->date = $date;
        }

        public function get_id() {
            return $this->id();
        }

        public function get_post() {
            return $this->post_id;
        }

        public function get_user() {
            return $this->user;
        }

        public function get_text() {
            return $this->text;
        }

        public function get_date() {
            return $this->date;
        }
    }