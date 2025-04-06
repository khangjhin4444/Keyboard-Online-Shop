function changeImage(newSrc) {
  document.getElementById("displayedImage").src = newSrc;
  document.getElementById("mainImageLink").href = newSrc;
}

document.addEventListener("DOMContentLoaded", function () {
  let variantsBtn = document.querySelectorAll(".variant-btn");
  variantsBtn.forEach(btn => {
      btn.addEventListener('click', () => {
          variantsBtn.forEach(b => {
              if (b.classList.contains("active")) {
                  b.classList.remove("active");
              }
          });
          btn.classList.add("active");
          let image = btn.dataset.image;
          let stock = btn.dataset.stock;
          document.getElementById('stockDisplay').innerHTML = `Stock: ${stock}`;
          changeImage(image);
      });
  });

  let plusBtn = document.querySelector(".plus-btn");
  let minusBtn = document.querySelector(".minus-btn");
  let quantity = document.querySelector(".quantity");
  quantity.addEventListener('blur', () => {
      if (!quantity.value || quantity.value < 1) {
          quantity.value = 1;
      }
  });
  plusBtn.addEventListener("click", () => {
      let old = quantity.value;
      quantity.value = Number(old) + 1;
  });
  minusBtn.addEventListener("click", () => {
      if (Number(quantity.value) === 1) {
          return;
      }
      let old = quantity.value;
      quantity.value = Number(old) - 1;
  });

  let relProductContainer = document.querySelectorAll(".rel-product-container");
  relProductContainer.forEach(product => {
      product.addEventListener('click', () => {
          let id = Number(product.dataset.id);
          window.location.href = `?page=product.php&productId=${id}`;
      });
  });
});

let addToCartBtn = document.querySelector(".add-to-cart");
let buyNowBtn = document.querySelector(".buy-now");

function handleOrder(action) {
  let color = 'Basic';
  let chosen = false;
  let productID = Number(document.querySelector(".product-name").dataset.id);
  let quantity = Number(document.querySelector(".quantity").value);
  let variantsBtn = document.querySelectorAll(".variant-btn");
  let allOutStock = true;

  variantsBtn.forEach(btn => {
      if (Number(btn.dataset.stock) > 0) {
          allOutStock = false;
      }
      if (btn.classList.contains("active")) {
          color = btn.dataset.color;
          chosen = true;
      }
  });

  if (variantsBtn.length === 0) {
      chosen = true; 
  }

  if (allOutStock && variantsBtn.length > 0) {
      window.alert("All out stock!");
      return;
  }

  let xhr = new XMLHttpRequest();
  xhr.open('get', `models/check_stock.php?ProductID=${productID}&color=${color}&quantity=${quantity}`);
  xhr.onload = function () {
      let response = JSON.parse(xhr.responseText);

      if (response.stock) {
          let xhrAddToCart = new XMLHttpRequest();
          xhrAddToCart.open('get', `models/add_to_cart.php?productID=${productID}&color=${color}&quantity=${quantity}`, true);
          xhrAddToCart.onload = function () {
              let response = JSON.parse(xhrAddToCart.responseText);
              let xhrUpdateCart = new XMLHttpRequest();
              xhrUpdateCart.open('get', 'models/update_cart.php', true);
              xhrUpdateCart.onload = function () {
                  document.querySelector('.cart-quantity').innerHTML = `${xhrUpdateCart.responseText}`;
                  if (action === 'add') {
                      window.alert("Added to cart!");
                  } else {
                      window.location.href = "?page=cart_view.php";
                  }
              };
              xhrUpdateCart.send();
          };
          xhrAddToCart.send();
      } else {
          if (!chosen) {
              window.alert("Please choose one variant!");
          } else {
              window.alert("Not enough stock!");
          }
      }
  };
  xhr.send();
}

addToCartBtn.addEventListener('click', () => handleOrder('add'));
buyNowBtn.addEventListener('click', () => handleOrder('buy'));