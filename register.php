<?php
require_once "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    
    if($password === $confirm_password){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
            
            if(mysqli_stmt_execute($stmt)){
                echo json_encode(["success" => true, "message" => "Registration successful"]);
            } else{
                echo json_encode(["success" => false, "message" => "Registration failed"]);
            }
            
            mysqli_stmt_close($stmt);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Passwords do not match"]);
    }
}

mysqli_close($conn);
?>