<?php
function ListadoProtocolo($_startDate, $_endDate)
{
	global $_BASEURL, $_WSToken, $_WSUsuario, $_WSError;

	//Conecto con el WebService
	$_WSResultText = ListaPedidos($_BASEURL, $_WSToken, $_WSUsuario, $_startDate, $_endDate);
	$_Fichas = null;

	//Convert Objet to array
	$_WSResultText1 = json_decode($_WSResultText);
	$_WSResultText2 = json_decode(json_encode($_WSResultText1), true);

	//Verifico que si el resultado es un mensaje de error a travez de WsLoginReponse
	if (isset($_WSResultText2["WsLoginResponse"])) {
		$_WsFichaResult = $_WSResultText2["WsLoginResponse"]["WsLoginResult"];

		//verifico si el error  es de tocken invalida, en tal caso lo reenvio al Login
		if ($_WsFichaResult["success"] == 8) {
			$_WSError = $_WsFichaResult["message"];
			$_WSToken = '';
			$_WSUsuario = '';
			header('Location: index.php', true, 302);
			die();
		}
		//Muestro el error, Ejemplo rango de fecha, sin datos etc.
		$_WSError = $_WsFichaResult["message"];
	} else {
		//Verifico que no sea un error de conexion y traiga un resultado vacio
		if ($_WSResultText2 == "") {
			$_WSError = "No se encontraron datos";
		} else {
			$_WSResultText1 = json_decode($_WSResultText, true);
			$_Fichas = $_WSResultText1;
		}
	}
?>

	<div class="inner">
		<?php
		if ($_WSError == '') {
			echo '<!-- <div class="content-box-red"> </div> -->';
		} else {
			echo '<div class="content-box-red">' . $_WSError . ' </div>';
		};
		?>
		<h2 style="text-align: center;">Paciente</h2>
		<p style="text-align: center;">RESULTADOS ONLINE.</p>
	</div>
	<div style="margin-top:10px;margin-left: 0px; text-align: center;" class="form-group">
		<input id="startDate" class="form-control" type="text" value="<?php echo $_startDate; ?>" style="display:inline-block;width:110px;" name="startDate" placeholder="Fecha desde" value="" required="">
		<input id="endDate" class="form-control" type="text" value="<?php echo $_endDate; ?>" style="display:inline-block;width:110px;" name="endDate" placeholder="Fecha hasta" value="" required="">
		<input type="submit" name="_action_doLogin" value="Filtrar" class="btn waves-effect waves-light light-blue lighten-2 class border-round col s12" controller="usuario">
		<input type="submit" name="_action_doLogin" value="Salir" class="btn waves-effect waves-light light-blue lighten-2 class border-round col s12" controller="usuario">
	</div>
	<!-- HTML PRINCIPIO -->

	<table class="responsive-table responsive-table-input-matrix">
	<thead role="rowgroup">
    <tr role="row">
      <th role="columnheader">Prestaciones</th>
      <th role="columnheader">Pedido</th>
      <th role="columnheader">Fecha Pedido</th>
      <th role="columnheader">Entrega Final</th>
      <th role="columnheader">Estado</th>
      <th role="columnheader">Visto</th>
      <th role="columnheader">Impreso</th>
      <th role="columnheader">printer.img</th>
      <th role="columnheader">eye</th>
      <th role="columnheader">pdf</th>
    </tr>
  </thead>
		<tbody role="rowgroup" id="listProtocolos">
			<?php
			if ($_Fichas != null) {
				foreach ($_Fichas as $fichas => $ficha) {
			?>
					<tr role="row">
						<td role="cell"><a onclick="loadDoc1(<?php echo $ficha['id_orden_trabajo'];  ?>)" class="modal-trigger" href="#modal1">
								<img src="./images/attibutes.png" title="Prestaciones solicitados" border="0">
							</a></td>
						<td role="cell"><?php echo $ficha['pedido'];  ?></td>
						<td role="cell"><?php echo formatFecha($ficha['fecha_pedido']);  ?></td>
						<td role="cell"><?php echo formatFecha($ficha['entrega_final']);  ?></td>
						<td role="cell"><?php echo $ficha['estado_validacion'];  ?></td>
						<td role="cell">
							<input type="checkbox" name="chkVisto" disabled="enabled" <?php echo $ficha['visto'] == "1" ? "checked" : "";  ?> id="chkVisto">
							<label></label>
						</td>
						<td role="cell"><input type="checkbox" name="chkImpreso" disabled="disabled" <?php echo $ficha['impreso'] == "1" ? "checked" : "";  ?> id="chkImpreso">
							<label></label>
						</td>
						<td><a onclick="loadDoc3(<?php echo $ficha['id_orden_trabajo'];  ?>)">
								<img src="./images/printer.png" title="Imprimir Informe" alt="Imprimir Informe" border="0">
							</a></td>
						<td role="cell">
							<a onclick="loadDoc2(<?php echo $ficha['id_orden_trabajo'];  ?>)" class="modal-trigger" href="#modal1">
								<img src="./images/eye.png" title="Visualizar Informe" alt="Visualizar Informe" border="0">
							</a>
						</td>
						<td role="cell"><a href="/glymsweb/pedido/informePDF?id_orden_trabajo=<?php echo $ficha['id_orden_trabajo'];  ?>&amp;pedido=<?php echo $ficha['pedido'];  ?>">
								<img src="./images/PDF.jpg" title="Descargar Informe en formato PDF" alt="Descargar Informe en formato PDF" border="0">
							</a></td>
					</tr>
			<?php  };
			}; ?>
		</tbody>
	</table>
	<!-- HTML FINAL -->
	<script>
		function ajaxReq() {
			if (window.XMLHttpRequest) {
				return new XMLHttpRequest();
			} else if (window.ActiveXObject) {
				return new ActiveXObject("Microsoft.XMLHTTP");
			} else {
				alert("Browser does not support.");
				return false;
			}
		}

		function loadDoc1(id_ot) {
			loadDoc(id_ot, 'D')
		}

		function loadDoc2(id_ot) {
			loadDoc(id_ot, 'V')
		}

		function loadDoc3(id_ot) {
			tipo = 'P';
			var xmlhttp = ajaxReq();
			var params = tipo + "," + document.getElementById("_WSUsuario").value + "," + id_ot + "";
			var url = "wscliente.php";
			xmlhttp.open("POST", url, true); // set true for async, false for sync request
			// xmlhttp.setRequestHeader("Content-type", "application/json");
			xmlhttp.setRequestHeader("Accept", "*/*");
			xmlhttp.setRequestHeader("access-token", document.getElementById("_WSToken").value);
			xmlhttp.send(params); // or null, if no parameters are passed

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					try {
						//  var obj = JSON.parse(xmlhttp.responseText);
						var obj = xmlhttp.responseText;
						print(obj);
						// do your work here

					} catch (error) {
						throw Error;
					}
				}
			}
		}

		function loadDoc(id_ot, tipo) {
			var xmlhttp = ajaxReq();
			var params = tipo + "," + document.getElementById("_WSUsuario").value + "," + id_ot + "";
			var url = "wscliente.php";
			xmlhttp.open("POST", url, true); // set true for async, false for sync request
			// xmlhttp.setRequestHeader("Content-type", "application/json");
			xmlhttp.setRequestHeader("Accept", "*/*");
			xmlhttp.setRequestHeader("access-token", document.getElementById("_WSToken").value);
			xmlhttp.send(params); // or null, if no parameters are passed

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					try {
						//  var obj = JSON.parse(xmlhttp.responseText);
						document.getElementById("demo").innerHTML = xmlhttp.responseText;
						// do your work here

					} catch (error) {
						throw Error;
					}
				}
			}
		}
	</script>

<?php  }; ?>