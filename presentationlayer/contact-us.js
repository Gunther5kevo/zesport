const inputFName = document.querySelector("#fname");
const inputLName = document.querySelector("#lname");
const email = document.querySelector("#email");
const phoneNumber = document.querySelector("#phoneNumber");
const submitButton = document.querySelector("#button");

let isFNameValid = false;
let isLNameValid = false;
let isEmailValid = false;
let isPhoneNumberValid = false;

let isFormValid = false;

inputFName.addEventListener("input", (e) => {
  isFNameValid = validateFName(e.target.value);
  updateFormValidity();
});
inputLName.addEventListener("input", (e) => {
    isLNameValid = validateLName(e.target.value);
    updateFormValidity();
  });
email.addEventListener("input", (e) => {
  isEmailValid = validateEmail(e.target.value);
  updateFormValidity();
});
phoneNumber.addEventListener("input", (e) => {
  isPhoneNumberValid = validatePhoneNumber(e.target.value);
  updateFormValidity();
});


function validateFName(value) {
  const error = document.querySelector("#fname + .error-message");
  const regEx = /^[A-Za-z' ]+$/;
  const isValid = regEx.test(value) || value === "";

  if (!isValid) {
    inputFName.classList.add("error");
    error.textContent = "Only letters and white space allowed";
  } else {
    inputFName.classList.remove("error");
    error.textContent = "";

    return true;
  }
}

function validateLName(value) {
    const error = document.querySelector("#lname + .error-message");
    const regEx = /^[A-Za-z' ]+$/;
    const isValid = regEx.test(value) || value === "";
  
    if (!isValid) {
      inputLName.classList.add("error");
      error.textContent = "Only letters and white space allowed";
    } else {
      inputLName.classList.remove("error");
      error.textContent = "";
  
      return true;
    }
  }

function validateEmail(value) {
  const error = document.querySelector("#email + .error-message");
  const regEx =
    /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
  const isValid = regEx.test(value) || value === "";

  if (!isValid) {
    email.classList.add("error");
    error.textContent = "Invalid email format";
  } else {
    email.classList.remove("error");
    error.textContent = "";

    return true;
  }
}

function validatePhoneNumber(value) {
  const error = document.querySelector("#phoneNumber + .error-message");
  const regEx = /^\d{10,}$/;

  const isValid = regEx.test(value) || value === "";

  if (!isValid) {
    phoneNumber.classList.add("error");
    error.textContent = "Phone Number should be atleast 10 digits";
  } else {
    phoneNumber.classList.remove("error");
    error.textContent = "";

    return true;
  }
}


function updateFormValidity() {
    isFormValid =
      isFNameValid && isLNameValid && isEmailValid && isPhoneNumberValid;
  
    if (isFormValid) {
      submitButton.removeAttribute("disabled");
    } else {
      submitButton.setAttribute("disabled", "disabled");
    }
}