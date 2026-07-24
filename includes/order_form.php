<?php
include __DIR__ . "/../config/db.php";

// Get product ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// If no ID is provided, show error instead of redirecting
if ($id == 0) {
  $error = "No product selected. Please go back and select a product.";
  $product = null;
} else {
  // Fetch product details
  $sql = "SELECT * FROM products WHERE id='$id'";
  $result = mysqli_query($conn, $sql);
  $product = mysqli_fetch_assoc($result);

  // If product not found, show error instead of redirecting
  if (!$product) {
    $error = "Product not found. Please go back and select a valid product.";
  }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $product) {
  // Get form data
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $city = mysqli_real_escape_string($conn, $_POST['city']);
  $size = mysqli_real_escape_string($conn, $_POST['size']);
  $color = mysqli_real_escape_string($conn, $_POST['color']);
  $quantity = (int)$_POST['quantity'];
  $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
  $notes = mysqli_real_escape_string($conn, $_POST['notes']);
  $product_id = $product['id'];
  $total_price = $product['price'] * $quantity;

  // Insert into orders table
  $insert_sql = "INSERT INTO orders (
        product_id, 
        full_name, 
        phone, 
        email, 
        address, 
        city, 
        size, 
        color, 
        quantity, 
        payment_method, 
        notes, 
        total_price
    ) VALUES (
        '$product_id',
        '$full_name',
        '$phone',
        '$email',
        '$address',
        '$city',
        '$size',
        '$color',
        '$quantity',
        '$payment_method',
        '$notes',
        '$total_price'
    )";

  if (mysqli_query($conn, $insert_sql)) {
    $order_id = mysqli_insert_id($conn);
    // Redirect to success page with order ID
    header("Location: order_success.php?order_id=" . $order_id);
    exit();
  } else {
    $error = "Error placing order: " . mysqli_error($conn);
  }
}

// Set default values
$default_size = '40';
$default_color = 'Black';
$default_quantity = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complete Your Order <?php echo $product ? '· ' . htmlspecialchars($product['name']) : ''; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/style/order_form.css">
  <style>
    /* Additional inline styles for specific elements */
    .input-with-icon {
      position: relative;
    }

    .input-with-icon .icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #8a9bb0;
      font-size: 1rem;
    }

    .input-with-icon input {
      padding-left: 40px !important;
    }

    .field-group-required label::after {
      content: '*';
      color: #dc2626;
      margin-left: 4px;
    }
  </style>
</head>

<body>

  <?php if (isset($error) && !$product): ?>
    <div style="max-width: 800px; margin: 40px auto; padding: 40px; background: #fff; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); text-align: center;">
      <div style="font-size: 56px; margin-bottom: 16px;">🔍</div>
      <h2 style="color: #0b1a2a; margin-bottom: 8px;">Product Not Found</h2>
      <p style="color: #6b7e9b; margin-bottom: 24px;"><?php echo htmlspecialchars($error); ?></p>
      <a href="../includes/home.php" style="display: inline-block; background: #0b1a2a; color: white; padding: 12px 32px; border-radius: 12px; text-decoration: none; font-weight: 600; transition: 0.2s;">Go Back to Shopping</a>
    </div>
    <?php exit(); ?>
  <?php endif; ?>

  <?php if (isset($error) && $product): ?>
    <div class="error-message">
      ⚠️ <?php echo htmlspecialchars($error); ?>
    </div>
  <?php endif; ?>

  <div class="card">
    <h1>Complete Your Order</h1>
    <div class="subhead">Please fill in your details to place your order</div>

    <form method="POST" action="" id="orderForm">
      <div class="order-grid">
        <!-- LEFT COLUMN -->
        <div class="left-col">
          <!-- Customer Information -->
          <div>
            <div class="section-title">Customer Information</div>

            <div class="field-group field-group-required">
              <label for="full_name">Full Name</label>
              <div class="input-with-icon">
                <span class="icon">👤</span>
                <input type="text" id="full_name" name="full_name" placeholder="Enter your full name"  required>
              </div>
            </div>

            <div class="field-group field-group-required">
              <label for="phone">Phone Number</label>
              <div class="input-with-icon">
                <span class="icon">📱</span>
                <input type="text" id="phone" name="phone" placeholder="03XX-XXXXXXX"  required>
              </div>
              <div class="phone-hint">Format: 03XX-XXXXXXX</div>
            </div>

            <div class="field-group field-group-required">
              <label for="email">Email Address</label>
              <div class="input-with-icon">
                <span class="icon">✉️</span>
                <input type="email" id="email" name="email" placeholder="Enter your email"  required>
              </div>
            </div>

            <div class="field-group field-group-required">
              <label for="address">Address</label>
              <div class="input-with-icon">
                <span class="icon">🏠</span>
                <input type="text" id="address" name="address" placeholder="House No, Street, Area"  required>
              </div>
            </div>

            <div class="field-group field-group-required">
              <label for="city">City</label>
              <div class="input-with-icon">
                <span class="icon">📍</span>
                <input type="text" id="city" name="city" placeholder="Enter your city" required>
              </div>
            </div>
          </div>

          <!-- Order Details -->
          <div>
            <div class="section-title">Order Details</div>

            <div class="product-row">
              <span class="label">Product</span>
              <span class="value"><?php echo htmlspecialchars($product['name']); ?></span>
            </div>
            <div class="product-row">
              <span class="label">Price</span>
              <span class="value price">Rs. <?php echo number_format($product['price']); ?></span>
            </div>

            <div style="margin-top: 1rem;">
              <div style="font-weight: 600; font-size: 0.78rem; color: #2b3a57; margin-bottom: 0.2rem;">Size *</div>
              <div class="chip-group" id="sizeGroup">
                <?php
                $sizes = [38, 39, 40, 41, 42, 43, 44];
                foreach ($sizes as $size):
                ?>
                  <span class="chip <?php echo ($size == $default_size) ? 'active' : ''; ?>" data-value="<?php echo $size; ?>"><?php echo $size; ?></span>
                <?php endforeach; ?>
              </div>
              <input type="hidden" name="size" id="selectedSize" value="<?php echo $default_size; ?>">
            </div>

            <div style="margin-top: 0.8rem;">
              <div style="font-weight: 600; font-size: 0.78rem; color: #2b3a57; margin-bottom: 0.2rem;">Color *</div>
              <div class="chip-group" id="colorGroup">
                <?php
                $colors = [
                  ['name' => 'Black', 'bg' => '#111'],
                  ['name' => 'Brown', 'bg' => ' #8B4513', 'border' => true],
                ];
                foreach ($colors as $color):
                ?>
                  <span class="chip color-chip <?php echo ($color['name'] == $default_color) ? 'active' : ''; ?>" data-value="<?php echo $color['name']; ?>">
                    <span class="color-dot" style="background:<?php echo $color['bg']; ?>; <?php echo isset($color['border']) ? 'border:1.5px solid #c5d2e0;' : ''; ?>"></span>
                    <?php echo $color['name']; ?>
                  </span>
                <?php endforeach; ?>
              </div>
              <input type="hidden" name="color" id="selectedColor" value="<?php echo $default_color; ?>">
            </div>

            <div style="margin-top: 0.8rem;">
              <div style="font-weight: 600; font-size: 0.78rem; color: #2b3a57; margin-bottom: 0.2rem;">Quantity *</div>
              <div class="quantity-wrapper">
                <button type="button" onclick="decreaseQuantity()" style="width: 36px; height: 36px; border-radius: 50%; border: 1.5px solid #e4e9f2; background: #fafcff; cursor: pointer; font-size: 1.2rem; font-weight: 600; color: #0b1a2a; transition: 0.2s;">−</button>
                <input type="number" name="quantity" id="quantity" value="<?php echo $default_quantity; ?>" min="1" max="10">
                <button type="button" onclick="increaseQuantity()" style="width: 36px; height: 36px; border-radius: 50%; border: 1.5px solid #e4e9f2; background: #fafcff; cursor: pointer; font-size: 1.2rem; font-weight: 600; color: #0b1a2a; transition: 0.2s;">+</button>
              </div>
            </div>

            <!-- Payment Method -->
            <div style="margin-top: 1.2rem;">
              <div style="font-weight: 600; font-size: 0.78rem; color: #2b3a57; margin-bottom: 0.4rem;">Payment Method *</div>
              <div class="payment-group">
                <div class="payment-item">
                  <input type="radio" name="payment_method" id="cod" value="Cash on Delivery" checked>
                  <label for="cod">Cash on Delivery (COD)</label>
                </div>
              </div>
            </div>

            <!-- Order Notes -->
            <div class="order-notes">
              <label for="notes" style="font-weight: 600; font-size: 0.78rem; color: #2b3a57; display: block; margin-bottom: 0.3rem;">Order Notes (Optional)</label>
              <textarea id="notes" name="notes" placeholder="Write any notes about your order...">Leave at the reception</textarea>
            </div>

            <!-- Complete Order Button -->
            <button type="submit" class="btn-complete">
              <span>Complete Order</span>
              <span class="arrow">→</span>
            </button>
            <div class="secure-note">🔒 Your information is safe and secure</div>
          </div>
        </div>

        <!-- RIGHT COLUMN: Order Summary -->
        <div class="right-col">
          <div>
            <div class="section-title" style="border-bottom: none; margin-bottom: 0.5rem;">Order Summary</div>
            <div class="summary-card">
              <div class="summary-item">
                <span class="label"><?php echo htmlspecialchars($product['name']); ?></span>
                <span class="value">Rs. <?php echo number_format($product['price']); ?></span>
              </div>
              <div class="summary-item">
                <span class="label">Size</span>
                <span class="value" id="summarySize"><?php echo $default_size; ?></span>
              </div>
              <div class="summary-item">
                <span class="label">Color</span>
                <span class="value" id="summaryColor"><?php echo $default_color; ?></span>
              </div>
              <div class="summary-item">
                <span class="label">Quantity</span>
                <span class="value" id="summaryQuantity"><?php echo $default_quantity; ?></span>
              </div>
              <div class="summary-total">
                <span class="total-label">Total</span>
                <span id="summaryTotal">Rs. <?php echo number_format($product['price']); ?></span>
              </div>
              <div class="summary-confirm">
                Your order will be confirmed after successful payment.
              </div>
            </div>
          </div>

          <div style="flex:1; min-height: 20px;"></div>
        </div>
      </div>
    </form>
  </div>

  <script>
    // Quantity buttons
    function decreaseQuantity() {
      const input = document.getElementById('quantity');
      let value = parseInt(input.value) || 1;
      if (value > 1) {
        value--;
        input.value = value;
        updateSummary();
      }
    }

    function increaseQuantity() {
      const input = document.getElementById('quantity');
      let value = parseInt(input.value) || 1;
      if (value < 10) {
        value++;
        input.value = value;
        updateSummary();
      }
    }

    // Dynamic update for size selection
    document.querySelectorAll('#sizeGroup .chip').forEach(chip => {
      chip.addEventListener('click', function() {
        document.querySelectorAll('#sizeGroup .chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        const value = this.dataset.value;
        document.getElementById('selectedSize').value = value;
        document.getElementById('summarySize').textContent = value;
        updateTotal();
      });
    });

    // Dynamic update for color selection
    document.querySelectorAll('#colorGroup .chip').forEach(chip => {
      chip.addEventListener('click', function() {
        document.querySelectorAll('#colorGroup .chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        const value = this.dataset.value;
        document.getElementById('selectedColor').value = value;
        document.getElementById('summaryColor').textContent = value;
      });
    });

    // Update quantity and total
    document.getElementById('quantity').addEventListener('change', function() {
      updateSummary();
    });

    function updateSummary() {
      const quantity = parseInt(document.getElementById('quantity').value) || 1;
      document.getElementById('summaryQuantity').textContent = quantity;
      updateTotal();
    }

    function updateTotal() {
      const quantity = parseInt(document.getElementById('quantity').value) || 1;
      const price = <?php echo $product['price']; ?>;
      const total = price * quantity;
      document.getElementById('summaryTotal').textContent = 'Rs. ' + total.toLocaleString();
    }
  </script>

</body>

</html>