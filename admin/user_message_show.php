<?php
include __DIR__ . "/../config/db.php";

$sql = mysqli_query($conn, "SELECT * FROM feed_back");
$current_page = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/dashboard.css">
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
                    <a class="nav-link <?= $current_page == '' ? 'active' : '' ?>" href="acnounch.php">
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

        <!-- Main content -->
        <div class="flex-grow-1 p-4">

            <!-- Stat cards -->

            <!-- Recent Orders -->
            <div class="card-table p-3">
                <h6 class="fw-semibold mb-3">Customer Messages 💬 </h6>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($sql as $order): ?>
                                <tr>
                                    <td><?= htmlspecialchars($order['id']) ?></td>
                                    <td><?= htmlspecialchars($order['full_name']) ?></td>
                                    <td><?= htmlspecialchars($order['email']) ?></td>
                                    <td><?= htmlspecialchars($order['phone']) ?></td>
                                    <td><?= htmlspecialchars($order['subject']) ?></td>
                                    <td><?= htmlspecialchars($order['message']) ?></td>
                                    <td><?= htmlspecialchars(date('d M Y', strtotime($order['created_at']))) ?></td>
                                </tr>
                            <?php endforeach; ?>


                            <?php ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>