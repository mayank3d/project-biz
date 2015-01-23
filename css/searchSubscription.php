<?php
//ini_set('display_errors',1);
include_once 'library.php';
include 'UserManager.php';
session_start();
//print_r($_SESSION);
//die();
include 'BusinessManager.php';
$businessManager = new BusinessManager;
if (isset($_SESSION['username']) && ($_SESSION['isAllowed'] == 'true')) {
    
} else {
    $_SESSION['notification'] = 'InValid Login';
    redirect('index.php');
}
//echo '<pre>';
//print_r($_SESSION);

?>
<!DOCTYPE html>
<html lang="">


    <?php include_once 'header.php'; 
	
	?>
    <body>
    <input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['userId'];?>" >
    <script>
	$(document).ready(function() {
			$('.fancybox').fancybox();
			$('.fancybox_group').fancybox();
			$('.create_new_group').fancybox({"width":540,scrolling:false});
			$('.create_new_group_success').fancybox();
			$('.dinamic_success_msg').fancybox();
			
		});
		function dinamic_success(head_msg,body_msg){
			if(head_msg!=''){
				$('#dinamic_head_msg').html(head_msg);
			}
			if(body_msg!=''){
				$('#dinamic_body_msg').html(body_msg);
			}
			$('.dinamic_success_msg').trigger('click');
		}
		function group_add_pop(){
				//alert('aa');	
				$.fancybox.close();		
			$('.fancybox_group').trigger('click');
		}
		function create_group(){
			$.fancybox.close();		
			$('.create_new_group').trigger('click');
		}
		
		
		function showUploadedItem (source) {
			var list = document.getElementById("image-list"),
				li   = document.createElement("li"),
				img  = document.createElement("img");
			img.src = source;
			li.appendChild(img);
			list.appendChild(li);
		}
		</script>
        
        <script>
		var input = document.getElementById("images"), 
		formdata = false;

	   

	if (window.FormData) {
  		formdata = new FormData();
  		//document.getElementById("btn").style.display = "none";
	}
function create_group_with_image(){
			
	
 	//input.addEventListener("change", function (evt) {
		//alert('s');
		//alert(document.getElementById("images").value.search(/\S/));
		if(document.getElementById("group_name").value.search(/\S/) == -1){
			alert('Please enter a group name.');
			return false;
		}else if(document.getElementById("images").value.search(/\S/) == -1){
			var group_name = document.getElementById("group_name").value;
			$.ajax({
			type: "POST",
			url: "upload.php",
			data: { imgg : "N", gname : group_name }
			}).done(function( msg ) {
				//alert( "Data Saved: " + msg );
				
				//document.getElementById("response").innerHTML = '<h2>Successfully Uploaded Images</h2>'; 
				$('.create_new_group_success').trigger('click');
				setTimeout("success_msg();",2000);
				//success_msg();
			});
			return false;

		}else{
		$('#images').change(function(){
			//alert('a');
 		document.getElementById("response").innerHTML = "Uploading . . ."
 		var i = 0, len = this.files.length, img, reader, file;
		//alert(this.files.length);
		for ( ; i < len; i++ ) {
			file = this.files[i];
			//alert(JSON.stringify(file));
			if (!!file.type.match(/image.*/)) {
				if ( window.FileReader ) {
					reader = new FileReader();
					reader.onloadend = function (e) { 
						showUploadedItem(e.target.result, file.fileName);
					};
					reader.readAsDataURL(file);
				}
				if (formdata) {
					formdata.append("images[]", file);
				}
			}	
		}
		//alert(JSON.stringify(formdata));
		document.getElementById("btn").style.display = "none";
		if (formdata) {
			var gn = document.getElementById("group_name").value;
			$.ajax({
				url: "upload.php?imgg=Y&gname="+gn,
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function (res) {
					//alert(res);
					if(res == 1){
						document.getElementById("response").innerHTML = '<h2>Successfully Uploaded Images</h2>'; 
						$('.create_new_group_success').trigger('click');
						//$('#group_add_frm').reset();
						
					}
					setTimeout("success_msg();",2000);
					
				}
			});
		}
		
		});
		$('#images').trigger('change');
	//}, false);
	
	return false;
	}
		}
	function success_msg(){
		document.getElementById("group_add_frm").reset();
		document.getElementById("response").innerHTML = '';
		$('#image-list li').html('');
		document.getElementById("btn").style.display = "block";
		setTimeout("document.location.href='searchSubscription.php';",1000);
	}
    </script>
    <?php
		include_once 'fancy_box_content.php';
		?>
   <!-- <a class="fancybox" href="#inline1" >Inline</a>-->
        <?php 
		
		include_once 'ajaxloading_up.php';
		include_once 'logo.php'; ?>
        <?php include_once 'sideMenu.php'; ?>
        <?php //include_once 'alert.php'; ?>
        <script>
		
		function search_subscription(){
			//document.getElementById('search_content').value.search(/\S/)
			if(document.getElementById('search_content').value.search(/\S/)==-1){
				//alert(document.getElementById('search_content').value);
				alert('Please enter search content.');
				return false;
			}else{
				var searchcon = document.getElementById('search_content').value;
				$('#fancyboxloading_up').css('display','block');
				$.post("searchcontent.php", {search_cc: searchcon})
						.done(function(data) {
							$('#fancyboxloading_up').css('display','none');
					//alert(data);
					$('#subscribed_id').html(data);
				});
			}
		}
        function open_unsubscribe(id){
			//alert(id);
			document.getElementById(id).innerHTML = 'UNSUBSCRIBED';
			jQuery('#'+id).css('padding-right','0px');
			jQuery('#'+id).css('padding-left','0px');
			
			//jQuery('#'+id).toggleClass( "blue", "orange" );
				
			
		}
		function open_subscribe(id){
			//alert(id);
			jQuery('#'+id).css('padding-right','5px');
			jQuery('#'+id).css('padding-left','5px');
			document.getElementById(id).innerHTML = 'SUBSCRIBED';
			//jQuery('#'+id).toggleClass( "orange", "blue");
		}
        </script>
        <script type="text/javascript">

						
						
                        function followUser(bizId) {
							if(bizId){
								$('#subscriber_id').val(bizId);
								$('.fancybox').trigger('click');
							}
                            /*$.post("followUser.php", {userId: userId, bizId: bizId})
                                    .done(function(data) {
										alert(data);
                                $("#" + userId + bizId).attr("class", "orange");
                                $("#" + userId + bizId).html('UNFOLLOW');
                                $("#" + userId + bizId).attr("onClick", "unFollowUser(" + userId + "," + bizId + ")");
                            });*/
                        }
						function Individual_add(){
							//subscriber_id
							var userId = $("#userId").val();
							var subscriber_id = $('#subscriber_id').val();
							//alert(subscriber_id);
							if(subscriber_id!=''){
								$('#fancyboxloading_up').css('display','block');
								$.post("followUser.php", {individual:'Y',bizId: subscriber_id})
                                    .done(function(data) {
										$('#fancyboxloading_up').css('display','none');
										//alert(data);
									if(data == 1){	
                               // $("#subscribe_" + userId + subscriber_id).attr("class", "orange");
							    $("#subscribe_" + userId + subscriber_id).attr("class", "green");
                                $("#subscribe_" + userId + subscriber_id).html('SUBSCRIBED');
                                $("#subscribe_" + userId + subscriber_id).attr("onClick", "unFollowUser(" + subscriber_id + ")");
								dinamic_success('You have subscribed successfully.');
									}
                            });
							}
						}
						function subscribe_group(){
							var groupid = $('select#group_id option:selected').val();
							//alert(groupid);
							if(groupid == ''){
								alert('Please select a group. ');
								return false;
							}else{
							var userId = $("#userId").val();
							var subscriber_id = $('#subscriber_id').val();
							//alert(subscriber_id);
							if(subscriber_id!=''){
								$('#fancyboxloading_up').css('display','block');
								$.post("followUser.php", {individual:'N',bizId: subscriber_id,groupid:groupid})
                                    .done(function(data) {
										$('#fancyboxloading_up').css('display','none');
										//alert(data);
									if(data == 1){	
                                //$("#subscribe_" + userId + subscriber_id).attr("class", "orange");
								$("#subscribe_" + userId + subscriber_id).attr("class", "green");
                                $("#subscribe_" + userId + subscriber_id).html('SUBSCRIBED');
                                $("#subscribe_" + userId + subscriber_id).attr("onClick", "unFollowUser(" + subscriber_id + ")");
								dinamic_success('You have subscribed successfully.');
									}
                            });
							}
							}
							
						}
                        /*function unFollowUser(userId, bizId) {
                            $.post("unFollowUser.php", {userId: userId, bizId: bizId})
                                    .done(function(data) {
										
                                $("#" + userId + bizId).attr("class", "blue");
                                $("#" + userId + bizId).html('FOLLOW');
                                $("#" + userId + bizId).attr("onClick", "followUser(" + userId + "," + bizId + ")");
                            });
                        }*/
						/*function unFollowUser(userId, bizId) {
								$('#fancyboxloading_up').css('display','block');
                            $.post("unFollowUser.php", {userId: userId, bizId: bizId})
                                    .done(function(data) {
										//alert(data);
										$('#fancyboxloading_up').css('display','none');
								if(data==1){
									$('div#subscribed_box_'+bizId).remove();
								}
                                $("#" + userId + bizId).attr("class", "blue");
                                $("#" + userId + bizId).html('FOLLOW');
                                $("#" + userId + bizId).attr("onClick", "followUser(" + userId + "," + bizId + ")");
                            });
                        }*/
						function unFollowUser(bizId) {
							var userId = $("#userId").val();
								$('#fancyboxloading_up').css('display','block');
                            $.post("unFollowUser.php", {bizId: bizId,search_subscribe:'Y'})
                                    .done(function(data) {
										//alert(data);
										$('#fancyboxloading_up').css('display','none');
								
                                $("#subscribe_" + userId + bizId).attr("class", "blue");
                                $("#subscribe_" + userId + bizId).html('UNSUBSCRIBED');
                                $("#subscribe_" + userId + bizId).attr("onClick", "followUser(" + bizId + ")");
                            });
                        }
                        function resetName() {
                            $("#newGroupName").val("");
                        }
                        function resetSelectOption() {
                            $('#groupName').prop('selectedIndex', 0);
                        }

        </script>
        <section class="content">

            <div class="widget-container">
                <section class="widget small" style="width:100%;">
                    <header> 
                        <span class="icon"> &#128214;</span>
                        <hgroup>
                            <h1>Search</h1>
                            <!--<h2>Individual and Groups</h2>-->
                        </hgroup>
                    </header>
                    <div class="content">
                    <div >
                        <div style="padding: 5px; width: 100%;">
                           <input type="text" name="search_content" id="search_content" placeholder="Enter search text." value="">
                        </div>
                        <button onclick="search_subscription();" class="blue">Search</button>
                        </div>
                        <section class="stats-wrapper">
                            <?php
                           // $userManager = new UserManager;
                           // echo $userManager->getAllFolloiwingUsersAndGroups($_SESSION['userId'])
                            ?>
                    <div style="" class="subscribed_class" id="subscribed_id">
	                </div> 
                        </section>
                    </div>
                </section>
                
                
            </div>

        </section>
        <script src="js/jquery.wysiwyg.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/cycle.js"></script>
        <script src="js/jquery.checkbox.min.js"></script>
        <script src="js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript">
            

            function coolMessage(msgId) {
                $.post("coolMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                        .done(function(data) {
                    alert(data);
                    $("#" + msgId + "msgId").html(data + " cools");
                    $("#" + msgId + "coolBtn").html("uncool");
                    $("#" + msgId + "coolBtn").attr("onclick", 'unCoolMessage(\'' + msgId + '\')');
                });
            }

            function unCoolMessage(msgId) {
                $.post("uncoolMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                        .done(function(data) {
                    $("#" + msgId + "msgId").html(data + " cools");
                    $("#" + msgId + "coolBtn").html("cool");
                    $("#" + msgId + "coolBtn").attr("onclick", 'coolMessage(\'' + msgId + '\')');
                });
            }

            function submitTweet() {
                var msg = $("#MyMsg").val();
                $.post("BroadCastMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msg: msg})
                        .done(function(data) {
                    $inter = '';
                    $inter = makeListTweet($inter, msg, data);
                    $("#myTweets").prepend($inter);
                    i = 20;
                    $(".tl-post").each(function() {
                        $(this).delay(i).animate({"opacity": 1});
                    });
                    $("#MyMsg").val('');
                });
            }

            function reTweet(msgId) {
                $.post("reTweet.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                        .done(function(data) {
                    $("#" + msgId + "msgIdshares").html(data + " shares ");
                    $("#" + msgId + "shareBtn").remove();
                    //  $("#" + msgId + "coolBtn").attr("onclick", 'unCoolMessage(\'' + msgId + '\')');
                });
            }

          function makeListTweet(inter, msg, key) {
                $inter = inter;
                $inter = $inter + '<div class="tl-post"><span class="icon"><img src="images/u.png" /></span>';
                $inter = $inter + ' <p align="justify">';
                $inter = $inter + msg;
                $inter = $inter + '<span class="cools" id="' + key + 'msgId">67 cools</span><a class="blue" id="' + key + 'coolBtn" onclick="coolMessage(\'';
                $inter = $inter + key + '\')">cool!</a> <span class="cools" id="' + key + 'msgIdshares">67 shares </span><a id="' + key + 'shareBtn" onclick="reTweet(\'' + key + '\')" class="green">share</a> <a class="red" onclick="window.location.href=\'commentSection.php?id=' + key + '\'">comment</a></p></div>';
                return $inter;
            }
        </script>
        
    </body>
</html>  
