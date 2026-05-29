<?php
require_once "../core/session.php";
requireAdmin();
require_once "../config/db.php";

$result = mysqli_query($conn,"SELECT * FROM employees");
?>

<?php include("../includes/layout_start.php"); ?>

<h1>Employees</h1>

<div class="glass-card">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Manager ID</th>
            <th>Created At</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>          <!-- ✅ was employee_id -->
            <td><?php echo $row['name']; ?></td>         <!-- ✅ was first_name.' '.last_name -->
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['manager_id']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
        </tr>
        <?php } ?>

    </table>
</div>

<?php include("../includes/layout_end.php"); ?>