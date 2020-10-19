<?php
    // database connection

    class Dbh
    {
        private $servername;
        private $username;
        private $password;
        private $dbname;

        private $conn;

        public function __construct()
        {
            $this->servername = "localhost";
            $this->username = "root";
            $this->password = "";
            $this->dbname = "rahacharity";

            $this->conn = new mysqli($this->servername, $this->username,$this->password,$this->dbname);

            date_default_timezone_set('Asia/Kabul');
            $this->conn->set_charset('utf8');
            // $this->conn->autocommit(FALSE);
        }

        public function fetchResult($sql)
        {
            $result = $this->conn->query($sql);
            if(!is_null($result)){
               return $result;
            } else {
                return false;
            }
        }

        protected function execute($sql) {
            return $this->conn->query($sql);
        }

        public function get_conn() {
            return $this->conn;
        }
    }

?>