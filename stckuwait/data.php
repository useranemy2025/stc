<?php
session_start();

$data_file = 'data.json';

// قراءة بيانات الإدخال سواء كانت JSON أو POST
$raw_input = file_get_contents("php://input");
$content_type = $_SERVER['CONTENT_TYPE'] ?? '';
$is_json = stripos($content_type, 'application/json') !== false;
$input = $is_json ? json_decode($raw_input, true) : $_POST;

// تحديد user_id
$user_id = $input['user_id'] ?? ($_SESSION['user_id'] ?? uniqid("user_"));
$_SESSION['user_id'] = $user_id;

// تحديد اسم الفورم
$form_key = $input['form_type'] ?? $input['form_name'] ?? 'unknown';

// استخراج البيانات (بدون المفاتيح الإدارية)
$data = $input;
unset($data['user_id'], $data['form_type'], $data['form_name']);

// إنشاء ملف فارغ إذا ما كان موجود
if (!file_exists($data_file)) {
    file_put_contents($data_file, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// قراءة البيانات من الملف
$stored = json_decode(file_get_contents($data_file), true);

// إنشاء مستخدم جديد إن لم يكن موجود
if (!isset($stored[$user_id])) {
    $stored[$user_id] = [
        'user_id' => $user_id,
        'last_active' => time()
    ];
}

// تأكد أن البيانات محفوظة كمصفوفة
if (!isset($stored[$user_id][$form_key]) || !is_array($stored[$user_id][$form_key])) {
    $stored[$user_id][$form_key] = [];
}

// ✅ إضافة البيانات - خاص لـ form4 لتنسيق موحد
if ($form_key === 'form4') {
    $stored[$user_id][$form_key][] = [
        'data' => $data,
        'timestamp' => time()
    ];
} else {
    $stored[$user_id][$form_key][] = $data;
}

$stored[$user_id]['last_active'] = time();

// حفظ الملف
file_put_contents($data_file, json_encode($stored, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// ✅ تحويل المستخدم إلى صفحة الشكر (عند استخدام POST فقط)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Location: kynt.php");
    exit;
}

// ✅ استرجاع البيانات عند الطلب (إذا كانت JSON)
echo json_encode([
    'status' => 'success',
    'user_id' => $user_id,
    'user_data' => $stored[$user_id]
]);

$new_entry = [
    "timestamp" => time(),
    "data" => $formData,
    "approved" => false // المستخدم غير موافق عليه مبدئياً
];
