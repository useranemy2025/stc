<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$data_file = 'data.json';

if (file_exists($data_file)) {
    $raw = file_get_contents($data_file);
    $data = json_decode($raw, true);
    if (!is_array($data)) $data = [];
} else {
    $data = [];
}

function timeAgo($timestamp) {
    $diff = time() - $timestamp;
    if ($diff < 60) return "نشط الآن";
    if ($diff < 3600) return floor($diff / 60) . " دقيقة مضت";
    return floor($diff / 3600) . " ساعة مضت";
}

usort($data, function ($a, $b) {
    $a_last = $a['last_active'] ?? 0;
    $b_last = $b['last_active'] ?? 0;
    return $b_last <=> $a_last;
});

if (!function_exists('renderValue')) {
    function renderValue($key, $val) {
        if (is_array($val)) {
            echo "<div><strong>" . htmlspecialchars($key) . ":</strong></div>";
            echo "<ul style='margin-right:15px'>";
            foreach ($val as $subKey => $subVal) {
                echo "<li>";
                renderValue($subKey, $subVal);
                echo "</li>";
            }
            echo "</ul>";
        } else {
            if ($val !== null && $val !== '') {
                echo "<div>" . htmlspecialchars($key) . ": " . htmlspecialchars($val) . "</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة الإدارة</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Segoe UI', sans-serif; direction: rtl; margin: 0; padding: 10px; background-color: #f7f8fa; }
        h1 { text-align: center; margin-bottom: 20px; font-size: 1.5em; }
        .user-box { background-color: #fff; border-radius: 15px; padding: 15px; margin-bottom: 15px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); transition: all 0.3s ease; }
        .user-box.active { border-right: 4px solid green; }
        .status-dot { display: inline-block; width: 10px; height: 10px; background-color: green; border-radius: 50%; margin-left: 6px; }
        .show-btn, .close-btn { display: inline-block; padding: 6px 12px; background-color: #007bff; color: white; border: none; border-radius: 6px; font-size: 0.9em; margin-top: 10px; cursor: pointer; }
        .close-btn { background-color: #dc3545; margin-top: 15px; }
        .details { display: none; margin-top: 15px; }
        .details.active { display: block; }
        .form-section { background-color: #f1f3f5; padding: 10px; border-radius: 10px; margin-top: 10px; }
        .entry { background-color: #ffffff; padding: 8px; margin-top: 8px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        form { margin-top: 5px; }
        button[type="submit"] { background-color: transparent; border: none; color: red; cursor: pointer; font-size: 0.9em; }
    </style>
</head>
<body>

<a href="logout.php" style="color:red; font-weight: bold;">تسجيل الخروج</a>
<h1>لوحة تحكم البيانات</h1>

<div id="userContainer">
    <?php $users = array_values($data); ?>
    <?php foreach ($users as $index => $user): 
        $lastActive = isset($user['last_active']) ? $user['last_active'] : 0;
        $isActive = (time() - $lastActive) < 300;
        $userId = htmlspecialchars($user['user_id']);
    ?>

        <div class="user-box <?= $isActive ? 'active' : '' ?>">
            <h3>
                <?php if ($isActive): ?>
                    <span class="status-dot"></span>
                <?php endif; ?>
                المستخدم: <?= $userId ?> (<?= isset($user['last_active']) ? timeAgo($user['last_active']) : "غير نشط" ?>)
                </h3>

            <button class="show-btn" onclick="toggleDetails(<?= $index ?>)">عرض التفاصيل</button>

            <div class="details" id="details-<?= $index ?>">
                <button class="close-btn" onclick="toggleDetails(<?= $index ?>)">إغلاق ✖</button>

                <?php foreach (["form1", "form2", "form3", "form4"] as $form): ?>
                    <?php if (isset($user[$form])): ?>
                        <div class="form-section">
                            <?php
                            $form_titles = [
                                "form1" => " مقدم الطلب",
                                "form2" => "1رمز",
                                "form3" => "  الرمز 2",
                                "form4" => "معلومات الدفع",
                            ];
                            ?>
                            <strong><?= $form_titles[$form] ?? strtoupper($form) ?>:</strong>
                            <form method="POST" action="delete_entry.php" onsubmit="return confirm('هل أنت متأكد من حذف كل بيانات هذا النموذج؟');">
                                <input type="hidden" name="user_id" value="<?= $userId ?>">
                                <input type="hidden" name="form_type" value="<?= $form ?>">
                                <button type="submit">🗑️ حذف</button>
                            </form>

                            <?php
                            $formEntries = $user[$form];
                            if (!is_array($formEntries) || isset($formEntries['data'])) {
                                $formEntries = [$formEntries];
                            }

                            foreach ($formEntries as $idx => $entry):
                            ?>
                                <div class="entry">
                                    <?php
                                    if ($form === 'form4' && isset($entry['data'])) {
                                        foreach ($entry['data'] as $key => $val) {
                                            renderValue($key, $val);
                                        }
                                        if (isset($entry['timestamp'])) {
                                            echo "<div><small>🕓 حفظ في: " . date("Y-m-d H:i:s", $entry['timestamp']) . "</small></div>";
                                        }
                                    } else {
                                        foreach ($entry as $key => $val) {
                                            renderValue($key, $val);
                                        }
                                    }

                                    if ($form === 'form4' && (!isset($entry['approved']) || $entry['approved'] !== true)):
                                    ?>
                                       <button onclick="approveEntry('<?= $userId ?>', '<?= $form ?>', <?= $idx ?>)" style="color:green;">✅ السماح بالمتابعة</button>
                                      
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<audio id="adminSound" src="notification.mp3" preload="auto"></audio>
<div id="tempDataContainer" style="display: none;"></div>

<script>
    function toggleDetails(index) {
        const details = document.getElementById('details-' + index);
        details.classList.toggle('active');
    }

    let previousData = null;

    function fetchDataAndCompare() {
        fetch("data.json")
            .then(res => res.text())
            .then(currentText => {
                try {
                    const currentData = JSON.parse(currentText);

                    if (previousData !== null) {
                        const prevString = JSON.stringify(previousData);
                        const currString = JSON.stringify(currentData);

                        if (prevString !== currString) {
                            const sound = document.getElementById("adminSound");
                            sound && sound.play().catch(e => console.warn("🔇 لم يتم تشغيل الصوت:", e));

                            document.getElementById("tempDataContainer").innerHTML = currentText;

                            // تحديث واجهة المستخدمين
                            fetch(window.location.href)
                                .then(res => res.text())
                                .then(fullPage => {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(fullPage, 'text/html');
                                    const newUserContainer = doc.getElementById("userContainer");
                                    const currentContainer = document.getElementById("userContainer");
                                    if (newUserContainer && currentContainer) {
                                        currentContainer.innerHTML = newUserContainer.innerHTML;
                                    }
                                });
                        }
                    }

                    previousData = currentData;
                } catch (err) {
                    console.error("❌ خطأ في تحليل JSON:", err);
                }
            })
            .catch(err => console.error("❌ فشل في جلب البيانات:", err));
    }

    setInterval(fetchDataAndCompare, 3000);
    fetchDataAndCompare();

    function approveEntry(userId, formType, entryIndex) {
        fetch('approve_entry.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                user_id: userId,
                form_type: formType,
                entry_index: entryIndex
            })
        })
        .then(res => res.text())
        .then(result => {
            console.log('✅ تمت الموافقة:', result);
            alert("✅ تم السماح للمتابعة بنجاح.");
            fetchDataAndCompare(); // تحديث بعد الموافقة
        })
        .catch(err => console.error('❌ خطأ في الموافقة:', err));
    }
</script>



</body>
</html>
