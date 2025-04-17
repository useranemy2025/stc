<?php
// الموافقة على إدخال form4
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    $userId = $input['user_id'] ?? null;
    $formType = $input['form_type'] ?? null;
    $entryIndex = $input['entry_index'] ?? null;

    if (!$userId || !$formType || $entryIndex === null) {
        echo "Missing data.";
        exit;
    }

    $file = 'data.json';

    if (!file_exists($file)) {
        echo "Data file not found.";
        exit;
    }

    $data = json_decode(file_get_contents($file), true);

    if (!isset($data[$userId][$formType][$entryIndex])) {
        echo "Entry not found.";
        exit;
    }

    $data[$userId][$formType][$entryIndex]['approved'] = true;

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "Approved successfully.";
}
?>
