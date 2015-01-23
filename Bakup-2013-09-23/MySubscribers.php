<?php
session_start();
include_once 'library.php';
include 'BusinessManager.php';

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
    
        

        <?php 
		include_once 'ajaxloading_up.php';
		include_once 'logo.php'; ?>
        <?php include_once 'sideMenu.php'; ?>
        <?php //include_once 'alert.php'; ?>
        <section class="content">
            <section class="widget">
                <table id="myTable" border="0" width="100%">
                    <thead>
                        <tr>
                            <th colspan="3" class="avatar" style="padding:0px;">
                            <div style=" text-align:left; margin-left:10px; margin-bottom:8px; vertical-align:middle; font-size:18px; padding:10px;">Subscribers </div>                            
                            </th>
                        </tr>
                        <tr>
                            <th class="avatar" style="padding:0px;" width="40%">
                            <div style=" margin-left:140px; text-align:left; margin-bottom:8px; vertical-align:middle;">
                            Full Name</div></th>
                            <th width="30%"><div style=" text-align:left; margin-bottom:8px; vertical-align:middle;">NewsID</div></th>
                            <!--<th width="30%"><div style=" text-align:left; margin-left:10px; margin-bottom:8px; vertical-align:middle;">ALLOW</div></th>-->
                            <th width="30%"><div style=" text-align:left; margin-left:10px; margin-bottom:8px; vertical-align:middle;">BLOCK</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $businessManager = new BusinessManager;
                        echo $businessManager->getNewFollowers($_SESSION['userId']);
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
        <!--<script src="js/jquery.dataTables.min.js"></script>-->
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
        <style>
            /*body { font-size: 62.5%; }*/
            label, input { display:block; }
            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            fieldset { padding:0; border:0; margin-top:25px; }
            h1 { font-size: 1.2em; 
			/*margin: .6em 0; */
			}
            div#users-contain { width: 350px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>
        <script type="text/javascript">
		/*$(document).ready(function() {
                            $('#myTable').dataTable({
                                "aaSorting": [[3, "desc"]]
                            });
                        });*/

                        function allow(userId, bizId) {
							$('#fancyboxloading_up').css('display','block');
                            $.post("allow.php", {userId: userId, bizId: bizId})
                                    .done(function(data) {
                                //alert(data);
                                $("#" + bizId + "_F").remove();
                            });
                        }
                        function block(bizId) {
							$('#fancyboxloading_up').css('display','block');
                            $.post("unFollowUser.php", {bizId: bizId})
                                    .done(function(data) {
										//alert(data);
									$('#fancyboxloading_up').css('display','none');
								$("#" + bizId + "_F").remove();
                                /*$("#" + userId + bizId).attr("class", "blue");
                                $("#" + userId + bizId).html('FOLLOW');
                                $("#" + userId + bizId).attr("onClick", "followUser(" + userId + "," + bizId + ")");*/
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