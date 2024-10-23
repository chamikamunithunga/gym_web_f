let date = new Date();
let expireddate = new Date(date);
let membership = "Instructor Payment";
let In_Name = "One month";
expireddate.setMonth(expireddate.getMonth() + 1);

document.getElementById("IN_01").addEventListener("click", function () {
  
    
    let In_Id = document.getElementById("In_Id_1").textContent;
    let In_cost = document.getElementById("Price_1").textContent;

    // let formdata = new FormData();
    // formdata.append("In_Id", In_Id);
    // formdata.append("In_cost", In_cost);
    // formdata.append("date", date.toISOString());
    // formdata.append("expireddate", expireddate.toISOString());

    let formdata = new FormData();
            formdata.append('plane_Id', In_Id);
            formdata.append('plane_Name', In_Name);
            formdata.append('plane_Price', In_cost);
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

        
        document.body.appendChild(form);
        form.submit();
    // fetch("PHP/updated_I.php", {
    //   method: "POST",
    //   body: formdata,
    // })
    //   .then(function (response) {
    //     return response.text();
    //   })
    //   .then(function (data) {
    //     if (data.includes("Email sent successfully.")) {
    //       alert("Plan added successfully" + data);
    //     } else {
    //       alert("Plan not added " + data);
    //     }
    //   })
    //   .catch(function (error) {
    //     console.error("Error:", error);
    //   });
  
});
document.getElementById("IN_02").addEventListener("click", function () {
  
  
    let In_Id = document.getElementById("In_Id_2").textContent;
    let In_cost = document.getElementById("Price_2").textContent;
    
    let formdata = new FormData();
            formdata.append('plane_Id', In_Id);
            formdata.append('plane_Name', In_Name);
            formdata.append('plane_Price', In_cost);
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

        
        document.body.appendChild(form);
        form.submit();


    // let formdata = new FormData();
    // formdata.append("In_Id", In_Id);
    // formdata.append("In_cost", In_cost);
    // formdata.append("date", date.toISOString());
    // formdata.append("expireddate", expireddate.toISOString());
    // formdata.append("paymnetLink", paymnetLink);

    // fetch("PHP/updated_I.php", {
    //   method: "POST",
    //   body: formdata,
    // })
    //   .then(function (response) {
    //     return response.text();
    //   })
    //   .then(function (data) {
    //     if (data.includes("Email sent successfully.")) {
    //       alert("Plan added successfully" + data);
    //     } else {
    //       alert("Plan not added " + data);
    //     }
    //   })
    //   .catch(function (error) {
    //     console.error("Error:", error);
    //   });
  
});
document.getElementById("IN_03").addEventListener("click", function () {
  
  
    let In_Id = document.getElementById("In_Id_3").textContent;
    let In_cost = document.getElementById("Price_3").textContent;
    
     let formdata = new FormData();
            formdata.append('plane_Id', In_Id);
            formdata.append('plane_Name', In_Name);
            formdata.append('plane_Price', In_cost);
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

        
        document.body.appendChild(form);
        form.submit();


    // let formdata = new FormData();
    // formdata.append("In_Id", In_Id);
    // formdata.append("In_cost", In_cost);
    // formdata.append("date", date.toISOString());
    // formdata.append("expireddate", expireddate.toISOString());
    // formdata.append("paymnetLink", paymnetLink);

    // fetch("PHP/updated_I.php", {
    //   method: "POST",
    //   body: formdata,
    // })
    //   .then(function (response) {
    //     return response.text();
    //   })
    //   .then(function (data) {
    //     if (data.includes("Email sent successfully.")) {
    //       alert("Plan added successfully" + data);
    //     } else {
    //       alert("Plan not added " + data);
    //     }
    //   })
    //   .catch(function (error) {
    //     console.error("Error:", error);
    //   });
  
});
