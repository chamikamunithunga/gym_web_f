<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verified</title>
    <link rel="stylesheet" href="css/verify.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #000000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
        }

        .verification-box {
            background-color: #ffffff2d;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 20px #000000;
            width: 100%;
            max-width: 500px;
            opacity: 0;
            transform: scale(0.8);
            animation: box-appear 1s forwards;
        }

        .icon-circle {
            width: 100px;
            height: 100px;
            background-color: #ffe600;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            opacity: 0;
            transform: scale(0.8);
            animation: icon-appear 1s 0.5s forwards;
        }

        .checkmark {
            font-size: 50px;
            color: #000000;
        }

        h1,
        p {
            opacity: 0;
            animation: text-appear 1s 1s forwards;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #ffe600;
        }

        p {
            font-size: 16px;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .ok-btn {
            padding: 10px 20px;
            background-color: #ffe600;
            color: rgb(0, 0, 0);
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            opacity: 0;
            animation: button-appear 1s 1.5s forwards;
        }

        .ok-btn:hover {
            background-color: #b10705;
        }

        /* Animation Keyframes */
        @keyframes box-appear {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes icon-appear {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes text-appear {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes button-appear {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .verification-box {
                padding: 20px;
                max-width: 300px;
            }

            .icon-circle {
                width: 60px;
                height: 60px;
            }

            .checkmark {
                font-size: 30px;
            }

            h1 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }

            .ok-btn {
                font-size: 14px;
            }
        }






        /* Logo Styles */
        .logo {
            position: absolute;
            top: 5px;
            left: 30px;
            width: 200px;
            height: auto;
        }




        @media (max-width: 768px) {
            .logo {
                top: 10px;
                left: 10px;
                width: 150px;
            }
        }
    </style>
</head>

<body
    style="background-image: url('../img/verify.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <img src="../img/gym copy 2.png" alt="Logo" class="logo">
    <div class="container">
        <div class="verification-box">
            <div class="icon-circle">
                <i class="checkmark">✔</i>
            </div>
            <h1>Verified!</h1>
            <p>Your payment has been verified.</p>
            <button class="ok-btn" onclick="window.location.href='profile.php'">Ok</button>
        </div>
    </div>

</body>

</html>