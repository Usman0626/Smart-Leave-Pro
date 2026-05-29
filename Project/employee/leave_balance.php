<?php
require_once "../core/session.php";
requireEmployee();
require_once "../config/db.php";

$id=$_SESSION['user_id'];
#$approved=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests WHERE employee_id=$id AND status='Approved'"));
#$balance=20-$approved;
$bal = mysqli_query($conn,"SELECT * FROM leave_balance WHERE employee_id=$id");
$balRow = mysqli_fetch_assoc($bal);
$approved = $balRow ? $balRow['used_leaves'] : 0;
$balance = $balRow ? $balRow['remaining_leaves'] : 20;
?>

<?php include("../includes/layout_start.php"); ?>

<div class="glass-card">

<h2>Leave Balance</h2>
<p>Total: 20</p>
<p>Used: <?php echo $approved; ?></p>
<p>Remaining: <?php echo $balance; ?></p>

</div>

<?php include("../includes/layout_end.php"); ?>