<?php 
include('includes/header.php');

$patientObj = new Patient();
$doctorObj = new Doctor();
$myClassObj = new MyClass();

$diseases = $myClassObj->getDiseases();

if(isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])){
	header("Location:index.php");exit;
}

if(isset($_POST['doctor_submit']) && !empty($_POST['doctor_submit'])){
?>
<script type="text/javascript">
$(document).ready(function(){
	//$('#form_head').html("DOCTOR");
	$('#patient_frm').hide("fast");
	$('#doctor_frm').show("fast");
});
</script>
<?php
}else if(isset($_POST['patient_submit']) && !empty($_POST['patient_submit'])){
?>
<script type="text/javascript">
$(document).ready(function(){
	//$('#form_head').html("PATIENT");
	$('#patient_frm').show("fast");
	$('#doctor_frm').hide("fast");
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


if(isset($_POST['doctor_submit']) && !empty($_POST['doctor_submit'])){
	//echo "<pre>";print_r($_POST);//die;
	$fname = $_POST['fname'];
	  $lname = $_POST['lname'];
      $mobile = $_POST['mobile'];
      $email = $_POST['email'];
      $cemail = $_POST['cemail'];
      $password = $_POST['password'];
      $pass_len = strlen($password);
	  $created = date('Y-m-d');
	  $disease = $_POST['disease'];

      /** === Start : Image Uploads == **/
       if(isset($_FILES['profile_img']) && !empty($_FILES['profile_img'])){
		   $image_name = $_FILES['profile_img']['name'];
		   $temp = explode(".", $image_name);
		   $newfilename_c = round(microtime(true)) . '.' . end($temp);
		   $imagepath="uploads/doctors/".$newfilename_c;
		   move_uploaded_file($_FILES["profile_img"]["tmp_name"],$imagepath);
	   }
       

    /** === Ended : Image Uploads == **/
      
      	if($fname == "" || $lname=="" || $email=="" || $mobile=="" || $password=="" || $disease==""){
			if(isset($disease) && ($disease=="")){
				$err_msg['DOCTOR_ERR']['disease'] = "Please select your speciality."; 		
			  }
			if(isset($fname) && ($fname=="")){
				$err_msg['DOCTOR_ERR']['fname'] = "Please enter first name."; 		
			  }
			  if(isset($lname) && ($lname=="")){
				$err_msg['DOCTOR_ERR']['lname'] = "Please enter last name."; 		
			  }
			  if(isset($mobile) && ($mobile=="")){
				$err_msg['DOCTOR_ERR']['mobile'] = "Please enter mobile number."; 		
			  }
			  if(isset($mobile) && ($mobile!="") && !is_int($mobile)){
				$err_msg['DOCTOR_ERR']['mobile'] = "Mobile can only be integer."; 		
			  }
			  if(isset($email) && ($email=="")){
				$err_msg['DOCTOR_ERR']['email'] = "Please enter email address."; 		
			  }
			  $email = test_input($_POST["email"]);
			  // check if e-mail address is well-formed
			  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$err_msg['DOCTOR_ERR']['email'] = "Invalid email format."; 
			  }
			  if($email != $cemail)
			  {
				 $err_msg['DOCTOR_ERR']['email'] = "Email and Confirm Email doesn't mached";
			  }
			  if(isset($password) && ($password=="")){
				$err_msg['DOCTOR_ERR']['password'] = "Please enter password."; 		
			  }
			  if($pass_len < 6 || $pass_len > 10){
				$err_msg['DOCTOR_ERR']['password'] = "Password length minimum 6 char and maximum 10."; 		
			  }
		}else{
			// Insert data into deal table	
			$addDoctor = $doctorObj->addDoctor($_POST);
			  if($addDoctor == true){
				$message['MESSAGE']['success'] = "Your Information has been registered in portal.";
			  }else{
				$message['MESSAGE']['error'] = "Ooopss.., There is some problem while registration.";
			  }
		}
    
	
}

if(isset($_POST['patient_submit']) && !empty($_POST['patient_submit'])){
	//echo "<pre>";print_r($_POST);//die;
	$fname = $_POST['fname'];
	  $lname = $_POST['lname'];
      $mobile = $_POST['mobile'];
      $email = $_POST['email'];
	  $age = $_POST['age'];
	  $gender = $_POST['gender'];
      $cemail = $_POST['cemail'];
      $password = $_POST['password'];
      $pass_len = strlen($password);
	  $created = date('Y-m-d');
	  $disease = $_POST['disease'];

      /** === Start : Image Uploads == **/
       if(isset($_FILES['profile_img']) && !empty($_FILES['profile_img'])){
		   $image_name = $_FILES['profile_img']['name'];
		   $temp = explode(".", $image_name);
		   $newfilename_c = round(microtime(true)) . '.' . end($temp);
		   $imagepath="uploads/patients/".$newfilename_c;
		   move_uploaded_file($_FILES["profile_img"]["tmp_name"],$imagepath);
	   }
       

    /** === Ended : Image Uploads == **/
      
      	if($fname == "" || $lname=="" || $email=="" || $mobile=="" || $password=="" || $disease==""){
			if(isset($disease) && ($disease=="")){
				$err_msg['PATIENT_ERR']['disease'] = "Please select your speciality."; 		
			  }
			if(isset($fname) && ($fname=="")){
				$err_msg['PATIENT_ERR']['fname'] = "Please enter first name."; 		
			  }
			  if(isset($lname) && ($lname=="")){
				$err_msg['PATIENT_ERR']['lname'] = "Please enter last name."; 		
			  }
			  if(isset($mobile) && ($mobile=="")){
				$err_msg['PATIENT_ERR']['mobile'] = "Please enter mobile number."; 		
			  }
			  if(isset($mobile) && ($mobile!="") && !is_int($mobile)){
				$err_msg['PATIENT_ERR']['mobile'] = "Mobile can only be integer."; 		
			  }
			  if(isset($gender) && ($gender=="")){
				$err_msg['PATIENT_ERR']['gender'] = "Please select your gender."; 		
			  }
			  if(isset($age) && ($age=="")){
				$err_msg['PATIENT_ERR']['age'] = "Please enter age."; 		
			  }
			  if(isset($age) && ($age!="") && !is_int($age)){
				$err_msg['PATIENT_ERR']['age'] = "Age can only be integer."; 		
			  }
			  if(isset($email) && ($email=="")){
				$err_msg['PATIENT_ERR']['email'] = "Please enter email address."; 		
			  }
			  $email = test_input($_POST["email"]);
			  // check if e-mail address is well-formed
			  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$err_msg['PATIENT_ERR']['email'] = "Invalid email format."; 
			  }
			  if($email != $cemail)
			  {
				 $err_msg['PATIENT_ERR']['email'] = "Email and Confirm Email doesn't mached";
			  }
			  if(isset($password) && ($password=="")){
				$err_msg['PATIENT_ERR']['password'] = "Please enter password."; 		
			  }
			  if($pass_len < 6 || $pass_len > 10){
				$err_msg['PATIENT_ERR']['password'] = "Password length minimum 6 char and maximum 10."; 		
			  }
		}else{
			// Insert data into deal table	
			$addPatient = $patientObj->addPatient($_POST);
			  if($addPatient == true){
				$message['MESSAGE']['success'] = "Your Information has been registered in portal.";
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
		//alert(value);return false;
		var get = $(this).attr("id");
		
		if(value=='patient'){
			//alert(value);
			//$('#form_head').html("PATIENT");
			$('#doctor_frm').hide("fast");
			$('#patient_frm').show("fast");
		}else{
			//$('#form_head').html("DOCTOR");
			$('#doctor_frm').show("fast");
			$('#patient_frm').hide("fast");
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

    <div class="clr"></div>
    <div class="body body_bg">
      <div class="left">
        <h3><span>Welcome to</span> Patients Like me</h3>
       
        <div class="body-row">
        	<table border="0" cellpadding="0" cellspacing="0" width="225">
                <tbody>
                <tr>
                  <td width="22" height="33" align="left" valign="middle">
                    <input name="type_reg" id="doctor_radio" value="doctor" type="radio" checked="" />
                  </td>
                  <td height="33"  align="left" valign="middle" class="register-details">Doctor</td>
                  <td width="22" height="33" align="left" valign="middle">
                  <input name="type_reg" id="patient_radio" value="patient" type="radio" /></td>
                  <td height="33" align="left" valign="middle" class="register-details">Patient</td>
                </tr>
                <tr>
                    <td id="form_head" align="left" valign="middle"></td>
                  </tr>
              </tbody>
            </table>
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
            
          <div id="doctor_frm">
          	<div class="frm_head">Please register your information as Doctor.</div>
          	<form action="" method="POST">
                <table align="center">
                <tr>
                  <td width="120" align="left" valign="middle" class="register-details">User Image</td>
                   <td width="20" align="center" valign="middle" class="register-details">:</td>
                    <td><input type="file" name="profile_img" id="profile_img" class="textbox-air" style="border:none;" /></td>
                  </tr>
                    <tr>
                      <td width="120" align="left" valign="middle">&nbsp;</td>
                      <td width="20" align="center" valign="middle">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="120" align="left" valign="middle" class="register-details">Speciality</td>
                      <td width="20" align="center" valign="middle" class="register-details">:</td>
                      <td>
                      	<select id="disease" name="disease" style="width:354px;">
                        	<option value="">--Select Speciality--</option>
                            <?php
                            	foreach($diseases as $key => $disease){
							?>
                            <option value="<?php echo $disease['id']; ?>"><?php echo $disease['name']; ?></option>
                            <?php	
								}
							?>
                        </select>
                        <?php if(isset($err_msg['DOCTOR_ERR']['disease']) && (!empty($err_msg['DOCTOR_ERR']['disease']))){ ?> <div id="disease_err" class="error"> <?php echo $err_msg['DOCTOR_ERR']['disease'];?></div><?php }else{ echo ""; } ?>
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
                      <td><input type="text" name="fname" id="fname" class="textbox-air" style="width:350px;" value="<?php echo (isset($fname))?$fname:'';?>" /><?php if(isset($err_msg['DOCTOR_ERR']['fname']) && (!empty($err_msg['DOCTOR_ERR']['fname']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['DOCTOR_ERR']['fname'];?></div><?php }else{ echo ""; } ?>
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
                      <td><input type="text" name="lname" id="lname" class="textbox-air" style="width:350px;" value="<?php echo (isset($lname))?$lname:'';?>" /><?php if(isset($err_msg['DOCTOR_ERR']['lname']) && (!empty($err_msg['DOCTOR_ERR']['lname']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['DOCTOR_ERR']['lname'];?></div><?php }else{ echo ""; } ?>
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
                      <td><input type="integer" name="mobile" id="mobile" class="textbox-air" style="width:350px;" value="<?php echo (isset($mobile))?$mobile:'';?>" /><?php if(isset($err_msg['DOCTOR_ERR']['mobile']) && (!empty($err_msg['DOCTOR_ERR']['mobile']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['DOCTOR_ERR']['mobile'];?></div><?php }else{ echo ""; } ?>
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
                        <td><input type="email" name="email" id="email" class="textbox-air" style="width:350px;" value="<?php echo (isset($email))?$email:'';?>" /><?php if(isset($err_msg['DOCTOR_ERR']['email']) && (!empty($err_msg['DOCTOR_ERR']['email']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['DOCTOR_ERR']['email'];?></div><?php }else{ echo ""; } ?>
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
                        <td><input type="email" name="cemail" id="cemail" class="textbox-air" style="width:350px;" value="<?php echo (isset($cemail))?$cemail:'';?>"/><?php if(isset($err_msg['DOCTOR_ERR']['email']) && (!empty($err_msg['DOCTOR_ERR']['email']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['DOCTOR_ERR']['email'];?></div><?php }else{ echo ""; } ?>
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
                        <?php if(isset($err_msg['DOCTOR_ERR']['password']) && (!empty($err_msg['DOCTOR_ERR']['password']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['DOCTOR_ERR']['password'];?></div><?php }else{ echo ""; } ?>
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
                      <button type="submit" value="Create Account" name="doctor_submit">Create Account</button>
                    </td>
                  </tr><p><?php if (isset($msg)) {echo $msg;}  ?></p>
              </table>
            </form>  
          </div>
          <div id="patient_frm" style="display:none;">
          	<form action="" method="POST">
                <table align="center">
                <tr>
                  <td width="120" align="left" valign="middle" class="register-details">User Image</td>
                   <td width="20" align="center" valign="middle" class="register-details">:</td>
                    <td><input type="file" name="profile_img" id="profile_img" class="textbox-air" style="border:none;" /></td>
                  </tr>
                    <tr>
                      <td width="120" align="left" valign="middle">&nbsp;</td>
                      <td width="20" align="center" valign="middle">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                          <tr>
                            <td width="120" align="left" valign="middle" class="register-details">Disease</td>
                            <td width="20" align="center" valign="middle" class="register-details">:</td>
                            <td>
                               <select id="disease" name="disease" style="width:354px;">
                        	<option value="">--Select Disease--</option>
                            <?php
                            	foreach($diseases as $key => $disease){
							?>
                            <option value="<?php echo $disease['id']; ?>"><?php echo $disease['name']; ?></option>
                            <?php	
								}
							?>
                        </select>
                        <?php if(isset($err_msg['DOCTOR_ERR']['disease']) && (!empty($err_msg['DOCTOR_ERR']['disease']))){ ?> <div id="disease_err" class="error"> <?php echo $err_msg['DOCTOR_ERR']['disease'];?></div><?php }else{ echo ""; } ?>
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
                      <td><input type="text" name="fname" id="fname" class="textbox-air" style="width:350px;" value="<?php echo (isset($fname))?$fname:'';?>" /><?php if(isset($err_msg['PATIENT_ERR']['fname']) && (!empty($err_msg['PATIENT_ERR']['fname']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['PATIENT_ERR']['fname'];?></div><?php }else{ echo ""; } ?>
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
                      <td><input type="text" name="lname" id="lname" class="textbox-air" style="width:350px;" value="<?php echo (isset($lname))?$lname:'';?>" /><?php if(isset($err_msg['PATIENT_ERR']['lname']) && (!empty($err_msg['PATIENT_ERR']['lname']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['PATIENT_ERR']['lname'];?></div><?php }else{ echo ""; } ?>
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
                      <td><input type="integer" name="mobile" id="mobile" class="textbox-air" style="width:350px;" value="<?php echo (isset($mobile))?$mobile:'';?>" /><?php if(isset($err_msg['PATIENT_ERR']['mobile']) && (!empty($err_msg['PATIENT_ERR']['mobile']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['PATIENT_ERR']['mobile'];?></div><?php }else{ echo ""; } ?>
                      </td>
                    </tr>
                     <tr>
                      <td width="120" align="left" valign="middle">&nbsp;</td>
                      <td width="20" align="center" valign="middle">&nbsp;</td>
                      <td>&nbsp;</td>
                     </tr>
                      <tr>
                        <td width="120" align="left" valign="middle" class="register-details">Gender</td>
                        <td width="20" align="center" valign="middle" class="register-details">:</td>
                        <td>
						<select name="gender" id="gender" style="width:354px;">
                        	<option value="">--Select Gender--</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
						<?php if(isset($err_msg['PATIENT_ERR']['gender']) && (!empty($err_msg['PATIENT_ERR']['gender']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['PATIENT_ERR']['gender'];?></div><?php }else{ echo ""; } ?>
                        </td>
                      </tr>
                     <tr>
                      <td width="120" align="left" valign="middle">&nbsp;</td>
                      <td width="20" align="center" valign="middle">&nbsp;</td>
                      <td>&nbsp;</td>
                     </tr>
                      <tr>
                        <td width="120" align="left" valign="middle" class="register-details">Age</td>
                        <td width="20" align="center" valign="middle" class="register-details">:</td>
                        <td><input type="text" name="age" id="age" class="textbox-air" style="width:350px;" value="<?php echo (isset($age))?$age:'';?>" /><?php if(isset($err_msg['PATIENT_ERR']['age']) && (!empty($err_msg['PATIENT_ERR']['age']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['PATIENT_ERR']['age'];?></div><?php }else{ echo ""; } ?>
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
                        <td><input type="email" name="email" id="email" class="textbox-air" style="width:350px;" value="<?php echo (isset($email))?$email:'';?>" /><?php if(isset($err_msg['PATIENT_ERR']['email']) && (!empty($err_msg['PATIENT_ERR']['email']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['PATIENT_ERR']['email'];?></div><?php }else{ echo ""; } ?>
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
                        <td><input type="email" name="cemail" id="cemail" class="textbox-air" style="width:350px;" value="<?php echo (isset($cemail))?$cemail:'';?>"/><?php if(isset($err_msg['PATIENT_ERR']['email']) && (!empty($err_msg['PATIENT_ERR']['email']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['PATIENT_ERR']['email'];?></div><?php }else{ echo ""; } ?>
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
                        <?php if(isset($err_msg['PATIENT_ERR']['password']) && (!empty($err_msg['PATIENT_ERR']['password']))){ ?> <div id="name_err" class="error"> <?php echo $err_msg['PATIENT_ERR']['password'];?></div><?php }else{ echo ""; } ?>
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
                      <button type="submit" value="Create Account" name="patient_submit">Create Account</button>
                    </td>
                  </tr><p><?php if (isset($msg)) {echo $msg;}  ?></p>
              </table>
            </form>  
          </div>
        </div>
        
       
      </div>
      <?php include('includes/rightside.php'); ?>
      <div class="clr"></div>
    </div>
    <?php include('includes/footer.php'); ?>
  