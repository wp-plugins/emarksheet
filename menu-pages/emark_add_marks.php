<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap/css/bootstrap.css', __FILE__); ?>' />
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>
<br/><br/>
<?php
global $wpdb;
if(isset($_GET['action']))
{
	$id = $_GET['id'];
	$selectd_query = "select * from `emarksheet_student` where `id`='$id'";
	$selectd_row =  $wpdb->get_results($selectd_query);
	$su_n = $selectd_row[0]->class_id;

	$selectd_query1 = "select * from `emarksheet_subject` where `class`='$su_n'";
	$selectd_row1 =  $wpdb->get_results($selectd_query1);
	?>
	<form action='<?php echo admin_url("admin.php?page=eMarksheet-add-marks&action_new=add_marks_final&class_id=$su_n"); ?>' method='post'>
	<input type='hidden' name='st_id' value="<?php echo $id; ?>">
	<table class="responsive display table table-bordered" style="width:80%;">
	<tr><th>Sr No</th><th>Subject Name</th><th>Total Marks</th><th>Minimum Passing Marks</th><th>Marks Obtained</th></tr>
	<?php
	$i=1;
	foreach($selectd_row1 as $selectd_row1)
	{
		echo "<tr><td>".$i."</td><td>".ucfirst($selectd_row1->sub_name)."</td><td><input type='text' name='tm_".$i."' value='".$selectd_row1->total_marks."' readonly='readonly' style='width:60px;' ></td><td><input type='text' name='mm_".$i."' value='".$selectd_row1->min_pass."' readonly='readonly' style='width:60px;' ></td><td> <input type='text' name='om_".$i."' style='width:60px;'/></td></tr>";
	$i++;
	}
	?>
	<tr><td colspan='5'><center><button type="submit" class='btn btn-info'>Add Marks Now !!!</button></center></td>
	</table>
	<?php
}
elseif(isset($_POST['get_st_lt']) || isset($_GET['action_new']))
{
	if(isset($_POST['get_st_lt']))	
		$class_n = $_POST['class_n'];
	else{
		$class_n = $_GET['class_id'];
		$student_id = $_POST['st_id'];
		$data = serialize($_POST);
		$gt_old = "select * from `emarksheet_marks` where `student_id`='$student_id' AND `class_id`='$class_n'";
		$gt_old = $wpdb->get_results($gt_old);
		if($gt_old)
		{
			$mk_id = $gt_old[0]->id;
			$upds = "update `emarksheet_marks` set `marks`='$data' where `id`='$mk_id'";
			$wpdb->query($upds);
			//echo $wpdb->last_error;
			echo "<div class='alert alert-success'> Marks Updated Successfully !!! </div>";
		}
		else
		{
			$insert_st = "insert into `emarksheet_marks`(`id`,`student_id`,`class_id`,`marks`) values('','$student_id','$class_n','$data')";
			$wpdb->query($insert_st);
			echo "<div class='alert alert-success'> Marks Added Successfully !!! </div>";
		}
	}
	$select_qury1 = "select * from `emarksheet_class` where `id`='$class_n'";
	$select_data1 = $wpdb->get_results($select_qury1);
	$class_name = $select_data1[0]->class_name;	
?>
<div class='alert alert-info'>
List of Students for <span class='alert-error'><?php echo $class_name; ?></span>
<a class="btn btn-mini btn-danger" style="float:right;" href="<?php echo admin_url("admin.php?page=eMarksheet-add-marks"); ?>" > Go Back !!!</a></div>
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
		echo "<tr><td>$i</td><td>".$select_data2->roll_no."</td><td>".$select_data2->first_n." ".$select_data2->last_n."</td><td>".$select_data2->father_n."</td><td>".$select_data2->mother_n."</td><td>".$select_data2->dob_date."-".$select_data2->dob_month."-".$select_data2->dob_year."</td><td><a href='".admin_url("admin.php?page=eMarksheet-add-marks&action=add_marks&id=$select_data2->id")."' class='btn btn-danger'><i class='icon-white icon-plus'></i> &nbsp;&nbsp; Add Marks</a></td></tr>";
	$i++;
	}
}
else
{
	echo "<tr><td colspan='7' class='alert alert-error'><center> Sorry !! You have not added any student yet</center></td></tr>";
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

