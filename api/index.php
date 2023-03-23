<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'Dbconnect.php';
$objDb = new Dbconnect;
$conn = $objDb->connect();

$method = $_SERVER['REQUEST_METHOD'];
switch($method) {
    case "GET";
        $sql = "SELECT * FROM users";
       $path = explode('/', $_SERVER['REQUEST_URI']);
        if(isset($path[3]) && is_numeric($path[3])) {
            $sql = "WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $path[3]);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
       
        echo json_encode($users);
        break;

    case "POST";
    $user = json_decode( file_get_contents('php://input') );
    $sql = "INSERT INTO users(id, name, email, mobile, create_at) VALUES(null, :name, :email, :mobile, :create_at)";
    $stmt = $conn->prepare($sql);
    $create_at = date('Y-m-d');
    $stmt->bindParam(':name', $user->name);
    $stmt->bindParam(':email', $user->email);
    $stmt->bindParam(':mobile', $user->mobile);
    $stmt->bindParam(':create_at', $create_at);

    if($stmt->execute()) {
        $response = ['status' => 1, 'message' => 'record created suucessfully.'];
    } else {
        $response = ['status' => 0, 'message' => 'Failes to create record...'];

    }
    echo json_encode($response);
    break;


case "PUT";
    $user = json_decode( file_get_contents('php://input') );
    $sql = "UPDATE users SET name= :name, email= :email, mobile= :mobile, updated_at= :updated_at WHERE id= :id";
    $stmt = $conn->prepare($sql);
    $updated_at = date('Y-m-d');
    $stmt->bindParam(':id', $user->id);
    $stmt->bindParam(':name', $user->name);
    $stmt->bindParam(':email', $user->email);
    $stmt->bindParam(':mobile', $user->mobile);
    $stmt->bindParam(':updated_at', $updated_at);

    if($stmt->execute()) {
        $response = ['status' => 1, 'message' => 'record updated suucessfully.'];
    } else {
        $response = ['status' => 0, 'message' => 'Failes to update record...'];

    }
    echo json_encode($response);
    break;

    case "DELETE";
    $sql = "DELETE  FROM users WHERE id = :id";
    $path = explode('/', $_SERVER['REQUEST_URI']);

         $stmt = $conn->prepare($sql);
         $stmt->bindParam(':id', $path[3]);

    if($stmt->execute()) {
        $response = ['status' => 1, 'message' => 'record deleted suucessfully.'];
    } else {
        $response = ['status' => 0, 'message' => 'Failes to delte record...'];

    }
    echo json_encode($response);
    break;


}