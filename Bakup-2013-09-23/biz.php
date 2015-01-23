<?php
include_once 'library.php';
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
    <body onload="getNewslets()">
        <?php include_once 'logo.php'; ?>
        <?php include_once 'sideMenu.php'; ?>
        <?php include_once 'alert.php'; ?>
        <?php include_once 'TNIManager.php'; ?>


        <section class="content">
            <section class="widget">
                <div class="field-wrap">
                    <input type="text" value="Stream a Newslet within 300 characters" id="MyMsg" name="MyMsg"/>
                </div>
                <button class="blue" onclick="submitNewslet()">Stream</button>
                <header>
                    <span class="icon">&#59168;</span>
                    <hgroup>
                        <h1>My Newslets</h1>
                        <h2>News items Streamed by you</h2>
                    </hgroup>
                </header>
                <div class="content no-padding timeline" id="myNewslets">
                    <?php
                    $tniManager = new TNIManager;
                    $tniManager->getNewsletsUIByBizId($_GET['g'], session_id());
                    ?>

                </div>
            </section>
        </section>
        <script src="js/jquery.wysiwyg.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/cycle.js"></script>
        <script src="js/jquery.checkbox.min.js"></script>
        <script src="js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript">
        function getNewslets() {
            $.post("getMessages.php", {userId: '<?php echo $_SESSION['userId'] ?>', sId: '<?php echo session_id() ?>'},
            function(data) {
                $('#myNewslets').append(data);
                i = 10;
                $(".tl-post").each(function() {
                    $(this).delay(i).animate({"opacity": 1});
                    i = i + 20;
                });
            });
        }
        function deleteNewslet(msgId) {
            $.post("getMessages.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                    .done(function(data) {

            });
        }

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

        function submitNewslet() {
            var msg = $("#MyMsg").val();
            $.post("BroadCastMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msg: msg})
                    .done(function(data) {
                $inter = '';
                $inter = makeListNewslet($inter, msg, data);
                $("#myNewslets").prepend($inter);
                i = 20;
                $(".tl-post").each(function() {
                    $(this).delay(i).animate({"opacity": 1});
                });
                $("#MyMsg").val('');
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

        function makeListNewslet(inter, msg, key) {
            $inter = inter;
            $inter = $inter + '<div class="tl-post"><span class="icon"><img src="images/u.png" /></span>';
            $inter = $inter + ' <p align="justify">';
            $inter = $inter + msg;
            $inter = $inter + '<span class="cools" id="' + key + 'msgId">67 cools</span><button class="blue" id="' + key + 'coolBtn" onclick="coolMessage(\'';
            $inter = $inter + key + '\')">cool!</button> <span class="cools" id="' + key + 'msgIdshares">67 shares </span><button id="' + key + 'shareBtn" onclick="reNewslet(\'' + key + '\')" class="green">share</button> <button class="red" onclick="window.location.href=\'commentSection.php?id=' + key + '\'">comment</button></p></div>';
            return $inter;
        }</script>
    </body>
</html>