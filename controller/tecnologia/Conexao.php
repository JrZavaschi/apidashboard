<?php

include_once "BancoDados.php";

class Conexao extends BancoDados {

   public static $instancia;

   private function __construct() {
      parent::__construct();
   }

   public static function getInstancia() {
      if (!isset(self::$instancia)) {
         try {
            self::$instancia = new PDO(BancoDados::getDns(), BancoDados::getUsuario(), BancoDados::getSenha());
            self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instancia->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
         }
         catch (Exception $ex) {
			 session_destroy();
			 session_start();

			 $mensagem = "Servidor em manutenção, tente novamente em alguns minutos";
			
			echo"<script language='javascript' type='text/javascript'>window.location.href='../../view/estrutura/login.php?mensagem=$mensagem'</script>";
			//header('Location: ../../view/estrutura/login.php');
         }
      }

      return self::$instancia;
   }
}