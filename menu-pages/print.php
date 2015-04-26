<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap/css/bootstrap.css', __FILE__); ?>' />
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
<br/><br/>
<?php
global $wpdb;
if(isset($_GET['action']))
{
	$sett = "select * from `emarksheet_setting`";
	$get_s = $wpdb->get_results($sett);
	
	$sid = $_GET['id'];
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
			echo "<div class='alert alert-error'>Please Add Marks to the subjects </div>";
		}
}
else if(isset($_POST['get_st_lt']))
{
	$class_n = $_POST['class_n'];
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
		echo "<tr><td>$i</td><td>".$select_data2->roll_no."</td><td>".$select_data2->first_n." ".$select_data2->last_n."</td><td>".$select_data2->father_n."</td><td>".$select_data2->mother_n."</td><td>".$select_data2->dob_date."-".$select_data2->dob_month."-".$select_data2->dob_year."</td><td><a href='".admin_url("admin.php?page=eMarksheet-print&action=get_marks&id=$select_data2->id")."' class='btn btn-danger'><i class='icon-white icon-document'></i> &nbsp;&nbsp; See Marksheet</a></td></tr>";
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
To Print the marksheet of the student, Please First Select the class :
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
<button type="submit" name="get_st_lt" class="btn btn-info">Get Student List to print marksheet !!!</button>
</form>
</div>
<hr/>
<?php
}
?>

