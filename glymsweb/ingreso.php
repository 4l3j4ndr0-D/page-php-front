<?php
function LoginHtml()
{
	global $_BASEURL, $_WSError, $_usuarioT, $_WSToken, $_WSUsuario, $_action, $post_varsa;
	//Variables locales
	$_username = '';
	$_password = '';

	if ($_action == 'Login') {
		//Construyo WSUsuario con Tipo y numero de documento
		if (isset($post_varsa['tipoDoc'])  && isset($post_varsa['username'])) {
			$_TipoDni = SearchTipoDni($post_varsa['tipoDoc']);
			$_WSUsuario = $_TipoDni . $post_varsa['username'];
			$_username = $post_varsa['username'];
		}

		if (isset($post_varsa['password'])) {
			$_password = $post_varsa['password'];
		}

		if ($_username != '' && $_password != '') {
			$_WSResultText = ValidarUsuario($_BASEURL, $_WSUsuario, $_password);

			//Control de respuesta
			$_WSResultText1 = json_decode($_WSResultText);
			$_WSResultText2 = json_decode(json_encode($_WSResultText1), true);
			$_WsFichaResult = $_WSResultText2["WsLoginResponse"]["WsLoginResult"];

			//Si error, --> muestro el error y password en blanco
			if ($_WsFichaResult["success"] == 0) {
				$_WSToken =  $_WsFichaResult["token"];
				$_action = "List";

				return "";
			} else {
				$_password = "";
				$_WSError = $_WsFichaResult["message"];
			}
		}
	}
?>

	<div class="row">
		<div class="col s12">
			<div class="container" style="padding-top: 5%">
				<div id="login-page" class="row">
					<div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
						<a href=""><img class="logo-color" src="./assets/images/gallery/logo-color.png" class="img-responsive" alt="" title="Volver al SITIO WEB" /></a>

						<!-- COMIENZO FORMULARIO -->
						<form class="login-form">
							<div class="row">
								<div class="input-field col s12">
									<?php
									if ($_WSError == '') {
										echo '<!-- <div class="content-box-red"> </div> -->';
									} else {
										echo '<div class="content-box-red">' . $_WSError . ' </div>';
									};
									?>

									<h5 class="ml-4" style="text-align: center">
										Ingreso Paciente
									</h5>
									<h6 style="text-align: center">
										Acceso al SISTEMA<br />
										de RESULTADOS ONLINE.
									</h6>
								</div>
							</div>
							<!-- DNI-->
							<div class="input-field col s12" style="width:auto ;">
								<i class="material-icons prefix pt-2">assignment_ind</i>
								<select id="tipoDoc" name="tipoDoc" class="form-control" style="width: 80px; ">
									<option value="3">CUIL</option>
									<option value="4">CI</option>
									<option value="14">DNIN</option>
									<option value="15">*</option>
									<option value="1" selected="selected">DNI</option>
									<option value="12">H.C</option>
									<option value="13">LOTE</option>
									<option value="2">LC</option>
									<option value="5">E</option>
									<option value="-1">NIN</option>
									<option value="16">PPE</option>
									<option value="6">PAS</option>
									<option value="7">SC</option>
								</select>
							</div>
							<!-- DOCUMENTO -->
							<div class="row margin">
								<div class="input-field col s12">
									<i class="material-icons prefix pt-2">person_outline</i>
									<input id="username" class="form-control" type="text" value="" style="display: inline-block; width: 110px" name="username" placeholder="Documento" required="" />
									<label for="username" class="center-align">Documento</label>
								</div>
							</div>
							<!-- reactive forms -->
							<!-- CONTRASEÑA -->
							<div class="row margin">
								<div class="input-field col s12">
									<i class="material-icons prefix pt-2">lock_outline</i>
									<input id="password" type="password" placeholder="Contraseña" name="password" value="" required="" class="form-control" style="display: inline-block; width: 200px" />
									<label for="password">Contraseña</label>
								</div>
							</div>
							<!-- BOTON INGRESAR -->
							<!-- (click)="LoginHtml()" -->
							<div class="row">
								<div class="input-field col s12">
									<input type="submit" name="_action_doLogin" value="Ingresar" class="btn waves-effect waves-light border-round light-blue lighten-2 class col s12" controller="usuario">
								</div>
							</div>
							<!-- OLVIDO CONTRASEÑA? -->
							<div class="row">
								<div class="input-field col s6 m6 l6">
									<p class="margin medium-small">
										<a href="https://lachybs.com.ar/nw/ingreso/index.php#pass">No conoce su Contraseña?</a>
									</p>
								</div>
								<!-- BOTON INSTRUCTIVO -->
								<div class="input-field col s6 m6 l6">
									<p class="margin right-align medium-small">
										<a href="https://lachybs.com.ar/nw/ingreso/index.php#pass" class="btn waves-effect waves-light light-blue lighten-2 class border-round col s12">Instructivo</a>
									</p>
								</div>
							</div>
						</form>
						<!-- FIN FORMULARIO -->
					</div>
				</div>
			</div>
			<div class="content-overlay"></div>
		</div>
	</div>
	</div>
<?php  }; ?>