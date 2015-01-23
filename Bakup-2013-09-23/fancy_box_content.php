<?php
include_once 'library.php';
?>
<div id="inline1" style="width:400px;display: none;">
<form name="group_add" id="group_add" method="post" action=""> 
<input type="hidden" name="subscriber_id" id="subscriber_id" value="" />
</form>
		<h3 style="font-size:18px; text-align:center;">Select Subscribe Type</h3>
		<div style="margin-top:5px;">
        <div style="width:235px; margin:0 auto;">
			<button onclick="Individual_add();" id="subscribe_individual" class="blue" style="padding:10px 5px;font-size:11px; font-weight:bold; margin:15px;">Individual</button>
            <button onclick="group_add_pop();" id="subscribe_group" class="blue" style="padding:10px 5px;font-size:11px; font-weight:bold; margin:15px;">Add to Group</button>
		</div>
        </div>
	</div>
    
    <div id="inline1_group" style="width:400px;display: none;">

		<h3 style="font-size:18px; text-align:center;">Please select your group</h3>
		<div style="margin-top:5px;">
        <div style="width:235px; margin:0 auto;">
        <div style="margin-top:25px; text-align:center;">
        <?php
		echo $businessManager->get_group_dropdown();
		?>
        </div>
        <div>
			<button onclick="subscribe_group();" id="subscribe_group" class="blue" style="padding:10px 5px;font-size:11px; font-weight:bold; margin:15px;">Subscribe</button>
            <button onclick="create_group();" id="create_group" class="blue" style="padding:10px 5px;font-size:11px; font-weight:bold; margin:15px;">Create Group</button>
		</div>    
		</div>
        </div>
	</div>
    <div id="inline1_create_group" style="width:530px; display: none;">
   <div style="width:508px;">
		<form method="post" enctype="multipart/form-data" name="group_add_frm" id="group_add_frm"  action="upload.php">
		<h3 style="font-size:18px; text-align:center;">Create Group</h3>
		<div style="margin-top:5px; width:440px;">
        <div style="width:435px; margin:0 auto;">
        
        <div style="margin-top:25px; text-align:center;">
        	<div style="float:left; width:150px; font-weight:bold;">Group Name :</div>
            <div style="float:left;  width:250px;"> <input type="text" name="group_name" id="group_name"  /></div>
        </div>
        
        <div style="margin-top:25px; text-align:center;">
        	<div style="float:left; width:150px; font-weight:bold;">Image : </div>
            <div style="float:left; width:250px;"><input type="file" name="images" id="images"  /></div>
        </div>
        
        <div style="margin-top:25px; text-align:center; width:435px; float:left;">
        	
            <div id="response"></div>
            <ul id="image-list">
    
            </ul>
            
        </div>
        <div style="width:435px; float:left;">
        
			<div style="float: left; width: 130px; margin-left: 80px;">
            &nbsp;
            <button type="button" id="btn" onclick="create_group_with_image();" class="blue" style="padding:10px 5px;font-size:11px; font-weight:bold; margin:15px;">Create Group</button>
            &nbsp;
            </div>
            <div style="float: left; width: 150px;"><button type="button" id="" onclick="javascript:$.fancybox.close();" class="blue" style="padding:10px 5px;font-size:11px; font-weight:bold; margin:15px;">Cancel</button></div>
		</div> 
           
		</div>
        </div>
        </form>
        </div>
	</div>
    
    <div id="inline1_group_success" style="width:400px;display: none;">
		<div style="margin-top:5px;">
        <h3 style="font-size:18px; text-align:center;">Your group created successfully.</h3>
        </div>
	</div>
    
    <div id="inline1_dinamic_success_msg" style="width:400px;display: none;">
		<div style="margin-top:5px;">
        <h3 style="font-size:18px; text-align:center;" id="dinamic_head_msg">Your group created successfully.</h3>
        </div>
	</div>
    
    
    <div style="display:none;">
    <a class="fancybox" href="#inline1" >Inline</a>
    <a class="fancybox_group" href="#inline1_group" >Inline</a>
    <a class="create_new_group" href="#inline1_create_group" >Inline</a>
     <a class="create_new_group_success" href="#inline1_group_success" >Inline</a>
     
     <a class="dinamic_success_msg" href="#inline1_dinamic_success_msg" >Inline</a>
    </div>