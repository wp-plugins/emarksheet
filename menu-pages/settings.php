<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap/css/bootstrap.css', __FILE__); ?>' />
<script type="text/javascript"   src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>"></script>
<br/><br/>
<?php
global $wpdb;
if(isset($_POST['save']))
{
	$name_sc = $_POST['sch_name'];
	$address = $_POST['address'];
	$district = $_POST['district'];
	$state = $_POST['state'];
	$phone_n  = $_POST['phone_n'];
	$principal = $_POST['principle'];
	$insert_q = "insert into `emarksheet_setting`(`id`,`school_name`,`address`,`district`,`state`,`phone`,`name_of_principal`) values('','$name_sc','$address','$district','$state','$phone_n','$principal')";
	$wpdb->query($insert_q);
	echo "<div class='alert alert-success'>Settins Saved Successfully !!! </div>";
}
$select = "select * from `emarksheet_setting`";
$get_r = $wpdb->get_results($select);
?>
<form method="post" action="#">
<table class="responsive display table table-bordered">
<tr><td>Name of The School</td><td><input type="text" name="sch_name" placeholder="Name of the school" value="<?php if(isset($get_r[0])) echo $get_r[0]->school_name ; ?>"></td></tr>
<tr><td>Address for School</td><td>
<textarea name="address" placeholder="Address for the school"><?php if(isset($get_r[0])) echo $get_r[0]->address ; ?> </textarea></td></tr>
<tr><td>District</td><td><input type="text" name="district" placeholder="District"  value="<?php if(isset($get_r[0])) echo $get_r[0]->district ; ?>"></td></tr>
<tr><td>State</td><td><input type="text" name="state" placeholder="State"  value="<?php if(isset($get_r[0])) echo $get_r[0]->state ; ?>"></td></tr>
<tr><td>Phone No</td><td><input type="text" name="phone_n" placeholder="Phone Number"  value="<?php if(isset($get_r[0])) echo $get_r[0]->phone ; ?>"></td></tr>
<tr><td>Name of the Principal</td><td><input type="text" name="principle" placeholder="Name of the Principal"  value="<?php if(isset($get_r[0])) echo $get_r[0]->name_of_principal; ?>" /></td></tr>
<tr><td></td><td><button type="submit" class="btn btn-info" name='save'>Save Settings !!! </button>
</table>
</form>
