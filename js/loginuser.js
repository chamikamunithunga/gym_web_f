document.getElementById('login_form').addEventListener('submit', function(e) {
  e.preventDefault();

  let toastBox = document.getElementById('toastBox');

  
  let errorMsg = '<i class="fa-solid fa-circle-xmark"></i> Incorrect email or password. Please try again';
  let invalidMsg = '<i class="fa-solid fa-circle-exclamation"></i> Invalid Please fill in all fields';

  let email = document.getElementById('email').value;
  let password = document.getElementById('password').value;

  if (email === '' || password === '') {
    // alert('Please fill in all fields');
    showToast(invalidMsg);
    return;
  }else{
    var formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
  }

  

  fetch('PHP/process_login.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.text()) // Expecting text response
    .then((data) => {
      if (data.includes('Login Successful')) {
        alert('Login successful!');
        
        setSessionWithExpiry("email", email, 604800000);
        window.location.href = './PHP/profile.php';
      } else {
        //  alert("Invalid email or password. Please try again" + data);
         document.getElementById('login_form').reset(); // Reset form
         showToast(errorMsg);
      }
    })
    .catch((error) => {
      alert(error);
      document.getElementById('login_form').reset(); // Reset form
    });
});

function setSessionWithExpiry(key, value, ttl) {
  const now = new Date();

 
  const item = {
      value: value,
      expiry: now.getTime() + ttl,
  };
  localStorage.setItem(key, JSON.stringify(item));
}

function showToast(msg) {
  let toast = document.createElement("div");
  toast.classList.add("toast");
  toast.innerHTML = msg;
  toastBox.appendChild(toast);

  if (msg.includes("Incorrect")) {
    toast.classList.add("error");
  }
  if (msg.includes("Invalid")) {
    toast.classList.add("Invalid");
  }
  setTimeout(function () {
    toast.remove();
  }, 3000);
}

