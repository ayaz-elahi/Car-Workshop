<?php
session_start(); include 'db_config.php';
if(!isset($_SESSION['admin'])) die("Admin only");

if(isset($_POST['add'])){
    $uid=$_POST['user']; $d=$_POST['date']; $mid=$_POST['mechanic'];
    $conn->query("INSERT INTO appointments(user_id,date,mechanic_id) VALUES($uid,'$d',$mid)");
}

if(isset($_POST['edit'])){
    $id=$_POST['id']; $d=$_POST['date']; $mid=$_POST['mechanic'];
    $conn->query("UPDATE appointments SET date='$d', mechanic_id=$mid WHERE id=$id");
}

if(isset($_POST['limit'])){
    $mid=$_POST['id']; $limit=$_POST['max'];
    $conn->query("UPDATE mechanics SET max_appointments=$limit WHERE id=$mid");
}


$apps=$conn->query("SELECT a.id,u.name,a.date,m.name as mech,a.mechanic_id 
                    FROM appointments a 
                    JOIN users u ON a.user_id=u.id 
                    JOIN mechanics m ON a.mechanic_id=m.id");
$users=$conn->query("SELECT * FROM users");
$mechs=$conn->query("SELECT * FROM mechanics");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Admin Panel</h2>

    <h4>Add Appointment</h4>
    <form method="post" class="row g-3 mb-4">
        <input type="hidden" name="add" value="1">
        <div class="col-md-4">
            <select name="user" class="form-control">
                <?php while($u=$users->fetch_assoc()) echo "<option value='{$u['id']}'>{$u['name']}</option>"; ?>
            </select>
        </div>
        <div class="col-md-4">
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="col-md-4">
            <select name="mechanic" class="form-control">
                <?php 
                $mechs2=$conn->query("SELECT * FROM mechanics");
                while($m=$mechs2->fetch_assoc()) echo "<option value='{$m['id']}'>{$m['name']}</option>"; 
                ?>
            </select>
        </div>
        <div class="col-md-12">
            <button class="btn btn-success">Add Appointment</button>
        </div>
    </form>

    <h4>All Appointments</h4>
    <table class="table table-bordered">
        <tr><th>User</th><th>Date</th><th>Mechanic</th><th>Action</th></tr>
        <?php while($r=$apps->fetch_assoc()): ?>
        <tr>
            <form method="post">
                <td><?=$r['name']?></td>
                <td><input type="date" name="date" value="<?=$r['date']?>" class="form-control"></td>
                <td>
                    <select name="mechanic" class="form-control">
                        <?php 
                        $mechs3=$conn->query("SELECT * FROM mechanics");
                        while($m=$mechs3->fetch_assoc()){
                            $sel = $m['id']==$r['mechanic_id'] ? "selected" : "";
                            echo "<option value='{$m['id']}' $sel>{$m['name']}</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="id" value="<?=$r['id']?>">
                    <button name="edit" value="1" class="btn btn-primary btn-sm">Save</button>
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>

    <h4>Mechanic Limits</h4>
    <table class="table table-bordered">
        <tr><th>Mechanic</th><th>Max Appointments/Day</th><th>Action</th></tr>
        <?php 
        $mechs4=$conn->query("SELECT * FROM mechanics");
        while($m=$mechs4->fetch_assoc()): ?>
        <tr>
            <form method="post">
                <td><?=$m['name']?></td>
                <td><input type="number" name="max" value="<?=$m['max_appointments']?>" class="form-control"></td>
                <td>
                    <input type="hidden" name="id" value="<?=$m['id']?>">
                    <button name="limit" value="1" class="btn btn-warning btn-sm">Update</button>
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="admin_logout.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>
