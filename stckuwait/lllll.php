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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>متجر إلكتروني</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- أيقونات Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      background-color: #f0f0f0;
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

    /* Bottom Navigation */
    .bottom-nav {
      position: fixed;
      bottom: 0;
      width: 100%;
      background-color: #00385c;
      display: flex;
      justify-content: space-around;
      align-items: center;
      padding: 15px 0;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .nav-item {
      color: white;
      font-size: 24px;
      transition: color 0.3s;
    }

    .nav-item.active i {
      color: #7bc8f6;
    }

    .nav-item i {
      display: block;
    }

    .nav-item:hover {
      color: #7bc8f6;
    }

    /* محتوى الصفحة */
    .content {
      padding: 20px;
      margin-bottom: 100px; /* مساحة لتفادي تغطية التذييل */
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
    }

    .product-card {
      position: relative;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      padding: 15px;
      text-align: center;
    }

    .product-card img {
      width: 100%;
      height: 170px;
      object-fit: contain;
      border-radius: 10px;
      margin-top: 20px;
    }

    .badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background-color: #4CAF50;
      color: white;
      font-size: 12px;
      padding: 4px 10px;
      border-radius: 4px;
    }

    .fav {
      position: absolute;
      top: 10px;
      right: 10px;
      background: white;
      border-radius: 50%;
      width: 32px;
      height: 32px;
      line-height: 32px;
      font-size: 18px;
      color: #444;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
      cursor: pointer;
    }

    .fav:hover {
      color: red;
    }

    .product-card h4 {
      margin: 10px 0 5px;
      font-weight: bold;
    }

    .product-card .desc {
      font-size: 14px;
      color: #444;
      margin-bottom: 10px;
    }

    .product-card .price {
      font-size: 18px;
      font-weight: bold;
      color: #000;
      margin-bottom: 15px;
    }

    .product-card button {
      background-color: #003f66;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 8px;
      font-size: 15px;
      width: 100%;
      cursor: pointer;
    }

    .product-card button:hover {
      background-color: #005a99;
    }


    .cart-icon {
  position: relative;
}

.cart-count {
  position: absolute;
  top: -8px;
  right: -10px;
  background-color: red;
  color: white;
  font-size: 12px;
  padding: 2px 6px;
  border-radius: 50%;
  font-weight: bold;
  animation: none;
  transition: transform 0.2s;
}

.cart-icon.shake {
  animation: shake 0.4s;
}

@keyframes shake {
  0% { transform: translate(0, 0); }
  25% { transform: translate(-2px, 2px); }
  50% { transform: translate(2px, -2px); }
  75% { transform: translate(-2px, 2px); }
  100% { transform: translate(0, 0); }
}
#hagg {
    text-decoration: line-through;
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
      <i class="fas fa-microphone"></i>
    </div>
  </div>




 <!-- اظافة المنتجات --> 

  <div class="content">
    <h2> خصومات تصل الى 50% ليوم واحد فقط</h2>

    <div class="product-grid">



    <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="imgo0.png" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>عرض خاص </h4>
        <p class="desc">
اشتر مكيف سبليت واحصل على شاشة هدية ( السعر شامل التوصيل 255 دينار بس)        </p>
        <p class="price">255.900 KD</p>
        <p id="hagg"> 510 دينار</p>
        <button>Add to cart</button>
      </div>




      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="imgo.webp" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>Samsung </h4>
        <p class="desc">Samsung S25 Ultra 5G, 6.9-inch, 12GB RAM, 256GB - Titanium Blue
        </p>
        <p class="price">72.900 KD</p>
        <p id="hagg"> 144 دينار</p>
        <button>Add to cart</button>
      </div>

      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/549887-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>Samsung </h4>
        <p class="desc">Samsung Galaxy S24 FE, 6.7-inch, 256GB, 8GB RAM, 5G Phone, SM-S721BLBCMEA - Blue
        </p>
        <p class="price">72.900 KD</p>
        <p id="hagg"> 144 دينار</p>
        <button>Add to cart</button>
      </div>

      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/551224-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>Samsung </h4>
        <p class="desc">Samsung S25 Ultra 5G, 6.9-inch, 12GB RAM, 256GB - Titanium White Silver
        </p>
        <p class="price">172.900 KD</p>
        <p id="hagg"> 344 دينار</p>

        <button>Add to cart</button>
      </div>


      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/551223-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>Samsung </h4>
        <p class="desc">Samsung S25 Ultra 5G, 6.9-inch, 12GB RAM, 256GB - Titanium Gray
        </p>
        <p class="price">172.900 KD</p>
        <p id="hagg"> 344 دينار</p>

        <button>Add to cart</button>
      </div>


      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/547031-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>LENOVO </h4>
        <p class="desc">Lenovo Yoga Book 9 Convertible Laptop, Intel Core Ultra 7, 16GB RAM, 1TB SSD, Intel Graphics, 13.3-inch, Windows 11 Home, 83FF000KAX - Teal
        </p>
        <p class="price">269.500 KD</p>
        <p id="hagg"> 538 دينار</p>

        <button>Add to cart</button>
      </div>


      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/655165-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>APPLE </h4>
        <p class="desc">Apple MacBook Pro M3, 18GB RAM, 512GB SSD, 16-Inch Laptop – Space Black
        </p>
        <p class="price">349.400 KD</p>
        <p id="hagg"> 698 دينار</p>

        <button>Add to cart</button>
      </div>


      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/548406-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>HEWLETT PACKARD </h4>
        <p class="desc">HP OmniBook X Laptop, Snapdragon X Elite, 16GB RAM, 1TB SSD, Qualcomm Adreno, 14-inch, Windows 11 Home, 14-FE0001NE – Silver
        </p>
        <p class="price">149.400 KD</p>
        <p id="hagg"> 298 دينار</p>

        <button>Add to cart</button>
      </div>

      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/545193-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>WANSA DIAMOND
        </h4>
        <p class="desc">Wansa Diamond Split AC, 27K BTU, Wi-fi Connection, WSUC27CMDS-24 - White
        </p>
        <p class="price">144.400 KD</p>
        <p id="hagg"> 288 دينار</p>

        <button>Add to cart</button>
      </div>


      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/537476-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>HAIER 
        </h4>
        <p class="desc">Haier Split AC With UV, 19100 BTU, Cooling Only (HSU-24LPA03/R2(T3) - White
        </p>
        <p class="price">144.400 KD</p>
        <p id="hagg"> 288 دينار</p>

        <button>Add to cart</button>
      </div>




      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/541355-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>WANSA DIAMOND

        </h4>
        <p class="desc">Wansa Diamond Split AC Inverter, 26000 BTU, Cooling Only (WSUC26CMDIS) - White
        </p>
        <p class="price">144.400 KD</p>
        <p id="hagg"> 288 دينار</p>

        <button>Add to cart</button>
      </div>


      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/542526-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>PHILIPS 

        </h4>
        <p class="desc">Philips Bottom Load Water Dispenser, ADD4962WH/56 – White
        </p>
        <p class="price">24.400 KD</p>
        <p id="hagg"> 48 دينار</p>

        <button>Add to cart</button>
      </div>

      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/538157-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>PHILIPS 

        </h4>
        <p class="desc">Philips Bottom Load Water Dispenser (ADD4970WHS/56) White
        </p>
        <p class="price">29.400 KD</p>
        <p id="hagg"> 58 دينار</p>

        <button>Add to cart</button>
      </div>




      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/538157-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>WANSA 

        </h4>
        <p class="desc">Wansa Water Dispenser 3 Tap Hot & Cold, WWD3FSRBC1 - Black
        </p>
        <p class="price">14.200 KD</p>
        <p id="hagg"> 28 دينار</p>

        <button>Add to cart</button>
      </div>



      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/531144-01?img404=default&w=1080&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>PHILIPS 

        </h4>
        <p class="desc">Philips Bottom Load Water Dispenser (ADD4968BK/56) - Black
        </p>
        <p class="price">34.200 KD</p>
        <p id="hagg"> 68 دينار</p>

        <button>Add to cart</button>
      </div>

      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/548479-01?img404=default&w=2048&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>WANSA 

        </h4>
        <p class="desc">Wansa 4K UHD 55 -inch Smart Google TV, WLE55NGT63 - Black
        </p>
        <p class="price">44.200 KD</p>
        <p id="hagg"> 88 دينار</p>

        <button>Add to cart</button>
      </div>

      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/548480-01?img404=default&w=2048&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>WANSA 

        </h4>
        <p class="desc">Wansa 4K UHD 65 -inch Smart Google TV, WLE65NGT63 - Black
        </p>
        <p class="price">64.200 KD</p>
        <p id="hagg"> 128 دينار</p>

        <button>Add to cart</button>
      </div>


      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/548387-01?img404=default&w=2048&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>SONY 

        </h4>
        <p class="desc">Sony Bravia 7 85-inch 4K Mini LED HDR Google TV, K-85XR70 – Black
        </p>
        <p class="price">490.200 KD</p>
        <p id="hagg"> 980 دينار</p>

        <button>Add to cart</button>
      </div>


      <div class="product-card">
        <span class="badge">خصم%50 </span>
        <img src="https://cdn.media.amplience.net/i/xcite/548498-01?img404=default&w=2048&qlt=75&fmt=auto" alt="iTunes 500">
        <div class="fav">♡</div>
        <h4>SONY 

        </h4>
        <p class="desc">SONY 65" Bravia 8 OLED Google TV, K-65XR80– Black
        </p>
        <p class="price">334.200 KD</p>
        <p id="hagg"> 668 دينار</p>

        <button>Add to cart</button>
      </div>




    </div>
  </div>





  <!-- Bottom Navigation -->
  <div class="bottom-nav">
    <div class="nav-item">
      <i class="fas fa-home"></i>
    </div>
    <div class="nav-item">
      <i class="fas fa-user"></i>
    </div>
    <div class="nav-item active cart-icon">
      <i class="fas fa-shopping-cart"></i>
      <span class="cart-count"></span>
    </div>

    <div class="nav-item">
      <i class="fas fa-bars"></i>
    </div>
  </div>

  <script>
    // تحميل العداد من السلة المخزنة
    const cartIcon = document.querySelector(".cart-icon");
    const cartCountEl = document.querySelector(".cart-count");
    let cart = JSON.parse(localStorage.getItem("cart") || "[]");
    let cartCount = cart.reduce((acc, item) => acc + (item.quantity || 1), 0);
    cartCountEl.textContent = cartCount;
    localStorage.setItem("cartCount", cartCount);

    // عند الضغط على زر "Add to cart"
    document.querySelectorAll(".product-card button").forEach((button) => {
      button.addEventListener("click", () => {
        const card = button.closest(".product-card");
        const name = card.querySelector(".desc").textContent;
        const priceText = card.querySelector(".price").textContent;
        const image = card.querySelector("img").src;
        const price = parseFloat(priceText.split(" ")[0]);

        // تحديث السلة
        let cart = JSON.parse(localStorage.getItem("cart") || "[]");
        const existing = cart.find(item => item.name === name && item.image === image);
        if (existing) {
          existing.quantity = (existing.quantity || 1) + 1;
        } else {
          cart.push({ name, price, image, quantity: 1 });
        }

        // تحديث العداد بناءً على السلة الجديدة
        cartCount = cart.reduce((acc, item) => acc + (item.quantity || 1), 0);
        cartCountEl.textContent = cartCount;

        // حفظ التحديثات
        localStorage.setItem("cart", JSON.stringify(cart));
        localStorage.setItem("cartCount", cartCount);

        // تأثير الحركة
        cartIcon.classList.add("shake");
        setTimeout(() => {
          cartIcon.classList.remove("shake");
        }, 400);
      });
    });

    // الانتقال لصفحة السلة عند الضغط على الأيقونة
    cartIcon.addEventListener("click", () => {
      window.location.href = "cart.php";
    });

    document.getElementById("loginot").addEventListener("click", function () {
      window.location.href = "home.html"; // عدل الرابط حسب اسم صفحتك
    });
  </script>


</body>
</html>
