<?php
include 'db_config.php';
if($_POST){
    $name=$_POST['name']; $email=$_POST['email'];
    $pass=password_hash($_POST['password'],PASSWORD_DEFAULT);
    if($conn->query("INSERT INTO users(name,email,password) VALUES('$name','$email','$pass')")){
        $success = "Signup successful. <a href='login.php'>Click here to login</a>";
    } else {
        $error = "Signup failed. Try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Customer Signup</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <form method="post">
        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Signup</button>
        <a href="login.php" class="btn btn-secondary">Login</a>
    </form>
</div>
</body>
</html>