let minusBtns = document.querySelectorAll('.minus-btn');
let plusBtns = document.querySelectorAll('.plus-btn');
let deleteBtns = document.querySelectorAll('.btn-outline-danger')


document.addEventListener('DOMContentLoaded', () => {
  let totalPrice = document.querySelector(".total-price")
  let totals = document.querySelectorAll('.total');
  let sum = 0;
  totals.forEach(total => {
    sum += Number(parseInt(total.innerHTML.replace(/\./g, "").replace("đ", "").trim(), 10))
  })
  totalPrice.innerHTML = Number(sum).toLocaleString('vi-VN') + "đ";
})

minusBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    let quantitys = document.querySelectorAll('.quantity');
    quantitys.forEach(quantity => {
      if (quantity.dataset.id == btn.dataset.id && quantity.dataset.color == btn.dataset.color && Number(quantity.innerHTML) !== 1) {
        let old = quantity.innerHTML;
        let newQuantity = Number(old) - 1;
        let xhr_1 = new XMLHttpRequest();
        xhr_1.open('get', `models/update_cart_db.php?ProductID=${quantity.dataset.id}&color=${quantity.dataset.color}&quantity=${newQuantity}`)
        xhr_1.onload = function () {
          quantity.innerHTML = newQuantity;
          let totals = document.querySelectorAll('.total');
          totals.forEach(total => {
            if (total.dataset.id == quantity.dataset.id && total.dataset.color == quantity.dataset.color) {
              total.innerHTML = (Number(quantity.dataset.price) * Number(quantity.innerHTML)).toLocaleString('vi-VN') + "đ";
            }
          })
          let totalPrice = document.querySelector(".total-price")
          let sum = 0;
          totals.forEach(total => {
            sum += Number(parseInt(total.innerHTML.replace(/\./g, "").replace("đ", "").trim(), 10))
          })
          totalPrice.innerHTML = Number(sum).toLocaleString('vi-VN') + "đ";
          let xhrUpdateCart = new XMLHttpRequest();
          xhrUpdateCart.open('get', 'models/update_cart.php', true);
          xhrUpdateCart.onload = function () {
            document.querySelector('.cart-quantity').innerHTML = `${xhrUpdateCart.responseText}`;
          };
          xhrUpdateCart.send();
        }
        xhr_1.send()
        
      }
    })
  })
})

plusBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    let quantitys = document.querySelectorAll('.quantity');
    quantitys.forEach(quantity => {
      if (quantity.dataset.id == btn.dataset.id && quantity.dataset.color == btn.dataset.color) {
        let old = quantity.innerHTML;
        let newQuantity = Number(old) + 1;
        let xhr = new XMLHttpRequest();
        xhr.open('get', `models/check_stock.php?ProductID=${quantity.dataset.id}&color=${quantity.dataset.color}&quantity=${newQuantity}`)
        xhr.onload = function () {
          let response = JSON.parse(xhr.responseText)
          if (response.stock) {
            let xhr_1 = new XMLHttpRequest();
            xhr_1.open('get', `models/update_cart_db.php?ProductID=${quantity.dataset.id}&color=${quantity.dataset.color}&quantity=${newQuantity}`)
            xhr_1.onload = function () {
              let response = xhr_1.responseText
              console.log(response)
              quantity.innerHTML = newQuantity;
              let totals = document.querySelectorAll('.total');
              totals.forEach(total => {
                if (total.dataset.id == quantity.dataset.id && total.dataset.color == quantity.dataset.color) {
                  total.innerHTML = (Number(quantity.dataset.price) * Number(quantity.innerHTML)).toLocaleString('vi-VN') + "đ";
                }
              })
              let totalPrice = document.querySelector(".total-price")
              let sum = 0;
              totals.forEach(total => {
                sum += Number(parseInt(total.innerHTML.replace(/\./g, "").replace("đ", "").trim(), 10))
              })
              totalPrice.innerHTML = Number(sum).toLocaleString('vi-VN') + "đ";
              let xhrUpdateCart = new XMLHttpRequest();
              xhrUpdateCart.open('get', 'models/update_cart.php', true);
              xhrUpdateCart.onload = function () {
                document.querySelector('.cart-quantity').innerHTML = `${xhrUpdateCart.responseText}`;
              };
              xhrUpdateCart.send();
            }
            xhr_1.send()
          } else {
            window.alert("Not enough stock!")
          }
        }
        xhr.send();
        
      }
    })
  })
})

deleteBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.product-container').forEach(container => {
      if (btn.dataset.id == container.dataset.id && btn.dataset.color == container.dataset.color) {
        let xhr = new XMLHttpRequest()
        xhr.open('get', `models/update_cart_db.php?ProductID=${btn.dataset.id}&color=${btn.dataset.color}&quantity=0`)
        xhr.onload = function () {
          container.innerHTML = "";
          let totalPrice = document.querySelector(".total-price")
          let totals = document.querySelectorAll('.total');
          let sum = 0;
          totals.forEach(total => {
            sum += Number(parseInt(total.innerHTML.replace(/\./g, "").replace("đ", "").trim(), 10))
          })
          totalPrice.innerHTML = Number(sum).toLocaleString('vi-VN') + "đ";
          let xhrUpdateCart = new XMLHttpRequest();
          xhrUpdateCart.open('get', 'models/update_cart.php', true);
          xhrUpdateCart.onload = function () {
            document.querySelector('.cart-quantity').innerHTML = `${xhrUpdateCart.responseText}`;
          };
          xhrUpdateCart.send();
          if (document.querySelectorAll('.btn-outline-danger').length == 0) {
            document.querySelector('.cart-container').innerHTML = "<div>No items in your cart!</div>"
            if (document.querySelector('.payment')) {
              document.querySelector('.payment').style.display = 'none'
            }
          }
        }
        xhr.send()
      }
    })
  })
})

let payBtn = document.querySelector('.pay-btn')
payBtn.addEventListener('click', () => {
  console.log("pay")
  window.location.href = 'checkout.php'
})