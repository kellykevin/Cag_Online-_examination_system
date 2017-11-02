<html>
<CENTER><h2>ONLINE EXAMINATION SYSTEM</h2></CENTER>
<CENTER><span>SIGNUP</span></CENTER>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script language="javascript">

$(document).ready(function(){

	$('#cancel').click(function(){
		//$('#users').load('index.php?');
		$('#user_add').action="index.php?"
		$('#user_add').submit();
	})
	$('#save').click(function(){
		var error ="Please fill up the requirement below \r\n----------------------------------------\r\n";
		var msg = error;
		if( $('#fname').val() == '' ){
			msg += '*First name \r\n';
		}
		if( $('#lname').val() == '' ){
			msg += '*Last name \r\n';
		}
		if( $('#user_name').val() == '' ){
			msg += '*user name \r\n';
		}
		if( $('#password').val() == '' ){
			msg += '*Password \r\n';
		}
		if( $('#dept_id').val() == '' ){
			msg += '*Department name \r\n';
		}
		if (msg == error){
			
			$.post('index.php?admin/signupadd',$("#user_add").serialize(),function(data){
				if ( parseInt(data) == 0 ) {
					alert('Your Registration is Success');
					$('#user_add').submit();
				}else{
					alert('Username is Already Exist');
				}

				//alert(data);
				//$('#user_add').submit();
			});	
			
		}else{
			alert(msg);	
		}
		
		
	});
});
</script>
<style>
.mcstyle{
	font-family: 'Lucida Grande',Helvetica,Arial,Verdana,sans-serif; font-size: 0.8em; color: #535353!important;

}
h2{
    	font-family:calibri;
    }
input[type="text"]{
width:20%;
height:30px;
padding:10px;
	}
input[type="password"]{
width:20%;
height:30px;
padding:10px;
	}
	input[type="submit"]{
background-color:#333;
color:white;	
border:none;
padding:5px;
    }
    input[type="text"]:focus{
    	outline-color:purple;
    }
    input[type="password"]:focus{
    	outline-color:purple;
    }
    a {
    	font-family: calibri;
    	color:black;
    }
    form{
    	margin-top:5%;
    	background-color:whitesmoke;
    }
    body{
    	background-color:whitesmoke;
    }
    select{
    	width:20%;
height:30px;
padding:10px;
    }input[type="button"]{
    	background-color:#333;
color:white;	
border:none;
padding:5px;
    }
</style>
<div id="users" class="users">
	<div class="user_add_data">
	<center>
	<form name="user_add" id="user_add" method="post" action="index.php?">
			
			 <input type="text" id="fname" name="fname" class="user_input" placeholder="Firstname"> <br><br>
				
			 <input type="text" id="lname" name="lname" class="user_input" placeholder="Lastname"> <br><br>
		
			 <input type="text" id="user_name" name="user_name" class="user_input" placeholder="Username"> <br><br>
		
			 <input type="password" id="password" name="password" class="user_input" placeholder="Password"> <br><br>
			 <td width="">
				<span style="color:red;"><b> * Chooce a department below * </b></span>
			</td>
					<br><br>
			<select id="dept_id" name="dept_id">
				<option value=""> </option>
				<?php
				if (is_array($data['department'])){
					foreach($data['department'] as $row){
				?>
				<option value="<?php echo $row['department_id']; ?>"> <?php echo $row['department_name'];?> </option>
				<?php
						}
					}
				?>
			</select>
			
			
			
		</tr>
		<tr>
		<br>
			<td> </td>
			<td> 
			<br>
			<input type="button" id="save" class="e_button" value="Save"><br><br><input type="button" id="cancel" class="e_button" value="Cancel"></td>
			<td> </td>
		</tr>
		
	</form>
	</center>
	</div>
</div>
</html>