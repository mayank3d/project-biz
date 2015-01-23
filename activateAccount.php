<?php
    include_once 'config.php';
    include_once 'UserManager.php';
    if(!isset($_SESSION))
        session_start();
    $msg = 'Invalid Request For Account Activation';    
    if(isset($_GET['code']) && !empty($_GET['code'])){
        $token = $_GET['code'];
        $userManager = new UserManager;
        if($userManager->validateToken($token)){
            $msg = 'Your Account has been activated, Login to continue';
        }
        else{
            $msg = 'Invalid or expired account activation request';
        }
    }
?>
<!DOCTYPE html>

<html lang="">
    <head>
        <meta charset="utf-8">
        <title>TheNewsID : Account Activation</title>
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="robots" content="" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="stylesheet" href="css/style.css"	 media="all" />
        <!--[if IE]><link rel="stylesheet" href="css/ie.css" media="all" /><![endif]-->
        <style>
            .myMsg{
                color: #FFF;
                padding: 10px;
                text-align: center;
                width: 100%;
                font-weight: bold;
            }
        </style>
    </head>
    <body class="login">
        <?php include_once("ga.php") ?>
        <section>
            <a href="index.php"> <h1><strong>The</strong> NewsID</h1></a>
            <?php if(isset($msg) && !empty($msg)):?>
            <div class='myMsg'><?php echo $msg?></div>
            <?php endif;?>
            <form method="post" action="ValidateUser.php">
                <input type="text" value="NewsID" name="email" id="email"/>
                <input value="Password" type="password" name="password" id="password"/>
                <input type="submit" class="button blue" style="width: 100%; margin:0px;"  value="Login"/>
            </form>
            <p><a href="register.php">New User?</a></p>
            <p><a href="forgotPassword.php">Forgot your password?</a></p>
        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>  
        <script type="text/javascript">
            $(function() {
                $('.login button').click(function(e) {
                    // Get the url of the link 
                    var toLoad = $(this).attr('href');

                    // Do some stuff 
                    $(this).addClass("loading");

                    // Stop doing stuff  
                    // Wait 700ms before loading the url 
                    setTimeout(function() {
                        window.location = toLoad
                    }, 10000);

                    // Don't let the link do its natural thing 
                    e.preventDefault
                });

                $('input').each(function() {

                    var default_value = this.value;

                    $(this).focus(function() {
                        if (this.value == default_value) {
                            this.value = '';
                        }
                    });

                    $(this).blur(function() {
                        if (this.value == '') {
                            this.value = default_value;
                        }
                    });

                });
            });
        </script>
    </body>
</html>