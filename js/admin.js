// Auto log out if close tab
window.addEventListener("beforeunload", function () {
  navigator.sendBeacon("logout.php");
});


let nameInput = document.getElementById('floatingName');
let continueBtn = document.querySelector(".continue-btn");
let continueSearchBtn = document.querySelector(".continue-search-btn");
let nameSearchInput = document.querySelector("#floatingSearchName");
let searchContainer = document.querySelector(".search-container");

document.querySelector('.log-out-btn').addEventListener('click', () => {
  window.location.href = 'logout.php'
})


nameInput.addEventListener('keydown', async (e) => {
  if (e.key == 'Enter' && nameInput.value) {
    handleAddToDB(nameInput)
  }
})

continueBtn.addEventListener('click', () => {
  if (nameInput.value) {
    handleAddToDB(nameInput)
  }
})

async function handleAddToDB(nameInput) {
  try {
    if (document.querySelector(".product-option")) {
      document.querySelector(".product-option").innerHTML = ""
    }
    const response = await fetch(`models/check_product_name.php?name=${nameInput.value}`);

    if (!response.ok) {
        throw new Error('Network response was not ok');
    }

    const status = await response.json();
    if (status.status == 'ok') {
      document.querySelector(".product-option").innerHTML = `
        <div class="col-12 col-md-3 pb-3">
          <label for="ProductType">Product Type</label>
          <select class="form-select ProductType">
            <option selected value="KeyboardKit">Keyboard Kit</option>
            <option value="Prebuild">PreBuild</option>
            <option value="Keycap">Keycap</option>
            <option value="Switch">Switch</option>
          </select>
        </div>
        <div class="col-12 col-md-3 pb-3">
          <label for="Size">Keyboard Size</label>
          <select class="form-select Size">
            <option selected value="Full Size">Full Size</option>
            <option value="75%">75% or less</option>
            <option value="TKL">TKL</option>
            <option value="Alice">Alice</option>
          </select>
        </div>
        <div class="col-12 col-md-3 pb-3">
          <label for="Profile">Profile Keycap</label>
          <select class="form-select Profile" disabled>
            <option selected value="Cherry">Cherry</option>
            <option value="MDA">MDA</option>
            <option value="SA">SA</option>
            <option value="Artisan">Artisan</option>
          </select>
        </div>
        <div class="col-12 col-md-3 pb-3">
          <label for="Type">Switch Type</label>
          <select class="form-select Type" disabled>
            <option selected value="Linear">Linear</option>
            <option value="Tactile">Tactile</option>
            <option value="Clicky">Clicky</option>
            <option value="Silent">Silent</option>
          </select>
        </div>
        <div class="form-floating p-1 mb-3 pb-3">
          <input type="url" class="form-control urlInput" id="floatingURL" placeholder="url" disabled>
          <label for="floatingURL">Soundtest URL</label>
        </div>

        <div class="form-floating p-2 mb-3" style="width: 500px;">
          <input type="number" class="form-control" id="floatingPrice" placeholder="price" min="1">
          <label for="floatingPrice">Price</label>
        </div>

        <div class="form-floating p-1">
          <textarea class="form-control" placeholder="Description" id="floatingTextarea2" style="height: 100px"></textarea>
          <label for="floatingTextarea2">Description</label>
        </div>

        <h3 class="text-start pb-2">Variants: </h3>
        <h4 class="text-start pb-2" style='color: red;'>If product has only one variant Color should be 'Basic' and stock must be the same for all input!</h4>
        <div class="variant-container">
          <div class="row align-items-center variant-row">
            <div class="col-12 col-md-3 pb-2">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingColor" placeholder="Basic">
                <label for="floatingColor">Color</label>
              </div>
            </div>
            <div class="col-12 col-md-3 pb-2">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingStock" placeholder="0">
                <label for="floatingStock">Stock</label>
              </div>
            </div>
            <div class="col-12 col-md-6 pb-2">
              <div class="mb-3">
                <!-- <label for="formFile" class="form-label">Image File</label> -->
                <input class="form-control form-control-lg" type="file" id="formFile" accept="image/*">
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex align-items-start">
          <button class='btn btn-success plus-btn' style="width: 40px; margin-right: 20px; font-size: 20px; padding: 3px 3px; height: 40px;">+</button>
          <button class='btn btn-danger minus-btn' style="width: 40px; margin-right: 20px; font-size: 20px; padding: 3px 3px; height: 40px;">-</button>
          <button class='btn btn-primary ms-auto add-to-db' style=" font-size: 20px; padding: 3px 10px; height: 40px;">ADD TO DATABASE</button>
        </div>
      `
      let productTypeSelect = document.querySelector(".ProductType")
      let sizeSelect = document.querySelector('.Size')
      let profileSelect = document.querySelector('.Profile')
      let typeSelect = document.querySelector(".Type")
      let urlInput = document.querySelector(".urlInput")

      productTypeSelect.addEventListener('change', (e) => {
        let type = e.target.value;
        if (type == 'KeyboardKit' || type == 'Prebuild') {
          sizeSelect.disabled = false;
          profileSelect.disabled = true;
          typeSelect.disabled = true;
          urlInput.disabled = true;
        } else if (type == 'Keycap') {
          sizeSelect.disabled = true;
          profileSelect.disabled = false;
          typeSelect.disabled = true;
          urlInput.disabled = true;
        } else if (type == 'Switch') {
          sizeSelect.disabled = true;
          profileSelect.disabled = true;
          typeSelect.disabled = false;
          urlInput.disabled = false;
        }
      })

      let plusBtn = document.querySelector('.plus-btn')
      let minusBtn = document.querySelector('.minus-btn')
      let variantContainer = document.querySelector(".variant-container")
      let addToDbBtn = document.querySelector(".add-to-db")
      minusBtn.style.display = "None";

      plusBtn.addEventListener('click', () => {
        variantContainer.insertAdjacentHTML('beforeend', `
          <div class="row align-items-center variant-row">
            <div class="col-12 col-md-3 pb-2">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingColor" placeholder="Basic">
                <label for="floatingColor">Color</label>
              </div>
            </div>
            <div class="col-12 col-md-3 pb-2">
              <div class="form-floating mb-3">
                <input min="0" type="number" class="form-control" id="floatingStock" placeholder="0">
                <label for="floatingStock">Stock</label>
              </div>
            </div>
            <div class="col-12 col-md-6 pb-2">
              <div class="mb-3">
                <input class="form-control form-control-lg" type="file" id="formFile" accept="image/*">
              </div>
            </div>
          </div>
        `);
      
        minusBtn.style.display = "Block";
      });

      minusBtn.addEventListener('click', () => {
        const rows = variantContainer.querySelectorAll('.variant-row');
        if (rows.length > 1) {
          rows[rows.length - 1].remove();
      
          if (rows.length - 1 === 1) {
            minusBtn.style.display = "none";
          }
        }
      });
      addToDbBtn.addEventListener('click', () => {
        let rows = variantContainer.querySelectorAll('.variant-row');
        const formData = new FormData();
        let isValid = true;
        let isValid_2 = true;
        for (const row of rows) {
          const color = row.querySelector('#floatingColor').value;
          const stock = row.querySelector('#floatingStock').value;
          const image = row.querySelector('#formFile').files[0];
          
          for (const row_1 of rows) {
            const color_1 = row_1.querySelector('#floatingColor').value;
            const stock_1 = row_1.querySelector('#floatingStock').value;
            if (color_1 == color) {
              if (stock_1 != stock) {
                alert("Same Color must has same Stock!")
                isValid_2 = false;
                return;
              }
            }
          }
        }
        if (!isValid_2) {
          return;
        }

        for (const row of rows) {
        // rows.forEach(row => { cannot use foreach because cannot stop the loop
          const color = row.querySelector('#floatingColor').value;
          const stock = row.querySelector('#floatingStock').value;
          const image = row.querySelector('#formFile').files[0];

          if (!document.getElementById("floatingPrice").value) {
            window.alert("Please fill Price!")
            return;
          }

          if (!/^[1-9][0-9]*$/.test(document.getElementById("floatingPrice").value)) {
            window.alert("Price must contains only Number and not start with '0'!")
            isValid = false;
            return;
          }

          if (!color || !stock || !image || !nameInput.value) {
            window.alert("Please fill all fields!")
            isValid = false;
            return;
          }

          if (color == "Basic") {
            variantContainer.querySelectorAll('.variant-row').forEach(row_1 => {
              const color_1 = row_1.querySelector('#floatingColor').value;
              const stock_1 = row_1.querySelector('#floatingStock').value;
              if (color_1 != "Basic" || stock_1 != stock) {
                alert("Invalid Variant!")
                isValid = false;
                return;
              }
            })
          }
          if (isValid) {
            formData.append(`color[]`, color);
            formData.append(`stock[]`, stock);
            formData.append(`image[]`, image);
          }
          else {
            return;
          }
          
        // })
        }
        if (!isValid) return;

        const name = nameInput.value;
        formData.append('Name', name);

        const productType = document.querySelector('.ProductType').value;
        formData.append('ProductType', productType);

        const sizeSelect = document.querySelector('.Size');
        if (!sizeSelect.disabled) {
          const size = sizeSelect.value;
          formData.append('Size', size);
        } else {
          formData.append('Size', null);
        }

        const profileSelect = document.querySelector('.Profile');
        if (!profileSelect.disabled) {
          const profile = profileSelect.value;
          formData.append('Profile', profile);
        } else {
          formData.append('Profile', null);
        }

        const typeSelect = document.querySelector('.Type');
        if (!typeSelect.disabled) {
          const type = typeSelect.value;
          formData.append('Type', type);
        } else {
          formData.append('Type', null);
        }

        const soundtestUrl = document.querySelector('.urlInput');
        if (!soundtestUrl.disabled) {
          const type = soundtestUrl.value;
          formData.append('SoundTest', type);
        } else {
          formData.append('SoundTest', null);
        }

        const description = document.querySelector('#floatingTextarea2').value;
        formData.append('Description', description);

        const price = document.querySelector('#floatingPrice').value;
        formData.append('Price', price);

        fetch('models/upload.php', {
          method: 'POST',
          body: formData
        })
        .then(res => res.text())
        .then(data => {
          console.log(data)
          alert("Added product to DataBase!")
          document.querySelector(".product-option").innerHTML = ""
          nameInput.value = ""
        })
        .catch(err => console.error(err));
      })

    } else {
      alert("Product already in Data Base!")
      nameInput.value = '';
    }
  } catch (error) {
      console.error('Error:', error);
  }
}

continueSearchBtn.addEventListener('click', async () => {
  if (!nameSearchInput.value) {
    return;
  }
  try {
    if (document.querySelector('.save-section')) {
      document.querySelector('.save-section').innerHTML = ''
    }
    if (document.querySelector('.product-information')) {
      document.querySelector('.product-information').innerHTML = ''
    }
    if (document.querySelector('.product-change-option')) {
      document.querySelector('.product-change-option').innerHTML = ''
    }
    document.querySelector('.variant-section').style.display = 'None'
    if (document.querySelector('variant-change-container')) {
      document.querySelector('variant-change-container').innerHTML = ""
    }
    
    searchContainer.innerHTML = ''
    let keyword = nameSearchInput.value;
    let response = await fetch(`models/search_product.php?keyword=${keyword}`)
    response = await response.json()
    console.log(response)
    if (response.length === 0) {
      searchContainer.innerHTML += `
        <div class="col-12 col-md-6 col-lg-3 p-2">
          No related product name in DataBase
        </div>
      `
      return;
    }
    response.forEach(product => {
      searchContainer.innerHTML += `
        <div class="col-12 col-md-6 col-lg-3 p-2">
          <button class='btn p-2' style="width: 100%; height: 80px; border: 2px solid black; border-radius: 5px;">${product['Name']}</button>
        </div>
      `
    })
    searchContainer.querySelectorAll('.btn').forEach(btn => {
      btn.addEventListener("click", () => {
        if (document.querySelector('variant-change-container')) {
          document.querySelector('variant-change-container').innerHTML = ""
        }
        searchContainer.innerHTML = ''
        let thisProduct
        response.forEach(product => {
          if (product['Name'] == btn.innerHTML) {
            thisProduct = product
          }
        })
        document.querySelector('.product-information').innerHTML = `
          <div class="col-12 col-xl-6 mt-2">
            <div class="form-floating mb-3" style="width: 500px;">
              <input type="name" class="form-control" id="floatingChangeName" placeholder="name" value="${thisProduct['Name']}">
              <label for="floatingChangeName">Name</label>
            </div>
            <div class="form-floating" style="width: 500px;">
              <input min="1" type="number" class="form-control" id="floatingChangePrice" placeholder="price" value="${thisProduct['Price']}">
              <label for="floatingChangePrice">Price</label>
            </div>
          </div>

          <div class="col-12 col-xl-6 mt-2">
            <div class="form-floating" style="height: 100%; width: 100%;">
              <textarea class="form-control" placeholder="Description" id="floatingChangeTextarea" style="height: 100%; width: 100%;" >${thisProduct['Description']}</textarea>
              <label for="floatingChangeTextarea">Description</label>
            </div>
          </div>
        `
        ////

        document.querySelector('.product-change-option').innerHTML = `
          <div class="col-12 col-md-3 pb-3">
            <label for="ProductType">Product Type</label>
            <select class="form-select ProductTypeChange">
              <option value="KeyboardKit">Keyboard Kit</option>
              <option value="Prebuild">PreBuild</option>
              <option value="Keycap">Keycap</option>
              <option value="Switch">Switch</option>
            </select>
          </div>
          <div class="col-12 col-md-3 pb-3">
            <label for="Size">Keyboard Size</label>
            <select class="form-select SizeChange">
              <option value="Full Size">Full Size</option>
              <option value="75%">75% or less</option>
              <option value="TKL">TKL</option>
              <option value="Alice">Alice</option>
            </select>
          </div>
          <div class="col-12 col-md-3 pb-3">
            <label for="Profile">Profile Keycap</label>
            <select class="form-select ProfileChange" disabled>
              <option value="Cherry">Cherry</option>
              <option value="MDA">MDA</option>
              <option value="SA">SA</option>
              <option value="Artisan">Artisan</option>
            </select>
          </div>
          <div class="col-12 col-md-3 pb-3">
            <label for="Type">Switch Type</label>
            <select class="form-select TypeChange" disabled>
              <option value="Linear">Linear</option>
              <option value="Tactile">Tactile</option>
              <option value="Clicky">Clicky</option>
              <option value="Silent">Silent</option>
            </select>
          </div>
          <div class="form-floating p-1 mb-3 pb-3">
            <input type="url" class="form-control urlInputChange" id="floatingURL" placeholder="url" disabled>
            <label for="floatingURL">Soundtest URL</label>
          </div>
        `
        let ProductTypeChange = document.querySelector(".ProductTypeChange")
        ProductTypeChange.value = thisProduct['ProductType']
        console.log(thisProduct['ProductType'])
        let SizeChange = document.querySelector(".SizeChange")
        let ProfileChange = document.querySelector(".ProfileChange")
        let TypeChange = document.querySelector(".TypeChange")
        let urlInputChange = document.querySelector(".urlInputChange")
        switch (ProductTypeChange.value) {
          case 'KeyboardKit':
            SizeChange.value = thisProduct['Size']
            SizeChange.disabled = false;
            ProfileChange.disabled = true;
            TypeChange.disabled = true;
            urlInputChange.disabled = true;
            break;
          case 'Prebuild':
            SizeChange.value = thisProduct['Size']
            SizeChange.disabled = false;
            ProfileChange.disabled = true;
            TypeChange.disabled = true;
            urlInputChange.disabled = true;
            break;
          case 'Keycap':
            ProfileChange.value = thisProduct['Profile']
            ProfileChange.disabled = false;
            SizeChange.disabled = true;
            TypeChange.disabled = true;
            urlInputChange.disabled = true;
            break;
          case 'Switch':
            TypeChange.value = thisProduct['Type']
            TypeChange.disabled = false;
            ProfileChange.disabled = true;
            SizeChange.disabled = true;
            urlInputChange.disabled = false;
            urlInputChange.value = thisProduct['SoundTest']
            break;
        }

        ProductTypeChange.addEventListener('change', () => {
          if (ProductTypeChange.value == 'KeyboardKit' || ProductTypeChange.value == 'Prebuild') {
            SizeChange.disabled = false;
            ProfileChange.disabled = true;
            TypeChange.disabled = true;
            urlInputChange.disabled = true;
          } else if (ProductTypeChange.value == 'Keycap') {
            SizeChange.disabled = true;
            ProfileChange.disabled = false;
            TypeChange.disabled = true;
            urlInputChange.disabled = true;
          } else if (ProductTypeChange.value == 'Switch') {
            SizeChange.disabled = true;
            ProfileChange.disabled = true;
            TypeChange.disabled = false;
            urlInputChange.disabled = false;
          }
        })

        ////
        
        document.querySelector('.variant-section').style.display = "Block"
        let variantChangeContainer = document.querySelector(".variant-change-container")
        variantChangeContainer.innerHTML = ""
        if (thisProduct['ProductType'] == 'Keycap' && thisProduct['Variants'][0]['Color'] == "Basic") {
          variantChangeContainer.innerHTML = `
            <div class="row align-items-center variant-change-row">
              <div class="col-12 col-md-6 pb-2">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingChangeColor" placeholder="Basic" value=${thisProduct["Variants"][0]['Color']}>
                  <label for="floatingChangeColor">Color</label>
                </div>
              </div>
              <div class="col-12 col-md-6 pb-2">
                <div class="form-floating mb-3">
                  <input min="0" type="number" class="form-control" id="floatingChangeStock" placeholder="0" value=${thisProduct['Variants'][0]['Stock']}>
                  <label for="floatingChangeStock">Stock</label>
                </div>
              </div>
            </div>
          `
        } else {
          thisProduct['Variants'].forEach(variant => {
            variantChangeContainer.insertAdjacentHTML('beforeend', `
              <div class="row align-items-center variant-change-row">
                <div class="col-12 col-md-6 pb-2">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingChangeColor" data-old="${variant['Color']}" placeholder="Basic" value=${variant['Color']}>
                    <label for="floatingChangeColor">Color</label>
                  </div>
                </div>
                <div class="col-12 col-md-6 pb-2">
                  <div class="form-floating mb-3">
                    <input min="0" type="number" class="form-control" id="floatingChangeStock" placeholder="0" value=${variant['Stock']}>
                    <label for="floatingChangeStock">Stock</label>
                  </div>
                </div>
              </div>
            `)
          })
        }
        
        let formData = new FormData()
        let variantRows = document.querySelectorAll('.variant-change-row');
        variantRows.forEach(row => {
          const colorInput = row.querySelector('#floatingChangeColor');
          formData.append(`OldColor[]`, colorInput.value)
        });
        document.querySelector('.save-section').innerHTML = `
          <h4 class="p-2">If you want to delete a variant, set its stock to <span style="color: red;">0</span>, if you want to delete the whole product, click <span style="color: red;">DELETE</span></h4>
          <div class="d-flex align-items-start">
          <button class='btn btn-outline-danger delete-btn' style="font-weight: bold; font-size: 20px; padding: 3px 10px; height: 40px;">DELETE</button>
            <button class='btn btn-primary ms-auto save-btn' style=" font-size: 20px; padding: 3px 10px; height: 40px;">SAVE TO DATABASE</button>
          </div>
        `
        document.querySelector(".product-information").scrollIntoView({ behavior: 'smooth' })

        let saveBtn = document.querySelector('.save-btn')
        let deleteBtn = document.querySelector(".delete-btn")

        saveBtn.addEventListener('click', async () => {
          
          formData.append("ProductID", thisProduct['ProductID'])
          let updateName = document.querySelector("#floatingChangeName").value;
          let updatePrice = document.querySelector("#floatingChangePrice").value;
          let updateDescription = document.querySelector("#floatingChangeTextarea").value;
          if (!updateName || !updatePrice || !updateDescription || (urlInputChange.value == "" && !urlInputChange.disabled)) {
            alert('Please fill all the fields!')
            return;
          }
          let allValid = true;
          let variantRows = document.querySelectorAll('.variant-change-row');
          for (const row of variantRows) {
          // variantRows.forEach(row => {
            const colorInput = row.querySelector('#floatingChangeColor');
            const stockInput = row.querySelector('#floatingChangeStock');
          
            if (!colorInput.value.trim() || !stockInput.value.trim()) {
              allValid = false;
            }
            if (isNaN(stockInput.value)) {
              alert("Stock must be a number")
              return;
            }
            if (colorInput.value == "Basic") {
              for (const row_1 of variantRows) {
                const color_1 = row_1.querySelector('#floatingChangeColor').value;
                const stock_1 = row_1.querySelector('#floatingChangeStock').value;
                if (color_1 != "Basic" || stock_1 != stockInput.value) {
                  alert("Invalid Variant!")
                  allValid = false;
                  return;
                }
              }
            }
            if (allValid) {
              formData.append(`Color[]`, colorInput.value)
              formData.append(`Stock[]`, stockInput.value)
            } else {
              return;
            }
            
          // });
          }
          if(!allValid) {
            alert('Please fill all the fields!')
            return;
          }
          let newProductType = ProductTypeChange.value;
          let newSize;
          let newProfile;
          let newType;
          let newURL;
          if (!SizeChange.disabled) {
            newSize = SizeChange.value
          } else {
            newSize = null;
          }

          if (!ProfileChange.disabled) {
            newProfile = ProfileChange.value
            console.log(newProfile)
          } else {
            newProfile = null;
          }

          if (!TypeChange.disabled) {
            newType = TypeChange.value
          } else {
            newType = null;
          }

          if (!urlInputChange.disabled) {
            newURL = urlInputChange.value;
          } else {
            newURL = null;
          }
          updateDescription = updateDescription.replace(/-/g, '\n-')
          let response = await fetch(`models/update_product_information.php?ProductID=${thisProduct['ProductID']}&name=${updateName}&price=${updatePrice}&description=${updateDescription}&ProductType=${newProductType}&Size=${newSize}&Profile=${newProfile}&Type=${newType}&SoundTest=${newURL}`)
          response = await response.json()
          console.log("response: ")
          console.log(response)
          // console.log(formData)

          fetch('models/update_product_information.php?updateVariant=true', {
            method: 'POST',
            body: formData
          }).then(res => res.text())
          .then(data => {
            console.log(data)
            alert("Update successful!")
            if (document.querySelector('.product-information')) {
              document.querySelector('.product-information').innerHTML = ''
            }
            if (document.querySelector('.product-change-option')) {
              document.querySelector('.product-change-option').innerHTML = ''
            }
            if (document.querySelector('.variant-section')) {
              document.querySelector('.variant-section').style.display = 'None'
            }
            nameSearchInput.value = ''
          })
        })

        deleteBtn.addEventListener('click', () => {
          fetch(`models/delete_product_db.php?ProductID=${thisProduct['ProductID']}`).then(res => res.text())
          .then(() => {
            alert("Deleted product from DataBase!")
            if (document.querySelector('.product-information')) {
              document.querySelector('.product-information').innerHTML = ''
            }
            if (document.querySelector('.product-change-option')) {
              document.querySelector('.product-change-option').innerHTML = ''
            }
            if (document.querySelector('.variant-section')) {
              document.querySelector('.variant-section').style.display = 'None'
            }
            nameSearchInput.value = ''
          })
        })
      })
    })
  } catch (error) {
    console.error('Error:', error);
  }
  
})


let acceptBtns = document.querySelectorAll(".accept-btn")
let declineBtns = document.querySelectorAll(".decline-btn")

acceptBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    console.log("click")
    fetch(`models/update_order_status.php?OrderID=${btn.dataset.id}&status=accept`)
    .then(res => res.json())
    .then((data) => {
      console.log(data)
      declineBtns.forEach(decBtn => {
        if (decBtn.dataset.id === btn.dataset.id) {
          decBtn.style.display = 'None'
        }
      })
      btn.style.display = 'None'
    })
  })
})

declineBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    console.log("click")
    fetch(`models/update_order_status.php?OrderID=${btn.dataset.id}&status=decline`)
    .then(res => res.json())
    .then((data) => {
      console.log(data)
      acceptBtns.forEach(accBtn => {
        if (accBtn.dataset.id === btn.dataset.id) {
          accBtn.style.display = 'None'
        }
      })
      btn.style.display = 'None'
    })
  })
})
