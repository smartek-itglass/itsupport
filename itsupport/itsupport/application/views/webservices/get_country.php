<h1 align="center">get_country</h1>
<form method="post" action="<?php echo base_url()?>index.php/user/getCountries" enctype="multipart/form-data">
	<table align="center">
		<tr>
			<td>continent_id</td>
			<td><input type="text" name="continent_id" /></td>
		</tr>
		<tr>
			<td>page_no</td>
			<td><input type="text" name="page_no" /></td>
		</tr>
		<tr>
			<td>limit</td>
			<td><input type="text" name="limit" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" value="submit"/></td>
		</tr>
	</table>
</form>