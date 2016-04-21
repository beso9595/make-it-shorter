<?php

	if(!file_exists("data/config.ini")){
		die("Configurations file('data/config.ini') doesn't exists, run <a href='install.php'>install.php</a> first");
	}
	elseif(!file_get_contents("data/config.ini")){
		die("Configurations file('data/config.ini') is empty, run <a href='install.php'>install.php</a> first");
	}
	elseif(file_exists("install.php")){
		die("Delete 'install.php'");
	}
	
	require_once "lib/config.php";
	require_once "lib/language.php";
	require_once "lib/redirect.php";
	
	if(isset($_GET["code"])){
		redirect($_GET["code"]);
	}
?>
<!DOCTYPE html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Link Shortener">
		<meta name="keywords" content="short, shorter, shortner">
		<meta name="author" content="Beso Bantsadze">
		<title><?php echo Config::get("sitename") . " - " . Config::get("title"); ?></title>
		<link rel="icon" type="text/css" href="img/favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<script src="js/jquery-1.11.2.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/script.js"></script>
	</head>
	<body>
		<div class="dropdown" id="lang">
			<button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><?php echo Lang::get("lang"); ?>
			<span class="caret"></span></button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
				<?php
					$arr = Lang::getIndexArray();
					for($i = 0; $i < count($arr); $i++){
						$index = $arr[$i];
						echo "<li role='presentation'><a role='menuitem' tabindex='-1' href='' id='lang_" . $index . "' onclick=changeLang(this.id)><img class='ico' src='/img/" . $index . ".ico' alt='" . $index . "' > " . Lang::getByLang($index, "lang_name") . "</a></li>";
					}
				?>
			</ul>
		</div>
		<div id="header">
			<a href=""><img src="img/logo_<?php echo Lang::get("logo"); ?>.png" alt="logo"></a>
		</div>
		<!-- -->
		<div class="col-md-5 col-centered" id="content" >
			<div class="panel with-nav-tabs">	<!-- panel-primary -->
				<div class="panel-heading">
						<ul class="nav nav-tabs" id="navigator">
							<li class="active" onclick><a href="#tab1primary" data-toggle="tab"><?php echo Lang::get("shortener"); ?></a></li>
							<li class=""><a href="#tab2primary" data-toggle="tab"><?php echo Lang::get("create"); ?></a></li>
						</ul>
				</div>
				<div class="panel-body" >
					<div class="tab-content" >
						<div class="tab-pane fade active in" id="tab1primary">
							<table id="shortTb_a">
								<tr>
									<td><input type="text" placeholder="<?php echo Lang::get("enter_link"); ?>" name="link" size="30px" class="form-control"></td>
									<td><input type="button" value="<?php echo Lang::get("shorter"); ?>" name="shorter" class="btn btn-primary"></td>
								</tr>
							</table>
						</div>
						<div class="tab-pane fade" id="tab2primary" >
							<table id="shortTb_b">
								<tr>
									<td colspan="2"><input type="url" placeholder="<?php echo Lang::get("enter_link"); ?>" name="c_link" class="form-control"></td>
								</tr>
								<tr>
									<td><input type="text" placeholder="<?php echo Lang::get("enter_code"); ?>" name="code" class="form-control"></td>
									<td><input type="button" value="<?php echo Lang::get("create"); ?>" name="create" class="btn btn-primary"></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- -->
		<br><h2 id="message" class="bg-danger"></h2>
		<div id="footer">
			<a href="<?php echo "mailto:" . Config::get('mail'); ?>"><?php echo Lang::get("contact"); ?></a> : <a href="https://github.com/beso9595/" target="_blank">Github</a>
		</div>
	</body>
</html>
