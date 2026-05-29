<?php
session_start();

if(isset($_SESSION['role'])){
    $r=$_SESSION['role'];

    if($r=="admin") header("Location: admin/dashboard.php");
    if($r=="manager") header("Location: manager/dashboard.php");
    if($r=="employee") header("Location: employee/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SmartLeavePro</title>

<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<!-- Particles.js -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#050814;
    color:white;
    overflow:hidden;
}

/* Particle background */
#particles-js{
    position:absolute;
    width:100%;
    height:100%;
    z-index:-1;
}

/* Center wrapper */
.wrapper{
    height:100vh;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    text-align:center;
    padding:20px;
}

/* Title */
h1{
    font-size:3rem;
    background:linear-gradient(90deg,#00f0ff,#9d4edd,#ff4dff);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.tagline{
    opacity:0.7;
    margin-top:10px;
}

/* Cards layout */
.card-container{
    margin-top:40px;
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    justify-content:center;
}

/* Glass card */
.card{
    width:260px;
    padding:25px;
    border-radius:16px;
    background:rgba(255,255,255,0.06);
    backdrop-filter:blur(15px);
    border:1px solid rgba(255,255,255,0.1);
    text-decoration:none;
    color:white;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-10px);
    border-color:#00f0ff;
    box-shadow:0 0 25px rgba(0,240,255,0.2);
}

/* Icon */
.icon{
    font-size:35px;
    margin-bottom:10px;
}

/* Mobile */
@media(max-width:768px){
    .card-container{
        flex-direction:column;
        align-items:center;
    }
}
</style>

</head>

<body>

<!-- Particle Background -->
<div id="particles-js"></div>

<div class="wrapper">

    <h1>SmartLeavePro</h1>
    <p class="tagline">The ultimate enterprise-grade leave management </p>

    <div class="card-container">

        <a href="auth/login.php?role=employee" class="card">
            <div class="icon">👨‍💼</div>
            <h2>Employee Portal</h2>
            <p>Request leaves, view balance, and track status.</p>
        </a>

        <a href="auth/login.php?role=manager" class="card">
            <div class="icon">🧑‍💻</div>
            <h2>Manager Portal</h2>
            <p>Review applications and manage team attendance.</p>
        </a>

        <a href="auth/login.php?role=admin" class="card">
            <div class="icon">🛡</div>
            <h2>Admin Portal</h2>
            <p>System configuration, user management, and reports.</p>
        </a>

    </div>

</div>

<!-- Particles config -->
<script>
particlesJS("particles-js", {
    particles: {
        number: { value: 60 },
        color: { value: "#00f0ff" },
        shape: { type: "circle" },
        opacity: { value: 0.3 },
        size: { value: 2 },
        move: {
            enable: true,
            speed: 1
        }
    }
});
</script>

</body>
</html>