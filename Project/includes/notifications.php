<?php
$emp_id = $_SESSION['user_id'] ?? null;
$role   = $_SESSION['role'] ?? '';

if($emp_id && $role == 'employee'){
    $notifRes = mysqli_query($conn,"SELECT * FROM leave_requests 
                                    WHERE employee_id=$emp_id 
                                    ORDER BY created_at DESC LIMIT 3");
    $count = 0;
    echo "<div class='glass-card'><h3>Notifications</h3>";
    while($n = mysqli_fetch_assoc($notifRes)){
        $count++;
        $badgeClass = strtolower($n['status']);
        if($n['status'] == 'Pending'){
            $msg = "Your {$n['leave_type']} leave request is under review.";
        } elseif($n['status'] == 'Approved'){
            $msg = "Your {$n['leave_type']} leave ({$n['start_date']} to {$n['end_date']}) was approved.";
        } else {
            $msg = "Your {$n['leave_type']} leave ({$n['start_date']} to {$n['end_date']}) was rejected.";
        }
        echo "<div class='notification'>
                <span class='badge {$badgeClass}'>{$n['status']}</span>
                {$msg}
              </div>";
    }
    if($count == 0){
        echo "<p style='color:#888;font-size:14px;'>No notifications yet.</p>";
    }
    echo "</div>";
}
?>