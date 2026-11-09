<?php
include __DIR__ . "/../config/db.php";
$reviews = mysqli_query($conn, "SELECT * FROM reviews ORDER BY id DESC");
$totalReviews = $reviews ? mysqli_num_rows($reviews) : 0;
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/dashboard.css">
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/review_show.css">
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
                    <h1>Customer Reviews</h1>
                    <p>Customers ne jo reviews diye hain wo yahan dekhein.</p>
                </div>
                <span class="count-pill"><?= $totalReviews ?> total</span>
            </div>

            <div class="card-table p-3">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Rating</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($totalReviews > 0): ?>
                                <?php foreach ($reviews as $review): ?>
                                    <?php
                                    $imagePath  = "/Complete_e-commerce_store/uploads/" . $review['image'];
                                    $serverPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                                    $hasImage   = !empty($review['image']) && file_exists($serverPath);
                                    $ratingRaw  = $review['rating'];
                                    $ratingNum  = is_numeric($ratingRaw) ? max(0, min(5, (int) $ratingRaw)) : null;
                                    ?>
                                    <tr>
                                        <td class="muted-id">#<?= htmlspecialchars($review['id']) ?></td>
                                        <td>
                                            <div class="cell-customer">
                                                <?php if ($hasImage): ?>
                                                    <img src="<?= htmlspecialchars($imagePath) ?>" class="user-img" alt="<?= htmlspecialchars($review['name']) ?>">
                                                <?php else: ?>
                                                    <div class="avatar"><?= htmlspecialchars(strtoupper(mb_substr($review['name'], 0, 1))) ?></div>
                                                <?php endif; ?>
                                                <span class="strong"><?= htmlspecialchars($review['name']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($ratingNum !== null): ?>
                                                <div class="stars" title="<?= $ratingNum ?> / 5">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <svg class="<?= $i <= $ratingNum ? 'on' : 'off' ?>">
                                                            <use href="#i-star" />
                                                        </svg>
                                                    <?php endfor; ?>
                                                    <span class="rate-num"><?= $ratingNum ?>/5</span>
                                                </div>
                                            <?php else: ?>
                                                <span class="stars-text"><?= htmlspecialchars($ratingRaw) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="msg-text"><?= nl2br(htmlspecialchars($review['message'])) ?></td>
                                        <td class="sub nowrap"><?= htmlspecialchars(date('d M Y', strtotime($review['created_at']))) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-secondary py-4">No reviews yet</td>
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