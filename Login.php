<?php
// Initialize the session
session_start();
$DB_SERVER_ERR = "";
$DB_USERNAME_ERR = "";
$DB_NAME_ERR ="";
$DB_PASSWORD_ERR ="";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["db_server"]))){
        $DB_SERVER_ERR = "Please enter server addres or name(ex.: localhost).";
    } else{
        $DB_SERVER = trim($_POST["db_server"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["db_username"]))){
        $DB_USERNAME_ERR = "Please enter your database account username(ex.: admin).";
    } else{
        $DB_USERNAME = trim($_POST["db_username"]);
    }
    if(empty(trim($_POST["db_name"]))){
        $DB_NAME_ERR = "Please enter your database name(ex.: dbo).";
    } else{
        $DB_NAME = trim($_POST["db_name"]);
    }
    if(empty(trim($_POST["db_password"]))){
        $DB_PASSWORD = "";
    } else{
        $DB_PASSWORD = trim($_POST["db_password"]);
    }

    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $conn_err ="";
    // Check connection
    if($link === false){
        $conn_err("ERROR: Could not connect. " . mysqli_connect_error());
        header("location: Index.php");
    }else{
        
        header("location: Index.php");
    }
    //echo $conn_err;
}    
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login to your database.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>MySQL server</label>
                <input type="text" name="db_server" class="form-control" value="">
                <span class="help-block"><?php echo $DB_SERVER_ERR; ?></span>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="db_username" class="form-control" value="">
                <span class="help-block"><?php echo $DB_USERNAME_ERR; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="text" name="db_password" class="form-control" value="">
                <span class="help-block"><?php echo $DB_PASSWORD_ERR; ?></span>
            </div>    
            <div class="form-group">
                <label>Database</label>
                <input type="text" name="db_name" class="form-control" value="">
                <span class="help-block"><?php echo $DB_NAME_ERR; ?></span>
            </div> 
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            
        </form>
    </div>    
</body>
</html>