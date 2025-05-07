<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <title>Mua lượt check</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .popup {
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      padding: 30px;
      width: 100%;
      max-width: 500px;
    }

    .popup h2 {
      margin-bottom: 20px;
      font-size: 22px;
    }

    .range-container {
      margin: 20px 0;
    }

    .range-labels {
      display: flex;
      justify-content: space-between;
      font-size: 14px;
      color: #555;
    }

    input[type="range"] {
      width: 100%;
      height: 6px;
      border-radius: 3px;
      appearance: none;
      background: #e5e7eb;
      outline: none;
      transition: background 0.3s;
    }

    input[type="range"]::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 18px;
      height: 18px;
      background: #fff;
      border: 2px solid #3b82f6;
      border-radius: 50%;
      cursor: pointer;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      position: relative;
      z-index: 2;
      margin-top: -2px; /* để canh giữa với track */
    }

    input[type="range"]::-moz-range-thumb {
      width: 18px;
      height: 18px;
      background: #fff;
      border: 2px solid #3b82f6;
      border-radius: 50%;
      cursor: pointer;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .info {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
      margin-top: 20px;
      font-size: 15px;
    }

    .info-item {
      padding: 10px 12px;
      border-radius: 6px;
    }

    .info-item label {
      font-weight: 900;
      color: #333;
      display: block;
      margin-bottom: 5px;
      font-size: 14px;
    }

    .info-item div {
      font-weight: bold;
      color: #111;
      background: #f9fafb;
      padding: 10px 10px;
      box-sizing: border-box;
      border: 1px solid #cccccc33;
      border-radius: 3px;
    }

    .footer {
      margin-top: 30px;
      text-align: right;
    }

    .footer button {
      background: #3b82f6;
      color: white;
      padding: 10px 18px;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
    }

    .footer button:hover {
      background: #2563eb;
    }
    @media (max-width: 400px) {
      .info {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="popup">
    <h2>Mua lượt check</h2>

    <div class="range-container">
      <input type="range" id="priceRange" min="0" max="28" step="1" value="0" />
      <div class="range-labels">
        <span id="rangeMinLabel"></span>
        <span id="rangeMaxLabel"></span>
      </div>
    </div>

    <div class="info" id="infoDisplay"></div>

    <div class="footer">
      <button>Mua ngay</button>
    </div>
  </div>

  <script>
    const data = [
    { price: 8, check: 5000, bonus: 0 },
    { price: 16, check: 10000, bonus: 5 },
    { price: 24, check: 15000, bonus: 5 },
    { price: 32, check: 20000, bonus: 5 },
    { price: 40, check: 25000, bonus: 5 },
    { price: 48, check: 30000, bonus: 5 },
    { price: 56, check: 35000, bonus: 8 },
    { price: 64, check: 40000, bonus: 8 },
    { price: 72, check: 45000, bonus: 8 },
    { price: 80, check: 50000, bonus: 10 },
    { price: 88, check: 55000, bonus: 10 },
    { price: 96, check: 60000, bonus: 10 },
    { price: 104, check: 65000, bonus: 10 },
    { price: 112, check: 70000, bonus: 10 },
    { price: 120, check: 75000, bonus: 10 },
    { price: 128, check: 80000, bonus: 15 },
    { price: 136, check: 85000, bonus: 15 },
    { price: 144, check: 90000, bonus: 15 },
    { price: 152, check: 95000, bonus: 15 },
    { price: 160, check: 100000, bonus: 15 },
    { price: 320, check: 200000, bonus: 15 },
    { price: 480, check: 300000, bonus: 20 },
    { price: 640, check: 400000, bonus: 20 },
    { price: 800, check: 500000, bonus: 20 },
    { price: 960, check: 600000, bonus: 20 },
    { price: 1120, check: 700000, bonus: 20 },
    { price: 1280, check: 800000, bonus: 20 },
    { price: 1440, check: 900000, bonus: 20 },
    { price: 1600, check: 1000000, bonus: 20 }
  ];

    const rangeInput = document.getElementById("priceRange");
    const infoDisplay = document.getElementById("infoDisplay");
    const rangeMinLabel = document.getElementById("rangeMinLabel");
    const rangeMaxLabel = document.getElementById("rangeMaxLabel");

    rangeMinLabel.innerText = data[0].check.toLocaleString('vi-VN');
    rangeMaxLabel.innerText = data[data.length - 1].check.toLocaleString('vi-VN');

    function updateUI(index) {
      const item = data[index];
      const bonusCount = item.check * (item.bonus / 100);
      const total = item.check + bonusCount;

      infoDisplay.innerHTML = `
        <div class="info-item">
          <label>SL lượt check (chưa bonus):</label><div>${item.check.toLocaleString('vi-VN')}</div>
        </div>
        <div class="info-item">
          <label>Doanh thu /Giá ($):</label><div>${item.price}</div>
        </div>
        <div class="info-item">
          <label>% Bonus khi áp mã giới thiệu:</label><div>${item.bonus}%</div>
        </div>
        <div class="info-item">
          <label>SL lượt check bonus:</label><div>${bonusCount.toLocaleString('vi-VN')}</div>
        </div>
      `;
    }

    function updateRangeBackground() {
      const val = (rangeInput.value - rangeInput.min) / (rangeInput.max - rangeInput.min) * 100;
      rangeInput.style.background = `linear-gradient(to right, #3b82f6 0%, #3b82f6 ${val}%, #e5e7eb ${val}%, #e5e7eb 100%)`;
    }

    rangeInput.addEventListener("input", () => {
      updateUI(rangeInput.value);
      updateRangeBackground();
    });

    // Khởi tạo mặc định
    updateUI(rangeInput.value);
  </script>
</body>
</html>