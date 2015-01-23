<head>
    <meta charset="utf-8">
    <title>TheNewsID</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/style.css" media="all" />
    <link rel="stylesheet" href="css/button.css" media="all" />
    <!--[if IE]><link rel="stylesheet" href="css/ie.css" media="all" /><![endif]-->
    <!--[if lt IE 9]><link rel="stylesheet" href="css/lt-ie-9.css" media="all" /><![endif]-->
    <?php
    //ini_set('display_errors', 'On');
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>  
<?php include_once("ga.php") ?>
        
    <script  type="text/javascript">
        $(document).ready(function() {
            var pathname = window.location.pathname;
            if (pathname.indexOf("NewsStream.php") >= 0) {
                $("#NewsStreamSM").attr('class', 'section');
            }
            else if (pathname.indexOf("MyStream.php") >= 0) {
                $("#MyStreamSM").attr('class', 'section');
            }
            else if (pathname.indexOf("MySubscription.php") >= 0 || pathname.indexOf("searchSubscription.php") >= 0) {
                $("#MySubscriptionSM").attr('class', 'section');
				$("#MySubscriptionSM ul").css('display','block');
				
            }
            else if (pathname.indexOf("MySubscribers.php") >= 0) {
                $("#MySubscribersSM").attr('class', 'section');
            }
            else if (pathname.indexOf("Trends.php") >= 0) {
                $("#TrendsSM").attr('class', 'section');
            } else {
                $("#NewsStreamSM").attr('class', '');
                $("#MyStreamSM").attr('class', '');
                $("#MySubscriptionSM").attr('class', '');
                $("#MySubscribersSM").attr('class', '');
                $("#TrendsSM").attr('class', '');
            }
        });
    </script>
    <?php
	
	if($_SERVER['PHP_SELF']=='/searchSubscription.php'){
		fancy_load('N');
	}
	?>
</head>
