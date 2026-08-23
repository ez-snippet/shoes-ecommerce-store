<?php
include __DIR__ . "/../config/db.php";
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $sql = "INSERT INTO feed_back(full_name, email, message, phone , subject) VALUES('$name', '$email', '$message', '$phone', '$subject') ";
    if (mysqli_query($conn, $sql)) {
        header("Location:home.php");
    } else {
        echo "please Enter your Feedback";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/feedback_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <div class="main">
        <div class="svg_image">
            <img src="../uploads/image.svg" alt="Contact SVG">
        </div>
        <div class="form">
            <h2>Contact Us</h2>

            <form method="post" id="form">

                <input type="text" name="name" id="name" placeholder="Enter your Name" required />
                <br>
                <span id="e1"></span>

                <input type="email" name="email" id="email" placeholder="Enter your Email" required />
                <br>
                <span id="e2"></span>

                <input type="tel" name="phone" id="phone" placeholder="Enter your Phone Number" required />
                <br>
                <span id="e3"></span>

                <input type="text" name="subject" id="subject" placeholder="Enter Subject" required />
                <br>
                <span id="e4"></span>

                <textarea name="message" id="message" placeholder="Enter your Message" required></textarea>
                <br>
                <span id="e5"></span>

                <button type="submit" name="submit" id="btn">
                    <i class="fa-solid fa-paper-plane"></i> Send Message
                </button>

            </form>
        </div>
    </div>
</body>

<script>
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    let subject = document.getElementById("subject").value;
    let message = document.getElementById("message").value
    let btn = document.getElementById("btn");
    btn.addEventListener("click", () => {
        if (name == "" || email == "" || phone == "" || subject == "" || message == "") {
        alert("Please enter your details");
    }
        else {
            alert("🚀 Message sent successfully! Thanks for reaching out. We'll reply soon. 💚")
        }
    })
</script>

</html>