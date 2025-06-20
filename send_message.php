<?php
require_once "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);
    
    $sql = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);
        
        if(mysqli_stmt_execute($stmt)){
            echo json_encode(["success" => true, "message" => "Message sent successfully"]);
        } else{
            echo json_encode(["success" => false, "message" => "Failed to send message"]);
        }
        
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>