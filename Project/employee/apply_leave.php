<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once "../core/session.php";
requireEmployee();
require_once "../config/db.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $id     = $_SESSION['user_id'];
    $type   = $_POST['leave_type'];
    $start  = $_POST['start_date'];
    $end    = $_POST['end_date'];
    $reason = $_POST['reason'];

    $startDate  = new DateTime($start);
    $endDate    = new DateTime($end);
    $interval   = $startDate->diff($endDate);
    $leave_days = (int)$interval->days + 1;

    $bal    = mysqli_query($conn,"SELECT remaining_leaves FROM leave_balance WHERE employee_id='$id'");
    $balRow = mysqli_fetch_assoc($bal);

    if(!$balRow){
        mysqli_query($conn,"INSERT INTO leave_balance(employee_id,total_leaves,used_leaves,remaining_leaves)
        VALUES('$id',20,0,20)");
        $remaining = 20;
    } else {
        $remaining = (int)$balRow['remaining_leaves'];
    }

    if($remaining <= 0){

        $alert = "<div style='background:#7f1d1d;padding:12px;border-radius:8px;color:white;margin-bottom:15px;'>
                    ⛔ You have used all your leaves. You cannot apply for any more leaves this year.
                  </div>";

    } elseif($leave_days > $remaining){

        $alert = "<div style='background:#7f1d1d;padding:12px;border-radius:8px;color:white;margin-bottom:15px;'>
                    ❌ You cannot apply for $leave_days day(s). Only $remaining leave(s) remaining.
                  </div>";

    } else {

        mysqli_query($conn,"INSERT INTO leave_requests(employee_id,leave_type,start_date,end_date,reason,status,created_at)
        VALUES('$id','$type','$start','$end','$reason','Pending',NOW())");

        $alert = "<div style='background:#064e3b;padding:12px;border-radius:8px;color:white;margin-bottom:15px;'>
                    ✅ Leave Applied Successfully for $leave_days day(s). Remaining Balance: $remaining leave(s) (deducted after manager approval).
                  </div>";
    }
}
?>

<?php include("../includes/layout_start.php"); ?>

<div class="glass-card">

    <h2>Apply Leave</h2>

    <?php if(isset($alert)) echo $alert; ?>

    <form method="POST">

        <select name="leave_type" required>
            <option value="">Select Leave Type</option>
            <option>Sick</option>
            <option>Casual</option>
            <option>Annual</option>
        </select>

        <input type="date" name="start_date" required>
        <input type="date" name="end_date" required>

        <textarea name="reason" placeholder="Enter Reason" required></textarea>

        <button class="btn btn-primary">Submit</button>

    </form>

</div>

<?php include("../includes/layout_end.php"); ?>
