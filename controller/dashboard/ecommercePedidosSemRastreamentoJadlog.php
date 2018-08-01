<?php
$query_pedidos_sem_rastreamento_jadlog = $conn->prepare("SELECT COUNT(*) AGUARDANDO 
														 FROM IN_INTEGRACAO X (NOLOCK)
														 WHERE X.STATUS IN (11)
														 AND X.PARAMETROINTEGRACAO = 9
														 AND DATA < GETDATE() - 1
													   ") or die('Não foi possível executar o Select');
$query_pedidos_sem_rastreamento_jadlog->execute();

while ($row_pedidos_sem_rastreamento_jadlog = $query_pedidos_sem_rastreamento_jadlog->fetch(PDO::FETCH_ASSOC)) {
		$quantidade_pedidos_sem_rastreamento_jadlog = $row_pedidos_sem_rastreamento_jadlog['AGUARDANDO'];
	
if($quantidade_pedidos_sem_rastreamento_jadlog > '0'){
	$cor_pedidos_sem_rastreamento_jadlog = 'red';
}
else{
	$cor_pedidos_sem_rastreamento_jadlog = 'green';
}
?>
	<p class="text-center indicador-valor" style="color: <?php echo $cor_pedidos_sem_rastreamento_jadlog; ?>"><?php echo number_format($quantidade_pedidos_sem_rastreamento_jadlog, '0',',','.'); ?></p>
<?php
	}
?>