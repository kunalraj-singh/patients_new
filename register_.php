<?php 
include('includes/header.php');
?>
<?php
if(isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])){
	header("Location:index.php");exit;
}

if(isset($_POST['merchant_submit']) && !empty($_POST['merchant_submit'])){
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#form_head').html("MERCHANT");
	$('#consumer_frm_row').hide("fast");
	$('#merchant_frm_row').show("fast");
});
</script>
<?php
}else if(isset($_POST['consumer_submit']) && !empty($_POST['consumer_submit'])){
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#form_head').html("CONSUMER");
	$('#consumer_frm_row').show("fast");
	$('#merchant_frm_row').hide("fast");
});
</script>
<?php
}
?>

<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
    if(isset($_POST['merchant_submit'])){
      
      $title = $_POST['title'];
      $name = $_POST['name'];
      $phone = $_POST['phone'];
      $website = $_POST['website'];
      $email = $_POST['email'];
      $cemail = $_POST['cemail'];
      $password = $_POST['password'];
      $pass_len = strlen($password);
      $address = $_POST['address'];
      
     

      /** === Start : Image Uploads == **/
       $image_name=$_FILES['image']['name'];
       $temp = explode(".", $image_name);
       $newfilename_m = round(microtime(true)) . '.' . end($temp);
       $imagepath="uploads/merchant/".$newfilename_m;
       move_uploaded_file($_FILES["image"]["tmp_name"],$imagepath);
       

	  /** === Ended : Image Uploads == **/
      
      if(empty($_SESSION['DataError']) && !isset($_SESSION['DataError'])){
        $query = "insert into business(title,name,phone,website,email,password,address,business_image) values('$title','$name','$phone','$website','$email','$password','$address','$newfilename_m')";
        $insert = mysql_query($con,$query);

        if($insert == true)
        {
          $_SESSION['DataSuccess']['message']="Record inserted successfully<br> Please Login to Continue";
        }
        else
        {
          $_SESSION['DataError']['message'] = "Insertion Failed";
        }
      }else{
        $_SESSION['DataError']['formErr'] = "Something went wrong with your data.";
      }
    }else if(isset($_POST['consumer_submit'])){
	//echo "<pre>";print_r($_POST);die;
      $type = 1;
	  $fname = $_POST['fname'];
	  $lname = $_POST['lname'];
      $mobile = $_POST['mobile'];
      $email = $_POST['email'];
      $cemail = $_POST['cemail'];
      $password = $_POST['password'];
      $pass_len = strlen($password);
	  $created = date('Y-m-d');

      /** === Start : Image Uploads == **/
       /*$image_name=$_FILES['image']['name'];
       $temp = explode(".", $image_name);
       $newfilename_c = round(microtime(true)) . '.' . end($temp);
       $imagepath="uploads/consumer/".$newfilename_c;
       move_uploaded_file($_FILES["image"]["tmp_name"],$imagepath);
       */

    /** === Ended : Image Uploads == **/
      
      	if($fname == "" || $lname=="" || $email=="" || $mobile=="" || $password==""){
			if(isset($fname) && ($fname=="")){
				$err_msg['CONSUMER_ERR']['fname'] = "Please enter first name."; 		
			  }
			  if(isset($lname) && ($lname=="")){
				$err_msg['CONSUMER_ERR']['lname'] = "Please enter last name."; 		
			  }
			  if(isset($mobile) && ($mobile=="")){
				$err_msg['CONSUMER_ERR']['mobile'] = "Please enter mobile number."; 		
			  }
			  if(isset($mobile) && ($mobile!="") && !is_int($mobile)){
				$err_msg['CONSUMER_ERR']['mobile'] = "Mobile can only be integer."; 		
			  }
			  if(isset($email) && ($email=="")){
				$err_msg['CONSUMER_ERR']['email'] = "Please enter email address."; 		
			  }
			  $email = test_input($_POST["email"]);
			  // check if e-mail address is well-formed
			  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$err_msg['CONSUMER_ERR']['email'] = "Invalid email format."; 
			  }
			  if($email != $cemail)
			  {
				 $err_msg['CONSUMER_ERR']['email'] = "Email and Confirm Email doesn't mached";
			  }
			  if(isset($password) && ($password=="")){
				$err_msg['CONSUMER_ERR']['password'] = "Please enter password."; 		
			  }
			  if($pass_len < 6 || $pass_len > 10){
				$err_msg['CONSUMER_ERR']['password'] = "Password length minimum 6 char and maximum 10."; 		
			  }
		}else{
			// Insert data into deal table			  
			  $query = "INSERT INTO user(user_type,contact_person_name,last_name,primary_phone_number,fax,email_address,password,registration_date,status) VALUES('$type','$fname','$lname','$mobile','$mobile','$email','$password','$created','Inactive')";
			  
			  $insert = mysql_query($query);
			  //echo $insert."dfgd";
			  if($insert == true){
					$message['MESSAGE']['success'] = "Your Information has been registered in portal, Please login to create Deal / Business.";
			  }else{
				  $message['MESSAGE']['error'] = "Ooopss.., There is some problem while registration.";
			  }
		}
    
	}


?>

<script type="text/javascript">
$(document).ready(function(){
  $("input:radio[name=type_reg]").click(function(){
		var value = $(this).val();
		var get = $(this).attr("id");
		
		if(value=='merchant'){
			//alert(value);
			$('#form_head').html("MERCHANT");
			$('#consumer_frm_row').hide("fast");
			$('#merchant_frm_row').show("fast");
		}else{
			$('#form_head').html("CONSUMER");
			$('#consumer_frm_row').show("fast");
			$('#merchant_frm_row').hide("fast");
		}
	});
  	$(function() {
		setTimeout(function() {
			$(".error").hide('slideDown', {}, 100)
		}, 1000);
	});
	$(function() {
		setTimeout(function() {
			$(".success").hide('slideDown', {}, 100)
		}, 1000);
	});
  
});
</script>
<!--Middle-Start-->
  <div id="middle">
    <div class="wrapper">
     <div id="middle-inner">
    <!--Middle--Left-Start-->
    	<div class="middle-left">
        <div class="middle-left-top-img"><img src="images/middle-left-top-img.jpg" width="736" height="10" /></div>
         <div class="middle-left-middle-bg">
          <div class="inner_left-middle">
            <div class="inner_heading"><div class="inner_heading_text">Register</div><div class="inner-heading-slogan">Already have an account on Facebook?</div>
            <div class="clearfix"></div>	
            </div>
            <div class="register-form">
      <?php
      	if(!empty($message) && $message['MESSAGE']['success']!=""){
		?>
        <div class="success"><?php echo $message['MESSAGE']['success']; ?></div>
       <?php 	
		}else if(!empty($message) && $message['MESSAGE']['error']!=""){
		?>
        <div class="top-error"><?php echo $message['MESSAGE']['error']; ?></div>
        <?php
		}
	  ?>
  			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
              <td height="10" align="center" valign="top"><img src="images/spacer.gif" width="1" height="1" /></td>
              </tr>
              <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="center" valign="middle">&nbsp;</td>
              <td><table border="0" cellpadding="0" cellspacing="0" width="225">
            <tbody>
            <tr>
              <td width="22" height="33" align="left" valign="middle">
                <input name="type_reg" id="consumer_radio" value="consumer" type="radio" checked="" />
              </td>
              <td height="33"  align="left" valign="middle" class="register-details">Consumer</td>
              <td width="22" height="33" align="left" valign="middle">
              <input name="type_reg" id="merchant_radio" value="merchant" type="radio" /></td>
              <td height="33" align="left" valign="middle" class="register-details">Merchant</td>
            </tr>
          </tbody>
        </table></td>
      </tr>
      <!-- START : Consumer Form -->
<tr>
  <td height="12" colspan="3" align="left" valign="middle"><img src="images/spacer.gif" width="1" height="1" /></td>
</tr>
  <tr>
    <td id="form_head" colspan="3" align="left" valign="middle">CONSUMER</td>
  </tr>
   <tr>
      <td id="consumer_frm_row" colspan="3" valign="middle">
      	<form action="" method="POST">
        	<table align="center">
            <tr>
              <td width="120" align="left" valign="middle" class="register-details">User Image</td>
               <td width="20" align="center" valign="middle" class="register-details">:</td>
                <td><input type="file" name="image" id="image" class="textbox-air" style="border:none;" /></td>
              </tr>
                <tr>
                  <td width="120" align="left" valign="middle">&nbsp;</td>
                  <td width="20" align="center" valign="middle">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                      <tr>
                        <td width="120" align="left" valign="middle" class="register-details">Type</td>
                        <td width="20" align="center" valign="middle" class="register-details">:</td>
                        <td>
                        	<select name="type" id="type">
                            	<option value="">--Select type--</option>
                                <option value="1" selected="selected">Customer</option>
                                <option value="2">Business</option>
                            </select>
                        </td>
                      </tr>
                      <tr>
                        <td width="120" align="left" valign="middle">&nbsp;</td>
                        <td width="20" align="center" valign="middle">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                <tr>
                  <td width="120" align="left" valign="middle" class="register-details">First Name</td>
                  <td width="20" align="center" valign="middle" class="register-details">:</td>
                  <td><input type="text" name="fname" id="fname" class="textbox-air" style="width:350px;" value="<?php echo (isset($fname))?$fname:'';?>" /><?php if(isset($err_msg['CONSUMER_ERR']['fname']) && (!empty($err_msg['CONSUMER_ERR']['fname']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['CONSUMER_ERR']['fname'];?></div><?php }else{ echo ""; } ?>
                  </td>
                </tr>
                <tr>
                        <td width="120" align="left" valign="middle">&nbsp;</td>
                        <td width="20" align="center" valign="middle">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                <tr>
                  <td width="120" align="left" valign="middle" class="register-details">Last Name</td>
                  <td width="20" align="center" valign="middle" class="register-details">:</td>
                  <td><input type="text" name="lname" id="lname" class="textbox-air" style="width:350px;" value="<?php echo (isset($lname))?$lname:'';?>" /><?php if(isset($err_msg['CONSUMER_ERR']['lname']) && (!empty($err_msg['CONSUMER_ERR']['lname']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['CONSUMER_ERR']['lname'];?></div><?php }else{ echo ""; } ?>
                  </td>
                </tr>
                <tr>
                  <td width="120" align="left" valign="middle">&nbsp;</td>
                  <td width="20" align="center" valign="middle">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="120" align="left" valign="middle" class="register-details">Mobile No.</td>
                  <td width="20" align="center" valign="middle" class="register-details">:</td>
                  <td><input type="integer" name="mobile" id="mobile" class="textbox-air" style="width:350px;" value="<?php echo (isset($mobile))?$mobile:'';?>" /><?php if(isset($err_msg['CONSUMER_ERR']['mobile']) && (!empty($err_msg['CONSUMER_ERR']['mobile']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['CONSUMER_ERR']['mobile'];?></div><?php }else{ echo ""; } ?>
                  </td>
                </tr>
                 <tr>
                  <td width="120" align="left" valign="middle">&nbsp;</td>
                  <td width="20" align="center" valign="middle">&nbsp;</td>
                  <td>&nbsp;</td>
                 </tr>
                  <tr>
                    <td width="120" align="left" valign="middle" class="register-details">Email</td>
                    <td width="20" align="center" valign="middle" class="register-details">:</td>
                    <td><input type="email" name="email" id="email" class="textbox-air" style="width:350px;" value="<?php echo (isset($email))?$email:'';?>" /><?php if(isset($err_msg['CONSUMER_ERR']['email']) && (!empty($err_msg['CONSUMER_ERR']['email']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['CONSUMER_ERR']['email'];?></div><?php }else{ echo ""; } ?>
                    </td>
                  </tr>
                      <tr>
                        <td width="120" align="left" valign="middle">&nbsp;</td>
                        <td width="20" align="center" valign="middle">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                  <tr>
                    <td width="120" align="left" valign="middle" class="register-details">Confirm Email</td>
                    <td width="20" align="center" valign="middle" class="register-details">:</td>
                    <td><input type="email" name="cemail" id="cemail" class="textbox-air" style="width:350px;" value="<?php echo (isset($cemail))?$cemail:'';?>"/><?php if(isset($err_msg['CONSUMER_ERR']['email']) && (!empty($err_msg['CONSUMER_ERR']['email']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['CONSUMER_ERR']['email'];?></div><?php }else{ echo ""; } ?>
                    </td>
                  </tr>
                  <tr>
                    <td width="120" align="left" valign="middle">&nbsp;</td>
                    <td width="20" align="center" valign="middle">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="120" align="left" valign="middle" class="register-details">Password</td>
                    <td width="20" align="center" valign="middle" class="register-details">:</td>
                    <td><input type="password" name="password" id="password" class="textbox-air" style="width:350px;" min="8" value="<?php echo (isset($password))?$password:'';?>"/>
                    <?php if(isset($err_msg['CONSUMER_ERR']['password']) && (!empty($err_msg['CONSUMER_ERR']['password']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['CONSUMER_ERR']['password'];?></div><?php }else{ echo ""; } ?>
                    </td>
                    </tr>
                  <tr>
                    <td width="120" align="left" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              <tr>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                <td>
                  <table width="550" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    <td height="25" align="left" valign="top" class="register-details">Type the characters you see in the below image.</td>
                    </tr>
                    <tr>
                    <td><img src="images/captcha_code_file.php.jpg" width="120" height="40" /></td>
                    </tr>
                   <tr>
                    <td height="25" align="left" valign="middle" class="register-details">Enter the code above here :</td>
                    </tr>
                    <tr>
                      <td><input type="text" name="textfield2" id="textfield2" class="textbox-air" style="width:350px;" /></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" valign="middle" class="register-details">Can't read the image? click here to refresh</td>
                    </tr>
                      <tr><td>&nbsp;</td></tr>
                    <tr>
                      <td height="22" align="left" valign="top" class="medial-box-details-black">By clicking Create Account, I agree to the Privacy Policy and Terms of Use.</td>
                    </tr>
                  </table>
                </td>
               </tr>
              <tr>
                <td height="12" colspan="3" align="left" valign="middle"><img src="images/spacer.gif" alt="" width="1" height="1" /></td>
              </tr>
              <tr>
                <td align="left" valign="middle">&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
                <td align="left" valign="top">
                  <button type="submit" value="Create Account" name="consumer_submit">Create Account</button>
                </td>
              </tr><p><?php if (isset($msg)) {echo $msg;}  ?></p>
          </table>
        </form>  
      </td>
    </tr>
<!-- ENDED : Consumer Form Content -->
<!-- START : Merchant Form Content -->
<tr>
  <td id="merchant_frm_row" colspan="3" valign="middle" style="display:none;">
    <form action="" method="POST" enctype="multipart/form-data">   
      <table align="center">
        <tr>
          <td width="120" align="left" valign="middle" class="register-details">User Image</td>
          <td width="20" align="center" valign="middle" class="register-details">:</td>
          <td><input type="file" name="image" id="image" class="textbox-air" style="border:none;" /></td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle">&nbsp;</td>
          <td width="20" align="center" valign="middle">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle" class="register-details">Business Name</td>
          <td width="20" align="center" valign="middle" class="register-details">:</td>
          <td><input type="text" name="title" id="title" class="textbox-air" style="width:350px;" required="" value="<?php echo (isset($bname))?$bname:'';?>" /></td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle">&nbsp;</td>
          <td width="20" align="center" valign="middle">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle" class="register-details">Name</td>
          <td width="20" align="center" valign="middle" class="register-details">:</td>
          <td><input type="text" name="name" id="name" class="textbox-air" style="width:350px;" required="" value="<?php echo (isset($name))?$name:'';?>" />
            <div style="color: #ff0;"><?php if(isset($_SESSION['DataError']['nameErr']) && !empty($_SESSION['DataError']['nameErr'])){ echo $_SESSION['DataError']['nameErr']; } ?></div>
          </td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle">&nbsp;</td>
          <td width="20" align="center" valign="middle">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle" class="register-details">Mobile No.</td>
          <td width="20" align="center" valign="middle" class="register-details">:</td>
          <td><input type="integer" name="phone" id="phone" class="textbox-air" style="width:350px;"  required=""value="<?php echo (isset($mobile))?$mobile:'';?>" /></td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle">&nbsp;</td>
          <td width="20" align="center" valign="middle">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle" class="register-details">Website</td>
          <td width="20" align="center" valign="middle" class="register-details">:</td>
          <td><input type="website" name="website" id="website" class="textbox-air" required=""style="width:350px;"  /></td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle">&nbsp;</td>
          <td width="20" align="center" valign="middle">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle" class="register-details">Email</td>
          <td width="20" align="center" valign="middle" class="register-details">:</td>
          <td><input type="email" name="email" id="email" class="textbox-air" style="width:350px;" required=""value="<?php echo (isset($email))?$email:'';?>" /></td>
        </tr>

        <tr>
          <td width="120" align="left" valign="middle">&nbsp;</td>
          <td width="20" align="center" valign="middle">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle" class="register-details">Confirm Email</td>
          <td width="20" align="center" valign="middle" class="register-details">:</td>
          <td><input type="email" name="cemail" id="cemail" class="textbox-air" style="width:350px;" required=""value="<?php echo (isset($cemail))?$cemail:'';?>"/></td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle">&nbsp;</td>
          <td width="20" align="center" valign="middle">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle" class="register-details">Password</td>
          <td width="20" align="center" valign="middle" class="register-details">:</td>
          <td><input type="password" name="password" id="password" class="textbox-air" style="width:350px;" min="8" required=""value="<?php echo (isset($password))?$password:'';?>"/></td>
        </tr>
        <tr>
          <td width="120" align="left" valign="middle">&nbsp;</td>
          <td width="20" align="center" valign="middle">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td width="120" align="left" valign="middle" class="register-details">Address</td>
          <td width="20" align="center" valign="middle" class="register-details">:</td>
          <td><input type="text" name="address" id="address" class="textbox-air" style="width:350px;" required="" /></td>
          </tr>
        <tr>
          <td width="120" align="left" valign="middle">&nbsp;</td>
          <td width="20" align="center" valign="middle">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      
        <tr>
        <td width="120" align="left" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td height="12" colspan="3" align="left" valign="middle"><img src="images/spacer.gif" alt="" width="1" height="1" /></td>
        </tr>
        <tr>
          <td align="left" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="left" valign="top">
            <button type="submit" name="merchant_submit">Create Account</button>
          </td>
        </tr>
    </table>
    </form>   
  </td>
      </tr>
      <!-- ENDED ; Merchant Form Contnt -->
    </table></td>
  </tr>
</table>


        </div>
      </div>
    </div>
  <div class="middle-left-top-img"><img src="images/middle-left-bottom-img.jpg" width="736" height="10" /></div>
</div>
<!--Middle--Left-End-->        
<?php include 'includes/rightside.php'; ?> 
            
    <div class="clearfix"></div>
  </div>
</div>
</div>    
    <!--Middle-End-->
  <?php include 'includes/footer.php'; ?>