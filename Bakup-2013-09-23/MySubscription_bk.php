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

    <link rel="stylesheet" href="css/style.css" media="all" />
    <body>
        <!--<div id="dialog-form" title="Add to Group">
            <p class="validateTips">Add to existing group or New Group</p>

            <form>
                <!--<fieldset>
                    <label for="name">Your Group</label>
                   <!-- <select name="groupName" id="groupName" class="text ui-widget-content ui-corner-all" onchange="resetName()"><select/>
                        <label for="email">New Group</label>
                        <input type="text" name="newGroupName" id="newGroupName" value="" onfocus="resetSelectOption()" class="text ui-widget-content ui-corner-all" />
                        <input type="hidden" id="selectedBizId" />-->
                <!--</fieldset>
            </form>
        </div>-->

        <?php include_once 'logo.php'; ?>
        <?php include_once 'sideMenu.php'; ?>
        <?php //include_once 'alert.php'; ?>
        <section class="content">
            <section class="widget">
                
               <?php
			  // mysql_connect();
			  
			  $res=$businessManager->test123($_SESSION['userId']);
			 // echo $num;
			   
			   ?>
               <div style="width:100%;margin: 15px; height:50px;">
               <div style="width:90%; margin:0 auto;float:left;">
               <div style="float:left;width:200px;">
               <form action="<?php $_SERVER['PHP_SELF'];?>" name="frm1234" method="post" >
               <div style="width:55px; float:left;"> Show : </div>
               <div style="width:100px; float:left;">
               <select style="padding-left:5px;"name="aa" onChange="change(this.value);">
               <option value="1" <?php if($_REQUEST['aa']==1){?> selected <?php }?>>Subscribed</option>
               <option value="2"<?php if($_REQUEST['aa']==2){?> selected <?php }?> >All News Id</option>
               </select>
               </div>
               
               </form>
               </div>
               <div style="float:left;width:200px;">
               <button id="create_group" class="blue" onclick="fun();" style="margin-top:0px;">Create Group</button>
               
               </div>
               </div>
               </div>
               <script>
			   
			    function change(value){
			   //alert(value);
			   document.frm1234.submit();
			   }
			   
			   
			   function fun(){
			   alert("cretae ");
			   }
			   </script>
               <div style="margin:15px;">
                <table id="myTable_" class="mysubscriptiob" border="0" width="100%">
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
                </div>
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