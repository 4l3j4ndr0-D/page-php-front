<?php
 $_BASEURL = 'http://192.168.15.71:8070';

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
	$inputJSON = file_get_contents('php://input');
	 
	$input_Split = preg_split ("/\,/", $inputJSON); 
	$arr_length = count($input_Split);


	$headerStringValue = '';
	if (isset($_SERVER['HTTP_ACCESS_TOKEN'])){
		$headerStringValue = $_SERVER['HTTP_ACCESS_TOKEN'];
 
	}
 
	//DetallePedido
	if (($arr_length == 3) && ($input_Split[0] == "D")){
		$_username = '';
		$_id_ot = '';		 
	 
	 	$_username = $input_Split[1];		 
		$_id_ot = $input_Split[2];		 
	
		 
		if ($_username != '' && $_id_ot !='') {
			header("HTTP/1.1 200 OK");
			$_WSResultText = DetallePedido($_BASEURL, $headerStringValue, $_username, $_id_ot);

   			echo GenerarPedido($_WSResultText);
			exit();
		}
	}

	//Vista Pedido
	if (($arr_length == 3) && ($input_Split[0] == "V")){
		$_username = '';
		$_id_ot = '';		 
	 
	 	$_username = $input_Split[1];		 
		$_id_ot = $input_Split[2];		 
	
		 
		if ($_username != '' && $_id_ot !='') {
			header("HTTP/1.1 200 OK");
			$_WSResultText = ConsultaInforme($_BASEURL, $headerStringValue, $_username, $_id_ot);

			$_WSResultText33 = GenerarVista($_WSResultText);
			$_WSResultText1 = json_decode($_WSResultText33 ,true);
			$_Fichas = $_WSResultText1;
			echo $_Fichas[0]['impresionorme_html_con_antecedente_grafico'];
			exit();
		}
	}

	//Vista Pedido
	if (($arr_length == 3) && ($input_Split[0] == "P")){
		$_username = '';
		$_id_ot = '';		 
	 
	 	$_username = $input_Split[1];		 
		$_id_ot = $input_Split[2];		 
	
		 
		if ($_username != '' && $_id_ot !='') {
			header("HTTP/1.1 200 OK");
			$_WSResultText = ConsultaInforme($_BASEURL, $headerStringValue, $_username, $_id_ot);

			$_WSResultText33 = GenerarVista($_WSResultText);
			$_WSResultText1 = json_decode($_WSResultText33 ,true);
			$_Fichas = $_WSResultText1;
			echo $_Fichas[0]['impresionorme_html_con_antecedente_grafico'];
			exit();
		}
	}
}

function GenerarVista($_WSResultText){
	$_WSError = '';
	$_WSResultText1 = json_decode($_WSResultText );
    $_WSResultText2 = json_decode(json_encode($_WSResultText1),true); 
	//Verifico que si el resultado es un mensaje de error a travez de WsLoginReponse
	if (isset($_WSResultText2["WsLoginResponse"])){
		$_WsFichaResult = $_WSResultText2["WsLoginResponse"]["WsLoginResult"];
				
		//verifico si el error  es de tocken invalida, en tal caso lo reenvio al Login
		if ($_WsFichaResult["success"] == 8){
			$_WSError = $_WsFichaResult["message"]; 
			$_WSToken = '';
			$_WSUsuario = '';			
			header('Location: index.php' ,true,302);
			die();
		} 
		//Muestro el error, Ejemplo rango de fecha, sin datos etc.
		$_WSError = $_WsFichaResult["message"];
	}
	else{
		//Verifico que no sea un error de conexion y traiga un resultado vacio
		if ($_WSResultText2 == ""){
			$_WSError= "No se encontraron datos";
		}
		else
		{ 
			$_WSResultText1 = json_decode($_WSResultText ,true);
			$_Fichas = $_WSResultText1;
		}		
	}
	
	if ($_WSError !=''){
		return PedidoHtmlError($_WSError);
	} //impresionorme_html_con_antecedente_grafico
 
	return $_WSResultText;
}


function GenerarPedido($_WSResultText){
	$_WSError = '';
	$_WSResultText1 = json_decode($_WSResultText );
    $_WSResultText2 = json_decode(json_encode($_WSResultText1),true); 
	//Verifico que si el resultado es un mensaje de error a travez de WsLoginReponse
	if (isset($_WSResultText2["WsLoginResponse"])){
		$_WsFichaResult = $_WSResultText2["WsLoginResponse"]["WsLoginResult"];
				
		//verifico si el error  es de tocken invalida, en tal caso lo reenvio al Login
		if ($_WsFichaResult["success"] == 8){
			$_WSError = $_WsFichaResult["message"]; 
			$_WSToken = '';
			$_WSUsuario = '';			
			header('Location: index.php' ,true,302);
			die();
		} 
		//Muestro el error, Ejemplo rango de fecha, sin datos etc.
		$_WSError = $_WsFichaResult["message"];
	}
	else{
		//Verifico que no sea un error de conexion y traiga un resultado vacio
		if ($_WSResultText2 == ""){
			$_WSError= "No se encontraron datos";
		}
		else
		{ 
			$_WSResultText1 = json_decode($_WSResultText ,true);
			$_Fichas = $_WSResultText1;
		}		
	}
	
	if ($_WSError !=''){
		return PedidoHtmlError($_WSError);
	}
	return PedidoHtml($_WSResultText);
}

function PedidoHtmlError($_WSResultText){

	return $_WSResultText;
}

function ConsultaInforme($_BASEURL, $headerStringValue, $_username, $_id_orden){
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $_BASEURL . '/ConsultaInforme',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{"WsInformeHtm": {"username": "' . $_username . '","id_orden": "' . $_id_orden . '"}}',
	  CURLOPT_HTTPHEADER => array(
		'Accept: */*',
		'access-token: ' . $headerStringValue,
		'Content-Type: application/json'
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return $response;

}
	  
function DetallePedido($_BASEURL, $headerStringValue, $_username, $_it_ot){
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $_BASEURL . '/DetallePedido',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{"WsPedidoEx":{"username":
	"' . $_username . '","id_ot":
	"' . $_it_ot . '"}}',
	  CURLOPT_HTTPHEADER => array(
		'Accept: */*',
		'access-token: ' . $headerStringValue ,
		'Content-Type: application/json'
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return $response;

}

function formatFecha($_fecha){
     
    if (strlen($_fecha) >11){
        $fecha = new DateTime($_fecha);        
        return  date_format($fecha, 'd/m/Y');
    }
    else{
        return $_fecha;
    } 
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
?>


<?php
function PedidoHtml($_WSResultText){
	$_WSResultText1 = json_decode($_WSResultText ,true);
	$_Fichas = $_WSResultText1;
	
	if ($_Fichas != null){
?>
<div id="list-pedido" class="text-color" >
			<table style="width:100%;border:0;">
				<tbody><tr>
					<td>
						Pedido:  <?php echo $_Fichas[0]['muestra'];?>
					</td>
					<td>
						Muestra:  <?php echo $_Fichas[0]['nombre'];?>
					</td>
					<td>
						Fecha: <?php echo formatFecha($_Fichas[0]['fecha']);?> 
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<table>
							<thead>
								<tr>
									<th class="text-color">
										Código
									</th>
									<th class="text-color">
										Abreviatura
									</th>
									<th class="text-color">
										Descripción
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$_index = 0;
								foreach ($_Fichas as $fichas => $ficha) { 
							?>
								<tr class="<?php echo ($_index%2 == 0? "odd":"even"); ?>">
									<td>
										<?php echo $ficha['codigo'];?>
									</td>
									<td>
										<?php echo $ficha['mnemonico'];?>
									</td>
									<td>
										<?php echo $ficha['descripcion'];?>
									</td>
								</tr>
							<?php 
								$_index++;
								}
							?>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody></table>
		</div>
<?php   
	}
return "";
}
?>