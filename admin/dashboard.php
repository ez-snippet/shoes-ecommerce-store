<?php
include __DIR__ . "/../config/db.php";
$current_page = basename($_SERVER['PHP_SELF']);

/* =========================================================
   Confirmed schema (shoes_ecommerce DB):

   products -> id, name, image, price, description, created_at
   orders   -> id, product_id, full_name, phone, email, address,
               city, size, color, quantity, payment_method,
               notes, total_price, created_at

   There is no "users" table, so the Users stat card below
   counts distinct customer emails from the orders table instead.

   $conn is assumed to be a mysqli connection object created
   inside db.php (i.e. $conn = new mysqli(...)).
========================================================= */

// --- Stat counts ---
$productsCount = 0;
$ordersCount   = 0;
$usersCount    = 0;
$revenueTotal  = 0;

if ($result = $conn->query("SELECT COUNT(*) AS total FROM products")) {
    $productsCount = $result->fetch_assoc()['total'];
}

if ($result = $conn->query("SELECT COUNT(*) AS total FROM orders")) {
    $ordersCount = $result->fetch_assoc()['total'];
}

if ($result = $conn->query("SELECT COUNT(DISTINCT email) AS total FROM orders")) {
    $usersCount = $result->fetch_assoc()['total'];
}

if ($result = $conn->query("SELECT SUM(total_price) AS total FROM orders")) {
    $revenueTotal = $result->fetch_assoc()['total'] ?? 0;
}

// --- Recent orders (latest 5, joined with products for name + image) ---
$recentOrders = [];
$sql = "SELECT o.id, o.full_name, o.phone, o.address, o.color, o.city, o.total_price, p.name AS product_name, p.image
        FROM orders o
        LEFT JOIN products p ON o.product_id = p.id
        ORDER BY o.created_at DESC
        LIMIT 5";
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $recentOrders[] = $row;
    }
}
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
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card d-flex align-items-center gap-3">
                        <div class="icon bg-products"><i class="fa-solid fa-shoe-prints"></i></div>
                        <div>
                            <div class="label">Products</div>
                            <div class="value"><?= htmlspecialchars($productsCount) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card d-flex align-items-center gap-3">
                        <div class="icon bg-orders"><i class="fa-solid fa-box"></i></div>
                        <div>
                            <div class="label">Orders</div>
                            <div class="value"><?= htmlspecialchars($ordersCount) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card d-flex align-items-center gap-3">
                        <div class="icon bg-revenue"><i class="fa-solid fa-money-bill-wave"></i></div>
                        <div>
                            <div class="label">Revenue</div>
                            <div class="value">PKR <?= number_format($revenueTotal) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card d-flex align-items-center gap-3">
                        <div class="icon bg-users"><i class="fa-solid fa-users"></i></div>
                        <div>
                            <div class="label">Customers</div>
                            <div class="value"><?= htmlspecialchars($usersCount) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card-table p-3">
                <h6 class="fw-semibold mb-3">Recent Orders</h6>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>color</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($recentOrders) > 0): ?>
                                <?php foreach ($recentOrders as $order): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($order['id']) ?></td>
                                        <td>
                                            <img src="/Complete_e-commerce_store/uploads/<?= htmlspecialchars($order['image']) ?>"
                                                class="product-img" alt="<?= htmlspecialchars($order['product_name']) ?>">
                                        </td>
                                        <td><?= htmlspecialchars($order['full_name']) ?></td>
                                        <td><?= htmlspecialchars($order['phone']) ?></td>
                                        <td><?= htmlspecialchars($order['address']) ?></td>
                                        <td><?= htmlspecialchars($order['city']) ?></td>
                                        <td><?= htmlspecialchars($order['color']) ?></td>
                                        <td>PKR <?= number_format($order['total_price']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-secondary py-3">No orders yet</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>