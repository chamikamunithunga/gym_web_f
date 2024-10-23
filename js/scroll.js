window.onload = function() {
    var element = document.getElementById('pricing_container');
        
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    } else {
        console.log('Div element is missing.');
    }
};

document.getElementById('Week_Plane_P').addEventListener('click', function() {
  
    let date = new Date();
    let expireddate = new Date(date);
    expireddate.setDate(expireddate.getDate() + 7);
    let membership = "Membership Payment"

    // alert(expireddate);
    //  alert('Pricing clicked');
     let plane_Id_El = document.getElementById('P_id_1').textContent;
     let plane_Name_El = document.getElementById('Plan_time_1').textContent;
     let plane_Price_El = document.getElementById('Price_1').textContent;
     
     if(plane_Id_El == "" || plane_Name_El == "" || plane_Price_El == ""){
         alert('somthing went wrong'); 
     }else{
        //    alert('Form Submitted');

            let plane_Id = plane_Id_El.valueOf();
            let plane_Name = plane_Name_El.valueOf();
            let plane_Price = plane_Price_El.valueOf();
            //  alert(plane_Id);

         let formdata = new FormData();
            formdata.append('plane_Id', plane_Id);
            formdata.append('plane_Name', plane_Name);
            formdata.append('plane_Price', plane_Price);
            formdata.append('date', date.toISOString());
            formdata.append('expireddate', expireddate.toISOString());
            formdata.append('membership', membership);  

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'PHP/Payment.php'; // Replace with your PHP file path
        
        // Append the form data values as hidden input elements
        for (let [key, value] of formdata.entries()) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }

        // Append the form to the document body and submit it
        document.body.appendChild(form);
        form.submit();
           
         // console.log('Plane ID:', plane_Id);
        // console.log('Plane Name:', plane_Name);
        // console.log('Plane Price:', plane_Price);
        // console.log('Date:', date.toISOString());
        // console.log('Expired Date:', expireddate.toISOString());
            // fetch('PHP/Payment.php', {
            //     method: 'POST',
            //     body: formdata
            // }).then(function(response) {
            //     return response.text();
            // }).then(function(data) {
            //     if(data.includes('continue')){
            //         // alert('Plan added successfully'+ data);
            //         window.location.href = 'PHP/Payment.php';
            //     } else {
            //         window.location.href = 'login.html';
            //     }
            // }).catch(function(error) {
            //     console.error('Error:', error);
            // });
     }
    
});

document.getElementById('Month_Plane_P').addEventListener('click', function() {

   
    let date = new Date();
    let expireddate = new Date(date);
    expireddate.setMonth(expireddate.getMonth() + 1);
    let membership = "Membership Payment";

    // alert(expireddate);
    //  alert('Pricing clicked');
     let plane_Id_El = document.getElementById('P_id_2').textContent;
     let plane_Name_El = document.getElementById('Plan_time_2').textContent;
     let plane_Price_El = document.getElementById('Price_2').textContent;
     
     if(plane_Id_El == "" || plane_Name_El == "" || plane_Price_El == ""){
         alert('somthing went wrong'); 
     }else{
       

            let plane_Id = plane_Id_El.valueOf();
            let plane_Name = plane_Name_El.valueOf();
            let plane_Price = plane_Price_El.valueOf();

            let formdata = new FormData();
            formdata.append('plane_Id', plane_Id);
            formdata.append('plane_Name', plane_Name);
            formdata.append('plane_Price', plane_Price);
            formdata.append('date', date.toISOString());
            formdata.append('expireddate', expireddate.toISOString());
            formdata.append('membership', membership);  

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'PHP/Payment.php'; 
        
        
        for (let [key, value] of formdata.entries()) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }

        // Append the form to the document body and submit it
        document.body.appendChild(form);
        form.submit();
           

        //  let formdata = new FormData();
        //     formdata.append('plane_Id', plane_Id);
        //     formdata.append('plane_Name', plane_Name);
        //     formdata.append('plane_Price', plane_Price);
        //     formdata.append('date', date.toISOString());
        //     formdata.append('expireddate', expireddate.toISOString());
        //     formdata.append('paymnet', paymnet);
        // // console.log('Plane ID:', plane_Id);
        // // console.log('Plane Name:', plane_Name);
        // // console.log('Plane Price:', plane_Price);
        // // console.log('Date:', date.toISOString());
        // // console.log('Expired Date:', expireddate.toISOString());
        //     fetch('PHP/update_M.php', {
        //         method: 'POST',
        //         body: formdata
        //     }).then(function(response) {
        //         return response.text();
        //     }).then(function(data) {
        //         if(data.includes('New record created successfully')){
        //             alert('Plan added successfully'+ data);
                    
        //         } else {
        //             alert('Plan not added '+data);    
        //         }
        //     }).catch(function(error) {
        //         console.error('Error:', error);
        //     });
     }
    
});



document.getElementById('Year_Plane_P').addEventListener('click', function() {

    let date = new Date();
    let expireddate = new Date(date);
    expireddate.setFullYear(expireddate.getFullYear() + 1);
    let membership = "Membership Payment";

    // alert(expireddate);
    //  alert('Pricing clicked');
     let plane_Id_El = document.getElementById('P_id_3').textContent;
     let plane_Name_El = document.getElementById('Plan_time_3').textContent;
     let plane_Price_El = document.getElementById('Price_3').textContent;
     
     if(plane_Id_El == "" || plane_Name_El == "" || plane_Price_El == ""){
         alert('somthing went wrong'); 
     }else{
        

            let plane_Id = plane_Id_El.valueOf();
            let plane_Name = plane_Name_El.valueOf();
            let plane_Price = plane_Price_El.valueOf();

            let formdata = new FormData();
            formdata.append('plane_Id', plane_Id);
            formdata.append('plane_Name', plane_Name);
            formdata.append('plane_Price', plane_Price);
            formdata.append('date', date.toISOString());
            formdata.append('expireddate', expireddate.toISOString());
            formdata.append('membership', membership);  

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'PHP/Payment.php'; // Replace with your PHP file path
        
        // Append the form data values as hidden input elements
        for (let [key, value] of formdata.entries()) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }

        // Append the form to the document body and submit it
        document.body.appendChild(form);
        form.submit();




            // alert(plane_Id);

        //  let formdata = new FormData();
        //     formdata.append('plane_Id', plane_Id);
        //     formdata.append('plane_Name', plane_Name);
        //     formdata.append('plane_Price', plane_Price);
        //     formdata.append('date', date.toISOString());
        //     formdata.append('expireddate', expireddate.toISOString());
        //     formdata.append('paymnet', paymnet);
        // // console.log('Plane ID:', plane_Id);
        // // console.log('Plane Name:', plane_Name);
        // // console.log('Plane Price:', plane_Price);
        // // console.log('Date:', date.toISOString());
        // // console.log('Expired Date:', expireddate.toISOString());
        //     fetch('PHP/update_M.php', {
        //         method: 'POST',
        //         body: formdata
        //     }).then(function(response) {
        //         return response.text();
        //     }).then(function(data) {
        //         if(data.includes('New record created successfully')){
        //             alert('Plan added successfully'+ data);
                    
        //         } else {
        //             alert('Plan not added '+data);    
        //         }
        //     }).catch(function(error) {
        //         console.error('Error:', error);
        //     });
     }
    
});
