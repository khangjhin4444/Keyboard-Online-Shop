function renderLogin() {
  document.querySelector('.right-side').innerHTML = `
    <div class="login-box">
      <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
        <h2 style="margin: 0; color: #000; font-family: Roboto; font-size: 35px; font-weight: 700; letter-spacing: -1px;">Welcome back</h2>
        <div style="display: flex; align-items: center; justify-content: center; column-gap: 6px;">
          <p style="color: #878787; font-family: Roboto; font-size: 15px;">New to App?</p>
          <a class="sign-up-ui" style="font-size: 15px; cursor: pointer; color: var(--primary, #3B9AB8); text-decoration: underline;">Sign up</a>
        </div>
      </div>

      <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 4px;">
        <p style="color: #000; font-size: 20px;">User name</p>
        <input class="email" placeholder="User name" style="width: 483px; padding: 14px; border-radius: 10px; border: 1px solid #B6B6B8;">
      </div>

      <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 4px;">
        <p style="color: #000; font-size: 20px;">Your password</p>
        <div style="position: relative; width: 490px;">
          <input class="password" id="password" type="password" placeholder="Enter password" style="width: 483px; padding: 14px; border-radius: 10px; border: 1px solid #B6B6B8;">
          <button id="togglePassword" type="button" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); background: none; border: none; cursor: pointer;" tabindex="-1">
            <img id="eyeIcon" src="https://cdn-icons-png.flaticon.com/512/709/709612.png" alt="Show" style="width: 20px; height: 20px;">
          </button>
        </div>
      </div>

      <div style="display: flex; flex-direction: column; gap: 16px; width: 483px; align-items: center;">
        <button class="login-button inactive" disabled>Login</button>
        <a class="forgot-ui" style="font-size: 15px; cursor: pointer; color: var(--primary, #3B9AB8); text-decoration: underline;">Forgot password?</a>

        <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
          <p>Or log in with</p>
          <div class="last-row">
            <button><img style="width: 22px;" src="images/google.png"></button>
            <button><img style="width: 22px;" src="images/Facebook.png"></button>
          </div>
        </div>
      </div>
    </div>
  `;

  const passwordInput = document.getElementById('password');
  const togglePassword = document.getElementById('togglePassword');
  const eyeIcon = document.getElementById('eyeIcon');
  const loginButton = document.querySelector('.login-button');
  const emailInput = document.querySelector('.email');

  // Toggle password visibility
  togglePassword.addEventListener('click', () => {
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    eyeIcon.src = isPassword
      ? 'https://cdn-icons-png.flaticon.com/512/709/709620.png'
      : 'https://cdn-icons-png.flaticon.com/512/709/709612.png';
  });

  // Enable login button only if both fields are filled
  function updateLoginButtonState() {
    const isEmailFilled = emailInput.value.trim() !== '';
    const isPasswordFilled = passwordInput.value.trim() !== '';
    if (isEmailFilled && isPasswordFilled) {
      loginButton.classList.remove('inactive');
      loginButton.disabled = false;
    } else {
      loginButton.classList.add('inactive');
      loginButton.disabled = true;
    }
  }

  emailInput.addEventListener('input', updateLoginButtonState);
  passwordInput.addEventListener('input', updateLoginButtonState);

  // Allow Enter key to trigger login
  passwordInput.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' && !loginButton.disabled) {
      loginButton.click();
    }
  });

  document.querySelector('.sign-up-ui').addEventListener('click', renderSignUp);

  document.querySelector('.forgot-ui').addEventListener('click', () => {
    document.querySelector('.right-side').innerHTML = "<h1>Forgot password page</h1>";
  });

  loginButton.addEventListener('click', () => {
    const username = emailInput.value.trim();
    const password = passwordInput.value.trim();

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "models/login.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
      if (this.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.success === true) {
          console.log(response.admin)
          if (response.admin === true) {
            window.location.href = 'admin.php';
          } else {
            window.location.href = "index.php";
          }
        } else {
          alert("Wrong Username or Password!");
          emailInput.value = '';
          passwordInput.value = '';
          updateLoginButtonState();
        }
      }
    };

    const data = { username, password };
    xhr.send(JSON.stringify(data));
  });
}


function renderSignUp() {
  document.querySelector('.right-side').innerHTML = `
    <form class="login-box" action="" method="post">
      <div style="display: flex;
          flex-direction: column;
          align-items: center;
          gap: 8px;">
        <h2 style="margin: 0;
          color: #000;
          font-family: Roboto;
          font-size: 35px;
          font-style: normal;
          font-weight: 700;
          line-height: normal;
          letter-spacing: -1px;
          ">Hey there</h2>
        <div style="display: flex;
          align-items: center;
          justify-content: center;
          column-gap: 6px;">
          <p style="color: #878787;
              font-family: Roboto;
              font-size: 15px;
              font-style: normal;
              font-weight: 400;
              line-height: normal;">Already know App?</p>
          <a class="log-in-ui" style="font-size: 15px;
            cursor: pointer;
            color: var(--primary, #3B9AB8);
            text-decoration-line: underline;
            text-decoration-style: solid;
            text-decoration-skip-ink: auto;
            text-decoration-thickness: auto;
            text-underline-offset: auto;
            text-underline-position: from-font;">Log In</a>
        </div>
      </div>

      <div style="display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;">
        <p style="color: #000;
        font-size: 20px;
        font-weight: 400;">User name</p>
        <input required class="email" placeholder="User name" style="
        width: 483px;
        padding-left: 14px;
        padding-top: 14px;
        padding-bottom: 16px;
        align-items: center;
        border-radius: 10px;
        border: 1px solid #B6B6B8;">
        <div class="email-notification">
        </div>
      </div>

      <div style="display: flex;
                  flex-direction: column;
                  align-items: flex-start;
                  gap: 4px;">
        <p style="color: #000;
                  font-size: 20px;
                  font-weight: 400;">Your password</p>
        <div style="position: relative; width: 490px;">
          <input required id="password1" 
                type="password" 
                placeholder="Enter password" 
                style="display: flex;
                        width: 483px;
                        padding-left: 14px;
                        padding-top: 14px;
                        padding-bottom: 16px;
                        align-items: center;
                        gap: 10px;
                        border-radius: 10px;
                        border: 1px solid #B6B6B8;">
          <button id="togglePassword1" 
                  type="button" 
                  style="position: absolute;
                        top: 50%;
                        right: 10px;
                        transform: translateY(-50%);
                        background: none;
                        border: none;
                        cursor: pointer;" tabindex="-1">
            <img id="eyeIcon1" 
                src="https://cdn-icons-png.flaticon.com/512/709/709612.png" 
                alt="Show" 
                style="width: 20px; height: 20px;">
          </button>
        </div>
        <ul>
          <li>Contain 10-20 characters</li>
          <li>At least 1 Uppercase letter and 1 Number</li>
        </ul>
      </div>

      <div style="display: flex;
                  flex-direction: column;
                  align-items: flex-start;
                  gap: 4px;">
        <p style="color: #000;
                  font-size: 20px;
                  font-weight: 400;">Confirm your password</p>
        <div style="position: relative; width: 490px;">
          <input required id="password2" 
                type="password" 
                placeholder="Enter password" 
                style="display: flex;
                        width: 483px;
                        padding-left: 14px;
                        padding-top: 14px;
                        padding-bottom: 16px;
                        align-items: center;
                        gap: 10px;
                        border-radius: 10px;
                        border: 1px solid #B6B6B8;">
          <button id="togglePassword2" 
                  type="button" 
                  style="position: absolute;
                        top: 50%;
                        right: 10px;
                        transform: translateY(-50%);
                        background: none;
                        border: none;
                        cursor: pointer;" tabindex="-1">
            <img id="eyeIcon2" 
                src="https://cdn-icons-png.flaticon.com/512/709/709612.png" 
                alt="Show" 
                style="width: 20px; height: 20px;">
          </button>
        </div>
        <p class="display-message" style="color: red; font-size: 14px; margin: 4px 0 0;"></p>
      </div>
      

      <div style="display: flex;
            flex-direction: column;
            gap: 16px;
            width:483px;
            align-items: center;
            justify-content: center;">
        <button class="login-button" type="submit">Continue</button>

        <div style="display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        align-self: stretch;">
          <p>Or log in with</p>
          <div class="last-row">
            <button><img style="width: 22px;" src="images/google.png"></button>
            <button><img style="width: 22px;" src="images/Facebook.png"></button>
          </div>
        </div>
      </div>
    </form>
  `;

  const form = document.querySelector(".login-box");

  function togglePasswordVisibility(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById(iconId);

    eyeIcon.addEventListener('click', () => {
      const isPassword = passwordInput.type === 'password';
      passwordInput.type = isPassword ? 'text' : 'password';
      // Change the eye icon based on the state
      eyeIcon.src = isPassword
        ? 'https://cdn-icons-png.flaticon.com/512/709/709620.png'  // Eye with slash (Hide)
        : 'https://cdn-icons-png.flaticon.com/512/709/709612.png'; // Eye (Show)
    });
  }

  // Apply toggle function to both password fields
  togglePasswordVisibility('password1', 'eyeIcon1');
  togglePasswordVisibility('password2', 'eyeIcon2');


  const passwordInput1 = document.getElementById('password1');
  const passwordInput2 = document.getElementById('password2');
  const displayMessage = document.querySelector('.display-message');


  function checkPasswordMatch() {
    if (passwordInput1.value && passwordInput2.value && document.querySelector('.email').value) {
      if (passwordInput1.value === passwordInput2.value) {
        passwordInput2.setCustomValidity("");
      } else {
        passwordInput2.setCustomValidity("Un-match password")
      }
    } else {
      displayMessage.textContent = "";
    }
  }

  function checkPasswordValid() {
    const password = passwordInput1.value;
    // Kiểm tra độ dài
    const lengthValid = password.length >= 10 && password.length <= 20;
    // Kiểm tra có ít nhất 1 số
    const hasNumber = /\d/.test(password);
    // Kiểm tra có ít nhất 1 chữ in hoa
    const hasUpperCase = /[A-Z]/.test(password);
    if (!lengthValid) {
      passwordInput1.setCustomValidity("Length must be 10-20 characters")
    } else if (!hasNumber) {
      passwordInput1.setCustomValidity("Must contains at least 1 number")
    } else if (!hasUpperCase) {
      passwordInput1.setCustomValidity("Must contains at least 1 uppercase letter")
    } else {
      passwordInput1.setCustomValidity("")
    }
  }



  passwordInput1.addEventListener('input', checkPasswordValid);
  passwordInput2.addEventListener('input', checkPasswordMatch);

  const emailInput = document.querySelector(".email");
  let afterChecked = false;
  emailInput.addEventListener('input', () => {
    // if (!emailInput.value.includes("@gmail.com")) {
    //   emailInput.setCustomValidity("Must contains @gmail.com");
    // } else {
    //   emailInput.setCustomValidity("");
    // }
    checkPasswordMatch();
    // const check_mail = await eel.check_email(emailInput.value)();
    // console.log(check_mail);
    // if (check_mail > 0) {
    //   alert("Email is already taken.");
    //   afterChecked = true;
    // }
    // else {
    //   afterChecked = false;
    // }
  })

  document.querySelector('.log-in-ui').addEventListener('click', () => {
    renderLogin();
  });


  form.addEventListener('submit', async (e) => {

    if (!afterChecked || !emailInput.checkValidity() || !passwordInput1.checkValidity()) {
      e.preventDefault();
    }


    const savedUserName = emailInput.value;
    const savedPassword = passwordInput1.value;
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "models/register.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    let data = "username=" + encodeURIComponent(savedUserName) + "&password=" + encodeURIComponent(savedPassword);

    xhr.onload = function() { 
      if (xhr.status == 200) {  
        let response = JSON.parse(xhr.responseText);
        if (response.exist == true) {
          window.alert("Existing username, please choose other username!");
          renderSignUp();
        } else if (response.passCheck == true) {
          window.alert("Invalid Password!");
          renderSignUp();
        } else {
          renderInformationInput(savedUserName, savedPassword);
        }
      }
    };
    xhr.send(data);
    
  })


}


function renderInformationInput(savedUserName, savedPassword) {
  let html = `
    <form class="login-box">
      <div style="display: flex;
          flex-direction: column;
          align-items: center;
          gap: 8px;">
        <h2 style="margin: 0;
          color: #000;
          font-family: Roboto;
          font-size: 35px;
          font-style: normal;
          font-weight: 700;
          line-height: normal;
          letter-spacing: -1px;
          ">Hey there</h2>
        <div style="display: flex;
          align-items: center;
          justify-content: center;
          column-gap: 6px;">
          <p style="color: #878787;
              font-family: Roboto;
              font-size: 15px;
              font-style: normal;
              font-weight: 400;
              line-height: normal;">Already know App?</p>
          <a class="log-in-ui" style="font-size: 15px;
            cursor: pointer;
            color: var(--primary, #3B9AB8);
            text-decoration-line: underline;
            text-decoration-style: solid;
            text-decoration-skip-ink: auto;
            text-decoration-thickness: auto;
            text-underline-offset: auto;
            text-underline-position: from-font;">Log In</a>

          <a class="go-back" style="font-size: 15px;
            cursor: pointer;
            margin-left: 10px;
            color: var(--primary, #3B9AB8);
            text-decoration-line: underline;
            text-decoration-style: solid;
            text-decoration-skip-ink: auto;
            text-decoration-thickness: auto;
            text-underline-offset: auto;
            text-underline-position: from-font;">Go back</a>
        </div>
      </div>

      <div style="display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;">
        <p style="color: #000;
        font-size: 20px;
        font-weight: 400;">Full name</p>
        <input required class="name" placeholder="Name" style="
        width: 483px;
        padding-left: 14px;
        padding-top: 14px;
        padding-bottom: 16px;
        align-items: center;
        border-radius: 10px;
        border: 1px solid #B6B6B8;">
      </div>

      <div style="display: flex;
                  flex-direction: column;
                  align-items: flex-start;
                  gap: 4px;">
        <p style="color: #000;
                  font-size: 20px;
                  font-weight: 400;">Phone Number</p>
        <div required style="position: relative; width: 490px;">
          <input class="phone" id="phone" 
                type="id" 
                placeholder="Enter Phone Number" 
                style="display: flex;
                        width: 483px;
                        padding-left: 14px;
                        padding-top: 14px;
                        padding-bottom: 16px;
                        align-items: center;
                        gap: 10px;
                        border-radius: 10px;
                        border: 1px solid #B6B6B8;">
        </div>
      </div>

      <div style="display: flex;
                  flex-direction: column;
                  align-items: flex-start;
                  gap: 4px;">
        <p style="color: #000;
                  font-size: 20px;
                  font-weight: 400;">Address</p>
        <div style="position: relative; width: 490px;">
          <input class="address" required id="address" 
                type="text" placeholder="Enter Address"
                style="display: flex;
                        width: 483px;
                        padding-left: 14px;
                        padding-top: 14px;
                        padding-bottom: 16px;
                        align-items: center;
                        gap: 10px;
                        border-radius: 10px;
                        border: 1px solid #B6B6B8;">
        </div>
      </div>

    
  `;
  


  html += `
      <div style="display: flex;
            flex-direction: column;
            gap: 16px;
            width:483px;
            align-items: center;
            justify-content: center;">
        <button class="login-button" type="submit">Sign Up</button>
      </div>
    </form>
  `;
  document.querySelector(".right-side").innerHTML = html;

  document.querySelector('.log-in-ui').addEventListener('click', () => {
    renderLogin();
  });

  document.querySelector('.go-back').addEventListener('click', () => {
    renderSignUp();
  });


  const form = document.querySelector(".login-box");

  const nameInput = form.querySelector(".name");
  const phoneInput = form.querySelector(".phone");
  const addressInput = form.querySelector(".address");

  function checkPhone() {
    if (phoneInput.value.length === 10 && /^[0][1-9]{9}$/.test(phoneInput.value)) {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "models/register.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      let data = "phone=" + encodeURIComponent(phoneInput.value);
      xhr.onload = function() { 
        if (xhr.status == 200) {  
          let response = JSON.parse(xhr.responseText);
          if (response.exist == true) {
            phoneInput.setCustomValidity("Existing Phone Number, please choose other Phone Number!");
          } else if (response.passCheck == true) {
            phoneInput.setCustomValidity("Invalid Phone Number!");
          } else {
            phoneInput.setCustomValidity("");
          }
        }
      };
      xhr.send(data);
    } else {
      phoneInput.setCustomValidity("Phone Number must contains 10 numbers")
    }
  }

  phoneInput.addEventListener("input", checkPhone)
  form.addEventListener('submit', async (e) => {
    if (!phoneInput.checkValidity()) {
      e.preventDefault();
      return;
    }
    e.preventDefault();
    const fullName = nameInput.value;
    const phone = phoneInput.value;
    const address = addressInput.value;
    let userData = {
      name: fullName,
      phone: phone,
      address: address,
      username: savedUserName,
      password: savedPassword
    };
    console.log(userData);
      // const insert_patient = await eel.insert_user(fullName, id, savedEmail, savedPassword, gender, dob, 'PATIENT', formattedDate);
      // console.log(insert_patient);
    // Them else add vao db cho patient
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "models/add_user_to_db.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = function() {
      if (xhr.status == 200) {
        let response = JSON.parse(xhr.responseText);
        if (!response.invalid) {
          setTimeout(
            alert("Sign up successful")
            , 1000)
          renderLogin();
        }
      }
    };
    
    xhr.send(JSON.stringify(userData));
    
  })
}


renderLogin();