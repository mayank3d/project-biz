

<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <title>TheNewsID</title>
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="robots" content="" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="stylesheet" href="css/style.css" media="all" />
        <!--[if IE]><link rel="stylesheet" href="css/ie.css" media="all" /><![endif]-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
    </head>
    <body class="login">
    <?php include_once 'ajaxloading.php'; ?>
    <style>
    input:focus, textarea:focus{
		color:#666;
	}
	.error {
        color: #FFFFFF;
		font-size: 1.1em;
		font-weight: bold;
		float:left;
		margin-top: -1em;
		width: 23em;     /*Makes sure that the error div is smaller than input */
		text-align:left;
    }
    </style>
         
        <?php include_once("ga.php");
		//registerUser.php ?>
        <script>
	    function lettersOnly(e){
		var k;
		document.all ? k = e.keyCode : k = e.which;
		return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8);
	    }
	</script>
	<section>
        
            <a href="index.php"> <h1><strong>The</strong> NewsID</h1></a>
	    <div>
		<div class="error" id="top_err" style="float:left"></div>
		<div style="float:left">
		    <form method="post" name="registration_frm" id="registration_frm" action="" onSubmit="return valid_register();">
		    
		    <input type="hidden" name="action" value="registration">
			<input type="text" value="Full Name" id="fullname" name="fullname"/>
			<div class="error" id="fn_err"></div>
			<input type="text" value="Username" id="name" name="name" autocomplete="off" maxlength="16"/>
			 <div class="error" id="u_err"></div>
			<input type="button" value="Check Username" class="blue" style="color:#FFF; font-weight:bold;" onclick="checkUserName()"/>
		       
			<input type="text" value="Email" id="email" name="email" onfocus=""/>
			<div class="error" id="e_err"></div>
			<input value="password" type="password" id="password" name="password"/>
			<div class="error" id="p_err"></div>
			<input value="password" type="password" id="checkPassword" name="checkPassword"/>
					<div class="error" id="rp_err"></div>
			<button class="blue">Register</button>
		    </form>
		</div>
		<p><a href="index.php">Already Registered User ?</a></p>
		<p><a href="forgotPassword.php">Forgot your password?</a></p>
	    </div>

        </section>

        <script type="text/javascript">
				$(document).ready(function(){
					$('#name').keyup(function(e){
					    if(e.keyCode >=37 && e.keyCode<=40)
						    return;
						else if($('#name').val().length ==0){
							xhr.abort();
							$('#fancybox-loading').css('display','none');
						    $('#u_err').html('User name should be between 1-16');
						    $('#u_err').css('color','#FF0000');
						}
						else{
							checkUserName();
						}
					});
				});
				var xhr;
                    function checkUserName() {

                        var username = $("#name").val();
						//alert(username.search(/\S/));
						// alert(username);
						$("#u_err").html('');
						if(username.search(/\S/)==-1 || username=='Username' || username=='username'){
							//alert($("#name").val());
							xhr.abort();
							$('#fancybox-loading').css('display','none');
							$("#u_err").css('color','#F00');
							$("#u_err").html('Please enter valid user name.');
							return false;
						}
						else if (!/^[A-Za-z0-9]*$/.test(username)) {
							xhr.abort();
							$('#fancybox-loading').css('display','none');
						    $("#u_err").css('color','#F00');
						    $("#u_err").html('Username only contain A-Z a-z and 0-9.');
						    return false;
						}
						else{
							$('#fancybox-loading').css('display','block');							
							if(xhr && xhr.readyState != 4){
								xhr.abort();
							}
							xhr = $.post("validateUsername.php", {username: username,action:'check_username'})
									.done(function(data) {
										//alert(data);
								$('#fancybox-loading').css('display','none');		
								if ($.trim(data) == "1") {
									$("#u_err").css('color','#F00');
									$("#u_err").html('User name already registered.');
									//$("#name").val("");
								}else{
									$("#u_err").css('color','#FFF');
									$("#u_err").html('User name is ready to use.');
								}
							});
						}
                    }
					
                    $(function() {
                        /*$('.login button').click(function(e) {
                            // Get the url of the link 
							//document.registration_frm.submit();
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
                        });*/

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
					function valid_register(){
						var username = $("#name").val();
						//
						$("#fn_err").html('');
						$("#u_err").html('');
						$("#e_err").html('');
						$("#p_err").html('');
						$("#rp_err").html('');
						var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
						if(document.registration_frm.fullname.value.search(/\S/)==-1 || document.registration_frm.fullname.value == 'Full Name'){
							$("#fn_err").css('color','#F00');
							$("#fn_err").html('Please enter full name.');
							return false;
						}else if(username.search(/\S/)==-1 || username=='Username' || username=='username'){
							//alert($("#name").val());
							$("#u_err").css('color','#F00');
							$("#u_err").html('Please enter valid user name.');
							return false;
						}else if(document.registration_frm.email.value.search(/\S/)==-1){
							
							$("#e_err").css('color','#F00');
							$("#e_err").html('Please enter email address.');
							return false;
							
						}else if(!filter.test(document.registration_frm.email.value)){
							
							$("#e_err").css('color','#F00');
							$("#e_err").html('Please enter valid email address.');
							return false;
							
						}else if(document.registration_frm.password.value.search(/\S/)==-1){
							$("#p_err").css('color','#F00');
							$("#p_err").html('Please enter password.');
							return false;
						}else if(document.registration_frm.checkPassword.value.search(/\S/)==-1 &&(document.registration_frm.password.value!=document.registration_frm.checkPassword.value)){
							$("#rp_err").css('color','#F00');
							$("#rp_err").html('Please re-enter password.');
							return false;
						}else{
							
							var frm_rec = $("form").serialize();
							$('#fancybox-loading').css('display','block');
							$.post("validateUsername.php",frm_rec)
									.done(function(data) {
										//alert(data);
								$('#fancybox-loading').css('display','none');		
								if ($.trim(data) == "1") {
									$("#u_err").css('color','#F00');
									$("#u_err").html('User name already registered.');
									//$("#name").val("");
								}else if ($.trim(data) == "3") {
									$("#e_err").css('color','#F00');
									$("#e_err").html('Email already registered.');
									//$("#name").val("");
								}else if($.trim(data) == "2"){
									$("#u_err").html('');
									$("#e_err").html('');
									$("#p_err").html('');
									$("#rp_err").html('');
									$("#top_err").css('color','#F00');
									$("#top_err").html('You have registered successfully. Please check your mail for account activation request');
									setTimeout('document.location.href="index.php";',2000);
									
								}else{
									$("#top_err").css('color','#FFF');
									$("#top_err").html('Something wrong ,Please try later.');
								}
							});
							return false;
						}
						return false;
					}
        </script>
    </body>
</html>