<?php
$role = $_SESSION['role'] ?? '';
$page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">

    <div class="logo">
        <i class="fa-solid fa-shield-halved"></i>
        <span>SmartLeave Pro</span>
    </div>

    <div class="nav">

        <!-- HOME -->
        <a class="nav-item <?php if($page=='index.php') echo 'active'; ?>" href="../index.php">
            <i class="fa fa-home"></i> Home
        </a>

        <!-- ================= EMPLOYEE ================= -->
        <?php if($role == "employee"){ ?>

            <a class="nav-item <?php if($page=='dashboard.php') echo 'active'; ?>" 
               href="../employee/dashboard.php">
                Dashboard
            </a>

            <a class="nav-item <?php if($page=='apply_leave.php') echo 'active'; ?>" 
               href="../employee/apply_leave.php">
                Apply Leave
            </a>

            <a class="nav-item <?php if($page=='my_requests.php') echo 'active'; ?>" 
               href="../employee/my_requests.php">
                My Requests
            </a>

            <a class="nav-item <?php if($page=='leave_balance.php') echo 'active'; ?>" 
               href="../employee/leave_balance.php">
                Balance
            </a>

        <?php } ?>

        <!-- ================= MANAGER ================= -->
        <?php if($role == "manager"){ ?>

            <a class="nav-item <?php if($page=='dashboard.php') echo 'active'; ?>" 
               href="../manager/dashboard.php">
                Dashboard
            </a>

            <a class="nav-item <?php if($page=='leave_requests.php') echo 'active'; ?>" 
               href="../manager/leave_requests.php">
                Requests
            </a>

        <?php } ?>

        <!-- ================= ADMIN ================= -->
        <?php if($role == "admin"){ ?>

            <a class="nav-item <?php if($page=='dashboard.php') echo 'active'; ?>" 
               href="../admin/dashboard.php">
                Dashboard
            </a>

            <a class="nav-item <?php if($page=='manage_employees.php') echo 'active'; ?>" 
               href="../admin/manage_employees.php">
                Employees
            </a>

            <a class="nav-item <?php if($page=='manage_managers.php') echo 'active'; ?>" 
               href="../admin/manage_managers.php">
                Managers
            </a>

            <a class="nav-item <?php if($page=='leave_reports.php') echo 'active'; ?>" 
               href="../admin/leave_reports.php">
                Reports
            </a>

        <?php } ?>

    </div>

    <div class="bottom">

        <a class="nav-item danger" href="../auth/logout.php">
            <i class="fa fa-sign-out"></i> Logout
        </a>

    </div>

</div>