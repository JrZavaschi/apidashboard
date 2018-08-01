<?php
$query_produtos_faltantes = $conn->prepare("SELECT CODIGOREFERENCIA, 
											   NOME, 
											   SOLICITADO, 
											   SALDOPICKING, 
											   SALDOPULMAO, 
											   SALDOOCORRENCIA, 
											   SALDOENDERECAMENTO
											 FROM (

											SELECT C.CODIGOREFERENCIA, C.NOME, SUM(B.QUANTIDADE) SOLICITADO, 
											(SELECT COALESCE(SUM(X.SALDOQUANTIDADE), 0) 
											FROM AM_SALDOESTOQUE X  (NOLOCK)
											INNER JOIN AM_DEPOSITOLOCALIZACAO X2 (NOLOCK) ON X2.HANDLE = X.ENDERECO
											WHERE X2.TIPOAREA = 2
											AND   X2.DEPOSITO = 3
											AND X.ITEM = B.ITEM) SALDOPICKING, 

											(SELECT COALESCE(SUM(X.SALDOQUANTIDADE), 0) 
											FROM AM_SALDOESTOQUE X (NOLOCK)
											INNER JOIN AM_DEPOSITOLOCALIZACAO X2 (NOLOCK) ON X2.HANDLE = X.ENDERECO
											WHERE X2.TIPOAREA IN (1, 9)
											AND   X2.DEPOSITO = 3
											AND X.ITEM = B.ITEM) SALDOPULMAO, 

											(SELECT COALESCE(SUM(X.SALDOQUANTIDADE), 0) 
											FROM AM_SALDOESTOQUE X (NOLOCK)
											INNER JOIN AM_DEPOSITOLOCALIZACAO X2 (NOLOCK) ON X2.HANDLE = X.ENDERECO
											WHERE X2.TIPOAREA IN (11, 6, 8)
											AND   X2.DEPOSITO = 3
											AND X.ITEM = B.ITEM) SALDOOCORRENCIA,

											(SELECT COALESCE(SUM(X.QUANTIDADE), 0)
											FROM AM_ORDEMITEMENDERECAMENTO X (NOLOCK)
											WHERE X.ITEM = B.ITEM
											AND X.STATUS NOT IN (3, 5)
											) SALDOENDERECAMENTO

											FROM AM_ORDEM A (NOLOCK)
											INNER JOIN AM_ORDEMPROGRAMACAO B (NOLOCK) ON B.ORDEM = A.HANDLE
											INNER JOIN MT_ITEM C (NOLOCK) ON C.HANDLE = B.ITEM
											WHERE A.EHIMPORTADOPELOEDI = 'S'
											  AND A.TIPOOPERACAO = 2
											  AND B.STATUS IN (1, 3)
											GROUP BY B.ITEM, C.CODIGOREFERENCIA, C.NOME
											) K 
											WHERE K.SOLICITADO > (SALDOPICKING + SALDOPULMAO)
										") or die('Não foi possível executar o Select');
				$query_produtos_faltantes->execute();

				while ($row_produtos_faltantes = $query_produtos_faltantes->fetch(PDO::FETCH_ASSOC)) {
					$codigo_produtos_faltantes = $row_produtos_faltantes['CODIGOREFERENCIA'];
					$nome_produtos_faltantes = $row_produtos_faltantes['NOME'];
					$solicitado_produtos_faltantes = $row_produtos_faltantes['SOLICITADO'];
					$saldo_picking_produtos_faltantes = $row_produtos_faltantes['SALDOPICKING'];
					$saldo_ocorrencia_produtos_faltantes = $row_produtos_faltantes['SALDOOCORRENCIA'];
					$saldo_pulmao_produtos_faltantes = $row_produtos_faltantes['SALDOPULMAO'];
					$saldo_enderecamento_produtos_faltantes = $row_produtos_faltantes['SALDOENDERECAMENTO'];
			?>
				<tr>
					<td><?php echo $codigo_produtos_faltantes; ?></td>
					<td><?php echo $nome_produtos_faltantes ?></td>
					<td><?php echo $solicitado_produtos_faltantes; ?></td>
					<td><?php echo $saldo_ocorrencia_produtos_faltantes; ?></td>
					<td><?php echo $saldo_picking_produtos_faltantes; ?></td>
					<td><?php echo $saldo_pulmao_produtos_faltantes; ?></td>
				</tr>
			<?php
				}
			?>