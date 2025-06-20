<?php
session_start();
require_once "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $user_id = $_SESSION["id"];
    $car_name = trim($_POST["carName"]);
    $color = trim($_POST["color"]);
    $payment_method = trim($_POST["paymentMethod"]);
    $amount = trim($_POST["amount"]);
    
    $sql = "INSERT INTO payments (user_id, car_name, color, payment_method, amount) VALUES (?, ?, ?, ?, ?)";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "isssd", $user_id, $car_name, $color, $payment_method, $amount);
        
        if(mysqli_stmt_execute($stmt)){
            echo json_encode(["success" => true, "message" => "Payment processed successfully"]);
        } else{
            echo json_encode(["success" => false, "message" => "Failed to process payment"]);
        }
        
        mysqli_stmt_close($stmt);
    }
} else {
    echo json_encode(["success" => false, "message" => "User not logged in or invalid request"]);
}

mysqli_close($conn);
?>