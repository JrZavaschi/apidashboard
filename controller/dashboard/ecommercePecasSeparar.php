<?php
$query_pecas_separar = $conn->prepare("SELECT SUM(B.QUANTIDADE) QUANTIDADE
										FROM AM_ORDEM A (NOLOCK)
										INNER JOIN AM_ORDEMPROGRAMACAO B (NOLOCK) ON B.ORDEM = A.HANDLE
										WHERE A.TIPOOPERACAO = 2
										AND A.NATUREZAOPERACAO IN (4, 5)
										AND A.STATUS IN (1, 2, 30, 32, 34, 35)
										AND B.STATUS IN (1, 18, 19)
										") or die('Não foi possível executar o Select');
	$query_pecas_separar->execute();


	while ($row_pecas_separar = $query_pecas_separar->fetch(PDO::FETCH_ASSOC)) {
		$quantidade_pecas_separar = $row_pecas_separar['QUANTIDADE'];
		
		if($quantidade_pecas_separar <= '500'){
			$cor_pecas_separar = 'red';
		}
		else{
			$cor_pecas_separar = 'green';
		}
?>

	<p class="text-center indicador-valor" style="color: <?php echo $cor_pecas_separar; ?>"><?php echo number_format($quantidade_pecas_separar, '0',',','.'); ?></p>
<?php
	}
?>