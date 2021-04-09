<?php 

use PDO;

class Db {
    protected $db;

    public function __construct() 
    {
		$config = require 'config/db_config.php';
        try {
		$this->db = new PDO('pgsql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['name'].'', $config['user'], $config['password']);
        } catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
	}

    
    /**
     * Выполнение заданного запроса
     *
     * @param  string $sql -- текст SQL запроса
     * @param  array $params -- параметры для переданного SQL запроса 
     */
    public function query($sql, $params = []) 
    {
		$stmt = $this->db->prepare($sql);
		if (!empty($params)) {
			foreach ($params as $key => $val) {
				if (is_int($val)) {
					$type = PDO::PARAM_INT;
				} else {
					$type = PDO::PARAM_STR;
				}
				$stmt->bindValue(':'.$key, $val, $type); 
			}
		}
		$stmt->execute();
		return $stmt;
	}
    
    /**
     * Получение строк после выполнения SQL запроса
     *
     * @param  string $sql -- текст SQL запроса
     * @param  array $params -- параметры для переданного SQL запроса 
     */
    public function row($sql, $params = []) 
    {
		$result = $this->query($sql, $params);
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}
    
    /**
     * Загрузка данных в БД из xml файла
     *
     * @param  string $path -- путь к xml файлу
     */
    public function loadDataFromXml($path) 
    {
        if (file_exists($path)) {
            if(@simplexml_load_file($path)) {
                // Преобразует в SimpleXMLElement
                $xmls = simplexml_load_file($path);
                // Проходим до всем рекордам
                foreach($xmls as $xml){
                    $params = [
                        'id' => (string)$xml->attributes()['id'],
                        'author' => (string)$xml->author,
                        'title' => (string)$xml->title,
                        'genre' => (string)$xml->genre,
                        'price' => (string)$xml->price,
                        'publish_date' => (string)$xml->publish_date,
                        'description' => (string)$xml->description,
                    ];
                    // Формируем запрос
                    $insert_sql = "INSERT INTO 
                                    books (id, author, title, genre, price, publish_date, description) 
                                    VALUES (:id, :author, :title, :genre, :price, :publish_date, :description)";
                    // Записываем в базу
                    try {
                        $this->query($insert_sql, $params);
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
            } else {
                echo "$path: Файл не соответствует стандарту xml".PHP_EOL;
            }
        } else {
            echo "$path: Файл не найден".PHP_EOL;
        }

    }
    
    /**
     * Сохранение данных из БД в json
     *
     * @param  string $path -- путь куда необходимо сохранить json
     */
    public function saveDataToJson($path)
    {
        $books = $this->row("SELECT * FROM books");
        $json = json_encode(['books' => $books]);
        file_put_contents($path, $json);
    }

}