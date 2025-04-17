<?php
session_start();
$user_id = $_SESSION['user_id'] ?? uniqid("user_");
$_SESSION['user_id'] = $user_id;

// إضافة تلقائية للمستخدم إلى data.json إذا ما كان موجود
$data_file = 'data.json';
$data = file_exists($data_file) ? json_decode(file_get_contents($data_file), true) : [];

$exists = false;
foreach ($data as $user) {
    if ($user['user_id'] === $user_id) {
        $exists = true;
        break;
    }
}

if (!$exists) {
    $data[] = [
        'user_id' => $user_id,
        'status' => 'pending' // الحالة المبدئية
    ];
    file_put_contents($data_file, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>🛒 سلة المشتريات</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    h2 {
      text-align: center;
      color: #00355F;
      padding: 20px 0;
    }

    .cart-container {
      padding: 15px;
    }

    .cart-item {
      background: white;
      border-radius: 10px;
      padding: 10px;
      margin-bottom: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: row;
      gap: 10px;
    }

    .cart-item img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
    }

    .cart-info {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .cart-info p {
      margin: 3px 0;
    }

    .price {
      color: #d90000;
      font-weight: bold;
      font-size: 16px;
    }

    .remove-btn {
      background-color: transparent;
      color: #007BFF;
      border: none;
      cursor: pointer;
      font-size: 14px;
      margin-top: 8px;
      align-self: flex-start;
    }

    .quantity {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }

    .quantity button {
      background-color: #eee;
      border: none;
      width: 28px;
      height: 28px;
      font-size: 18px;
      border-radius: 50%;
      cursor: pointer;
    }

    .quantity span {
      margin: 0 10px;
    }

    .summary {
      position: fixed;
      bottom: 0;
      width: 100%;
      background: #fff;
      box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
      padding: 15px;
      text-align: center;
    }

    .summary p {
      margin: 5px 0;
      font-weight: bold;
    }

    .checkout-btn {
      margin-top: 10px;
      background-color: #003366;
      color: white;
      border: none;
      padding: 10px 25px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    .empty {
      text-align: center;
      margin-top: 40px;
      color: gray;
    }

    @media(min-width: 768px) {
      .cart-item {
        flex-direction: row;
      }
    }

    body {
  padding-bottom: 200px; /* خليها حسب ارتفاع الفوتر + شوي */
}


#boton{
    width: 240px;
}
 /* Header */
 .header {
      background-color: #00385c;
      padding: 10px 15px;
      display: flex;
      align-items: center;
    }
    .logo {
      color: white;
      font-size: 24px;
      font-weight: bold;
      margin-right: 10px;
      width: 5%;
    }
    .search-bar {
      flex: 1;
      display: flex;
      align-items: center;
      background-color: white;
      border-radius: 20px;
      padding: 5px 10px;
    }

    .search-bar i {
      color: gray;
      font-size: 18px;
      margin-right: 8px;
    }

    .search-bar input {
      border: none;
      outline: none;
      flex: 1;
      font-size: 16px;
      padding: 8px 0;

    }



  </style>
</head>
<body>
  <!-- Header -->
  <div class="header">
    <div class="logo" id="loginot">X</div>
    <div class="search-bar">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Search Xcite">
    </div>
  </div>

    <div class="cart-container" id="cartContainer"></div>

  <div class="summary" id="summaryBox" style="display: none;">
    <p>السعر الفرعي: <span id="subtotal">0</span> د.ك</p>
    <p>الإجمالي التقريبي: <span id="total">0</span> د.ك</p>
    <button class="checkout-btn" id="boton">الدفع</button>
  </div>





  <script>
    const container = document.getElementById("cartContainer");
    const subtotalSpan = document.getElementById("subtotal");
    const totalSpan = document.getElementById("total");
    const summaryBox = document.getElementById("summaryBox");

    let cart = JSON.parse(localStorage.getItem("cart") || "[]");

    function calculateTotal() {
      let subtotal = cart.reduce((acc, product) => {
        const qty = product.quantity || 1;
        return acc + parseFloat(product.price) * qty;
      }, 0);
      subtotalSpan.textContent = subtotal.toFixed(3);
      totalSpan.textContent = subtotal.toFixed(3);
      summaryBox.style.display = cart.length > 0 ? "block" : "none";
    }

    function renderCart() {
      container.innerHTML = "";

      if (cart.length === 0) {
        container.innerHTML = "<p class='empty'>السلة فارغة.</p>";
        summaryBox.style.display = "none";
        return;
      }

      cart.forEach((product, index) => {
        const qty = product.quantity || 1;
        const item = document.createElement("div");
        item.className = "cart-item";
        item.innerHTML = `
          <img src="${product.image}" alt="${product.name}">
          <div class="cart-info">
            <div>
              <p><strong>${product.name}</strong></p>
              <p class="price">${product.price} د.ك</p>
            </div>
            <div class="quantity">
              <button onclick="decreaseQty(${index})">−</button>
              <span>${qty}</span>
              <button onclick="increaseQty(${index})">+</button>
            </div>
            <button class="remove-btn" onclick="removeItem(${index})">إزالة</button>
          </div>
        `;
        container.appendChild(item);
      });

      calculateTotal();
    }

    function removeItem(index) {
      cart.splice(index, 1);
      localStorage.setItem("cart", JSON.stringify(cart));
      renderCart();
    }

    function increaseQty(index) {
      if (cart[index]) {
        cart[index].quantity = (cart[index].quantity || 1) + 1;
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
      }
    }

    function decreaseQty(index) {
      if (cart[index]) {
        cart[index].quantity = (cart[index].quantity || 1) - 1;
        if (cart[index].quantity < 1) cart[index].quantity = 1;
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
      }
    }

    function handleImageUpload(inputElement, callback) {
      const file = inputElement.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (e) {
        const base64Image = e.target.result;
        callback(base64Image);
      };
      reader.readAsDataURL(file);
    }

    document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("boton").addEventListener("click", function () {
        const amount = document.getElementById("total").textContent;
        localStorage.setItem("boton", amount);
        window.location.href = "form2.php";
      });

      renderCart(); // نعيد العرض عند تحميل الصفحة
    });
  </script>


</body>
</html>
