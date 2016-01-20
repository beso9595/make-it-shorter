<?php
	if(file_exists("data/config.ini")){
		if(file_get_contents("data/config.ini")){
			die("Configurations are already installed, run <a href='index.php'>index.php</a>. if you want to reinstall delete 'data/config.ini'");
		}
	}
	
	require_once "lib/language.php";
?>
<!DOCTYPE html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Link Shortener">
		<meta name="keywords" content="">
		<meta name="author" content="Beso Bantsadze">
		<title>Installation</title>
		<link rel="icon" type="text/css" href="img/favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<script src="js/jquery-1.11.2.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/script.js"></script>
	</head>
	<body>
		<div id="ins_header">
			<img src="img/header.png">
		</div>
		<div id="instructions">
			<textarea class = "form-control" rows="7" cols="10" readonly style="resize: none">
				Some License Text.
			</textarea>
		</div>
		<div id="config">
			<table id="configTb" >
				<tr>
					<td><label>Address: </label></td>
					<td><input type="text" value="" placeholder="https://www.google.com/" name="address"></td>
					<td class="start">*</td>
				</tr>
				<tr>
					<td><label>Sitename: </label></td>
					<td><input type="text" value="" placeholder="Google.com" name="sitename"></td>
					<td class="start">*</td>
				</tr>
				<tr>
					<td><label>Title: </label></td>
					<td><input type="text" value="Make It Shorter" name="title"></td>
					<td class="start">*</td>
				</tr>
				<tr>
					<td><label>Hostname: </label></td>
					<td><input type="text" value="localhost" name="hostname"></td>
					<td class="start">*</td>
				</tr>
				<tr>
					<td><label>Username: </label></td>
					<td><input type="text" value="root" name="username"></td>
					<td class="start">*</td>
				</tr>
				<tr>
					<td><label>Password: </label></td>
					<td><input type="text" value="" name="password"></td>
				</tr>
				<tr>
					<td><label>Database: </label></td>
					<td><input type="text" value="" name="database"></td>
					<td class="start">*</td>
				</tr>
				<tr>
					<td><label>Prefix: </label></td>
					<td><input type="text" value="w2e_" name="prefix"></td>
					<td class="start">*</td>
				</tr>
				<tr>
					<td><label>Seceret word: </label></td>
					<td><input type="text" value="" placeholder="ex: n1jh9" name="sec_word"></td>
					<td class="start">*</td>
				</tr>
				<tr>
					<td><label>E-mail: </label></td>
					<td><input type="email" value="" placeholder="ex: someone@mail.com"name="mail"></td>
					<td class="start">*</td>
				</tr>
				<tr>
					<td><label>Default<br>language: </label></td>
					<td>
						<?php
							$arr = Lang::getIndexArray();
							$count = count($arr);
							echo '<select  size="' . ($count+1) . '" width="150px" name="language">';
								echo '<option value="' . $arr[0] . '" selected="selected">' . Lang::getByLang($arr[0], "lang_name") . '</option>';
								for($i = 1; $i < $count; $i++){
									echo '<option value="' . $arr[$i] . '">' . Lang::getByLang($arr[$i], "lang_name") . '</option>';
								}
							echo '</select>';
						?>
					</td>
					<td class="start">*</td>
				</tr>
				<tr>
					<td colspan="2" align="right"><input type="button" value="Submit" name="install" class="btn btn-danger"></td>
				</tr>
			</table>
		</div>
		<div id="ins_message" class="bg-danger">
			
		</div>
		<div id="ins_footer">
			<a href="mailto:beso35@live.com">Contact</a> : <a href="https://github.com/beso9595/" target="_blank">Github</a>
		</div>
	</body>
</html>
