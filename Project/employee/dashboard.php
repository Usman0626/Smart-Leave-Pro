<?php
require_once "../core/session.php";
requireEmployee();
require_once "../config/db.php";

$id = $_SESSION['user_id'];

$total   = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests WHERE employee_id=$id"));
$pending = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests WHERE employee_id=$id AND status='Pending'"));
$approved= mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests WHERE employee_id=$id AND status='Approved'"));
$rejected= mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests WHERE employee_id=$id AND status='Rejected'"));

$bal     = mysqli_query($conn,"SELECT remaining_leaves FROM leave_balance WHERE employee_id=$id");
$balRow  = mysqli_fetch_assoc($bal);
$balance = $balRow ? (int)$balRow['remaining_leaves'] : 20;

// Real recent activity (last 5 requests)
$activityRes = mysqli_query($conn,"SELECT * FROM leave_requests WHERE employee_id=$id ORDER BY created_at DESC LIMIT 5");

// Real notifications (last 3 status changes)
$notifRes = mysqli_query($conn,"SELECT * FROM leave_requests WHERE employee_id=$id AND status != 'Pending' ORDER BY created_at DESC LIMIT 3");
?>

<?php include("../includes/layout_start.php"); ?>

<h1>Employee Dashboard</h1>

<!-- STATS -->
<div class="stats-grid">
    <div class="glass-card gradient-blue">
        <h3>Total Leaves</h3>
        <div class="stat-number"><?php echo $total; ?></div>
    </div>
    <div class="glass-card gradient-purple">
        <h3>Pending</h3>
        <div class="stat-number"><?php echo $pending; ?></div>
    </div>
    <div class="glass-card gradient-green">
        <h3>Approved</h3>
        <div class="stat-number"><?php echo $approved; ?></div>
    </div>
    <div class="glass-card gradient-blue">
        <h3>Balance</h3>
        <div class="stat-number"><?php echo $balance; ?></div>
    </div>
</div>

<!-- CHARTS -->
<div class="dashboard-grid">

    <div class="glass-card">
        <h3>Leave Trends</h3>
        <div style="height:200px;">
            <canvas id="leaveChart"></canvas>
        </div>
    </div>

    <div class="glass-card">
        <h3>Leave Distribution</h3>
        <div style="width:180px;height:180px;margin:auto;">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

</div>

<!-- REAL NOTIFICATIONS -->
<div class="glass-card">
    <h3>Notifications</h3>
    <?php
    mysqli_data_seek($notifRes, 0);
    $notifCount = 0;
    while($n = mysqli_fetch_assoc($notifRes)){
        $notifCount++;
        $badgeClass = strtolower($n['status']);
        $msg = $n['status'] == 'Approved'
            ? "Your {$n['leave_type']} leave ({$n['start_date']} to {$n['end_date']}) was approved."
            : "Your {$n['leave_type']} leave ({$n['start_date']} to {$n['end_date']}) was rejected.";
        echo "<div class='notification'>
                <span class='badge {$badgeClass}'>{$n['status']}</span>
                {$msg}
              </div>";
    }
    if($notifCount == 0){
        echo "<p style='color:#888;font-size:14px;'>No notifications yet.</p>";
    }
    ?>
</div>

<!-- REAL RECENT ACTIVITY -->
<div class="glass-card">
    <h3>Recent Activity</h3>
    <?php
    mysqli_data_seek($activityRes, 0);
    $actCount = 0;
    while($a = mysqli_fetch_assoc($activityRes)){
        $actCount++;
        $dotClass = strtolower($a['status']);
        $msg = "{$a['leave_type']} leave — {$a['start_date']} to {$a['end_date']} — <strong>{$a['status']}</strong>";
        echo "<div class='activity'>
                <span class='dot {$dotClass}'></span>
                {$msg}
              </div>";
    }
    if($actCount == 0){
        echo "<p style='color:#888;font-size:14px;'>No activity yet.</p>";
    }
    ?>
</div>

<!-- CALENDAR -->
<div class="glass-card">
    <h3>Leave Calendar</h3>
    <div id="calendar"></div>
</div>

<?php include("../includes/layout_end.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet'>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<script>
new Chart(document.getElementById('leaveChart'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun'],
        datasets: [{
            label: 'Leaves Taken',
            data: [2,4,1,5,3,6],
            borderWidth: 2,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: ['Approved','Pending','Rejected'],
        datasets: [{
            data: [<?php echo $approved; ?>, <?php echo $pending; ?>, <?php echo $rejected; ?>],
            backgroundColor: ['#00ffcc','#ffaa00','#ff4d4d']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { color: '#fff', font: { size: 11 } } } }
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        events: [
            <?php
            $res = mysqli_query($conn,"SELECT * FROM leave_requests WHERE employee_id=$id");
            while($row = mysqli_fetch_assoc($res)){
                echo "{
                    title: '".$row['leave_type']."',
                    start: '".$row['start_date']."',
                    end: '".$row['end_date']."',
                    color: '".(
                        $row['status']=='Approved' ? "#00ffcc" :
                        ($row['status']=='Pending' ? "#ffaa00" : "#ff4d4d")
                    )."'
                },";
            }
            ?>
        ]
    });
    calendar.render();
});
</script>