<?php
include __DIR__ . "/../config/db.php";
$current_page = basename($_SERVER['PHP_SELF']);
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM  products WHERE id = $id");
mysqli_fetch_assoc($query);
if (isset($_POST['submit'])) {
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $star  = $_POST['star'];

    $image = "";

    // sirf tab move karo jab file waqai upload hui ho aur error na ho
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0 && $_FILES['image']['name'] != "") {

        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/Complete_e-commerce_store/uploads/";

        // agar uploads folder na ho to bana do
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // filename se spaces/brackets waghera hata do
        $originalName = basename($_FILES['image']['name']);
        $safeName = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $originalName);
        $image = time() . '_' . $safeName;

        $tmp = $_FILES['image']['tmp_name'];
        $targetPath = $targetDir . $image;

        if (!move_uploaded_file($tmp, $targetPath)) {
            echo "<p style='color:red;'>Image upload fail ho gayi.</p>";
            $image = ""; // fail hone par empty rakho
        }
    }

    $query = "INSERT INTO products (name, price, image, stars) VALUES ('$name', '$price', '$image', '$star')";
    mysqli_query($conn, $query);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/add_product.css">
    <link rel="icon" href="/uploads/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="/Complete_e-commerce_store/uploads/logo.jpg" alt="Logo" class="logo" style="width: 50px; height: 50px; border-radius: 50%;">
            </a>
            <button
                class="navbar-toggler d-lg-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId"
                aria-controls="collapsibleNavId"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link mt-1" href="#">Welcome Admin 👋</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">

        <!-- Sidebar -->
        <div class="sidebar p-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
                        <i class="fa-solid fa-house me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'add_product.php' ? 'active' : '' ?>" href="add_product.php">
                        <i class="fa-solid fa-shoe-prints me-2"></i> Add Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'orders.php' ? 'active' : '' ?>" href="orders.php">
                        <i class="fa-solid fa-box me-2"></i>Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'user_message_show.php' ? 'active' : '' ?>" href="user_message_show.php">
                        <i class="fa-solid fa-message me-2"></i>Customer Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'reviews_show.php' ? 'active' : '' ?>" href="reviews_show.php">
                        <i class="fa-solid fa-star me-2"></i>Reviews
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'acnounch.php' ? 'active' : '' ?>" href="acnounch.php">
                        <i class="fa-solid fa-bullhorn me-2 "></i>Announcements
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../admin/logout.php">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
        <!-- /Sidebar -->

        <!-- Content wrapper: form on top, table stacked below it -->
        <div class="content-wrapper">

            <!-- Announcement form -->
            <div class="main">
                <div class="svg_image">
                    <img src="../uploads/png.jpg" alt="Contact SVG">
                </div>
                <div class="form">
                    <h2>👟 Add New Product</h2>

                    <form method="post" id="form" enctype="multipart/form-data">
                        <input type="file" name="image" placeholder="Select product image">
                        <br>
                        <input type="text" name="name" placeholder="Enter your product Name">
                        <br>
                        <input type="number" name="price" placeholder="Enter your product price">
                        <br>
                        <input type="text" name="star" placeholder="e.g. ⭐⭐⭐⭐⭐ ">

                        <button type="submit" name="submit" id="btn">

                            ➕ Add Product
                        </button>


                    </form>
                </div>
            </div>