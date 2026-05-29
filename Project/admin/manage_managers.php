<?php
require_once "../core/session.php";
requireAdmin();
require_once "../config/db.php";

$result=mysqli_query($conn,"SELECT * FROM managers");
?>

<?php include("../includes/layout_start.php"); ?>

<h1>Managers</h1>

<div class="glass-card">

<table>

<tr><th>ID</th><th>Name</th><th>Email</th></tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
</tr>

<?php } ?>

</table>

</div>

<?php include("../includes/layout_end.php"); ?>