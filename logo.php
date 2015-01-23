<?php
//print_r($_SESSION);
?>
<div class="testing"><header class="main">
        <h1><a href="NewsStream.php" style="cursor:pointer; color:#FFF;">The<strong> NewsID</strong> </a></h1>
        <form name="" action="searchSubscription.php" method="post">
        <input type="text" name="top_search_content" value="search" />
        <input type="submit" value="search" style="display:none;" />
        </form>
    </header>      <section class="user">
    <!---->
        <div class="profile-img">
            <p><a href="viewProfile.php"><img src="upload/<?php echo $_SESSION['userId']; ?>_S.png" onError="this.onerror=null;this.src='images/u.png';" /> <?php 
			if($user_info['FIRST_NAME']){
				echo $user_info['FIRST_NAME'].' ';
			}
			if($user_info['LAST_NAME']){
				echo $user_info['LAST_NAME'];
			}
			//echo $_SESSION["username"] ?></a></p>
        </div>
        <div class="buttons">
            <button class="ico-font">&#59157;</button>
            <?php include_once 'Notifications.php'; ?>
            <!--<span class="button"><a href="viewProfile.php">My Profile</a></span>-->
            <!--<span class="button">Help</span> 
            <span class="button blue"><a href="logout.php">Logout</a></span>  -->
            <span class="button dropdown1">
                <a href="#">Options </a>
                <ul class="notice_logout">
                    <li>
                        <hgroup>
                            <h1><span class="icon">&#59154;</span><a href="Help.php">Help</a></h1>
                            <!--<h2>John Doe</h2>
                            <h3>Lorem ipsum dolor sit amet, consectetuer sed aidping putamus delo de sit felume...</h3> -->
                        </hgroup>
                        <!--<p><span>11:24</span></p> -->
                    </li>
                    
                    <li>
                        <hgroup>
                            <h1><span class="icon">&#59154;</span><a href="viewProfile.php">Profile</a></h1>
                            
                        </hgroup>
                     
                    </li>
                    <!--<li>
                        <hgroup>
                            <h1><span class="icon">&#59154;</span>Developers</h1>
                            
                        </hgroup>
                     
                    </li>-->
                    <li>
                        <hgroup>
                            <h1><span class="icon">&#59154;</span><a href="logout.php">Logout</a></h1>
                            <!--<h2>John Doe</h2>
                            <h3>Lorem ipsum dolor sit amet, consectetuer sed aidping putamus delo de sit felume...</h3> -->
                        </hgroup>
                        <!--<p><span>11:24</span></p>-->
                    </li>
                </ul>
            </span>
        </div>
    </section>
</div>
