

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Canvas Menu
    $(".canvas-open").on('click', function () {
        $(".offcanvas-menu-wrapper").addClass("show-offcanvas-menu-wrapper");
        $(".offcanvas-menu-overlay").addClass("active");
    });

    $(".canvas-close, .offcanvas-menu-overlay").on('click', function () {
        $(".offcanvas-menu-wrapper").removeClass("show-offcanvas-menu-wrapper");
        $(".offcanvas-menu-overlay").removeClass("active");
    });

    // Search model
    $('.search-switch').on('click', function () {
        $('.search-model').fadeIn(400);
    });

    $('.search-close-switch').on('click', function () {
        $('.search-model').fadeOut(400, function () {
            $('#search-input').val('');
        });
    });

    //Masonary
    $('.gallery').masonry({
        itemSelector: '.gs-item',
        columnWidth: '.grid-sizer',
        gutter: 10
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
        Carousel Slider
    --------------------*/
    var hero_s = $(".hs-slider");
    hero_s.owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        items: 1,
        dots: false,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: false
    });

    /*------------------
        Team Slider
    --------------------*/
    $(".ts-slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: true,
        dotsEach: 2,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            320: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 3,
            }
        }
    });

    /*------------------
        Testimonial Slider
    --------------------*/
    $(".ts_slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*------------------
        Image Popup
    --------------------*/
    $('.image-popup').magnificPopup({
        type: 'image'
    });

    /*------------------
        Video Popup
    --------------------*/
    $('.video-popup').magnificPopup({
        type: 'iframe'
    });

    /*------------------
        Barfiller
    --------------------*/
    $('#bar1').barfiller({
        barColor: '#ffffff',
        duration: 2000
    });
    $('#bar2').barfiller({
        barColor: '#ffffff',
        duration: 2000
    });
    $('#bar3').barfiller({
        barColor: '#ffffff',
        duration: 2000
    });

    $('.table-controls ul li').on('click', function () {
        var tsfilter = $(this).data('tsfilter');
        $('.table-controls ul li').removeClass('active');
        $(this).addClass('active');

        if (tsfilter == 'all') {
            $('.class-timetable').removeClass('filtering');
            $('.ts-meta').removeClass('show');
        } else {
            $('.class-timetable').addClass('filtering');
        }
        $('.ts-meta').each(function () {
            $(this).removeClass('show');
            if ($(this).data('tsmeta') == tsfilter) {
                $(this).addClass('show');
            }
        });
    });

})(jQuery);

window.addEventListener('scroll', function() {
    const header = document.querySelector('.header-section');
    if (window.scrollY > 50) { // Adjust scroll value as needed
        header.classList.add('blur');
    } else {
        header.classList.remove('blur');
    }
});

window.onload = function (){

    var element = document.getElementById('pricing_container');
        
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    } else {
        console.log('Div element is missing.');
    }

    var element_2 = document.getElementById('Team_Section');
        
    if (element_2) {
        element_2.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    } else {
        console.log('Div element is missing.');
    }



    const isLoggedIn = getSessionWithExpiry("email"); 

    let successMsg = '<i class="fa-solid fa-circle-check"></i> session set successfully';
    let errorMsg = '<i class="fa-solid fa-circle-xmark"></i> Incorrect email or password. Please try again';
    let invalidMsg = '<i class="fa-solid fa-circle-exclamation"></i> Invalid ! You time is out Login again';

    
      
     if (isSessionSet()) {
         alert('Session is set'); 
         //showToast(successMsg);   
     } else {
         alert('Session is not set');
         //showToast(invalidMsg);
     }
        
        const loginButton = document.getElementById('loginButton');

        
        if (isLoggedIn !== null) {
            // loginButton.style.backgroundColor = '#F3D700';
            loginButton.value = '';
            loginButton.classList.add('user-icon');
            loginButton.onclick = function() {
                window.location.href = 'PHP/profile.php'; // Redirect to profile page
            };
            loginButton.innerHTML = '<img src="../img/logo/user_icon.png" alt="User Icon" style="width:20px; height:20px;">'; 
        }

        

        // Membership Plan show in index page
         fetch('PHP/M_plan.php') 
         .then(response => {
             if (!response.ok) {
                 throw new Error('Network response was not ok');
             }
             return response.json();
         })
         .then(data => {
             if(Array.isArray(data)) {
            for(let i=0;i<data.length;i++){
                
                if(data[i].p_id === "P001"){
                    document.getElementById('Plan_time_1').textContent = data[i].name;
                    document.getElementById('Price_1').textContent = data[i].price;
                    document.getElementById('des_1_1').textContent = data[i].benefits_1;
                    document.getElementById('des_1_2').textContent = data[i].benefits_2;
                    document.getElementById('des_1_3').textContent = data[i].benefits_3;
                    document.getElementById('des_1_4').textContent = data[i].benefits_4;
                    document.getElementById('des_1_5').textContent = data[i].benefits_5;
                    document.getElementById('P_id_1').textContent = data[i].p_id;
                }
                if(data[i].p_id === "P002"){
                    document.getElementById('Plan_time_2').textContent = data[i].name;
                    document.getElementById('Price_2').textContent = data[i].price;
                    document.getElementById('des_2_1').textContent = data[i].benefits_1;
                    document.getElementById('des_2_2').textContent = data[i].benefits_2;
                    document.getElementById('des_2_3').textContent = data[i].benefits_3;
                    document.getElementById('des_2_4').textContent = data[i].benefits_4;
                    document.getElementById('des_2_5').textContent = data[i].benefits_5;
                    document.getElementById('P_id_2').textContent = data[i].p_id;
                }
                if(data[i].p_id === "P003"){
                    document.getElementById('Plan_time_3').textContent = data[i].name;
                    document.getElementById('Price_3').textContent = data[i].price;
                    document.getElementById('des_3_1').textContent = data[i].benefits_1;
                    document.getElementById('des_3_2').textContent = data[i].benefits_2;
                    document.getElementById('des_3_3').textContent = data[i].benefits_3;
                    document.getElementById('des_3_4').textContent = data[i].benefits_4;
                    document.getElementById('des_3_5').textContent = data[i].benefits_5;
                    document.getElementById('P_id_3').textContent = data[i].p_id;
                }
              }
             }else{
                console.log('No data found');
             }
                              
                   console.log(data);  
          })
         .catch(error => {
             console.error('Error:', error);
             console.error('Error message:', error.message); 
         });
// shama part
         fetch('PHP/I_show.php') 
         .then(response => {
             if (!response.ok) {
                 throw new Error('Network response was not ok');
             }
             return response.json();
         })
         .then(data => {
             if(Array.isArray(data)) {
               console.log(data);
            for(let i=0;i<data.length;i++){
                
                if(data[i].Instructor_Id === "IN001"){
                    document.getElementById("In_name_1").textContent = data[i].Name;
                    document.getElementById("Price_1").textContent = data[i].price;
                    document.getElementById("In_Postion_1").textContent = data[i].description;
                    document.getElementById("In_Id_1").textContent = data[i].Instructor_Id;

                    var photolink = data[i].In_photo;
                    var imgElement = document.getElementById("img-01");
                    imgElement.setAttribute('data-setbg', photolink);
                    imgElement.style.backgroundImage = "url('" + photolink + "')";


                    if (data[i].user_count > 0) {
                         document.getElementById("IN_01").style.display = 'none';
                         document.getElementById("booked_message_1").textContent = 'Instructor fully booked!';
                        
                    }

                    if(data[i].status === "0"){
                        document.getElementById("IN_01").style.display = 'none';
                        document.getElementById("booked_message_1").textContent = 'Instructor not available!';
                    }
                }
                if(data[i].Instructor_Id === "IN002"){
                    document.getElementById("In_name_2").textContent = data[i].Name;
                    document.getElementById("Price_2").textContent = data[i].price;
                    document.getElementById("In_Postion_2").textContent = data[i].description;
                    document.getElementById("In_Id_2").textContent = data[i].Instructor_Id;

                    var photolink = data[i].In_photo;
                    var imgElement = document.getElementById("img-02");
                    imgElement.setAttribute('data-setbg', photolink);
                    imgElement.style.backgroundImage = "url('" + photolink + "')";

                    if (data[i].user_count > 0) {
                        document.getElementById("IN_02").style.display = 'none';
                        document.getElementById("booked_message_2").textContent = 'Instructor fully booked!';
                       
                    }
                    if(data[i].status === "0"){
                        document.getElementById("IN_02").style.display = 'none';
                        document.getElementById("booked_message_2").textContent = 'Instructor not available!';
                    }
                }
                if(data[i].Instructor_Id === "IN003"){
                    document.getElementById("In_name_3").textContent = data[i].Name;
                    document.getElementById("Price_3").textContent = data[i].price;
                    document.getElementById("In_Postion_3").textContent = data[i].description;
                    document.getElementById("In_Id_3").textContent = data[i].Instructor_Id;

                    var photolink = data[i].In_photo;
                    var imgElement = document.getElementById("img-03");
                    imgElement.setAttribute('data-setbg', photolink);
                    imgElement.style.backgroundImage = "url('" + photolink + "')";

                    if (data[i].user_count > 10) {
                        document.getElementById("IN_03").style.display = 'none';
                        document.getElementById("booked_message_3").textContent = 'Instructor fully booked!';
                       
                    }
                    if(data[i].status === "0"){
                        document.getElementById("IN_03").style.display = 'none';
                        document.getElementById("booked_message_3").textContent = 'Instructor not available!';
                    }
                }
              }
             }else{
                console.log('No data found');
             }
                              
                   console.log(data);  
          })
         .catch(error => {
             console.error('Error:', error);
             console.error('Error message:', error.message); 
         });
         
    // shama part   
        // Membership Plan show in index page

        // // Class time show in index page
        // fetch('PHP/TimeTable.php') // Path to the PHP script
        // .then(response => response.json())
        // .then(data => {
        //     console.log(data);
        //     // Iterate through each time slot and day to populate the table
        //      for (let time_slot in data) {
        //         for (let day in data[time_slot]) {
        //              const classData = data[time_slot][day];
        //              const tableCell = document.querySelector(
        //                  `td[data-time="${time_slot}"][data-day="${day}"]`
        //              );
                    
        //              if (tableCell) {
        //                  tableCell.classList.add(classData.meta_type);
        //                  tableCell.innerHTML = `
        //                      <h5>${classData.class_name}</h5>
        //                      <span>${classData.instructor_name}</span>
        //                  `;
        //              }
        //          }
        //      }
        // })
        // .catch(error => console.error('Error:', error));
    


        // Class time show in index page
    }

function isSessionSet() {
    const isLoggedIn = localStorage.getItem('email');
    return isLoggedIn ? true : false;
}

function getSessionWithExpiry(key) {
    const itemStr = localStorage.getItem(key);

    if (!itemStr) {
        return null;
    }

    const item = JSON.parse(itemStr);
    const now = new Date();

    if (now.getTime() > item.expiry) {
        localStorage.removeItem(key);
        window.location.href = './login.html';
        return null;
    }

    return item.value;
}

// function showToast(msg) {
    
//     let toastBox = document.getElementById("toastBox");
    
//     let toast = document.createElement("div");
//     toast.classList.add("toast");
//     toast.innerHTML = msg;
//     toastBox.appendChild(toast);
  
//     if (msg.includes("Incorrect")) {
//       toast.classList.add("error");
//     }
//     if (msg.includes("Invalid")) {
//       toast.classList.add("Invalid");
//     }
//     setTimeout(function () {
//       toast.remove();
//     }, 3000);
//   }
