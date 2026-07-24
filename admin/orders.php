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
    <a class="nav-link text-danger" href="../admin/logout.php">
        <i class="fa-solid fa-arrow-right-to-bracket"></i> Logout
    </a>
</li>
            </ul>
        </div>

        <!-- Main content -->
        <div class="flex-grow-1 p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold mb-0">All Orders <span class="text-secondary fw-normal">(<?= $totalOrders ?>)</span></h5>
            </div>

            <div class="card-table p-3">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>city</th>
                                <th>size</th>
                                <th>color</th>
                                <th>Quanity</th>
                                <th>Pyment Method</th>
                                <th>price</th>
                                <th>orderdate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($totalOrders > 0): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($order['id']) ?></td>
                                        <td>
                                            <img src="/Complete_e-commerce_store/uploads/<?= htmlspecialchars($order['image']) ?>"
                                                class="product-img" alt="<?= htmlspecialchars($order['product_name']) ?>">
                                        </td>
                                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                                        <td><?= htmlspecialchars($order['full_name']) ?></td>
                                        <td><?= htmlspecialchars($order['phone']) ?></td>
                                        <td><?= htmlspecialchars($order['address']) ?></td>
                                        <td><?= htmlspecialchars($order['city']) ?></td>
                                        <td><?= htmlspecialchars($order['size']) ?></td>
                                        <td><?= htmlspecialchars($order['color']) ?></td>
                                        <td><?= htmlspecialchars($order['quantity']) ?></td>
                                        <td><?= htmlspecialchars($order['payment_method']) ?></td>
                                        <td>PKR <?= number_format($order['total_price']) ?></td>
                                        <td><?= htmlspecialchars(date('d M Y', strtotime($order['created_at']))) ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="orders.php?delete=<?= $order['id'] ?>"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Delete"
                                                    onclick="return confirm('Delete this order?');">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="14" class="text-center text-secondary py-3">No orders found</td>
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
