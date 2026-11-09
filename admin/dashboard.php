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
</head>

<body>

    <!-- SVG icon set (defined once, used below with <use>) -->
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <symbol id="i-home" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="9" rx="2" />
                <rect x="14" y="3" width="7" height="5" rx="2" />
                <rect x="14" y="12" width="7" height="9" rx="2" />
                <rect x="3" y="16" width="7" height="5" rx="2" />
            </symbol>
            <symbol id="i-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 8v8M8 12h8" />
            </symbol>
            <symbol id="i-bag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2h12l2 5v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7z" />
                <path d="M4 7h16M9 11a3 3 0 0 0 6 0" />
            </symbol>
            <symbol id="i-chat" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12a8 8 0 0 1-11.5 7.2L3 21l1.8-5.5A8 8 0 1 1 21 12z" />
            </symbol>
            <symbol id="i-star" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1 6.2L12 17.2 6.5 20.2l1-6.2L3 9.6l6.2-.9z" />
            </symbol>
            <symbol id="i-megaphone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 11v2a1 1 0 0 0 1 1h3l8 5V5L7 10H4a1 1 0 0 0-1 1z" />
                <path d="M19 9a4 4 0 0 1 0 6" />
            </symbol>
            <symbol id="i-logout" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" />
            </symbol>
            <symbol id="i-package" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 8l-9-5-9 5 9 5zM3 8v8l9 5 9-5V8M12 13v8" />
            </symbol>
            <symbol id="i-wallet" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="6" width="20" height="12" rx="2" />
                <circle cx="12" cy="12" r="3" />
                <path d="M6 12h.01M18 12h.01" />
            </symbol>
            <symbol id="i-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="8" r="3.5" />
                <path d="M2 20a7 7 0 0 1 14 0M16 4.5a3.5 3.5 0 0 1 0 7M22 20a7 7 0 0 0-4-6.3" />
            </symbol>
        </defs>
    </svg>

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
                        <div class="admin-chip">
                            <div class="admin-avatar">A</div>
                            <span>Welcome, Admin</span>
                        </div>
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
                        <svg>
                            <use href="#i-home" />
                        </svg>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'add_product.php' ? 'active' : '' ?>" href="add_product.php">
                        <svg>
                            <use href="#i-plus" />
                        </svg>Add Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'orders.php' ? 'active' : '' ?>" href="orders.php">
                        <svg>
                            <use href="#i-bag" />
                        </svg>Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'user_message_show.php' ? 'active' : '' ?>" href="user_message_show.php">
                        <svg>
                            <use href="#i-chat" />
                        </svg>Customer Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'reviews_show.php' ? 'active' : '' ?>" href="reviews_show.php">
                        <svg>
                            <use href="#i-star" />
                        </svg>Reviews
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'acnounch.php' ? 'active' : '' ?>" href="acnounch.php">
                        <svg>
                            <use href="#i-megaphone" />
                        </svg>Announcements
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-danger" href="../admin/logout.php">
                        <svg>
                            <use href="#i-logout" />
                        </svg>Logout
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
                        <div class="icon bg-products"><svg>
                                <use href="#i-package" />
                            </svg></div>
                        <div>
                            <div class="label">Products</div>
                            <div class="value"><?= htmlspecialchars($productsCount) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card d-flex align-items-center gap-3">
                        <div class="icon bg-orders"><svg>
                                <use href="#i-bag" />
                            </svg></div>
                        <div>
                            <div class="label">Orders</div>
                            <div class="value"><?= htmlspecialchars($ordersCount) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card d-flex align-items-center gap-3">
                        <div class="icon bg-revenue"><svg>
                                <use href="#i-wallet" />
                            </svg></div>
                        <div>
                            <div class="label">Revenue</div>
                            <div class="value">PKR <?= number_format($revenueTotal) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card d-flex align-items-center gap-3">
                        <div class="icon bg-users"><svg>
                                <use href="#i-users" />
                            </svg></div>
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
                                <th>Color</th>
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
                                    <td colspan="8" class="text-center text-secondary py-4">No orders yet</td>
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