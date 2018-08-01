<?php
include('../tecnologia/sistema.php');

try{
	
    $conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);
	
	$query = $conn->prepare("SELECT (SELECT COUNT(DISTINCT B.NUMERO) FROM AM_ORDEM B 
							 WHERE B.LOGDATACADASTRO >= A.DATA AND B.LOGDATACADASTRO < (A.DATA + 1)
							 AND B.EHIMPORTADOPELOEDI = 'S'
							 AND B.TIPOOPERACAO = 2 ) QUANTIDADE
							 FROM MS_CALENDARIO A
							 WHERE TRUNC(A.DATA) >= TRUNC(SYSDATE) - 6 AND TRUNC(A.DATA) <= TRUNC(SYSDATE)
							") or die('Não foi possível executar o Select');
	$query->execute();
	
	$outstr = array();
	
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		$outstr = array("Quantidade" => $row['QUANTIDADE']);
		echo json_encode($outstr);
	}
	
}
catch(PDOException $e){
    echo ($e->getMessage());
}
?>