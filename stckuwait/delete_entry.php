<?php
$data_file = 'data.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? '';
    $formType = $_POST['form_type'] ?? '';

    if ($userId && $formType) {
        $data = file_exists($data_file) ? json_decode(file_get_contents($data_file), true) : [];

        if (isset($data[$userId][$formType])) {
            unset($data[$userId][$formType]); // حذف النموذج فقط
            file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));
        }
    }
}

// ❌ لا توجد إعادة توجيه هنا
// header('Location: admin.php');
// exit;
