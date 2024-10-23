<?php
 include 'imageupload.php';
 session_start();
 $image = null;
    
   if(isset($_SESSION['userId'])!= null){

    $user_id = $_SESSION['userId'];

    $plan_id = isset($_POST['plane_Id']) ? $_POST['plane_Id'] : null;
    $plane_Name = isset($_POST['plane_Name']) ? $_POST['plane_Name'] : null;
    $price = isset($_POST['plane_Price']) ? $_POST['plane_Price'] : null;
    $date = isset($_POST['date']) ? $_POST['date'] : null;
    $expiry_date = isset($_POST['expireddate']) ? $_POST['expireddate'] : null;
    $mebership = isset($_POST['membership']) ? $_POST['membership'] : null;
    // echo $price;
    $price = preg_replace('/[^0-9]/', '', $price); 
    $price = (float)$price;
    $vat = $price * 0.21;
    $total = $price + $vat;
    
    
   }else{
       echo "<script> window.location.href = '../login.html';</script>";
    //    header("Location: ../login.html");
       exit();
   }

    if(isset($_FILES['image'])){
     $image = $_FILES['image'];
     $imagePath = saveImage($image);
     if ($imagePath) {
          echo $imagePath;
          exit();
     } else {
          echo 'failed';
     }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Payment </title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            gap: 20px;
            width: 100%;
            height: 100vh;
            /* border: 1px solid red; */
        }

        .payment-options,
        .order-summary {
            width: 45%;
            height: 100%;
            /* border: 1px solid red; */
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .order-summary-inner {
            width: 70%;
            height: 80%;
            border: 3px solid rgb(9, 9, 9);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 25px;
        }

        .payment-options-inner {
            width: 100%;
            height: 80%;
            /* border: 5px solid rgb(9, 9, 9); */

            display: flex;
            flex-direction: column;

        }

        .order-summary-inner-1 {
            width: 100%;
            height: 30%;
            /* border : 1px solid red; */
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        h3 {
            color: rgb(9, 9, 9);
            font-size: 20px;
            font-weight: 600;
            padding: 6px;
            text-align: left;
        }

        .order-summary-inner-2 {
            width: 100%;
            height: 20%;
            /* border : 1px solid red; */
            display: flex;
            justify-content: center;
        }

        .order-summary-inner-3 {
            width: 100%;
            height: 10%;
            /* border : 1px solid red; */
            display: flex;
            justify-content: center;
        }

        .order-summary-inner-4 {
            width: 100%;
            height: 30%;
            /* border : 1px solid red;  */
            display: flex;
            align-items: center;
            justify-content: start;
            flex-direction: column;
            padding: 5px;
        }

        .label {
            padding-right: 20px;
            /* Adjust as needed */
        }

        .colon {
            padding-right: 5px;
            /* Adds space after the colon */
        }

        .discount-section {
            width: 100%;
            height: 50%;
            /* border : 1px solid red;  */
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 10px;
        }

        .btn {
            width: 80%;
            height: 40px;
            background-color: rgb(235, 191, 14);
            color: rgb(8, 8, 8);
            font-size: 17px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
        }

        .inner-div {
            /* border: 1px solid red; */
            width: 80%;
        }

        .payment-options-inner-1 {
            width: 100%;
            height: 45%;
            /* border : 1px solid red;  */
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .payamnt-button {
            width: 90%;
            height: 60px;
            border-radius: 20px;
            background-color: rgba(238, 238, 238, 0.444);
            border: 2px solid rgb(8, 8, 8);
            margin: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .payamnt-button-1 {
            width: 50%;
            height: 100%;

            background-color: rgba(238, 238, 238, 0.444);
            /* border: 2px solid rgb(8, 8, 8); */
            display: flex;
            align-items: center;
            padding: 10px;

        }

        .image {
            justify-content: end;
        }

        .img {
            width: 100px;
            height: 25px;
            margin-right: 10px;
        }

        .Select {
            width: 20px;
            height: 20px;
            border-radius: 100%;
            background-color: rgb(21, 0, 128);
        }

        .slipshow_div {
            width: 100%;
            height: 85%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            /* border: 1px solid rgb(8, 0, 255); */
        }

        .img-show {
            width: 90%;
            height: 80%;
            border: 2px solid rgb(16, 16, 16);
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
        }

        img {
            width: 70%;
            height: 100%;
            /* border: 1px solid red; */
        }

        .btn_show {
            width: 100%;
            height: 15%;
            /* border: 1px solid rgb(8, 0, 255); */
            display: flex;
            justify-content: center;
            padding: 5px;
        }

        input {
            width: 280px;
            font-size: 18px;

        }
        
        /* Full-screen overlay */
#loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.7);  /* Light opaque background */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999; /* Make sure it's above other elements */
    backdrop-filter: blur(5px); /* Apply blur effect */
}

/* Spinner styling */
.spinner {
    border: 12px solid #f3f3f3;
    border-radius: 50%;
    border-top: 12px solid #3498db;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}




    </style>
</head>

<body>

    <div class="container">
        <h4 onclick="goBack()" style="cursor: pointer;">Back</h4>
        <div class="payment-options">

            <div class="payment-options-inner">
                <h2> Select your Payment option </h2>
                <div class="payment-options-inner-1">
                    <div class="payamnt-button" style="background-color: rgba(0, 0, 0, 0.147);">
                        <div class="payamnt-button-1">
                            <h4>Credit Cardes &nbsp;<h5>(Not avilibale yet)</h5>
                            </h4>
                        </div>
                        <div class="payamnt-button-1 image">
                            <img class="img" src="../img/logo/img2.png" alt="">
                        </div>
                    </div>
                    <div class="payamnt-button" style="background-color: rgba(0, 0, 0, 0.147);">
                        <div class="payamnt-button-1">
                            <h4>KoKo&nbsp; <h5>(Not avilibale yet)</h5>
                            </h4>
                        </div>
                        <div class="payamnt-button-1 image">
                            <img class="img" src="../img/logo/Slider-Banner-Koko.png" alt="">
                        </div>
                    </div>
                    <div class="payamnt-button">
                        <div class="payamnt-button-1">
                            <h4>Paymnet Slip Upload</h4>
                        </div>
                        <div class="payamnt-button-1 image">
                            <div class="Select"></div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="payment-options-inner-1">
                    <div class="slipshow_div">
                        <div class="img-show" id="img-show">
                            <img src="" alt="upload image" id="image-preview">
                        </div>
                    </div>
                    <div class="btn_show">
                        <input type="file" value="Select" id="file-select" accept="image/*"
                            onchange="showImagePreview()">
                    </div>
                </div>

            </div>
        </div>

        <div class="order-summary">
            <div class="order-summary-inner">
                <h2>Order summery </h2>
                <div class="order-summary-inner-1">
                    <div class="inner-div">
                        <h3><span class="label">Payment</span><span class="colon">:</span><?php echo $mebership;?></h3>
                        <h3><span class="label">Id</span><span class="colon">:</span><?php echo $plan_id;?></h3>
                        <h3><span class="label">Duration</span><span class="colon">:</span> <?php echo $plane_Name;?></h3>
                    </div>
                </div>
                <div class="order-summary-inner-2">
                    <div class="inner-div">
                        <h3 id="balnce-ammpunt"><span class="label">Balance Amount </span><span class="colon"> : Rs</span><?php echo $price ?>.00</h3>
                        <h3 id="VAT"><span class="label">VAT(21%)</span><span class="colon">: Rs.</span><?php echo $vat ?>.00</h3>
                    </div>
                </div>
                <div class="order-summary-inner-3">
                    <div class="inner-div">
                        <h3 id="Total"><b><span class="label">Total Amount </span><span class="colon"> : Rs. </span><?php echo $total ?>.00</b></h3>
                        </h3>

                    </div>
                </div>
                <div class="order-summary-inner-4">
                    <button onclick="payment()" class="btn">Confirm payamnt</button>
                    <div class="discount-section">
                        <h5>(No discount or any promotion available at the moment</h5>
                        <h5>If available, it will show here)</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="loading-overlay" style="display: none;">
    <div class="spinner"></div>
    </div>

    
    <script>
        let paymentitem = "<?php echo $mebership; ?>";
        let plan_id = "<?php echo $plan_id; ?>";
        let plane_Name = "<?php echo $plane_Name; ?>";
        let price = "<?php echo $total; ?>";
        let date = "<?php echo $date; ?>";
        let expireddate = "<?php echo $expiry_date; ?>";
        
        
        
        
        function showImagePreview() {
           
            const fileInput = document.getElementById('file-select');
            const imagePreview = document.getElementById('image-preview');
            const file = fileInput.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                alert('Please upload a valid image file.');
            }
        }

        function payment() {
            const fileInput = document.getElementById('file-select');
            const file = fileInput.files[0];

            if (!file) {
                alert('Please select a payment slip to upload.');
               
                return;
            }
            
            const formData = new FormData();
            formData.append('image', file);

            fetch('Payment.php', {
                 method: 'POST',
                 body: formData
             })
             .then(response => response.text())
             .then(result => {
                
                 let paymentSlipLink = "http://localhost/sahan/gym-main/PHP/" + result; 
                 alert(paymentSlipLink); // This will display the returned file path or an error message

                //  let date = date_ND.date.toISOString().slice(0, 10);
                //  let expireddate = expireddate_ND.date.toISOString().slice(0, 10);
                

                 if(paymentitem == "Membership Payment"){

                    //  alert('Membership Payment confirmed. Your payment slip has been uploaded successfully.');

                     let formdata = new FormData();
                       formdata.append('plane_Id', plan_id);
                       formdata.append('plane_Name', plane_Name);
                       formdata.append('plane_Price', price);
                       formdata.append('date', date);
                       formdata.append('expireddate', expireddate);
                       formdata.append('paymnet', paymentSlipLink);

                       document.getElementById('loading-overlay').style.display = 'flex';
        
                        fetch('update_M.php', {
                             method: 'POST',
                             body: formdata
                        }).then(function(response) {
                          return response.text();
                        }).then(function(data) {
                            document.getElementById('loading-overlay').style.display = 'none';
                        if(data.includes('New record created successfully')){
                            alert('Plan added successfully'+ data);
                            window.location.href = 'AfterpaymnetUI.php';
                            
                        } else {
                            alert('Plan not added '+data); 
                            window.location.href = 'profile.php';   
                        }
                        }).catch(function(error) {
                            console.error('Error:', error);
                        });

                 }else if(paymentitem == "Instructor Payment"){

                    let formdata = new FormData();

                       formdata.append('In_Id', plan_id);
                       formdata.append('In_cost', price);
                       formdata.append('date', date);
                       formdata.append('expireddate', expireddate);
                       formdata.append('paymnetLink', paymentSlipLink);

                       document.getElementById('loading-overlay').style.display = 'flex';

                        fetch('updated_I.php', {
                             method: 'POST',
                             body: formdata
                        }).then(function(response) {
                          return response.text();
                        }).then(function(data) {
                            document.getElementById('loading-overlay').style.display = 'none';
                        if(data.includes('Email sent successfully.')){
                            alert('Plan added successfully'+ data);
                             window.location.href = 'AfterpaymnetUI.php';
                              
                        } else {
                            alert('Plan not added '+data); 
                            window.location.href = 'profile.php';
                            //    
                        }
                        }).catch(function(error) {
                            console.error('Error:', error);
                        });

                    // alert('Instructor Payment confirmed. Your payment slip has been uploaded successfully.');

                  
                 }else if(paymentitem == "Membership Payment renewal"){
                    let formdata = new FormData();
                       
                       formdata.append('payment_photo_link', paymentSlipLink);
                       formdata.append('plane_Price', price);
                       document.getElementById('loading-overlay').style.display = 'flex';
                        fetch('renewPayment.php', {
                             method: 'POST',
                             body: formdata
                        }).then(function(response) {
                          return response.text();
                        }).then(function(data) {
                            document.getElementById('loading-overlay').style.display = 'none';
                        if(data.includes('success')){

                            alert('Membership Payment renewal confirmed. Your payment slip has been uploaded successfully.');
                            window.location.href = 'AfterpaymnetUI.php';
                            
                        } else {
                            alert('Payment faild. Please try again.'+data); 
                            // window.location.href = 'profile.php';   
                        }
                        }).catch(function(error) {
                            console.error('Error:', error);
                        });

                    // alert('Membership Payment renewal confirmed. Your payment slip has been uploaded successfully.');
                   
                 }else if(paymentitem == "Instructor Payment renewal"){

                    let formdata = new FormData();
                       
                       formdata.append('payment_photo_link', paymentSlipLink);
                       formdata.append('plane_Price', price);
                       document.getElementById('loading-overlay').style.display = 'flex';
                        fetch('renewInsructor.php', {
                             method: 'POST',
                             body: formdata
                        }).then(function(response) {
                          return response.text();
                        }).then(function(data) {
                            document.getElementById('loading-overlay').style.display = 'none';
                        if(data.includes('success')){

                            alert('Membership Payment renewal confirmed. Your payment slip has been uploaded successfully.');
                            window.location.href = 'AfterpaymnetUI.php';
                            
                        } else {
                            alert('Payment faild. Please try again.'+data); 
                            // window.location.href = 'profile.php';   
                        }
                        }).catch(function(error) {
                            console.error('Error:', error);
                        });

                    //    alert('Instructor Payment renewal confirmed. Your payment slip has been uploaded successfully.');
                   
                 }else{
                     alert('Payment faild. Please try again.');
                 }

             })
             .catch(error => {
                 console.error('Error:', error);
                 alert('Image upload failed.');
             });


            

               
            // Prepare the form data
            // const formData = new FormData();
            // formData.append('image', file);

            // Send the image to the PHP function using fetch
            // fetch('save_image.php', {
            //     method: 'POST',
            //     body: formData
            // })
            // .then(response => response.text())
            // .then(result => {
            //     alert(result);  // This will display the returned file path or an error message
            // })
            // .catch(error => {
            //     console.error('Error:', error);
            //     alert('Image upload failed.');
            // });
        }

                   function goBack() {
                       window.history.back();
                    }


    </script>
</body>

</html>