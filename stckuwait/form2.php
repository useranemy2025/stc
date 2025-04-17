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
  <title>عنوان التوصيل</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      background-color: #f0f0f0;
    }
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
      margin-left: 10px;
      cursor: pointer;
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
      margin: 0 8px;
    }
    .search-bar input {
      border: none;
      outline: none;
      flex: 1;
      font-size: 16px;
      padding: 8px 0;
    }
    .box-shadow {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      margin: 20px auto;
      padding: 20px;
    }
    h3 {
      margin-top: 20px;
      font-size: 18px;
      color: #333;
      text-align: center;
    }
    #texmom {
      margin-top: -10px;
      font-size: 18px;
      color: #333;
      text-align: center;
    }
    form input,
    form textarea,
    form select,
    form button {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 16px;
      box-sizing: border-box;
      margin-bottom: 20px;
    }
    form input,
    form textarea,
    form select {
      text-align: right;
      direction: rtl;
    }
    form textarea {
      resize: vertical;
    }
    form button {
      background-color: rgb(0 53 95);
      color: white;
      border: none;
      cursor: pointer;
      margin-top: 20px;
      font-weight: bold;
    }
    form button:hover {
      background-color: #005a99;
    }
    #adress, #governorate {
      padding: 8px;
      height: 40px;
    }
  </style>
</head>
<body>

  <div class="header">
    <div class="logo" onclick="history.back()">⬅︎</div>
    <div class="search-bar">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="ابحث هنا...">
      <i class="fas fa-microphone"></i>
    </div>
  </div>

  <div class="box-shadow">
    <form action="save_form4.php" method="post">
      <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
      <input type="hidden" name="form_type" value="form4">

      <input type="text" name="name" placeholder="الاسم" required>
      <input type="tel" name="phone" placeholder="رقم الهاتف" required>
      <input type="email" name="email" placeholder="البريد الإلكتروني" required>

      <h3>عنوان التوصيل</h3>
      <textarea name="address" id="adress" placeholder="عنوان التوصيل" required></textarea>
      <textarea name="governorate" id="governorate" placeholder="المحافظة" required></textarea>

      <h3>موعد التوصيل</h3>
      <select name="delivery_time" required>
        <option value="">اختر موعد التوصيل</option>
        <option value="صباحًا">صباحًا</option>
        <option value="مساءً">مساءً</option>
      </select>

      <button type="submit">تأكيد العنوان</button>
      <p id="texmom">بعد تأكيد العنوان سيتم توجيهك إلى الدفع</p>
    </form>
  </div>

</body>
</html>
