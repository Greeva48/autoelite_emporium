<?php
session_start();
require_once "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $username);
        
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        echo json_encode(["success" => true, "message" => "Login successful"]);
                    } else{
                        echo json_encode(["success" => false, "message" => "Invalid password"]);
                    }
                }
            } else{
                echo json_encode(["success" => false, "message" => "Invalid username"]);
            }
        } else{
            echo json_encode(["success" => false, "message" => "Oops! Something went wrong. Please try again later."]);
        }
        
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>