
<?php
require_once "../core/session.php";
requireManager();
require_once "../config/db.php";

header('Content-Type: application/json');

$id     = $_POST['id'];
$action = $_POST['action'];

if(!$id || !$action){
    echo json_encode(["status"=>"error","message"=>"Invalid request"]);
    exit();
}

if($action == "approve"){
    $req    = mysqli_query($conn,"SELECT * FROM leave_requests WHERE id=$id");
    $row    = mysqli_fetch_assoc($req);

    if(!$row){
        echo json_encode(["status"=>"error","message"=>"Leave request not found"]);
        exit();
    }

    if($row['status'] == 'Approved'){
        echo json_encode(["status"=>"error","message"=>"Already approved"]);
        exit();
    }

    $employee_id = $row['employee_id'];
    $startDate   = new DateTime($row['start_date']);
    $endDate     = new DateTime($row['end_date']);
    $leave_days  = (int)$startDate->diff($endDate)->days + 1;

    $bal    = mysqli_query($conn,"SELECT * FROM leave_balance WHERE employee_id='$employee_id'");
    $balRow = mysqli_fetch_assoc($bal);

    if(!$balRow){
        mysqli_query($conn,"INSERT INTO leave_balance(employee_id,total_leaves,used_leaves,remaining_leaves) VALUES('$employee_id',20,0,20)");
        $remaining = 20;
        $used      = 0;
    } else {
        $remaining = (int)$balRow['remaining_leaves'];
        $used      = (int)$balRow['used_leaves'];
    }

    if($leave_days > $remaining){
        echo json_encode(["status"=>"error","message"=>"Not enough balance ($remaining left, needs $leave_days)"]);
        exit();
    }

    $new_used      = $used + $leave_days;
    $new_remaining = $remaining - $leave_days;
    if($new_remaining < 0) $new_remaining = 0;

    mysqli_query($conn,"UPDATE leave_requests SET status='Approved', manager_remark='Approved by Manager' WHERE id=$id");
    mysqli_query($conn,"UPDATE leave_balance SET used_leaves='$new_used', remaining_leaves='$new_remaining' WHERE employee_id='$employee_id'");

    echo json_encode(["status"=>"success"]);

} elseif($action == "reject"){
    mysqli_query($conn,"UPDATE leave_requests SET status='Rejected', manager_remark='Rejected by Manager' WHERE id=$id");
    echo json_encode(["status"=>"success"]);

} else {
    echo json_encode(["status"=>"error","message"=>"Unknown action"]);
}
?>