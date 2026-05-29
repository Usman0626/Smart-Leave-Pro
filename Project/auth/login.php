<?php
require_once "../config/db.php";
session_start();

$role = $_GET['role'] ?? 'employee';
$error = "";

/* Theme mapping */
$themes = [
    "employee" => "#00c2ff",
    "manager"  => "#9d4edd",
    "admin"    => "#ff4d6d"
];

$color = $themes[$role] ?? "#00c2ff";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == "employee") {
        $query = "SELECT * FROM employees WHERE email='$email'";
    } elseif ($role == "manager") {
        $query = "SELECT * FROM managers WHERE email='$email'";
    } else {
        $query = "SELECT * FROM admins WHERE email='$email'";
    }

    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && $password == $user['password']) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $role;

        header("Location: ../index.php");
        exit();

    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#0a0f1d;
    font-family:Arial;
}

.login-card{
    width:350px;
    padding:30px;
    border-radius:15px;
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(15px);
    border:1px solid rgba(255,255,255,0.1);
    text-align:center;
    color:white;
}

h2{
    color:<?php echo $color; ?>;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
    border-radius:8px;
    border:none;
    outline:none;
}

button{
    width:100%;
    padding:10px;
    border:none;
    border-radius:8px;
    background:<?php echo $color; ?>;
    color:white;
    cursor:pointer;
}

button:hover{
    opacity:0.8;
}
</style>

</head>

<body>

<div class="login-card">

    <h2><?php echo ucfirst($role); ?> Login</h2>

    <form method="POST">

        <input type="hidden" name="role" value="<?php echo $role; ?>">

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>

    </form>

    <p style="color:red;"><?php echo $error; ?></p>

</div>

</body>
</html>