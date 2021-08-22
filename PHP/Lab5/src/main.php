<?php
require_once(__DIR__ . '/../core/db.php');

$db = new Db();

if (isset($_POST['protected_user_id'])) {
    $id = $_POST['protected_user_id'];
    echo json_encode($db->protectedQuery($id));
} elseif (isset($_POST['injected_user_id'])) {
    $id = $_POST['injected_user_id'];
    echo json_encode($db->injectedQuery($id));
}