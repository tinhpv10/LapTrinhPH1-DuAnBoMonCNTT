<?php

class Database
{
    private $db_host = "onehost-webhn072403.000nethost.com";
    private $db_name = "lsmuhehthosting_polyonline";
    private $db_user = "lsmuhehthosting_polyonline";
    private $db_pass = "<@NT?[aOj5!N1ju";


    public function connect()
    {
        $dsn = "mysql:host=$this->db_host;dbname=$this->db_name;charset=utf8";
        try {
            $pdo = new PDO($dsn, $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
            return $pdo;
        } catch (Exception $e) {
            echo "Kết nối thất bại" . $e->getMessage();
        }
    }
}
