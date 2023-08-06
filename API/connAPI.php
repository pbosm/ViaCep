<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

require_once('functions.php');

class Rest {
    // Executa a Classe e Função recebida por URL e envia os parâmetros por GET ou POST
    public static function open($function, $content) {
        $args[] = json_decode($content, true);

        try {
            $class = 'functions';

            // Retorna o sucesso da execução
            if (class_exists($class)) {
                if (method_exists($class, $function)) {
                    $return = call_user_func_array(array(new $class, $function), $args);

                    return json_encode(array('status' => 'success', 'data' => $return));
                } else {
                    return json_encode(array('status' => 'erro', 'data' => 'Método inexistente!'));
                }
            } else {
                return json_encode(array('status' => 'erro', 'data' => 'Classe inexistente!'));
            }
        } catch (Exception $e) {	
            // Retorna o erro caso exista
            $errorMessage 	= $e->getMessage();
            
            echo json_encode(array('status' => 'erro', 'data' => $errorMessage));
        }
        
    }
}

if (isset($_POST['API'], $_POST['content'])) {
    echo Rest::open($_POST['API'], $_POST['content']);
}


