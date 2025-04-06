let nameInput = document.querySelector('.name-input');
let phoneInput = document.querySelector('.phone-input');
let addressInput = document.querySelector('.address-input');
let orderBtn = document.querySelector('.orderBtn');
let request = document.getElementById("floatingTextarea");
let backBtn = document.querySelector('.backBtn');

// Hàm tính tổng giá tiền (giữ nguyên)
document.addEventListener('DOMContentLoaded', () => {
  let totalPrice = document.querySelector(".total-price");
  let totals = document.querySelectorAll('.price');
  let sum = 0;
  totals.forEach(total => {
    sum += Number(parseInt(total.innerHTML.replace(/\./g, "").replace("đ", "").trim(), 10));
  });
  if (document.getElementById('fastShipping').checked) {
    sum += Number(60000);
  } else {
    sum += Number(30000);
  }
  totalPrice.innerHTML = Number(sum).toLocaleString('vi-VN') + "đ";
});

// Cập nhật giá khi chọn Fast Shipping (giữ nguyên)
document.getElementById('fastShipping').addEventListener('click', () => {
  let totalPrice = document.querySelector(".total-price");
  let totals = document.querySelectorAll('.price');
  let sum = 0;
  totals.forEach(total => {
    sum += Number(parseInt(total.innerHTML.replace(/\./g, "").replace("đ", "").trim(), 10));
  });
  sum += Number(60000);
  totalPrice.innerHTML = Number(sum).toLocaleString('vi-VN') + "đ";
});

// Cập nhật giá khi chọn Normal Shipping (giữ nguyên)
document.getElementById('normalShipping').addEventListener('click', () => {
  let totalPrice = document.querySelector(".total-price");
  let totals = document.querySelectorAll('.price');
  let sum = 0;
  totals.forEach(total => {
    sum += Number(parseInt(total.innerHTML.replace(/\./g, "").replace("đ", "").trim(), 10));
  });
  sum += Number(30000);
  totalPrice.innerHTML = Number(sum).toLocaleString('vi-VN') + "đ";
});

// Hàm hiển thị popup cho Banking
function showBankingPopup(orderId, totalPrice) {
  const popup = document.createElement('div');
  popup.style.cssText = `
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    z-index: 1000;
    width: 600px;
    max-width: 90%;
  `;

  popup.innerHTML = `
    <div style="display: flex; gap: 20px;">
      <div style="flex: 1;">
        <h5>Order Information</h5>
        <p><strong>Order ID:</strong> ${orderId}</p>
        <p><strong>Total Price:</strong> ${totalPrice}</p>
        <p><strong>Note:</strong> Please transfer with the exact content: "JK Keyboard-Order#${orderId}"</p>
      </div>
      <div style="flex: 1; text-align: center;">
        <h5>Payment QR Code</h5>
        <img src="images/banking.jpg" alt="QR Code" style="max-width: 100%; height: auto;">
      </div>
    </div>
    <button id="closePopup" style="margin-top: 20px; width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 5px;">Close</button>
  `;

  const overlay = document.createElement('div');
  overlay.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 999;
  `;

  document.body.appendChild(overlay);
  document.body.appendChild(popup);

  document.getElementById('closePopup').addEventListener('click', () => {
    document.body.removeChild(popup);
    document.body.removeChild(overlay);
    window.location.href = "index.php";
  });
}

orderBtn.addEventListener('click', () => {
  if (nameInput.value === "" || phoneInput.value === "" || addressInput.value === "") {
    window.alert("Please fill in all the fields!");
    return;
  }

  let shipping = document.getElementById('fastShipping').checked ? 'Fast' : 'Normal';
  let payment = document.getElementById('cod').checked ? 'COD' : 'Banking';
  let date = dayjs().format('YYYY-MM-DD');
  let time = dayjs().format('HH:mm');
  let totalPrice = document.querySelector(".total-price").innerHTML;

  let xhr = new XMLHttpRequest();
  xhr.open('get', `models/create_order.php?name=${encodeURIComponent(nameInput.value)}&phone=${encodeURIComponent(phoneInput.value)}&address=${encodeURIComponent(addressInput.value)}&request=${encodeURIComponent(request.value)}&shipping=${shipping}&payment=${payment}&date=${date}&time=${time}&total=${encodeURIComponent(totalPrice)}`, true);
  
  xhr.onload = function () {
    if (xhr.status === 200) {
      try {
        const response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          if (payment === 'COD') {
            window.alert("Order placed successfully!");
            window.location.href = "index.php";
          } else {
            showBankingPopup(response.orderId, totalPrice);
          }
        } else {
          window.alert("Order failed: " + response.message);
        }
      } catch (e) {
        console.error("Error parsing response:", e);
        window.alert("Order failed! Invalid response from server.");
      }
    } else {
      console.log(xhr.responseText);
      window.alert("Order failed! Server error.");
    }
  };
  xhr.send();
});

backBtn.addEventListener('click', () => {
  window.location.href = "index.php?page=cart_view.php";
});