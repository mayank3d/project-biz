<?php
ini_set('display_errors', 0);
//session_start();
include_once 'library.php';
include 'BusinessManager.php';
$businessManager = new BusinessManager;
//session_start();
if (isset($_SESSION['username']) && ($_SESSION['isAllowed'] == 'true')) {
    
} else {
    $_SESSION['notification'] = 'InValid Login';
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="">
    <?php
    include_once 'header.php';
    include_once 'UserManager.php';
    ?>
<head>
   <link rel="stylesheet" type="text/css" media="all" href="css2/style2.css">
  <link rel="stylesheet" type="text/css" media="all" href="fancybox/jquery.fancybox.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script type="text/javascript" src="fancybox/jquery.fancybox.js?v=2.0.6"></script>
  </head>
    <body>
       

        <?php include_once 'logo.php'; ?>
        <?php include_once 'sideMenu.php'; ?>
        <?php //include_once 'alert.php'; ?>
        <section class="content">
            <section class="widget">
                <table id="myTable_" border="0" width="100%">
               <?php
			  // mysql_connect();
			  
			  $res=$businessManager->test123($_SESSION['userId']);
			 // echo $num;
			   
			   ?>
               <form action="<?php $_SERVER['PHP_SELF'];?>" name="frm1234" method="post" >
               Show:<select style="padding-left:5px;"name="aa" onChange="change(this.value);">
               <option value="1" <?php if($_REQUEST['aa']==1){?> selected <?php }?>>Subscribed</option>
               <option value="2"<?php if($_REQUEST['aa']==2){?> selected <?php }?> >All News Id</option>
            
               </select>
           
               </form>
              
  <div id="wrapper">
	
	<p><a class="button modalbox" href="#inline">Create Group</a></p>
</div>

<!-- hidden inline form -->
<div id="inline">
	<form id="contact" name="contact" action="<?php $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
		<fieldset>
		<legend>Please complete the following form</legend>

		<label for="email"><span class="required">*</span> Name</label>
		<input name="name" type="text" id="name" class="txt" />

		<br />
		<label for="comments"><span class="required">*</span> Image</label>
		<input type="file" name="file">

		<button id="send" class="button">Create Group</button>
		</fieldset>
	</form>
</div>
<?php
 $res=$businessManager->insertGroup($_REQUEST['name'],$_SESSION['userId']);
 ?>

<script type="text/javascript" src="js2/custom.js"></script>
    
   
               <script>
			   
			    function change(value){
			   //alert(value);
			   document.frm1234.submit();
			   }
			   
			   
			   function fun(){
			   alert("cretae ");
			   }
			   </script>
               
                
                    <thead>
                        <tr>
                            <th class="avatar">UserName</th>
                            <th>Followers</th>
                            <th>Tweets</th>
                            <th>Status</th>
                            <th>Add to Group</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        //echo $businessManager->getTopUsers($_SESSION['userId']);
		     if(isset($_REQUEST['aa']))
			 {
					if($_REQUEST['aa']==1)
					{
					echo $businessManager->getTopUsers($_SESSION['userId']);
					}
					else
					{
					echo $businessManager->getTopUsers22($_SESSION['userId']);
					}
			}
			else
			{
			echo $businessManager->getTopUsers($_SESSION['userId']);
			}
		             ?>


                    </tbody>
                </table>
            </section>
        </section>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />


        <script src="js/jquery.wysiwyg.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/cycle.js"></script>
        <script src="js/jquery.checkbox.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
        <style>
            body { font-size: 62.5%; }
            label, input { display:block; }
            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            fieldset { padding:0; border:0; margin-top:25px; }
            h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 350px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
			
			header input {
    border: medium none;
    border-radius: 15px 15px 15px 15px;
    color: #8A8A8A;
    float: right;
    margin: -46px 7px -20px -20px;
    padding: 5px 10px;
    width: 30%;
}
	.widget > select {
    margin-left: 9px;
}
        </style>
        <script type="text/javascript">$(document).ready(
		
function() {
                            $('#myTable').dataTable({
                                "aaSorting": [[3, "desc"]]
                            });
                        });

                        function followUser(userId, bizId) {
                            $.post("followUser.php", {userId: userId, bizId: bizId})
                                    .done(function(data) {
                                $("#" + userId + bizId).attr("class", "orange");
                                $("#" + userId + bizId).html('UNFOLLOW');
                                $("#" + userId + bizId).attr("onClick", "unFollowUser(" + userId + "," + bizId + ")");
                            });
                        }
                        function unFollowUser(userId, bizId) {
                            $.post("unFollowUser.php", {userId: userId, bizId: bizId})
                                    .done(function(data) {
                                $("#" + userId + bizId).attr("class", "blue");
                                $("#" + userId + bizId).html('FOLLOW');
                                $("#" + userId + bizId).attr("onClick", "followUser(" + userId + "," + bizId + ")");
                            });
                        }
                        function resetName() {
                            $("#newGroupName").val("");
                        }
                        function resetSelectOption() {
                            $('#groupName').prop('selectedIndex', 0);
                        }

        </script>
        <script type="text/javascript">
            $(function() {
                var name = $("#newGroupName"),
                        email = $("#email"),
                        password = $("#password"),
                        allFields = $([]).add(name).add(email).add(password),
                        tips = $(".validateTips");

                function updateTips(t) {
                    tips
                            .text(t)
                            .addClass("ui-state-highlight");
                    setTimeout(function() {
                        tips.removeClass("ui-state-highlight", 1500);
                    }, 500);
                }

                function checkLength(o, n, min, max) {
                    if (o.val().length > max || o.val().length < min) {
                        o.addClass("ui-state-error");
                        updateTips("Length of " + n + " must be between " +
                                min + " and " + max + ".");
                        return false;
                    } else {
                        return true;
                    }
                }

                function checkRegexp(o, regexp, n) {
                    if (!(regexp.test(o.val()))) {
                        o.addClass("ui-state-error");
                        updateTips(n);
                        return false;
                    } else {
                        return true;
                    }
                }



                $("#dialog-form").dialog({
                    autoOpen: false,
                    height: 300,
                    width: 350,
                    modal: true,
                    buttons: {
                        "Add to Group": function() {
                            var groupName = $("#newGroupName").val();
                            var groupSelectID = $('#groupName').val();
                            var groupSelectValue = $("#groupName option:selected").text();
                            if (groupSelectID <= 0) {
                                $.post("createAndAddtoGroup.php", {userId: '<?php echo $_SESSION['userId'] ?>', bizId: $("#selectedBizId").val(), groupName: groupName})
                                        .done(function(data) {
                                    allFields.val("").removeClass("ui-state-error");
                                    $("#dialog-form").dialog("close");
                                });
                            } else {
                                $.post("AddToGroup.php", {userId: '<?php echo $_SESSION['userId'] ?>', bizId: $("#selectedBizId").val(), groupName: groupSelectValue, groupId: groupSelectID})
                                        .done(function(data) {

                                    alert(data);
                                    allFields.val("").removeClass("ui-state-error");
                                    $("#dialog-form").dialog("close");
                                });
                            }
                        },
                        Cancel: function() {
                            $(this).dialog("close");
                        }
                    },
                    close: function() {
                        allFields.val("").removeClass("ui-state-error");
                    }
                });

//                $("#create-user")
//                        .button()
//                        .click(function() {
//                  
//                });
            });
            function addToGroup(userId, bizId) {
                $("#selectedBizId").val("");
                $.post("getGroups.php", {userId: '<?php echo $_SESSION['userId'] ?>'})
                        .done(function(data) {
                    $("#groupName").html(data);
                    $("#dialog-form").dialog("open");
                    $("#selectedBizId").val(bizId);
                });

            }
        </script>
    </body>
</html>