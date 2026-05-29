<?php
require_once "../core/session.php";
requireEmployee();
require_once "../config/db.php";

$id=$_SESSION['user_id'];
$result=mysqli_query($conn,"SELECT * FROM leave_requests WHERE employee_id=$id");
?>

<?php include("../includes/layout_start.php"); ?>

<h1>My Requests</h1>

<div class="glass-card">

<table>

<tr>
<th>Type</th>
<th>Start</th>
<th>End</th>
<th>Status</th>
</tr>

<?php while($r=mysqli_fetch_assoc($result)): ?>

<tr>
<td><?php echo $r['leave_type']; ?></td>
<td><?php echo $r['start_date']; ?></td>
<td><?php echo $r['end_date']; ?></td>
<td><?php echo $r['status']; ?></td>
</tr>

<?php endwhile; ?>

</table>

</div>

<?php include("../includes/layout_end.php"); ?>