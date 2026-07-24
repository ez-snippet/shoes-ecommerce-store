<?php
include __DIR__ . "/../config/db.php";
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];
    $rating = $_POST['rating'];
    $message = $_POST['message'];
    move_uploaded_file($tmp, __DIR__ . "/../uploads/" . $image);
    $sql = "INSERT INTO reviews(name, image, rating, message) VALUES('$name', '$image', '$rating', '$message') ";
    mysqli_query($conn, $sql);
    header("Location:review.php");
    exit();
}
$result = mysqli_query($conn, "SELECT * FROM reviews ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Review</title>
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/review.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <div class="main">

        <div class="svg_image">
            <img src="../uploads/sv1.svg" alt="Customer Review">
        </div>

        <div class="form">

            <h2>Customer Review</h2>

            <form method="POST" enctype="multipart/form-data">

                <input type="text" name="name" placeholder="Enter Your Name" required>
                <br>

                <input type="file"  name="image"  placeholder="Select your Image"  required>
                <br>

                <select name="rating" required>
                    <option value="">Select Rating</option>
                    <option value="5">⭐⭐⭐⭐⭐ </option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐ </option>
                    <option value="2">⭐⭐ </option>
                    <option value="1">⭐</option>
                </select>
                <br>

                <textarea
                    name="message"
                    rows="5"
                    placeholder="Write Your Review..."
                    required></textarea>
                <br>

                <button type="submit" id="btn" name="submit">
                    <i class="fa-solid fa-paper-plane"></i>
                    Submit Review
                </button>

            </form>

        </div>

    </div>
    <div class="container">

    <h2 class="heading">Customer Reviews</h2>

    <div class="row">

        <?php while($row = mysqli_fetch_assoc($result)){ ?>

        <div class="card">

            <img src="../uploads/<?php echo $row['image']; ?>" alt="">

            <h3><?php echo $row['name']; ?></h3>

            <div class="rating">
                <?php
                for($i=1; $i<=5; $i++){
                    if($i <= $row['rating']){
                        echo "⭐";
                    }else{
                        echo "☆";
                    }
                }
                ?>
            </div>

            <p>
                <?php echo $row['message']; ?>
            </p>

            <small>
                <?php echo date("d M Y", strtotime($row['created_at'])); ?>
            </small>

        </div>

        <?php } ?>

    </div>

</div>

    <script>
        let btn = document.getElementById("btn");
        btn.addEventListener("click", () => {
            alert("✔️ Review Submitted! ", "Thank you for sharing your feedback.")
        })
    </script>
</body>

</html>