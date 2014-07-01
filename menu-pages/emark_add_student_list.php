<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap/css/bootstrap.css', __FILE__); ?>' />
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>
<br/><br/>
<?php
global $wpdb;
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
<tr><th>Sr No</th><th>Roll No</th><th>Student Name</th><th>Father's Name</th><th>Mother's Name</th><th>Date Of Birth</th></tr>
<?php
$select_qury2 = "select * from `emarksheet_student` where `class_id`='$class_n'";
$select_data2 = $wpdb->get_results($select_qury2);
$i = 1;
if($select_data2)
{
	foreach($select_data2 as $select_data2)
	{
		echo "<tr><td>$i</td><td>".$select_data2->roll_no."</td><td>".$select_data2->first_n." ".$select_data2->last_n."</td><td>".$select_data2->father_n."</td><td>".$select_data2->mother_n."</td><td>".$select_data2->dob_date."-".$select_data2->dob_month."-".$select_data2->dob_year."</td></tr>";
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
}
?>

