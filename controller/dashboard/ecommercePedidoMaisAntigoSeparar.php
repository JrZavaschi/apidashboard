<?php
$query_pedidos_antigo = $conn->prepare("SELECT A.NUMERO, A.DATA, A.NUMEROCONTROLE
										FROM AM_ORDEM A (NOLOCK)
										WHERE A.HANDLE = (
											SELECT MIN(A.HANDLE)
											FROM AM_ORDEM A
											WHERE A.TIPOOPERACAO = 2
											AND A.NATUREZAOPERACAO IN (4, 5)
											AND A.STATUS IN (1, 2, 30, 32, 34)
											AND A.DATA = (
												SELECT MIN(A.DATA)
												FROM AM_ORDEM A (NOLOCK)
												WHERE A.TIPOOPERACAO = 2
												AND A.NATUREZAOPERACAO IN (4, 5)
												AND A.STATUS IN (1, 2, 30, 32, 34)
												)
											)	
										") or die('Não foi possível executar o Select');
$query_pedidos_antigo->execute();


while ($row_pedidos_antigo = $query_pedidos_antigo->fetch(PDO::FETCH_ASSOC)) {
	$os_pedidos_antigo = $row_pedidos_antigo['NUMERO'];
	$data_pedidos_antigo = $row_pedidos_antigo['DATA'];
	$numero_pedidos_antigo = $row_pedidos_antigo['NUMEROCONTROLE'];
?>
<tr style="color: red;">
	<td><strong><?php echo $os_pedidos_antigo; ?></strong></td>
	<td><?php echo date('d/m/Y', strtotime($data_pedidos_antigo)); ?></td>
	<td><?php echo $numero_pedidos_antigo; ?></td>
</tr>
<?php
}
?>