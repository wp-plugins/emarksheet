<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap/css/bootstrap.css', __FILE__); ?>' />
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>
<script type="text/javascript">
function show_confirm() {
    return confirm("Do You Really Want to delete the Entry ? ");
}
</script>
<br/><br/>
<?php
global $wpdb;
if(isset($_POST['update_name']))
{
	$up_id = $_POST['up_id'];
	$class = $_POST['class_nm'];
	$roll_n = $_POST['roll_number'];
	$first_n = $_POST['first_n'];
	$last_n = $_POST['last_n'];
	$father_n = $_POST['f_name'];
	$mother_n = $_POST['m_name'];
	$dob_date = $_POST['dob_date'];
	$dob_m= $_POST['dob_month'];
	$dob_y = $_POST['dob_year'];
	$update_query = "update `emarksheet_student` set `class_id`='$class',
	`roll_no`='$roll_n',`first_n`='$first_n',`last_n`='$last_n',`father_n`='$father_n',`mother_n`='$mother_n',
	`dob_date`='$dob_date',`dob_month`='$dob_m',`dob_year`='$dob_y' where `id`='$up_id'";
	$wpdb->query($update_query);
	echo "<div class='alert alert-success'>Student Name Updated Successfully</div>";
	echo "<script>setTimeout(location.href='".admin_url("admin.php?page=eMarksheet-student-list")."',6000)</script>";
}

if($_GET['action']=='delete')
{
	$iddelt = $_GET['id'];
	$delete_query = "delete from `emarksheet_student` where `id`='$iddelt'";
	$wpdb->query($delete_query);
	echo "<div class='alert alert-success'>Student Name Deleted Successfully</div>";
	echo "<script>setTimeout(location.href='".admin_url("admin.php?page=eMarksheet-student-list")."',6000)</script>";
}
if($_GET['action']=='update')
{
	$idd = $_GET['id'];
	$selectd_query = "select * from `emarksheet_student` where `id`='$idd'";
	$selectd_row =  $wpdb->get_results($selectd_query);
	$class_ida = $selectd_row[0]->class_id;
	$rollno = $selectd_row[0]->roll_no;
	$f_n = $selectd_row[0]->first_n;
	$l_n = $selectd_row[0]->last_n;
	$father_name = $selectd_row[0]->father_n;
	$mother_name = $selectd_row[0]->mother_n;
	$dob_d = $selectd_row[0]->dob_date;
	$dob_m = $selectd_row[0]->dob_month;
	$dob_y = $selectd_row[0]->dob_year;
	$select_dd = "select * from `emarksheet_class`";
	$select_data =  $wpdb->get_results($select_dd);
	?>
	<form method="post" action="#">
<table class="responsive display table table-bordered">
<input type="hidden" name="up_id" value="<?php echo $idd;?>">
<tr><td> Select Class : </td><td>
 <select name="class_nm" style='width:100px;'>
	<?php
	foreach($select_data as $select_data)
	{
		if($select_data->id == $class_ida)
			echo "<option value='$select_data->id' selected='selected'>$select_data->class_name </option>";
		else
			echo "<option value='$select_data->id'>$select_data->sem </option>";
	}
	?>
	</select>
</td></tr>
<tr><td> Roll No : </td><td><input type="text" name="roll_number" placeholder="Roll Number" value = "<?php echo $rollno; ?>"/></td>
</tr>
<tr><td> Name : </td><td><input type="text" name="first_n" placeholder="First Name" value = "<?php echo $f_n; ?>"/ >&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="last_n" placeholder="Last Name" value = "<?php echo $l_n; ?>"/></td></tr>
<tr><td> Father's Name : </td><td><input type="text" name="f_name" placeholder="Father's Name" value ="<?php echo $father_name; ?>" /></td>
</tr>
<tr><td> Mother's Name : </td><td><input type="text" name="m_name" placeholder="Mother's Name" value ="<?php echo $mother_name; ?>" /></td>
</tr>
<tr><td> Date Of Birth : </td><td>
<select name="dob_date" style="width:80px;">
<option>Date</option>
<option value="1">01</option>
<option value="2">02</option>
<option value="3">03</option>
<option value="4">04</option>
<option value="5">05</option>
<option value="6">06</option>
<option value="7">07</option>
<option value="8">08</option>
<option value="9">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>
&nbsp;&nbsp;
<select name="dob_month" style="width:80px;">
<option>Month</option>
<option value="1">01</option>
<option value="2">02</option>
<option value="3">03</option>
<option value="4">04</option>
<option value="5">05</option>
<option value="6">06</option>
<option value="7">07</option>
<option value="8">08</option>
<option value="9">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select>
&nbsp;&nbsp;
<input type="text" style="width:100px;" name="dob_year" placeholder="YEAR" value ="<?php echo $dob_y; ?>"/>
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td><button type="submit" class="btn btn-info" name="update_name">Enroll Student !!!</button></td>
</tr>
</table>
</form>
	</form>
	</div>
	<?php
}
else{

if(isset($_POST['get_st_lt']))
{
	$class_n = $_POST['class_n'];
	$select_qury1 = "select * from `emarksheet_class` where `id`='$class_n'";
	$select_data1 = $wpdb->get_results($select_qury1);
	$class_name = $select_data1[0]->class_name;	
?>
<div class='alert alert-info'>
List of Students for <span class='alert-error'><?php echo $class_name; ?></span>
<a class="btn btn-mini btn-danger" style="float:right;" href="<?php echo admin_url("admin.php?page=eMarksheet-student-list"); ?>" > Go Back !!!</a></div>
<table class="responsive display table table-bordered">
<tr><th>Sr No</th><th>Roll No</th><th>Student Name</th><th>Father's Name</th><th>Mother's Name</th><th>Date Of Birth</th><th>Action</th></tr>
<?php
$select_qury2 = "select * from `emarksheet_student` where `class_id`='$class_n'";
$select_data2 = $wpdb->get_results($select_qury2);
$i = 1;
if($select_data2)
{
	foreach($select_data2 as $select_data2)
	{
		echo "<tr><td>$i</td><td>".$select_data2->roll_no."</td><td>".$select_data2->first_n." ".$select_data2->last_n."</td><td>".$select_data2->father_n."</td><td>".$select_data2->mother_n."</td><td>".$select_data2->dob_date."-".$select_data2->dob_month."-".$select_data2->dob_year."</td><td> &nbsp;&nbsp;&nbsp;&nbsp;<a href='".admin_url("admin.php?page=eMarksheet-student-list&action=update&id=$select_data2->id")."' rel='tooltip' title='update' class='update'><i class='icon-pencil'></i></a> &nbsp;&nbsp; <a href='".admin_url("admin.php?page=eMarksheet-student-list&action=delete&id=$select_data2->id")."' onclick='return show_confirm();' rel='tooltip' title='Delete' class='delete'><i class='icon-trash'></i></a></td></tr>";
	$i++;
	}
}
else
{
	echo "<tr><td colspan='6' class='alert alert-error'><center> Sorry !! You have not added any student yet</center></td></tr>";
}
?>
</table>
<?php
}
else{
?>
<div class="alert alert-info">
See the list of Enrolled Students for each Class. First Select the class :
<?php
$select_qury = "select * from `emarksheet_class`";
$select_data = $wpdb->get_results($select_qury);
?>
<form method="post" action="#">
<select name="class_n">
<?php
	foreach($select_data as $select_data)
	{
		echo "<option value='$select_data->id'>$select_data->class_name </option>";
	}
?>
</select> &nbsp;&nbsp;&nbsp; 
<button type="submit" name="get_st_lt" class="btn btn-info">Get Student List !!!</button>
</form>
</div>
<hr/>
<?php
}}
?>

