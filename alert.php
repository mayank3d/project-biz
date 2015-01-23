<script type="text/javascript" language="javascript">
setTimeout(function() {
    $('#mydiv').fadeOut('fast');
}, 3000);

</script>
<?php

if (isset($_SESSION['alert'])) {
    ?>
    <section  id="mydiv" class = "alert">
        <div class = "green">
            <p><?php echo $_SESSION['alert']?></p>
            <span class = "close">&#10006;</span>
        </div>
    </section>
    <?php

}
?>