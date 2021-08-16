<?php

class Db {

    protected $db;

    public function __construct() {
        $config = require __DIR__ . '/../config/config.php';
        $this->db = new PDO('pgsql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['name'].'', $config['user'], $config['password']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * query -- Выполняет произвольный запрос к базе данных
     *
     * @param  string $sql Текст SQL запроса
     * @param  array $params Параметры передаваемые в SQL запрос
     * @return stmt
     */
    public function query(string $sql, array $params = []) {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $type = PDO::PARAM_STR;
                $stmt->bindValue(':'.$key, $val, $type);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    /**
     * row -- Возвращает строки, соответствующие SQL запросу
     *
     * @param  string $sql Текст SQL запроса
     * @param  array $params Параметры передаваемые в SQL запрос
     * @return array
     */
    public function row(string $sql, array $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}