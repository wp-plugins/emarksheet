<script src="<?php echo plugins_url('/datepicker-assets/js/jquery.ui.datepicker.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>
<style>
#print {
        width: 21.6cm;
        padding: 2cm;
        margin: 1cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
</style>
<script>
function print_this()
{
	   var divToPrint = document.getElementById('print');
	   var popupWin = window.open('', '_blank', 'width=800,height=600');
	   popupWin.document.open();
	   popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
	   popupWin.document.close();
}
</script>
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
		echo "<tr><th>Subject</th><th>Total Marks</th><th>Min Pass Marks</th><th>Obtained Marks</th><th>Remark</tr>";
		$tm_total = 0;
		$om_total = 0;
		$mm_total = 0;
		foreach($get_cl_l as $get_cl_l)
		{
			$tm = 'tm_'.$j;
			$om = 'om_'.$j;
			$mm = 'mm_'.$j;
			//echo $marks[$mm]." ".$marks[$om];
			if($marks[$mm] > $marks[$om])
			{
				$fails = '1';
				$fail2 = '1';
			}
			else
			{
				$fails = '0';
			}
			echo "<tr><td> $j . ".$get_cl_l->sub_name."</td><td>".$marks[$tm]."</td><td>".$marks[$mm]."</td><td>".$marks[$om]."</td><td>";
			if($fails == '1'){ echo "Fail"; }
			echo "</td></tr>";
			$tm_total = $tm_total+$marks[$tm];
			$om_total = $om_total+$marks[$om];
			$mm_total = $mm_total+$marks[$mm];
			$j++;
		}
		echo "<tr><th>Total</th><th>$tm_total</th><th>$mm_total</th><th>$om_total</th><th>";
		if($fail2 == '1'){echo "Fail"; }
		echo "</th></tr>";
		echo "</table>";
		echo "<h4><center>Results</center></h4>";
if($tm_total != '0')
		{
			$per = $om_total/$tm_total*100;
			$per = round($per,2);

			$req_per = $mm_total/$tm_total*100;
			$req_per = round($req_per,2);
			if($fail2 == '1')
				$div = "Fail";
			elseif($per>=60 && $per<=100)
				$div = "First Division";
			elseif($per<=60 && $per>=50)
				$div = "Second Division";
			elseif($per<=50 && $per>=$req_per)
				$div = "Third Division";
			else
				$div = "Fail";
			echo "<table class='table' border='1' style='width:100%;'><tr><th>Percentage : </th><td> $per %</td><th>Minimum Passing Percentage : </th><td> $req_per % </td><th>Final Result : </th><td> $div </td></table>";
			echo "</div>";
		
?>
<input type="button" class="btn btn-info" value="Print This Marksheet !!!" onclick="print_this();">
<?php
}
		else
		{
			echo "<div class='alert_lor alert-error-lord'>Please Add Marks to the subjects </div>";
		}
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
