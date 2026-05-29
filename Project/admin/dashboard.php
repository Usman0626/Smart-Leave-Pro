<?php
require_once "../core/session.php";
requireAdmin();
require_once "../config/db.php";

$employees = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM employees"));
$managers  = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM managers"));
$pending   = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests WHERE status='Pending'"));
$approved  = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests WHERE status='Approved'"));
$rejected  = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM leave_requests WHERE status='Rejected'"));
?>

<?php include("../includes/layout_start.php"); ?>

<h1>Admin Dashboard</h1>

<!-- STATS -->
<div class="stats-grid">
    <div class="glass-card gradient-blue">
        <h3>Employees</h3>
        <div class="stat-number"><?php echo $employees; ?></div>
    </div>
    <div class="glass-card gradient-purple">
        <h3>Managers</h3>
        <div class="stat-number"><?php echo $managers; ?></div>
    </div>
    <div class="glass-card gradient-green">
        <h3>Pending</h3>
        <div class="stat-number"><?php echo $pending; ?></div>
    </div>
    <div class="glass-card gradient-blue">
        <h3>Approved</h3>
        <div class="stat-number"><?php echo $approved; ?></div>
    </div>
    <div class="glass-card gradient-purple">
        <h3>Rejected</h3>
        <div class="stat-number"><?php echo $rejected; ?></div>
    </div>
</div>

<!-- CHARTS -->
<div class="dashboard-grid">
    <div class="glass-card">
        <h3>System Overview</h3>
        <div style="position:relative; height:200px;">
            <canvas id="adminChart"></canvas>
        </div>
    </div>

    <div class="glass-card">
        <h3>Leave Distribution</h3>
        <div style="position:relative; width:180px; height:180px; margin:auto;">
            <canvas id="adminPie"></canvas>
        </div>
    </div>
</div>

<!-- SCRIPTS BEFORE layout_end -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('adminChart'), {
    type: 'bar',
    data: {
        labels: ['Employees','Managers','Pending','Approved','Rejected'],
        datasets: [{
            label: 'System Stats',
            data: [<?php echo $employees; ?>, <?php echo $managers; ?>, <?php echo $pending; ?>, <?php echo $approved; ?>, <?php echo $rejected; ?>],
            backgroundColor: ['#00f0ff','#aa00ff','#ffaa00','#00ffcc','#ff4d4d']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { labels: { color: '#fff' } } },
        scales: { x: { ticks: { color: '#fff' } }, y: { ticks: { color: '#fff' } } }
    }
});

new Chart(document.getElementById('adminPie'), {
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