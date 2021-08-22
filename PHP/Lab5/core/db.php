<?php

class Db {

    protected $db;

    public function __construct() {
        $config = require __DIR__ . '/../config/config.php';
        $this->db = new PDO('pgsql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['name'].'', $config['user'], $config['password']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function protectedQuery($id) {
        $sql="Select * from users where id=:id";
        try{
            $prepared=$this->db->prepare($sql);
            $prepared->bindParam(':id', $id);
            $prepared->execute();
            return $prepared->fetchAll();
        }catch (Exception $e){
            return['error'=>true];
        }
    }

    public function injectedQuery($id) {
        $sql="Select * from users where id=" . $id;
        try{
            $prepared=$this->db->prepare($sql);
            $prepared->execute();
            return $prepared->fetchAll();
        }catch (Exception $e){
            return['error'=>true];
        }
    }
}