<h1 align="center">user_login</h1>
<form method="post" action="<?php echo base_url()?>index.php/user/userLogin" enctype="multipart/form-data">
	<table align="center">
		<tr>
			<td>user</td>
			<td><input type="text" name="user"/></td>
		</tr>
		<tr>
			<td>password</td>
			<td><input type="text" name="password"/></td>
		</tr>
		<tr>
			<td>device_token</td>
			<td><input type="text" name="device_token"/></td>
		</tr>
		<tr>
			<td>device_type</td>
			<td><input type="text" name="device_type"/></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" value="submit"/></td>
		</tr>
	</table>
</form>