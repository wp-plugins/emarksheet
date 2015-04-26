<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap/css/bootstrap.css', __FILE__); ?>' />
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>
<br/><br/><div class='alert alert-info'>Enroll the students in the class</div>

<?php
global $wpdb;
$select_qury = "select * from `emarksheet_class`";
$select_data = $wpdb->get_results($select_qury);
if(isset($_POST['enroll']))
{
	$class = $_POST['class_n'];
	$roll_n = $_POST['roll_number'];
	$first_n = $_POST['first_n'];
	$last_n = $_POST['last_n'];
	$father_n = $_POST['f_name'];
	$mother_n = $_POST['m_name'];
	$dob_date = $_POST['dob_date'];
	$dob_m= $_POST['dob_month'];
	$dob_y = $_POST['dob_year'];
	$insert_query="insert into `emarksheet_student`(`id`,`class_id`,`roll_no`,`first_n`,`last_n`,`father_n`,`mother_n`,`dob_date` ,`dob_month`,`dob_year`) values('','$class','$roll_n','$first_n','$last_n','$father_n','$mother_n','$dob_date','$dob_m','$dob_y')";
	$wpdb->query($insert_query);
	echo "<div class='alert alert-success'>New Student Enrolled Successfully !!!</div>";
}
?>
<form method="post" action="#">
<table class="responsive display table table-bordered">
<tr><td> Select Class : </td><td>
<select name="class_n">
<?php
	foreach($select_data as $select_data)
	{
		echo "<option value='$select_data->id'>$select_data->class_name </option>";
	}
?>
</select>
</td></tr>
<tr><td> Roll No : </td><td><input type="text" name="roll_number" placeholder="Roll Number" /></td>
</tr>
<tr><td> Name : </td><td><input type="text" name="first_n" placeholder="First Name" / >&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="last_n" placeholder="Last Name" /></td></tr>
<tr><td> Father's Name : </td><td><input type="text" name="f_name" placeholder="Father's Name" /></td>
</tr>
<tr><td> Mother's Name : </td><td><input type="text" name="m_name" placeholder="Mother's Name" /></td>
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
<input type="text" style="width:100px;" name="dob_year" placeholder="YEAR" />
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td><button type="submit" class="btn btn-info" name="enroll">Enroll Student !!!</button></td>
</tr>
</table>
</form>
