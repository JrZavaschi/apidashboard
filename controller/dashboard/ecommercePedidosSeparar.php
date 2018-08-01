<?php
$query_pedidos_separar = $conn->prepare(" SELECT COUNT(*) QUANTIDADE
										FROM AM_ORDEM A (NOLOCK)
										WHERE A.TIPOOPERACAO = 2
										AND A.NATUREZAOPERACAO IN (4, 5)
										AND A.STATUS IN (1, 2, 30, 32, 34, 35)
										") or die('Não foi possível executar o Select');
	$query_pedidos_separar->execute();


	while ($row_pedidos_separar = $query_pedidos_separar->fetch(PDO::FETCH_ASSOC)) {
		$quantidade_pedidos_separar = $row_pedidos_separar['QUANTIDADE'];
		
		if($quantidade_pedidos_separar <= '200'){
			$cor_pedidos_separar = 'red';
		}
		else{
			$cor_pedidos_separar = 'green';
		}
?>

	<p class="text-center indicador-valor" style="color: <?php echo $cor_pedidos_separar; ?>"><?php echo number_format($quantidade_pedidos_separar, '0',',','.'); ?></p>
<?php
	}
?>