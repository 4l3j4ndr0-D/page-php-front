<?php   

function ValidarUsuario ($_BASEURL, $usuario, $password){
	$curl = curl_init();
   	curl_setopt_array($curl, array(
	  CURLOPT_URL => $_BASEURL. '/ValidarUsuario',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{"WsLogin": {"username": "' . $usuario . '", "password": "' . $password . '"} }',
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json'
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return $response;
}

function ListaPedidos($_BASEURL, $headerStringValue, $_username, $_startDate, $_endDate){
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $_BASEURL . '/ListaPedidos',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{"WsListaEx":{"username":
	"' . $_username . '","startDate":
	"' . $_startDate . '","endDate": "' . $_endDate . '"}}',
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

?>