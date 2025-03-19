<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>لوحة التحكم - Frfano</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f9f9f9;
    }
    h1 {
      text-align: center;
      color: #333;
    }
    form {
      max-width: 500px;
      margin: 0 auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      margin-top: 15px;
      padding: 10px 20px;
      background-color: #000;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .preview {
      margin-top: 30px;
      text-align: center;
    }
    .preview .product {
      display: inline-block;
      width: 250px;
      margin: 10px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 10px;
      overflow: hidden;
    }
    .preview img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .preview h3 {
      margin: 10px 0;
    }
  </style>
</head>
<body>
  <h1>لوحة التحكم - إضافة منتج</h1>

  <form id="productForm">
    <label for="name">اسم العطر</label>
    <input type="text" id="name" required>

    <label for="desc">وصف العطر</label>
    <textarea id="desc" rows="3" required></textarea>

    <label for="img">رابط صورة العطر</label>
    <input type="url" id="img" required>

    <button type="submit">إضافة</button>
  </form>

  <div class="preview" id="preview">
    <h2>معاينة المنتجات</h2>
    <div id="productList"></div>
  </div>

  <script>
    const form = document.getElementById('productForm');
    const productList = document.getElementById('productList');

    form.addEventListener('submit', function(e) {
      e.preventDefault();

      const name = document.getElementById('name').value;
      const desc = document.getElementById('desc').value;
      const img = document.getElementById('img').value;

      const product = {
        name: name,
        desc: desc,
        img: img
      };

      // Send to save.php
      fetch('save.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(product)
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          alert('تم حفظ المنتج بنجاح!');
          addToPreview(product);
          form.reset();
        } else {
          alert('حدث خطأ أثناء الحفظ');
        }
      })
      .catch(err => {
        console.error('Error:', err);
        alert('فشل الاتصال بالخادم');
      });
    });

    function addToPreview(product) {
      const productHTML = `
        <div class="product">
          <img src="${product.img}" alt="${product.name}">
          <h3>${product.name}</h3>
          <p>${product.desc}</p>
          <button onclick="contactWhatsApp('${product.name}')">اطلب الآن</button>
        </div>
      `;
      productList.innerHTML += productHTML;
    }

    function contactWhatsApp(productName) {
      const phone = "201234567890";
      const message = `مرحبا، أرغب في طلب المنتج: ${productName}`;
      window.open(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`, '_blank');
    }
  </script>
</body>
</html>
