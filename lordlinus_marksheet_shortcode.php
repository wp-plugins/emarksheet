<script src="<?php echo plugins_url('/datepicker-assets/js/jquery.ui.datepicker.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>
<style>
.alert_lor {
  padding: 8px 35px 8px 14px;
  margin-bottom: 20px;
  color: #c09853;
  text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
  background-color: #fcf8e3;
  border: 1px solid #fbeed5;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}
.alert-error-lord {
  color: #b94a48;
  background-color: #f2dede;
  border-color: #eed3d7;
}
</style>
<?php
global $wpdb;
if(isset($_POST['roll_no']))
{
	$class_n = $_POST['class_n'];
	$roll_n = $_POST['roll_no'];
	$select_st = "select * from `emarksheet_student` where `roll_no`='$roll_n' AND `class_id`='$class_n'";
	$select_st = $wpdb->get_results($select_st);
	if(isset($select_st[0]))
	{
		$sett = "select * from `emarksheet_setting`";
		$get_s = $wpdb->get_results($sett);
	
		$sid = $select_st[0]->id;
		$get_m = "select * from `emarksheet_marks` where `student_id` = '$sid'";
		$get_st_l = $wpdb->get_results($get_m);
		$gee_cl = $get_st_l[0]->class_id;

		$marks = $get_st_l[0]->marks;
		$marks = unserialize($marks);
		unset($marks['st_id']);
		$count = count($marks)/2;

		$select_qury5 = "select * from `emarksheet_student` where `id`='$sid'";
		$select_data5 = $wpdb->get_results($select_qury5);

		$get_class_l = "select * from `emarksheet_subject` where `class` = '$gee_cl'";
		$get_cl_l = $wpdb->get_results($get_class_l);

		$get_class_li = "select * from `emarksheet_class` where `id` = '$gee_cl'";
		$get_cl_li = $wpdb->get_results($get_class_li);
	
		echo "<div class='print' id='print'><center><h1>".$get_s[0]->school_name."</h1></center><center><div style='font-size:18px;'>".$get_s[0]->address." , ".$get_s[0]->district." ( ". $get_s[0]->state ." ) "."<br/><br/>PROGRESS REPORT</div></center><br/><br/>";
		echo "<table class='table' border='1'style='width:100%;' >";
		echo "<tr><td><strong>Name of the student : </strong></td> <td>".$select_data5[0]->first_n." ".$select_data5[0]->last_n."</td> <td><strong>Date Of Birth</strong></td> <td>".$select_data5[0]->dob_date."/".$select_data5[0]->dob_month."/".$select_data5[0]->dob_year."</td></tr>";
		echo "<tr><td><strong>Father's Name  </strong><td>".$select_data5[0]->father_n."</td><td><strong> Mother's Name : </strong> </td><td>".$select_data5[0]->mother_n."</td></tr>";
		echo "<tr><td><strong>Class : </strong><td> ".$get_cl_li[0]->class_name."</td><td><strong> Roll No </strong>: </td><td>".$select_data5[0]->roll_no."</td></tr>";
		echo "</table>";
		$j = 1;
		echo "<table class='responsive display table table-bordered'style='width:100%;' border='1'>";
		echo "<tr><th>Subject</th><th>Total Marks</th><th>Obtained Marks</th></tr>";
		$tm_total = 0;
		$om_total = 0;
		foreach($get_cl_l as $get_cl_l)
		{
			$tm = 'tm_'.$j;
			$om = 'om_'.$j;
			echo "<tr><td> $j . ".$get_cl_l->sub_name."</td><td>".$marks[$tm]."</td><td>".$marks[$om]."</td></tr>";
			$tm_total = $tm_total+$marks[$tm];
			$om_total = $om_total+$marks[$om];
			$j++;
		}
		echo "<tr><th>Total</th><th>$tm_total</th><th>$om_total</th></tr>";
		echo "</table>";
		echo "<h4><center>Results</center></h4>";
		$per = $om_total/$tm_total*100;
		$per = round($per,2);
		if($per>=60 && $per<=100)
			$div = "First Division";
		elseif($per<=60 && $per>=50)
			$div = "Second Division";
		elseif($per<=50 && $per>=33)
			$div = "Third Division";
		else
			$div = "Fail";
		echo "<table class='table' border='1' style='width:100%;'><tr><td>Percentage : </td><td> $per %</td><td>Final Result : </td><td> $div </td></table>";
		echo "</div>";
	}
	else
	{
		echo "<div class='alert_lor alert-error-lord'>Sorry !!! Roll No does not exists .... </div>";
	}
}
else
{
	$select_qury = "select * from `emarksheet_class`";
	$select_data = $wpdb->get_results($select_qury);
	?>
	<form method="post" action="#">
	Select the Class :
	<select name="class_n">
	<?php
		foreach($select_data as $select_data)
		{
			echo "<option value='$select_data->id'>$select_data->class_name </option>";
		}
	?>
	</select> <br/><br/>
	Enter Roll Number : <input type='text' name='roll_no' id='roll_no' style='width:156px;'><br/> <br/>
	<button type="submit" name="get_rslt" id='get_rslt' class="btn btn-info">Get Result !!!</button>
	</form>
<?php
}
?>
