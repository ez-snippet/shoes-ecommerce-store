<?php
include __DIR__ . "/../config/db.php";
$current_page = basename($_SERVER['PHP_SELF']);

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$result = mysqli_query($conn, "SELECT * FROM announcements WHERE id = $id");
$row = mysqli_fetch_assoc($result);

// If no announcement found with that id, send back to the list instead of showing a broken form
if (!$row) {
    header("Location: acnounch.php");
    exit;
}

if (isset($_POST['submit'])) {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $sql = "UPDATE announcements SET message = '$message' WHERE id = $id";
    mysqli_query($conn, $sql);
    header("Location: acnounch.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/anouc.css">
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

        <!-- Content wrapper -->
        <div class="content-wrapper">

            <!-- Update announcement form -->
            <div class="main">
                <div class="svg_image">
                    <img src="../uploads/ali.png" alt="Contact SVG">
                </div>
                <div class="form">
                    <h2>✏️ Update Announcement</h2>

                    <form method="post" id="form">

                        <textarea name="message" id="message" placeholder="Type your announcement here..." required><?= htmlspecialchars($row['message']) ?></textarea>
                        <br>


                        <button type="submit" name="submit" id="btn">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Update Announcement
                        </button>

                    </form>
                </div>
            </div>

        </div>
        <!-- /Content wrapper -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>