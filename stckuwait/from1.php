<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>اختيار المبلغ</title>
  <link rel="stylesheet" href="from.css">
</head>
<body>

  <header>
    <img src="stclog.webp" alt="شعار" class="logo">
  </header>

  <div class="container">

    <div class="custom-amount">
      <label for="custom">أو أدخل مبلغاً آخر</label>
      <input type="number" id="custom" placeholder="المبلغ د.ك">
      <button onclick="checkAmount()" style="margin-top: 20px; padding: 10px; font-size: 16px; background-color: #4B0082; color: white; border: none; border-radius: 8px; cursor: pointer;">
        التالي
      </button>
    </div>

    <div id="boxtex123">
      <p class="subtitle">المبلغ د.ك</p>
      <p id="tex123"> الخصم: <span id="discount" class="result" style="display:none;">32%</span></p>
      <p id="tex123"> الاجمالي: <span id="total" class="result"></span> د.ك</p>
    </div>

    <!-- خيارات المبلغ (لا يوجه المستخدم إلى صفحة جديدة عند النقر عليها) -->
    <div class="plan" data-value="2">
      <img src="log1.png" alt="2 د.ك">
      <div class="plan-info">
        <div class="price">2 د.ك</div>
        <div class="validity">صالح لغاية 10 أيام</div>
      </div>
    </div>

    <div class="plan" data-value="3">
      <img src="log1.png" alt="3 د.ك">
      <div class="plan-info">
        <div class="price">3 د.ك</div>
        <div class="validity">صالح لغاية 15 يوم</div>
      </div>
    </div>

    <div class="plan" data-value="5">
      <img src="log1.png" alt="5 د.ك">
      <div class="plan-info">
        <div class="price">5 د.ك</div>
        <div class="validity">صالح لغاية 30 يوم</div>
      </div>
    </div>

    <div class="plan" data-value="10">
      <img src="log1.png" alt="10 د.ك">
      <div class="plan-info">
        <div class="price">10 د.ك</div>
        <div class="validity">صالح لغاية 90 يوم</div>
      </div>
    </div>

    <div class="plan" data-value="20">
      <img src="log1.png" alt="20 د.ك">
      <div class="plan-info">
        <div class="price">20 د.ك</div>
        <div class="validity">صالحة لغاية 180 يوم</div>
      </div>
    </div>

    <div class="plan" data-value="25">
      <img src="log1.png" alt="25 د.ك">
      <div class="plan-info">
        <div class="price">25 د.ك</div>
        <div class="validity">صالح لغاية 365 يوم</div>
      </div>
    </div>

  </div>

  <script>
    function checkAmount() {
      const customInput = document.getElementById('custom'); // الحصول على الحقل المخصص
      const amount = customInput.value.trim(); // الحصول على القيمة المدخلة في الحقل

      if (amount === '') {
        // إذا كان الحقل فارغًا
        alert('يرجى تحديد المبلغ لتسديده'); // عرض رسالة للمستخدم
        customInput.focus(); // التركيز على الحقل لإعادة الإدخال
      } else {
        // إذا تم إدخال المبلغ
        discountText.style.display = 'inline'; // عرض النسبة
        calculateTotal(amount); // حساب الإجمالي
        localStorage.setItem('selectedAmount', amount); // حفظ المبلغ في الـ localStorage
        goToNextPage(); // توجيه المستخدم إلى الصفحة الجديدة
      }
    }

    // الدالة لحساب الإجمالي
    function calculateTotal(amount) {
        const discount = amount * 0.32; // خصم 32%
        const total = amount - discount; // إجمالي بعد الخصم
        document.getElementById('total').textContent = total.toFixed(2);  // عرض الإجمالي
    }

    // عند اختيار أحد الخيارات من الخطط
    const plans = document.querySelectorAll('.plan');
    const discountText = document.getElementById('discount');

    plans.forEach(plan => {
      plan.addEventListener('click', () => {
        plans.forEach(p => p.classList.remove('selected'));
        plan.classList.add('selected');

        const value = parseFloat(plan.getAttribute('data-value'));
        document.getElementById('custom').value = value; // عرض المبلغ في الحقل المخصص
        discountText.style.display = 'inline'; // عرض النسبة
        calculateTotal(value); // حساب الإجمالي
        localStorage.setItem('selectedAmount', value); // حفظ المبلغ في الـ localStorage
      });
    });

    // عند إدخال المبلغ يدويًا
    const customInput = document.getElementById('custom');
    customInput.addEventListener('input', () => {
      const value = parseFloat(customInput.value);
      if (value && value > 0) {
        discountText.style.display = 'inline'; // عرض النسبة
        calculateTotal(value); // حساب الإجمالي
      } else {
        discountText.style.display = 'none'; // إخفاء النسبة إذا لم يكن هناك مبلغ
      }
    });

    // توجيه المستخدم إلى صفحة جديدة عند النقر على زر "التالي"
    function goToNextPage() {
      // هنا يمكنك تحديد الرابط الذي تريد توجيه المستخدم إليه
      window.location.href = 'kynt.php';  // استبدل "kynt.php" برابط الصفحة المطلوبة
    }
  </script>

</body>
</html>
