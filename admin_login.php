<?php
session_start(); include 'db_config.php';
if($_POST){
    $u=$_POST['username']; $p=$_POST['password'];
    $res=$conn->query("SELECT * FROM admins WHERE username='$u'");
    if($a=$res->fetch_assoc()){
        if($p === $a['password']){
            $_SESSION['admin']=$a['id']; header("Location: admin.php"); exit;
        }
    }
    $error="Invalid admin credentials.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Admin Login</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
        <div class="mb-3">
            <label>Username</label>
            <input name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>