document.querySelector(".search-btn").addEventListener("click", function() {
  // let searchInput = document.querySelector(".search-bar")
  // let searchValue = searchInput.value.toLowerCase();
  window.location.href = "?page=search_products.php&keyword=" + encodeURIComponent(document.querySelector(".search-bar").value);
});

document.querySelector(".search-bar").addEventListener("keydown", function(event) {
  console.log(event.key)
  if (event.key === "Enter") { // Kiểm tra nếu nhấn phím Enter
    window.location.href = "?page=search_products.php&keyword=" + encodeURIComponent(document.querySelector(".search-bar").value);
  }
});