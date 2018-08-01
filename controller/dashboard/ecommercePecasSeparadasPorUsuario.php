<?php
$query_pecas_separados = $conn->prepare("SELECT 
										K.LOGIN AS USUARIO, 
										COALESCE(SUM(CASE WHEN DATEADD(dd, 0, DATEDIFF(dd, 0, GetDate()))  = DATEADD(dd, 0, DATEDIFF(dd, 0, DATASEPARACAO)) THEN K.QUANTIDADE ELSE NULL END), 0) AS QUANTIDADE
										FROM (

										SELECT A.NUMERO, C.LOGIN, B.DATASEPARACAO DATASEPARACAO, B.QUANTIDADE 
										FROM AM_ORDEM A (NOLOCK)
										INNER JOIN AM_ORDEMITEMSEPARACAO B (NOLOCK) ON B.ORDEM = A.HANDLE
										INNER JOIN MS_USUARIO C (NOLOCK) ON C.HANDLE = B.USUARIOSEPARACAO
										WHERE A.NATUREZAOPERACAO IN (4, 5)
										AND A.EHIMPORTADOPELOEDI  = 'S'
										AND B.STATUS <> 7
										AND  B.DATASEPARACAO >= DATEADD(dd, 0, DATEDIFF(dd, 0, GetDate()))
										) K
										GROUP BY K.LOGIN

										UNION ALL 

										SELECT 
										'Total', 
										COALESCE(SUM(CASE WHEN DATEADD(dd, 0, DATEDIFF(dd, 0, GetDate()))  = DATEADD(dd, 0, DATEDIFF(dd, 0, DATASEPARACAO)) THEN K.QUANTIDADE ELSE NULL END), 0) AS QUANTIDADE
										FROM (

										SELECT A.NUMERO, C.LOGIN, B.DATASEPARACAO DATASEPARACAO, B.QUANTIDADE 
										FROM AM_ORDEM A (NOLOCK)
										INNER JOIN AM_ORDEMITEMSEPARACAO B (NOLOCK) ON B.ORDEM = A.HANDLE
										INNER JOIN MS_USUARIO C (NOLOCK) ON C.HANDLE = B.USUARIOSEPARACAO
										WHERE A.NATUREZAOPERACAO IN (4, 5)
										AND A.EHIMPORTADOPELOEDI  = 'S'
										AND B.STATUS <> 7
										AND  B.DATASEPARACAO >= DATEADD(dd, 0, DATEDIFF(dd, 0, GetDate()))
										) K 
										ORDER BY QUANTIDADE DESC
										") or die('Não foi possível executar o Select');
				$query_pecas_separados->execute();


				while ($row_pecas_separados = $query_pecas_separados->fetch(PDO::FETCH_ASSOC)) {
					$usuario_pecas_separados = $row_pecas_separados['USUARIO'];
					$quantidade_pecas_separados = $row_pecas_separados['QUANTIDADE'];
			?>
				<tr>
					<td><?php echo $usuario_pecas_separados; ?></td>
					<td><?php echo $quantidade_pecas_separados; ?></td>
				</tr>
			<?php
				}
			?>