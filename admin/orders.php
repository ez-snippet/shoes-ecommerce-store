<?php
include __DIR__ . "/../config/db.php";
$current_page = basename($_SERVER['PHP_SELF']);

/* =========================================================
   Confirmed schema (shoes_ecommerce DB):

   products -> id, name, image, price, description, created_at
   orders   -> id, product_id, full_name, phone, email, address,
               city, size, color, quantity, payment_method,
               notes, total_price, created_at

   $conn is assumed to be a mysqli connection object created
   inside db.php (i.e. $conn = new mysqli(...)).
========================================================= */

// --- Handle delete request ---
if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();
    header("Location: orders.php");
    exit;
}

// --- Fetch all orders joined with products ---
$orders = [];
$sql = "SELECT o.id, o.full_name, o.phone, o.email, o.address, o.city,
               o.size, o.color, o.quantity, o.payment_method, o.notes,
               o.total_price, o.created_at, p.name AS product_name, p.image
        FROM orders o
        LEFT JOIN products p ON o.product_id = p.id
        ORDER BY o.created_at DESC";
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
$totalOrders = count($orders);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/dashboard.css">
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/orders.css">
    <link rel="icon" href="/Complete_e-commerce_store/uploads/logo.jpg">
</head>

<body>

    <!-- SVG icon set -->
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
            <symbol id="i-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2M19 6l-1 14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1L5 6M10 11v6M14 11v6" />
            </symbol>
        </defs>
    </svg>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <img src="/Complete_e-commerce_store/uploads/logo.jpg" alt="Logo" class="logo" style="width: 50px; height: 50px; border-radius: 50%;">
            </a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
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
        <!-- /Sidebar -->

        <!-- Main content -->
        <div class="flex-grow-1 p-4">

            <div class="page-head d-flex justify-content-between align-items-end flex-wrap gap-2">
                <div>
                    <h1>Orders</h1>
                   
                </div>
                <span class="count-pill"><?= $totalOrders ?> total</span>
            </div>

            <div class="card-table p-3">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Details</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($totalOrders > 0): ?>
                                <?php foreach ($orders as $order): ?>
                                    <?php
                                    $imagePath  = "/Complete_e-commerce_store/uploads/" . $order['image'];
                                    $serverPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                                    $imageSrc   = (!empty($order['image']) && file_exists($serverPath))
                                        ? $imagePath
                                        : "/Complete_e-commerce_store/uploads/no-image.png";
                                    ?>
                                    <tr>
                                        <td class="muted-id">#<?= htmlspecialchars($order['id']) ?></td>
                                        <td>
                                            <div class="cell-product">
                                                <img src="<?= htmlspecialchars($imageSrc) ?>"
                                                    class="product-img" alt="<?= htmlspecialchars($order['product_name']) ?>">
                                                <span class="strong"><?= htmlspecialchars($order['product_name']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="strong"><?= htmlspecialchars($order['full_name']) ?></div>
                                            <div class="sub"><?= htmlspecialchars($order['phone']) ?></div>
                                        </td>
                                        <td>
                                            <div><?= htmlspecialchars($order['address']) ?></div>
                                            <div class="sub"><?= htmlspecialchars($order['city']) ?></div>
                                        </td>
                                        <td>
                                            <div class="badges">
                                                <span class="badge-soft">Size <?= htmlspecialchars($order['size']) ?></span>
                                                <span class="badge-soft"><?= htmlspecialchars($order['color']) ?></span>
                                                <span class="badge-soft">Qty <?= htmlspecialchars($order['quantity']) ?></span>
                                            </div>
                                        </td>
                                        <td><span class="badge-pay"><?= htmlspecialchars($order['payment_method']) ?></span></td>
                                        <td class="strong nowrap">PKR <?= number_format($order['total_price']) ?></td>
                                        <td class="sub nowrap"><?= htmlspecialchars(date('d M Y', strtotime($order['created_at']))) ?></td>
                                        <td>
                                            <a href="orders.php?delete=<?= (int) $order['id'] ?>"
                                                class="icon-btn danger"
                                                title="Delete"
                                                onclick="return confirm('Delete this order?');">
                                                <svg>
                                                    <use href="#i-trash" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-secondary py-4">No orders found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- /Main content -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>