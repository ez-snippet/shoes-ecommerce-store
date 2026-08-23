<?php
include __DIR__ . "/../config/db.php";
$message = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    if (empty($name) || empty($pass)) {
        $message = "please Enter your username and password";
    } elseif ($name == "admin" && $pass == "ayazshk") {
        header("Location:dashboard.php");
        exit;
    } else {
        $message = "invalid username and password";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/admin_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <form method="post">
        <div class="login-card">
            <p style="text-align: center; margin-top: 10px; color: red; background-color: black; padding: 10px;"> <?php echo $message ?></p>
            <h2>Admin Form</h2>
            <input type="text" name="name" placeholder="Enter your Admin username" />
            <input type="password" name="pass" placeholder=" Enter your Admin Password" />
            <button name="submit"> <i class="fa-solid fa-arrow-right-to-bracket"></i>Login</button>
        </div>
    </form>

</body>

</html>