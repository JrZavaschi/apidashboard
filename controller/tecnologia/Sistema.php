<?php
include_once "Conexao.php";
ob_start();
session_start();

//define inicializações do php com seus parametros
ini_set('max_file_uploads', '100');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size ', '2500M');
set_time_limit(99000);

if (isset($_SESSION['loginUsuario'])) {
    $empresa = $_SESSION['empresa'];
    $papel = $_SESSION['papel'];
    $filial = $_SESSION['filial'];
    $NomeEmpresa = $_SESSION['NomeEmpresa'];
    $NomeFilial = $_SESSION['NomeFilial'];
    $pessoa = $_SESSION['pessoa'];
    $handleUsuario = $_SESSION['handleUsuario'];
    $loginUsuario = $_SESSION['loginUsuario'];
    $papelNome = $_SESSION['papelNome'];
	
    //$referenciaPapelUsuario  = $_SESSION['referenciaPapelUsuario '];
}

date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y');
$hora = date('H:i:s');
$date = date('Y-m-d');
$time = date('H:i:s');
$datetime = date('Y-m-d H:i:s');
$datahora = date('d/m/Y H:i:s');

function limitarTexto($texto, $limite) {
    $contador = strlen($texto);
    if ($contador >= $limite) {
        $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '';
        return $texto;
    } else {
        return $texto;
    }
}

class Sistema {

    static function getConexao($transacao = true) {
        $conexao = Conexao::getInstancia();

        if ($transacao) {
            $conexao->beginTransaction();
        }

        return $conexao;
    }

    static function getFiltroSuperGlobal($superGlobal, $variavel, $tipoVariavel) {
        return filter_input($superGlobal, $variavel, $tipoVariavel);
    }

    static function getPost($variavel, $tipoVariavel = FILTER_SANITIZE_STRING) {
        return self::getFiltroSuperGlobal(INPUT_POST, $variavel, $tipoVariavel);
    }

    static function getGet($variavel, $tipoVariavel = FILTER_SANITIZE_STRING) {
        return self::getFiltroSuperGlobal(INPUT_GET, $variavel, $tipoVariavel);
    }

    static function getServer($variavel, $tipoVariavel = FILTER_SANITIZE_STRING) {
        return self::getFiltroSuperGlobal(INPUT_SERVER, $variavel, $tipoVariavel);
    }

}
