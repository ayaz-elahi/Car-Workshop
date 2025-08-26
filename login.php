<?php
session_start(); include 'db_config.php';
if($_POST){
    $email=$_POST['email']; $pass=$_POST['password'];
    $res=$conn->query("SELECT * FROM users WHERE email='$email'");
    if($u=$res->fetch_assoc()){
        if(password_verify($pass,$u['password'])){
            $_SESSION['user']=$u['id'];
            header("Location: index.php"); exit;
        }
    }
    $error = "Invalid email or password.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Customer Login</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="signup.php" class="btn btn-secondary">Signup</a>
    </form>
</div>
</body>
</html>