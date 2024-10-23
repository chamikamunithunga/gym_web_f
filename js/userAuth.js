document.getElementById("signupForm").addEventListener("submit", function (e) {
  e.preventDefault();

  let userId = generateID(document.getElementById("username").value, document.getElementById("NIC").value);

  let username = document.getElementById("username").value;
  let password = document.getElementById("Password").value;
  let nic = document.getElementById("NIC").value;
  let email = document.getElementById("email").value;
  let confiemPassword = document.getElementById("Confirm_Password").value;

  let selectedGender = "";

  let genderInputs = document.querySelectorAll('input[name="gender"]');
  for (let i = 0; i < genderInputs.length; i++) {
    if (genderInputs[i].checked) {
      selectedGender = genderInputs[i].value;
      break;
    }
  }
  let p_number = document.getElementById("p_number").value;
  let age = document.getElementById("age").value;

  if (
    userId === "" ||
    username === "" ||
    password === "" ||
    nic === "" ||
    email === "" ||
    confiemPassword === "" ||
    selectedGender === "" ||
    p_number === "" ||
    age === ""
  ) {
    alert("Please fill in all fields");
    return;
  }

  if (password === confiemPassword) {
    var formData = new FormData();
    formData.append("userId", userId);
    formData.append("username", username);
    formData.append("password", password);
    formData.append("nic", nic);
    formData.append("email", email);
    formData.append("selectedGender", selectedGender);
    formData.append("p_number", p_number);
    formData.append("age", age);
    
    document.getElementById("loading-overlay").style.display = "flex";
    // alert("Password and Confirm Password are same");
    // alert("User ID  : " + userId);
    
   
  } else {
    alert("Password and Confirm Password are not same");
    document.getElementById("Password").value = "";
    document.getElementById("Confirm_Password").value = "";
  }

  // Send the form data using fetch
  fetch("PHP/process_signup.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Expecting text response
    .then((data) => {
      document.getElementById("loading-overlay").style.display = "none";
      if (data.includes("Verification email sent!")) {

        setSessionWithExpiry("email", email, 604800000);

        alert("Verification email sent!");
        window.location.href = "PHP/verify.php";
        document.getElementById("signupForm").reset();

        } else if (data.includes("user already exists!")) {
        alert("User already exists!");
        document.getElementById("signupForm").reset();

      } else {
        alert("Signup failed: " + data);
      }
    })
    .catch((error) => console.error("Error:", error));
});

function  generateID( name,nic){

     const firstLetter = name.charAt(0).toUpperCase();
     const Id = nic;

     const userId = `${firstLetter}${Id}`;

     return userId;

}

function setSessionWithExpiry(key, value, ttl) {
  const now = new Date();

 
  const item = {
      value: value,
      expiry: now.getTime() + ttl,
  };
  localStorage.setItem(key, JSON.stringify(item));
}

