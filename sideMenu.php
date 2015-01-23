<?php
//echo 'aaaaaaaaaaaaa';
$se = $_SERVER['PHP_SELF'];
?>
<nav>
    <ul>
        <li id="NewsStreamSM"     > <a href="NewsStream.php"    > <span class="icon">&#59194; </span> News Stream    </a></li>
        <li id="MyStreamSM"       > <a href="MyStream.php"      > <span class="icon">&#9998;  </span> My Stream      </a></li>
        <li id="MySubscriptionSM" <?php if($se =='/searchSubscription.php' || $se =='/MySubscription.php'){ $d = 'block';?> class="section" <?php }else{ $d = 'none';}	?> > <a href="MySubscription.php"> <span class="icon">&#128196;</span> My Subscription</a>
            <ul class="submenu" style="display:<?php echo $d?>;">
                <li><a href="MySubscription.php">Subscribed</a></li>
                <li class="last"><a href="searchSubscription.php">Search NewsID</a></li>
            </ul>
        </li>
        <li id="MySubscribersSM" <?php if($se =='/pending.php' || $se =='/MySubscribers.php'){ $dd = 'block';?> class="section" <?php }else{ $dd = 'none';}	?> > <a href="MySubscribers.php" > <span class="icon">&#128101;</span> My Subscribers </a>
            <ul class="submenu" style="display:<?php echo $dd?>;">
                <li><!--<a href="subscribed.php">Subscribed</a>-->
                <a href="MySubscribers.php">Subscribed</a>
                </li>
                <li class="last"><a href="pending.php">Pending</a></li>
            </ul>
        </li>
        <li id="TrendsSM"         > <a href=""        > <span class="icon">&#128227;</span> Trending News  </a></li>
    </ul>
    <?php include_once 'TrendyNews.php'; ?>
</nav>

