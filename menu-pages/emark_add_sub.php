<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap/css/bootstrap.css', __FILE__); ?>' />
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>

<div class='span12' style='margin-top:20px;'>
<?php
global $wpdb;
$select_qury = "select * from `emarksheet_class`";
$select_data = $wpdb->get_results($select_qury);

$select_quiz = "select * from `emarksheet_subject`";
$select_data_quiz = $wpdb->get_results($select_quiz);
if(isset($_POST['add_quiz']))
{
	$quiz_n = $_POST['qz_n'];
	$sub_id = $_POST['sub_nm'];
	$tot_m = $_POST['tot_m'];
	$min_pass = $_POST['min_pass'];
	$insert_queryr = "insert into `emarksheet_subject`(`id`,`class`,`sub_name`,`min_pass`,`total_marks`) values('','$sub_id','$quiz_n','$min_pass','$tot_m')";
	$wpdb->query($insert_queryr);
	echo "<div class='alert alert-success'>Subject Name Added Successfully</div>";
}

if(isset($_POST['update_name']))
{
	$up_su_n = $_POST['up_su_n'];
	$up_su_id = $_POST['up_id'];
	$up_su_ss = $_POST['sub_nm'];
	$up_su_tm = $_POST['tot_m'];
	$up_su_mp = $_POST['min_pass'];
	$update_query = "update `emarksheet_subject` set `sub_name`='$up_su_n',`class`='$up_su_ss',`total_marks`='$up_su_tm',`min_pass`='$up_su_mp' where `id`='$up_su_id'";
	$wpdb->query($update_query);
	echo "<div class='alert alert-success'>Subject Name Updated Successfully</div>";
	echo "<script>setTimeout(location.href='".admin_url("admin.php?page=eMarksheet-subject")."',6000)</script>";
}

if($_GET['action']=='delete')
{
	$iddelt = $_GET['id'];
	$delete_query = "delete from `emarksheet_subject` where `id`='$iddelt'";
	$wpdb->query($delete_query);
	echo "<div class='alert alert-success'>subject Name Deleted Successfully</div>";
	echo "<script>setTimeout(location.href='".admin_url("admin.php?page=eMarksheet-subject")."',6000)</script>";
}
?>
<script type="text/javascript">
function show_confirm() {
    return confirm("Do You Really Want to delete the Entry ? ");
}
</script>

<?php 

if($_GET['action']=='update')
{
	$idd = $_GET['id'];
	$selectd_query = "select * from `emarksheet_subject` where `id`='$idd'";
	$selectd_row =  $wpdb->get_results($selectd_query);
	$su_n = $selectd_row[0]->sub_name;
	$sub_id = $selectd_row[0]->class;
	$tot_mar = $selectd_row[0]->total_marks;
	$min_pass = $selectd_row[0]->min_pass;
	?>
	<div class="alert alert-success" style="margin-top:40px;">
	<center><strong>Edit Your Subject</strong></center>
	<form action="<?php echo admin_url("admin.php?page=eMarksheet-subject") ?>" method="post">
	<input type="hidden" name="up_id" value="<?php echo $idd;?>">
	Select Subject Name : <select name="sub_nm" style='width:100px;'>
	<?php
	foreach($select_data as $select_data)
	{
		if($select_data->id == $sub_id)
			echo "<option value='$select_data->id' selected='selected'>$select_data->class_name </option>";
		else
			echo "<option value='$select_data->id'>$select_data->class_name</option>";
	}
	?>
	</select> &nbsp;&nbsp;&nbsp;&nbsp;
	Name of the Subject : <input type="text" value="<?php echo $su_n;?>" name="up_su_n" style='width:150px;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Total Marks : <input type="text" value="<?php echo $tot_mar; ?>" name="tot_m" style='width:50px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Minimum Passing Marks : <input type="text" value="<?php echo $min_pass; ?>" name="min_pass">
	<input class="btn" name="update_name" type="submit" value="Update Subject">
	</form>
	</div>
	<?php
}
?>

<?php
if($select_data)
{
	?>
	<div class="alert alert-info" style="height:70px;">
	<form action="" method="post">
	Class Name : <select name="sub_nm" style='width:100px;'>
	<?php
	foreach($select_data as $select_data)
	{
		echo "<option value='$select_data->id'>$select_data->class_name </option>";
	}
	?>
	</select> &nbsp;&nbsp;&nbsp;&nbsp;
	Subject Name : <input type="text" name="qz_n" style='width:150px;'> &nbsp;&nbsp;&nbsp;&nbsp;
	Total Marks : <input type='text' name='tot_m' style='width:50px;'> &nbsp;&nbsp;&nbsp;&nbsp;
	Minimum Passing Marks : <input type="text" name="min_pass" style="width:50px;">&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" class="btn" value="Add Subject" name="add_quiz">
	<?php
}
else
{
	echo "<div class='alert alert-error'>You have not added any Class yet. First Add Class </div>";
}
?>
</div>
<div class="alert alert-success"><center><strong>List of Subjects Added By you</strong></center></div>
<table class="responsive display table table-bordered">
<tr>
<th>Sr No</th><th>Class Name</th><th>Name of Subject</th><th>Total Marks</th><th>Minimum Passing Marks</th><th>Action</th>
</tr>
<?php
if($select_data_quiz)
{
	$i = 1;
	foreach($select_data_quiz as $select_data_quiz)
	{
		$select_sub = "select * from `emarksheet_class` where `id`='$select_data_quiz->class'";
		$select_sub_quiz = $wpdb->get_results($select_sub);
		echo "<tr><td>$i</td><td>".ucfirst($select_sub_quiz[0]->class_name)."</td><td>".ucfirst($select_data_quiz->sub_name)."</td><td>".$select_data_quiz->total_marks."</td><td>".$select_data_quiz->min_pass."</td><td> &nbsp;&nbsp;&nbsp;&nbsp;<a href='".admin_url("admin.php?page=eMarksheet-subject&action=update&id=$select_data_quiz->id")."' rel='tooltip' title='update' class='update'><i class='icon-pencil'></i></a> &nbsp;&nbsp; <a href='".admin_url("admin.php?page=eMarksheet-subject&action=delete&id=$select_data_quiz->id")."' onclick='return show_confirm();' rel='tooltip' title='Delete' class='delete'><i class='icon-trash'></i></a></td></tr>";
		$i++;
	}
}
else
{
	echo "<tr><td colspan='5' class='alert alert-error'><center><strong>You have not added any Subject yet</strong></center></td></tr>";
}
?>
</table>
</div>
