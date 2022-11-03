<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{ 
    $headerStringValue = '';
    if (isset($_SERVER['HTTP_ACCESS_TOKEN'])){
        $headerStringValue = $_SERVER['HTTP_ACCESS_TOKEN'];
    }

    //Recupero variables post
    parse_str(file_get_contents("php://input"), $post_varsa);   

    $_WSToken =isset( $post_varsa["_WSToken"])?  $post_varsa["_WSToken"]:"";
	$_WSUsuario =isset( $post_varsa["_WSUsuario"])? $post_varsa["_WSUsuario"]:"";

    $obj = json_encode($post_varsa);
    $texts  = print_r($obj, true);
    if ($texts !=""){
        header("HTTP/1.1 200 OK");

        //Selecciono accion
        $_action = $_WSToken !=""?"List": "Login";

        //Accion de validacion de usuario
        if ( $post_varsa["_action_doLogin"] == "Ingresar"){
            $_action = "Login";
            $_WSToken = "";
	        $_WSUsuario = '';
            $_startDate = '01/01/2018';
            $_endDate = '01/01/2022';
        }
        //Accion de Salir 
        if ( $post_varsa["_action_doLogin"] == "Salir"){
            $_action = "Login";
            $_WSToken = "";
	        $_WSUsuario = '';
        }
        //Accion de filtrado
        if ( $post_varsa["_action_doLogin"] == "Filtrar"){
            $_action = "List";
          
            if (isset( $post_varsa['startDate']) && isset( $post_varsa['endDate']))
            {
                $_startDate = $post_varsa['startDate'];
                $_endDate   = $post_varsa['endDate'];
            }
        }
    }  
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

function SearchTipoDni($idTipoDNI){
    $_username ="";
    
    switch ($idTipoDNI)
    {
     case '3':
         $_username = 'CUIL';
         break;
          case '4':
         $_username = 'CI';
         break;
          case '14':
         $_username = 'DNIN';
         break;
          case '15':
         $_username = '*';
         break;
          case '1':
         $_username = 'DNI';
         break;
          case '12':
         $_username = 'H.C';
         break;
          case '13':
         $_username = 'LOTE';
         break;
          case '2':
         $_username = 'LC';
         break;
          case '5':
         $_username = 'E';
         break;
          case '-1':
         $_username = 'NIN';
         break;
          case '16':
         $_username = 'PPE';
         break;
          case '6':
         $_username = 'PAS';
         break;
          case '7':
         $_username = 'SC';
         break;
                
         default:
             $_username = '*';
    }
    return $_username;
}
?>