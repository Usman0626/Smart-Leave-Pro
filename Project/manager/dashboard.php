<?php
require_once "../core/session.php";
requireManager();
require_once "../config/db.php";

$total    = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests"));
$pending  = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests WHERE status='Pending'"));
$approved = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests WHERE status='Approved'"));
$rejected = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests WHERE status='Rejected'"));

$notifRes = mysqli_query($conn,"SELECT lr.*, e.name 
                                FROM leave_requests lr 
                                JOIN employees e ON lr.employee_id = e.id 
                                WHERE lr.status != 'Pending' 
                                ORDER BY lr.created_at DESC LIMIT 3");

$pendingRes = mysqli_query($conn,"SELECT lr.*, e.name 
                                  FROM leave_requests lr 
                                  JOIN employees e ON lr.employee_id = e.id 
                                  WHERE lr.status = 'Pending' 
                                  ORDER BY lr.created_at DESC LIMIT 3");
?>

<?php include("../includes/layout_start.php"); ?>

<h1>Manager Dashboard</h1>

<!-- STATS -->
<div class="stats-grid">
    <div class="glass-card gradient-blue">
        <h3>Total Requests</h3>
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
        <h3>Rejected</h3>
        <div class="stat-number"><?php echo $rejected; ?></div>
    </div>
</div>

<!-- CHARTS -->
<div class="dashboard-grid">
    <div class="glass-card">
        <h3>Leave Requests Trend</h3>
        <div style="position:relative; height:200px;">
            <canvas id="managerChart"></canvas>
        </div>
    </div>

    <div class="glass-card">
        <h3>Status Distribution</h3>
        <div style="position:relative; width:180px; height:180px; margin:auto;">
            <canvas id="managerPie"></canvas>
        </div>
    </div>
</div>

<!-- NOTIFICATIONS -->
<div class="glass-card">
    <h3>Notifications</h3>
    <?php
    $notifCount = 0;
    while($n = mysqli_fetch_assoc($notifRes)){
        $notifCount++;
        $badgeClass = strtolower($n['status']);
        $name = $n['name'];
        $msg = "{$name}'s {$n['leave_type']} leave ({$n['start_date']} to {$n['end_date']}) was {$n['status']}.";
        echo "<div class='notification'>
                <span class='badge {$badgeClass}'>{$n['status']}</span>
                {$msg}
              </div>";
    }

    $pendingCount = 0;
    while($p = mysqli_fetch_assoc($pendingRes)){
        $pendingCount++;
        $name = $p['name'];
        $msg = "{$name} requested {$p['leave_type']} leave ({$p['start_date']} to {$p['end_date']}).";
        echo "<div class='notification'>
                <span class='badge pending'>Pending</span>
                {$msg}
              </div>";
    }

    if($notifCount == 0 && $pendingCount == 0){
        echo "<p style='color:#888;font-size:14px;'>No notifications yet.</p>";
    }
    ?>
</div>

<!-- SCRIPTS BEFORE layout_end -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('managerChart'), {
    type: 'line',
    data: {
        labels: ['Week1','Week2','Week3','Week4'],
        datasets: [{
            label: 'Requests',
            data: [<?php echo $pending; ?>, <?php echo $approved; ?>, <?php echo $rejected; ?>, <?php echo $total; ?>],
            tension: 0.4,
            borderColor: '#00f0ff',
            backgroundColor: 'rgba(0,240,255,0.1)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { labels: { color: '#fff' } } },
        scales: { x: { ticks: { color: '#fff' } }, y: { ticks: { color: '#fff' } } }
    }
});

new Chart(document.getElementById('managerPie'), {
    type: 'doughnut',
    data: {
        labels: ['Pending','Approved','Rejected'],
        datasets: [{
            data: [<?php echo $pending; ?>, <?php echo $approved; ?>, <?php echo $rejected; ?>],
            backgroundColor: ['#ffaa00','#00ffcc','#ff4d4d']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { color: '#fff', font: { size: 11 } } } }
    }
});
</script>

<?php include("../includes/layout_end.php"); ?>