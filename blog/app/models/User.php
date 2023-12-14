<?php
    class User {
        private int $id;
        private string $username;
        private string $email;
        private string $password;

        function __construct(int $id, string $username, string $email, string $password) {
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
        }
    }