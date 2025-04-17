<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;

    if ($user_id) {
        $file = 'data.json';
        $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        foreach ($data as &$entry) {
            if ($entry['user_id'] === $user_id) {
                $entry['status'] = 'rejected';
                break;
            }
        }

        file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}
?>

