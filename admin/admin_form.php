<?php
include __DIR__ . "/../config/db.php";
if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === "admin" && $password === "admin123") {

        header("Location:dashboard.php");
        exit();
    }
    else{
        echo "invalid username and password";
        exit();
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
            <h2>Admin Form</h2>
            <input type="text" name="username" placeholder="Enter your Admin username" />
            <input type="password" name="password" placeholder=" Enter your Admin Password" />
            <button name="submit"> <i class="fa-solid fa-arrow-right-to-bracket"></i>Login</button>
        </div>
    </form>

</body>
</html>