<h1 align="center">emergency_notification</h1>
<form method="post" action="<?php echo base_url()?>index.php/user/emergencyNotification" enctype="multipart/form-data">
	<table align="center">
		<tr>
			<td>location</td>
			<td><input type="text" name="location" /></td>
		</tr>
		<tr>
			<td>software_name</td>
			<td><input type="text" name="software_name" /></td>
		</tr>
		<tr>
			<td>subject</td>
			<td><input type="text" name="subject" /></td>
		</tr>
		<tr>
			<td>date</td>
			<td><input type="text" name="date" /></td>
		</tr>
		<tr>
			<td>picture</td>
			<td><input type="file" name="picture" /></td>
		</tr>
		<tr>
			<td>note</td>
			<td><textarea name="note"></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" value="submit"/></td>
		</tr>
	</table>
</form>