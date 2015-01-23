

<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <title>TheNewsId</title>
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="robots" content="" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="stylesheet" href="css/style.css" media="all" />
        <!--[if IE]><link rel="stylesheet" href="css/ie.css" media="all" /><![endif]-->
    </head>
    <body class="login">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>  
        <?php include_once("ga.php") ?>
        <section>
            <a href="index.php"> <h1><strong>The</strong> NewsId</h1></a>
            <form method="post" action="registerUser.php">
                <input type="text" value="username" id="name" name="name"/><input type="button" value="check" onclick="checkUserName()"/>
                <input type="text" value="Email" id="email" name="email" onfocus=""/>
                <input value="Password" type="password" id="password" name="password"/>
                <input value="Password" type="password" id="checkPassword" name="checkPassword"/>

                <button class="blue">Register</button>
            </form>

            <p><a href="index.php">Already Registered User ?</a></p>
            <p><a href="forgotPassword.php">Forgot your password?</a></p>

        </section>

        <script type="text/javascript">
                    function checkUserName() {

                        var username = $("#name").val();
                        $.post("validateUsername.php", {username: username})
                                .done(function(data) {
                            if ($.trim(data) == "1") {
                                $("#name").val("");
                            }
                        });
                    }
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