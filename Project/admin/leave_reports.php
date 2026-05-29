<?php
require_once "../core/session.php";
requireAdmin();
require_once "../config/db.php";

$res=mysqli_query($conn,"SELECT * FROM leave_requests ORDER BY created_at DESC");
?>

<?php include("../includes/layout_start.php"); ?>

<h1>Leave Reports</h1>

<div class="glass-card">

<table>

<tr>
<th>ID</th>
<th>Employee</th>
<th>Type</th>
<th>Status</th>
<th>Date</th>
</tr>

<?php while($r=mysqli_fetch_assoc($res)){ ?>

<tr>
<td><?php echo $r['id']; ?></td>
<td><?php echo $r['employee_id']; ?></td>
<td><?php echo $r['leave_type']; ?></td>
<td><?php echo $r['status']; ?></td>
<td><?php echo $r['created_at']; ?></td>
</tr>

<?php } ?>

</table>

</div>

<?php include("../includes/layout_end.php"); ?>