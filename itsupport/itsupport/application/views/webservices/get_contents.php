<h1 align="center">get_contents</h1>
<form method="post" action="<?php echo base_url()?>index.php/user/getContent" enctype="multipart/form-data">
	<table align="center">
		<tr>
			<td>category_id</td>
			<td><input type="text" name="category_id" /></td>
		</tr>
		<tr>
			<td>title_id</td>
			<td><input type="text" name="title_id" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" value="submit"/></td>
		</tr>
	</table>
</form>