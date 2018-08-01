<?php
class BancoDados {
	
   private static $tipo = 'sqlsrv:Server=';
   
   // Mudar para false quando BD Oracle
   private static $sqlsvr = true;
  
   private static $host = "SVBCN2";
   private static $nome = "ESCALASOFT";
   private static $usuario = "SA";
   private static $senha = "#escalasoft123";
   private static $TnsOracle = "
							(DESCRIPTION =
    						(ADDRESS_LIST =
    						  (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
   						 )
    						(CONNECT_DATA =
    						  (SERVICE_NAME = orcl)
    						)
  						)
       					";
   
   private function __construct() {
      
   }

   public static function getDns() {
	   if(self::$sqlsvr){
     		return "sqlsrv:Server=" . self::$host . ";Database=" .  self::$nome. ";ConnectionPooling=0";
	   }
	   else{
		 	  return "oci:dbname" . self::$TnsOracle;
	   }
   }

   public static function getUsuario() {
      return self::$usuario;
   }

   public static function getSenha() {
      return self::$senha;
   }

}
