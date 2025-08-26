<?php
session_start(); include 'db_config.php';
if(!isset($_SESSION['user'])) die("Login first <a href='login.php'>here</a>");
if($_POST){
    $uid=$_SESSION['user']; $d=$_POST['date']; $mid=$_POST['mechanic'];
    $chk=$conn->query("SELECT * FROM appointments WHERE user_id=$uid AND date='$d'");
    if($chk->num_rows) $error="Already booked that day";
    else {
        $mech = $conn->query("SELECT max_appointments FROM mechanics WHERE id=$mid")->fetch_assoc();
        $limit = $mech['max_appointments'];
        $chk=$conn->query("SELECT * FROM appointments WHERE mechanic_id=$mid AND date='$d'");
        if($chk->num_rows >= $limit) $error="Mechanic is fully booked for that day (limit: $limit)";
        else {
            $conn->query("INSERT INTO appointments(user_id,date,mechanic_id) VALUES($uid,'$d',$mid)");
            $success="Appointment booked successfully!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Book Appointment</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <form method="post">
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mechanic</label>
            <select name="mechanic" class="form-control">
                <?php
                $res=$conn->query("SELECT * FROM mechanics");
                while($m=$res->fetch_assoc()) echo "<option value='{$m['id']}'>{$m['name']}</option>";
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Book</button>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </form>
</div>
</body>
</html>