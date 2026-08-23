<?php
include __DIR__ . "/../config/db.php";

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

if ($order_id > 0) {
    $sql = "SELECT o.*, p.name as product_name, p.price as product_price 
            FROM orders o 
            JOIN products p ON o.product_id = p.id 
            WHERE o.id = $order_id";
    $result = mysqli_query($conn, $sql);
    $order = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f7fb; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .success-card { background: white; max-width: 600px; width: 100%; padding: 40px; border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); text-align: center; }
        .icon { font-size: 64px; margin-bottom: 16px; }
        h1 { color: #1a2a3a; font-size: 28px; margin-bottom: 8px; }
        .subhead { color: #6b7a8a; font-size: 16px; margin-bottom: 24px; }
        .order-details { text-align: left; background: #f8f9fc; border-radius: 12px; padding: 20px; margin: 20px 0; }
        .order-details p { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eef0f4; }
        .order-details p:last-child { border-bottom: none; }
        .label { color: #6b7a8a; font-weight: 500; }
        .value { color: #1a2a3a; font-weight: 600; }
        .btn-home { display: inline-block; background: #1a2a3a; color: white; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 8px; }
        .btn-home:hover { background: #2a3a4a; }
    </style>
</head>
<body>
<div class="success-card">
    <div class="icon">✅</div>
    <h1>Order Placed Successfully!</h1>
    <p class="subhead">Thank you for your order. We'll process it shortly.</p>
    
    <?php if (isset($order) && $order): ?>
    <div class="order-details">
        <p><span class="label">Order ID</span><span class="value">#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></span></p>
        <p><span class="label">Product</span><span class="value"><?php echo htmlspecialchars($order['product_name']); ?></span></p>
        <p><span class="label">Size</span><span class="value"><?php echo htmlspecialchars($order['size']); ?></span></p>
        <p><span class="label">Color</span><span class="value"><?php echo htmlspecialchars($order['color']); ?></span></p>
        <p><span class="label">Quantity</span><span class="value"><?php echo $order['quantity']; ?></span></p>
        <p><span class="label">Total Amount</span><span class="value">Rs. <?php echo number_format($order['total_price']); ?></span></p>
        <p><span class="label">Payment Method</span><span class="value"><?php echo htmlspecialchars($order['payment_method']); ?></span></p>
        <p><span class="label">Delivery Address</span><span class="value"><?php echo htmlspecialchars($order['address'] . ', ' . $order['city']); ?></span></p>
    </div>
    <?php endif; ?>
    
    <a href="../includes/index.php" class="btn-home">Continue Shopping</a>
</div>
</body>
</html>