document.getElementById("otp-Form").addEventListener("submit", function () {

  let otp = document.getElementById("otp-input1").value + document.getElementById("otp-input2").value + document.getElementById("otp-input3").value + document.getElementById("otp-input4").value;

  // Send OTP to process_signup.php
  fetch('http://localhost:8080/vcode_chek.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ otp: otp })
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    if (data.includes('Email verification successful')) {
      alert("OTP Matched");
      window.location.href = 'PHP/dashbord.php';
    } else {
      alert("Invalid OTP");
    }
  })
  .catch((error) => {
    console.error(error);
    alert("An error occurred. Please try again later.");
  });

  
});






