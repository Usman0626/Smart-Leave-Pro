<?php
require_once "../core/session.php";
requireManager();
require_once "../config/db.php";

$result=mysqli_query($conn,"SELECT * FROM leave_requests");
?>

<?php include("../includes/layout_start.php"); ?>

<h1>Leave Requests</h1>

<div class="glass-card">

<table>

<tr>
<th>ID</th>
<th>Type</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($r=mysqli_fetch_assoc($result)): ?>

<tr>

<td><?php echo $r['id']; ?></td>
<td><?php echo $r['leave_type']; ?></td>

<td>

<?php if($r['status']=="Pending"): ?>

<button class="btn btn-primary action-btn"
        data-id="<?php echo $r['id']; ?>"
        data-action="approve">
    Approve
</button>

<button class="btn btn-danger action-btn"
        data-id="<?php echo $r['id']; ?>"
        data-action="reject">
    Reject
</button>

<?php else: ?>
<span class="badge <?php echo strtolower($r['status']); ?>">
    <?php echo $r['status']; ?>
</span>
<?php endif; ?>

</td>




</tr>

<?php endwhile; ?>

</table>

</div>

<?php include("../includes/layout_end.php"); ?>