<?php
require_once('config.php');
require_once('query.php');
require_once('post.php');
require_once('listado.php');
require_once('ingreso.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>.: Clínica Raña :. Laboratorio de Análisis Clínico - Hematología - Infectología - Donantes y Banco de Sangre de Neuquén Patagonia Argentina</title>
	<!--<link rel="shortcut icon" type="image/x-icon" href="style/images/favicon.png" />-->
	<meta name="GOOGLEBOT" content="index follow">
	<meta http-equiv="Content-Language" content="es-ar">
	<meta name="robots" content="index,follow,all">
	<meta name="classification" content="Design">
	<meta name="Revisit" content="7 days">
	<meta name="revisit-after" content="7 days">
	<meta name="DC.Title" content=".: Clínica Raña :. Laboratorio de Análisis Clínico - Hematología - Infectología - Donantes y Banco de Sangre de Neuquén Patagonia Argentina">
	<meta name="DC.Description" content=".: Clínica Raña :. Laboratorio de Análisis Clínico - Hematología - Infectología - Donantes y Banco de Sangre de Neuquén Patagonia Argentina">
	<meta name="searchtitle" content=".: Clínica Raña :. Laboratorio de Análisis Clínico - Hematología - Infectología - Donantes y Banco de Sangre de Neuquén Patagonia Argentina">
	<meta name="distribution" content="Global">
	<meta name="rating" content="Safe For Kids">
	<meta name="language" content="ES">
	<meta name="doc-type" content="Web Page">
	<meta name="doc-class" content="Completed">
	<meta name="doc-rights" content="Copywritten Work">
	<meta name="MSSmartTagsPreventParsing" content="true">
	<meta name="doc-rights" content="Copywritten Work">
	<meta name="DC.Language" scheme="RFC1766" content="Spanish">
	<meta name="Description" content="Clínica Raña Laboratorio de Análisis Clínico - Hematología - Infectología - Donantes y Banco de Sangre Medicina Transfusional Resultados Online Extracción de Sangre a Domicilio Ubicado en calle Tucumán 71 Neuquén. ">
	<meta name="Keywords" content="Clínica Raña Laboratorio de Análisis Clínico - Hematología - Infectología - Donantes y Banco de Sangre Medicina Transfusional Resultados Online Extracción de Sangre a Domicilio Ubicado en calle Tucumán 71 Neuquén. ">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
	<!-- BEGIN: VENDOR CSS-->
	<link rel="stylesheet" type="text/css" href="../glymsweb/assets/vendors/vendors.min.css" />
	<!-- END: VENDOR CSS-->
	<!-- BEGIN: Page Level href="../../../assets/css/themes/vertical-modern-menu-template/style.min.css" -->
	<link rel="stylesheet" type="text/css" href="./assets/css/themes/vertical-modern-menu-template/materialize.min.css" />
	<link rel="stylesheet" type="text/css" href="./assets/css/themes/vertical-modern-menu-template/style.min.css" />
	<link rel="stylesheet" type="text/css" href="./assets/css/pages/login.css" />
	<!-- END: Page Level CSS-->
	<!-- BEGIN: Custom CSS-->
	<link rel="stylesheet" type="text/css" href="./assets/css/custom/custom.css" />
	<!-- END: Custom CSS-->
	<!-- Lista SCSS -->
	<link rel="stylesheet" text="text/scss" href="index.scss">

	<!-- <link rel="stylesheet" href="../nw/ingreso/assets/css/main.css"> -->

	<!-- <noscript>
		<link rel="stylesheet" href="assets/css/noscript.css" />
	</noscript> -->

	<link rel="stylesheet" href="index.css">
	
	<link rel="stylesheet" text="text/scss" href="./assets/css/pages/list.scss">
	<link rel="stylesheet" text="text/css" href="./assets/css/pages/login.css">
	<link rel="stylesheet" text="text/css" href="./assets/css/pages/list.css">

</head>

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 1-column login-bg blank-page blank-page" data-open="click" data-menu="vertical-modern-menu" data-col="1-column">
	<!-- Wrapper -->
	<div id="wrapper">
		<!-- Header -->
		<header id="header">
			<a href="https://lachybs.com.ar/nw/index.php"><img src="../nw/images/logo-bco.png" class="img-responsive" alt="" title="Volver al SITIO WEB"></a>
			<div class="content">
				<form action="" method="post" class="form-horizontal">
					<?php

					if ($_action == "" || $_action == "Login") {
						LoginHtml();
					}

					if ($_action == "List") {
						ListadoProtocolo($_startDate, $_endDate);
					}
					?>
					<!-- Login -->
					<!-- Listado  -->
					<!-- ChangePassword -->
					<input id="_usuarioT" name="_usuarioT" value="<?php echo $_usuarioT; ?>" type="hidden">
					<input id="_WSToken" name="_WSToken" value="<?php echo $_WSToken; ?>" type="hidden">
					<input id="_WSUsuario" name="_WSUsuario" value="<?php echo $_WSUsuario; ?>" type="hidden">
				</form>
			</div>
			<button class="modal-trigger fichaPrint" id="<?php echo "WSToken";  ?>" href="#modal1">

			</button>

		</header>
	</div>
	<!-- Modal Structure -->
	<div class="container white">
		<div id="modal1" class="modal modal-fixed-footer" style="background-color: green;">
			<div class="modal-content modal-dialog modal-lg modal-dialog-centered" style="background-color: violet;">
				<p id="demo" style="background-color: white; float:left;"></p>
			</div>
			<div class="modal-footer" style="background-color: yellow;">
				<a href="#!" class="text-color modal-action modal-close waves-effect waves-green btn-flat-modal" style="background-color: #00aeef;">Cerrar</a>
			</div>
		</div>
	</div>
	<!-- BG -->
	<div id="bg"></div>

	<!-- BEGIN VENDOR JS-->
	<script src="./assets/js/vendors.min.js"></script>
	<!-- BEGIN VENDOR JS-->
	<!-- BEGIN PAGE VENDOR JS-->
	<!-- END PAGE VENDOR JS-->
	<!-- BEGIN THEME  JS-->
	<script src="./assets/js/plugins.min.js"></script>
	<script src="./assets/js/search.min.js"></script>
	<script src="./assets/js/custom/custom-script.min.js"></script>
	<!-- END THEME  JS-->
	<!-- END PAGE LEVEL JS-->
	<script src="index.js"></script>
	<script src="js/materialize.min.js"></script>


</body>

</html>