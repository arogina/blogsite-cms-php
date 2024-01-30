<?php
    class Database {
        private static $db;

        private function __constructor() {}

        public static function connect() {
            $env = $GLOBALS["env"];
            self::$db = new msqli($env["DB_HOST"], $env["DB_USER"], $env["DB_PWD"], $env["DB_NAME"]);
            if (self::$db->connect_errno) {
                die("Connection to DB failed: " . self::$db->connect_errno);
            }

            self::$db->set_charset("utf8");
            if (self::$db->connect_errno) {
                die("Connection to DB failed: " . self::$db->connect_errno);
            }
        }

        public static function get_connection() {
            return self::$db;
        }

        public static function disconnect() {
            self::$db->close();
        }
    }