<?php 

require 'Db.php';

$db = new Db();

$db->loadDataFromXml('xml/books.xml');
$db->saveDataToJson('books.json');