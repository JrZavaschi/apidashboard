<?php
$query_itens_sem_picking = $conn->prepare("SELECT A.HANDLE, 
											B.NUMERO OS, 
											B.DATA DATA_OS, 
											B0.CODIGOREFERENCIA ITEM, 
											B0.NOME DESCRICAO_ITEM, 
											A.QUANTIDADE QUANTIDADE_SOLICITADA
											FROM AM_ORDEMPROGRAMACAO A (NOLOCK)
											INNER JOIN AM_ORDEM B (NOLOCK) ON B.HANDLE = A.ORDEM
											INNER JOIN MT_ITEM B0 (NOLOCK) ON B0.HANDLE = A.ITEM
											WHERE B.NATUREZAOPERACAO IN (4, 5)
											AND A.STATUS = 1
											AND B.EHIMPORTADOPELOEDI = 'S'
											AND EXISTS (
											  SELECT Y.HANDLE FROM AM_ORDEMPROGRAMACAO Y (NOLOCK)
											  WHERE Y.ORDEM = A.ORDEM 
											  AND Y.HANDLE <> A.HANDLE

											  )AND NOT EXISTS (
															  SELECT K.HANDLE FROM AM_SALDOESTOQUE K  (NOLOCK)
															  INNER JOIN AM_DEPOSITOLOCALIZACAO K2 (NOLOCK) ON K2.HANDLE = K.ENDERECO                  
															  WHERE K.ITEM = A.ITEM                  
															  AND K2.TIPOAREA IN (2)
															 )
										") or die('Não foi possível executar o Select');
				$query_itens_sem_picking->execute();

				while ($row_itens_sem_picking = $query_itens_sem_picking->fetch(PDO::FETCH_ASSOC)) {
					$handle_itens_sem_picking = $row_itens_sem_picking['HANDLE'];
					$os_itens_sem_picking = $row_itens_sem_picking['OS'];
					$data_os_itens_sem_picking = $row_itens_sem_picking['DATA_OS'];
					$codigo_picking_itens_sem_picking = $row_itens_sem_picking['ITEM'];
					$nome_ocorrencia_itens_sem_picking = $row_itens_sem_picking['DESCRICAO_ITEM'];
					$quantidade_pulmao_itens_sem_picking = $row_itens_sem_picking['QUANTIDADE_SOLICITADA'];
			?>
				<tr>
					<td><?php echo $os_itens_sem_picking; ?></td>
					<td><?php echo date('d/m/Y', strtotime($data_os_itens_sem_picking)); ?></td>
					<td><?php echo $codigo_picking_itens_sem_picking; ?></td>
					<td><?php echo $nome_ocorrencia_itens_sem_picking; ?></td>
					<td><?php echo $quantidade_pulmao_itens_sem_picking; ?></td>
				</tr>
			<?php
				}
			?>