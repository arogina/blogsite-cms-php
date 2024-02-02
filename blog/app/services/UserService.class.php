<?php
    class UserService {
        private function __construct() {}

        public static function create(string $username, string $email, string $password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            Database::connect();
            $stmt = Database::get_connection()->prepare("INSERT INTO user (username, email, password) VALUES (?,?,?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if (!$stmt->execute()) {
                trigger_error("Error executing query: " . $stmt->error);
                Database::disconnect();
                return false;
            }

            Database::disconnect();
            return true;
        }

        public static function login(string $email, string $password) {
            Database::connect();
            $stmt = Database::get_connection()->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);

            if (!$stmt->execute()) {
                trigger_error("Error executing query: " . $stmt->error);
                Database::disconnect();
                throw new ErrorException("Database error occured!");
            }

            $result = $stmt->get_result();
            Database::disconnect();

            $user = null;
            while ($row = $result->fetch_object()) {
                if ($row) {
                    $user = new User($row->id, $row->username, $row->email, $row->password);
                } 
            }

            if (!isset($user)) throw new ErrorException("Invalid e-mail!");;
            if (password_verify($password, $user->get_password())) {
                return $user;
            }

            throw new ErrorException("Wrong password!");
        }
    }