<!DOCTYPE html>
<html lang="ar">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>عقد وساطة في استيراد مركبة</title>
    <style>
      body {
        font-family: "Arial", sans-serif;
        background-color: #fff;
        color: #333;
        line-height: 1.6;
        margin: 0;
        padding: 20px;
        direction: rtl; /* Supports right-to-left text for Arabic */
        text-align: right; /* Aligns text to the right */
      }

      h1,
      h2 {
        text-align: center;
      }

      h1 {
        font-size: 22px;
        font-weight: bold;
      }

      h2 {
        font-size: 18px;
        font-weight: normal;
      }

      p,
      ul {
        margin: 20px 0;
        font-size: 16px;
      }

      ul {
        list-style: none; /* Removes bullets */
        padding: 0;
      }

      ul li {
        margin-bottom: 10px;
      }

      .contract-section {
        margin-bottom: 20px;
      }

      .contract-number {
        font-weight: bold;
        color: #f00; /* Red color */
      }

      .company-logo {
        text-align: center;
        margin-bottom: 30px;
      }

      .company-logo img {
        width: 200px; /* Adjust width as needed */
      }

      .footer {
        text-align: center;
        margin-top: 40px;
        font-size: 14px;
      }

      .contact-info {
        text-align: center;
        font-size: 14px;
        margin-top: 20px;
      }

      .contact-info img {
        width: 30px;
        margin: 0 10px;
        vertical-align: middle;
      }

      .important-note {
        border: 2px dashed #ccc;
        padding: 15px;
        background-color: #f9f9f9;
        text-align: center;
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
    
    <h1>عقد وساطة في استيراد مركبة</h1>

    <div class="contract-section">
      <h2>رقم العقد ({{ $invoice->order_id }})</h2>
      <p>الطرف الأول: أبوبكر علي عبدالله الفقيه إدارة وتنشيط المبيعات.</p>
      <p>الطرف الثاني: ({{ $invoice->user_name }}) رقم سجل ({{ $invoice->national_id }}).</p>
    </div>

    <div class="contract-section">
      <p>
        أقر أنا الطرف الأول بأني قد
        <strong>استلمت مبلغ ({{ $invoice->amount }})</strong> ألف ريال فقط لا غير من الطرف
        الثاني عن طريق الحوالة في حساب النشاط بمصرف الراجحي وذلك مقابل الوساطة
        لشراء سيارة  ({{ $invoice->car_company }})  
        موديل ({{ $invoice->car_model }})
        لون<strong>({{ $invoice->car_color }})</strong> 
        من مزادات في كوريا الجنوبية تحمل رقم
        هيكل <strong>( {{ $invoice->car_base_number }} )</strong> ومشاركة الطرف الثاني فحصها
        وتعميده للطرف الأول ومن ثم شرائها.
      </p>

      <p>
        يتبقى على الطرف الثاني بقية الرسوم المتمثلة في ضريبة وجمرك السيارة
        وأتعاب التخليص عند وصولها إلى ميناء الدمام بأمر الله. يقوم الطرف الأول
        بشحن السيارة عن طريق أحد شركات الشحن المعتمدة وإرسال بوليصة الشحن للطرف
        الثاني.
      </p>

      <p>
        بعد تسليم البوليصة واستمارة السيارة وفاتورة الشراء الخاصة بالجمارك للطرف
        الثاني يكون الطرف الأول قد أنهى التزاماته نحو الطرف الثاني من وساطته
        (شراء/شحن/عمولة) ويبقى الطرف الأول مسؤول عن فحص السيارة كما زود بمقطع
        الفحص.
      </p>
    </div>

    <div class="contract-section">
      <h2>المبلغ المحول هو شامل الآتي:</h2>
      <ul>
        <li>قيمة الشراء.</li>
        <li>قيمة الشحن.</li>
        <li>قيمة العمولة والوساطة في الاستيراد هي (2250) ريال.</li>
      </ul>

      <p>
        في حال رغبة العميل تخليص السيارة عن طرفنا من خلال مؤسستنا (الخطوة
        السريعة للتخليص الجمركي) يقوم العميل بعمل التفويض وقت إشعاره بعمل
        التفويض وتحويل رسوم التخليص لحساب المؤسسة.
      </p>

      <div class="important-note">
        مدة الاستيراد المتوقعة من 45 يوم إلى 60 يوم
      </div>
    </div>

    <div class="footer">
      <p>FL-826022884</p>
      <p><strong>Alfaqih cars</strong></p>
      <p>الختم يفضل باللون الأزرق بولد</p>
    </div>

    <div class="contact-info">
      {{-- <img src="phone-icon.png" alt="Phone Icon" /> 0558007721 --}}
      <br />
      {{-- <img src="email-icon.png" alt="Email Icon" /> alfaqihcars@gmail.com --}}
      <br />
      <a href="http://alfaqihcars.com">Alfaqihcars.com</a>
    </div>
  </body>
</html>