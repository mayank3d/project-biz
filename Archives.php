<?php
include_once 'library.php';
include 'UserManager.php';
if(!isset($_SESSION))
	session_start();
if (isset($_SESSION['username']) && ($_SESSION['isAllowed'] == 'true')) {
    
} else {
    $_SESSION['notification'] = 'InValid Login';
    redirect('index.php');
}
?>
<!--

-->

<!DOCTYPE html>
<html lang="">


    <?php include_once 'header.php'; ?>
	<style>
		.charCount{float: right;color: #3B3E40;}
		/*.button, button{ padding: 2px;}*/
	</style>
    <body onload="getNewslets();">
    <?php include_once 'ajaxloading.php'; ?>
        <?php include_once 'logo.php'; ?>
        <?php include_once 'sideMenu.php'; ?>
        <?php //include_once 'alert.php'; ?>
        <?php include_once 'MessageManager.php'; ?>

        <section class="content">
            <section class="widget">
				<!--
                <div class="field-wrap" style="padding: 5px; width: 60%;">
                    <input type="text" value="Stream a Newslet within 300 characters" id="MyMsg" name="MyMsg" maxlength="300"/>
                </div>
                <button class="blue" onclick="submitNewslet()">Stream</button>
				-->
                <header>
                    <span class="icon">&#59168;</span>
                    <hgroup>
                        <h1>Archive Newslets</h1>
                        <h2>You added to Archive Stream</h2>
                    </hgroup>
                </header>
                <div class="content no-padding timeline" id="myNewslets">
                </div>
            </section>
        </section>
        <script src="js/jquery.wysiwyg.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/cycle.js"></script>
        <script src="js/jquery.checkbox.min.js"></script>
        <script src="js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript">
		$(document).ready(function(){
			$('#MyMsg').parent().append('<div class="charCount" id="charCount">300 Char remain</div>')
			$('#MyMsg').keyup(function(){
				if($('#MyMsg').val().length < 299){
					CCount = (300 - ($('#MyMsg').val().length));
					if(CCount == 299)
						CCount = 300
					CCount += " Char remain";
					$('#charCount').html(CCount);
					//$('#charCount').append(" Char remain");
				}
				else{
					$('#charCount').html("0 Char remain");
				}
				//alert($('#MyMsg').val().length);
			});
			$('.btn_remarks').live('click',function(){
			    var C = $(this);
			    var id = C.attr('data-id');
			    if ($('#add_r_'+id).length>0) {
				return;
			    }
			    var newBox = '<div id="add_r_'+id+'" class="add_remark_cont">';
			    newBox += '<textarea class="remarkTxt" data-id="'+id+'" maxlength="300" id="rem_txt_'+id+'"></textarea>';
			    newBox += '<span class="rcharCount" id="rem_charCount_'+id+'">300 Char remain</span>';
			    //newBox += '<button class="rem_submit" data-id="'+id+'">Submit</button>';
			    //newBox += '<button class="view_other" data-id="'+id+'">View Others</button>';
			    //newBox += '<button class="rem_cancel" data-id="'+id+'">Cancel</button></div>';
			    newBox += '<a class="rem_submit" data-id="'+id+'" href="javascript:void(0);">Submit</a>';
			    newBox += '<a class="view_other" data-id="'+id+'" href="javascript:void(0);">View Others</a>';
			    newBox += '<a class="rem_cancel" data-id="'+id+'" href="javascript:void(0);">Cancel</a></div>';
			    C.parent().parent().append(newBox);
			    
			});
			$('.view_other').live('click',function(){
			    var C = $(this);
			    id = C.attr('data-id');
			    window.location.href = '<?php echo SITE_URL."commentSection.php?id="?>'+id;
			});
			$('.rem_cancel').live('click',function(){
			    var C = $(this);
			    id = C.attr('data-id');
			    $('#add_r_'+id).remove();
			});
			$('.rem_submit').live('click',function(){
			    var C = $(this);
			    id = C.attr('data-id');
			    var comment = $('#rem_txt_'+id).val();
			    var userId = '<?php echo $_SESSION['userId'] ?>';
			    if (comment.length <= 0) {
				alert('Must Enter Remark');
				return false;
			    }
			    $("#fancybox-loading").css('display','block');
			    $.post("makeComment.php", {userId: userId, msgId: id, comment: comment,mode:'add'})
				    .done(function(data) {
							    $("#fancybox-loading").css('display','none');
							    $('#rem_txt_'+id).val('');
							    if(data ==0){
								    alert('Please enter valid content.');
							    }else{
								    if(data){
									    $('#add_r_'+id).remove();
									    alert('Remark has been added');
								    }
							    }
								    
				//alert(data);
			    });
			    return true;
			});
			$('.remarkTxt').live('keyup',function(){
				var C = $(this);
				var id = C.data('id');
				if($('.remarkTxt').val().length < 299){
					CCount = (300 - (C.val().length));
					if(CCount == 299)
						CCount = 300
					CCount += " Char remain";
					$('#rem_charCount_'+id).html(CCount);
					//$('#charCount').append(" Char remain");
				}
				else{
					$('#rem_charCount_'+id).html("0 Char remain");
				}
				//alert($('#MyMsg').val().length);
			});
			$('.remarkTxt').live('focusout',function(){
				var C = $(this);
				var id = C.data('id');
				if($('.remarkTxt').val().length < 299){
					CCount = (299 - (C.val().length));
					if(CCount == 299)
						CCount = 300
					CCount += " Char remain";
					$('#rem_charCount_'+id).html(CCount);
					//$('#charCount').append(" Char remain");
				}
				else{
					$('#rem_charCount_'+id).html("0 Char remain");
				}
			});
		    });
        // function getNewslets() {
			// $('#fancybox-loading').css('display','block');
            // $.post("getArchives.php", {userId: '<?php echo $_SESSION['userId'] ?>', sId: '<?php echo session_id() ?>'},
            // function(data) {
				// $('#fancybox-loading').css('display','none');
                // $('#myNewslets').append(data);
                // i = 10;
                // $(".tl-post").each(function() {
                    // $(this).delay(i).animate({"opacity": 1});
                    // i = i + 20;
                // });
            // });
        // }
		function getNewslets() {
			// alert('ok');
			$('#fancybox-loading').css('display','block');
			$.ajax({
				url: 'getArchives.php?userId=<?php echo $_SESSION['userId'] ?>&sId=<?php echo session_id(); ?>',
				type: 'GET',
				success: function(data){
					// alert(data);
					$('#fancybox-loading').css('display','none');
					$('#myNewslets').append(data);
					i = 10;
					$(".tl-post").each(function() {
						$(this).delay(i).animate({"opacity": 1});
						i = i + 20;
					});
				}
			});
            // $.post("getArchives.php", {userId: '<?php echo $_SESSION['userId'] ?>', sId: '<?php echo session_id() ?>'},
            // function(data) {
				//// alert(data);
				// $('#fancybox-loading').css('display','none');
                // $('#myNewslets').append(data);
                // i = 10;
                // $(".tl-post").each(function() {
                    // $(this).delay(i).animate({"opacity": 1});
                    // i = i + 20;
                // });
            // });
        }
        // function deleteNewslet(msgId) {
            // $.post("deleteArchive.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                    // .done(function(data) {
					// if(data == '1'){
						// $('#mystream_msg_'+msgId).remove();
					// }
            // });
        // }

        function coolMessage(msgId) {
            $.post("coolMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                    .done(function(data) {
                $("#" + msgId + "msgId").html(data + " Star");
                $("#" + msgId + "coolBtn").html("Unstar");
                $("#" + msgId + "coolBtn").attr("onclick", 'unCoolMessage(\'' + msgId + '\')');
            });
        }

        function unCoolMessage(msgId) {
            $.post("uncoolMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                    .done(function(data) {
                //$("#" + msgId + "msgId").html(data + " cools");
		if ($.trim(data) != "0") {
		    $("#" + msgId + "msgId").html(data + " Stars");
		}
		else{
		    $("#" + msgId + "msgId").html("");
		}
                $("#" + msgId + "coolBtn").html("Star");
                $("#" + msgId + "coolBtn").attr("onclick", 'coolMessage(\'' + msgId + '\')');

            });
        }

        function submitNewslet() {
            var msg = $("#MyMsg").val();
            /* $.post("BroadCastMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msg: msg})
                    .done(function(data) {
                $inter = '';
				var key = data.id;
				var dmsg = data.msg;
				alert(dmsg);
				$("#myNewslets").prepend(data);
                // $inter = makeListNewslet($inter, msg, data);
                // $("#myNewslets").prepend(data["msg"]);
                i = 20;
                $(".tl-post").each(function() {
                    $(this).delay(i).animate({"opacity": 1});
                });
                $("#MyMsg").val('');
				$('#charCount').html('300 Char remain');
            }); */
			jQuery.ajax({
				type: 'GET',
				url: 'BroadCastMessage.php',
				data: {userId: '<?php echo $_SESSION['userId'] ?>', msg: msg},
				dataType: 'json',
				success: function(data) {
					$('#fancybox-loading').css('display','none');
					//alert(data);
					//alert(JSON.stringify(data));
					var key = data.id;
					var dmsg = data.msg;
					//alert(data.msg);
					 $inter = '';
					//alert(data);
					//$inter = makeListNewslet($inter, dmsg, key);
					
					//alert(data);
					
					
					$("#myNewslets").prepend(dmsg);
					i = 20;
					$(".tl-post").each(function() {
						$(this).delay(i).animate({"opacity": 1});
					});
					$("#MyMsg").val('');
				}
			});
        }

        function reNewslet(msgId) {
            $.post("reNewslet.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                    .done(function(data) {
                $("#" + msgId + "msgIdshares").html(data + " shares ");
                $("#" + msgId + "shareBtn").remove();
                //  $("#" + msgId + "coolBtn").attr("onclick", 'unCoolMessage(\'' + msgId + '\')');
            });
        }
		
		function delete_msg(tw_id,uid){
			$('#fancybox-loading').css('display','block');
			jQuery.ajax({
				type: 'GET',
				url: 'deleteArchive.php?userId=<?php echo $_SESSION['userId'] ?>&msgId='+tw_id,
				/*dataType: 'json',*/
				success: function(data) {
					$('#fancybox-loading').css('display','none');
					$('div#mystream_msg_'+tw_id).remove();					
				}
			});
		}
        function makeListNewslet(inter, msg, key) {
            $inter = inter;
            $inter = $inter + '<div class="tl-post"><span class="icon"><img src="images/u.png" /></span>';
            $inter = $inter + ' <p align="justify">';
            $inter = $inter + msg;
            $inter = $inter + '<span class="cools" id="' + key + 'msgId">67 cools</span><button class="blue" id="' + key + 'coolBtn" onclick="coolMessage(\'';
            $inter = $inter + key + '\')">cool!</button> <span class="cools" id="' + key + 'msgIdshares">67 shares </span><button id="' + key + 'shareBtn" onclick="reNewslet(\'' + key + '\')" class="green">share</button> <button class="red" onclick="window.location.href=\'commentSection.php?id=' + key + '\'">comment</button></p></div>';
            return $inter;
        }
        </script>
    </body>
</html>