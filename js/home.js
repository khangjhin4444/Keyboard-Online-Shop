let category_1 = {offset : 8, productList: "product-list-KeyboardKit", ProductType: "KeyboardKit", categoryId: 1}
let category_2 = {offset : 8, productList: "product-list-Keycap", ProductType: "Keycap", categoryId: 2}
let category_3 = {offset : 8, productList: "product-list-Prebuild", ProductType: "Prebuild", categoryId: 3}
let category_4 = {offset : 8, productList: "product-list-Switch", ProductType: "Switch", categoryId: 4}
let divBtns = document.querySelectorAll(".div-btn");
let btns = document.querySelectorAll(".show-more-btn");

// document.addEventListener("DOMContentLoaded", () => {
//   const cards = document.querySelectorAll(".card");
  
//   cards.forEach((card, index) => {
//     card.style.animationDelay = `${index * 0.1}s`;
//     card.style.opacity = "1"; // Đảm bảo card hiển thị sau animation
//   });
// });


function fetchSortedProducts(category, sortName, sortPrice) {
  console.log(sortName, sortPrice)
  divBtns.forEach(divBtn =>{
    if (Number(divBtn.id) === category.categoryId) {
      divBtn.style.display = "block";
    }
  })

  category.offset = 8; // Reset offset khi thay đổi sort

  let xhr = new XMLHttpRequest();
  xhr.open("GET", "models/sort_products.php?sort_name=" + sortName + "&sort_price=" + sortPrice + "&ProductType=" + category.ProductType, true);
  
  xhr.onload = function () {
    if (this.status == 200) {
      document.getElementById(category.productList).innerHTML = this.responseText;
    }
  };

  xhr.send();
}

document.querySelectorAll(".sort-name").forEach(select => {
  select.addEventListener("change",() => {
    let sortName = select.value
    let sortPrice = "default"
    document.querySelectorAll(".sort-price").forEach(select2 => {
      if (Number(select2.id) === Number(select.id)) {
        select2.value = "default"
      }
    })
    switch (Number(select.id)) {
      case 1:
        fetchSortedProducts(category_1, sortName, sortPrice)
        break;
      case 2:
        fetchSortedProducts(category_2, sortName, sortPrice)
        break;
      case 3:
        fetchSortedProducts(category_3, sortName, sortPrice)
        break;
      case 4:
        fetchSortedProducts(category_4, sortName, sortPrice)
        break;
    }
    
  });
})
document.querySelectorAll(".sort-price").forEach(select => {
  select.addEventListener("change",() => {
    let sortPrice = select.value
    let sortName = "default"
    document.querySelectorAll(".sort-name").forEach(select2 => {
      if (Number(select2.id) === Number(select.id)) {
        select2.value = "default"
      }
    })
    switch (Number(select.id)) {
      case 1:
        fetchSortedProducts(category_1, sortName, sortPrice)
        break;
      case 2:
        fetchSortedProducts(category_2, sortName, sortPrice)
      case 3:
        fetchSortedProducts(category_3, sortName, sortPrice)
        break;
      case 4:
        fetchSortedProducts(category_4, sortName, sortPrice)
        break;
    }
    
  });
})

function handleShowMore(category) {
  let sortName
  let sortPrice
  document.querySelectorAll(".sort-name").forEach(select => {
    if (Number(select.id) === category.categoryId) {
      sortName = select.value
      document.querySelectorAll(".sort-price").forEach(select2 => {
        if (Number(select2.id) === Number(select.id)) {
          sortPrice = select2.value
        }
      })
    }
  })
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "models/load_more.php?offset=" + category.offset + "&sort_name=" + sortName + "&sort_price=" + sortPrice + "&ProductType=" + category.ProductType, true);

  xhr.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);
      console.log(response)
      let productContainer = document.getElementById(category.productList);

      if (response.products === "" || response.end) {
        divBtns.forEach(divBtn =>{
          if (Number(divBtn.id) === category.categoryId) {
            divBtn.style.display = "none";
          }
        })
        productContainer.innerHTML += response.products;
      } else {
        productContainer.innerHTML += response.products;
        category.offset += 8;
        let productCount = (response.products.match(/class="col col-12 col-xxl-3 col-xl-4 col-md-6 text-center"/g) || []).length;
        if (productCount < 8) {
          divBtns.forEach(divBtn =>{
            if (Number(divBtn.id) === category.categoryId) {
              divBtn.style.display = "none";
            }
          })
        }
      }
    }
  };

  xhr.send();
}

btns.forEach(btn => {
  btn.addEventListener("click", function () {
    switch (Number(btn.id)) {
      case 1:
        handleShowMore(category_1)
        break;
      case 2:
        handleShowMore(category_2)
        break;
      case 3:
        handleShowMore(category_3)
        break;
      case 4:
        handleShowMore(category_4)
        break;
      default:
        console.log("default")
    }
  });
})

document.querySelector(".search-btn").addEventListener("click", function() {
  // let searchInput = document.querySelector(".search-bar")
  // let searchValue = searchInput.value.toLowerCase();
  window.location.href = "?page=search_products.php&keyword=" + encodeURIComponent(document.querySelector(".search-bar").value);
});

document.querySelector(".search-bar").addEventListener("keydown", function(event) {
  if (event.key === "Enter" && document.querySelector(".search-bar").value) {
    window.location.href = "?page=search_products.php&keyword=" + encodeURIComponent(document.querySelector(".search-bar").value);
  }
});

// let cards = document.querySelectorAll('.card');
// cards.forEach(card => {
//   card.addEventListener('click')
// })
