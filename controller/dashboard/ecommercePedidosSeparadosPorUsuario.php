<?php
$query_pedidos_separados = $conn->prepare("SELECT 
										K.LOGIN AS USUARIO, 
										COUNT(CASE WHEN TO_CHAR(DATASEPARACAO, 'DD') = EXTRACT(DAY FROM SYSDATE) THEN K.NUMERO ELSE NULL END) 
										AS QUANTIDADE
										FROM (

										SELECT A.NUMERO, C.LOGIN, B.DATASEPARACAO DATASEPARACAO 
										FROM AM_ORDEM A (NOLOCK)
										INNER JOIN AM_ORDEMITEMSEPARACAO B (NOLOCK) ON B.ORDEM = A.HANDLE
										INNER JOIN MS_USUARIO C (NOLOCK) ON C.HANDLE = B.USUARIOSEPARACAO
										WHERE B.HANDLE = (SELECT MAX(HANDLE) FROM AM_ORDEMITEMSEPARACAO WHERE STATUS <> 7 AND ORDEM = A.HANDLE
										AND DATASEPARACAO = (SELECT MAX(DATASEPARACAO) FROM AM_ORDEMITEMSEPARACAO WHERE STATUS <> 7 AND ORDEM = A.HANDLE))
										AND A.NATUREZAOPERACAO IN (4, 5)
										AND A.EHIMPORTADOPELOEDI  = 'S'
										AND B.DATASEPARACAO >= TRUNC(SYSDATE) - 7
										) K
										GROUP BY K.LOGIN

										UNION ALL 

										SELECT 
										'Total', 
										COUNT(CASE WHEN TO_CHAR(DATASEPARACAO, 'DD') = EXTRACT(DAY FROM SYSDATE) THEN K.NUMERO ELSE NULL END)  AS QUANTIDADE
										FROM (

										SELECT A.NUMERO, C.LOGIN, B.DATASEPARACAO DATASEPARACAO 
										FROM AM_ORDEM A (NOLOCK)
										INNER JOIN AM_ORDEMITEMSEPARACAO B (NOLOCK) ON B.ORDEM = A.HANDLE
										INNER JOIN MS_USUARIO C (NOLOCK) ON C.HANDLE = B.USUARIOSEPARACAO
										WHERE B.HANDLE = (SELECT MAX(HANDLE) FROM AM_ORDEMITEMSEPARACAO WHERE STATUS <> 7 AND ORDEM = A.HANDLE
										AND DATASEPARACAO = (SELECT MAX(DATASEPARACAO) FROM AM_ORDEMITEMSEPARACAO WHERE STATUS <> 7 AND ORDEM = A.HANDLE))
										AND A.NATUREZAOPERACAO IN (4, 5)
										AND A.EHIMPORTADOPELOEDI  = 'S'
										AND B.DATASEPARACAO >= TRUNC(SYSDATE) - 7
										) K 
										ORDER BY QUANTIDADE DESC
										") or die('Não foi possível executar o Select');
				$query_pedidos_separados->execute();


				while ($row_pedidos_separados = $query_pedidos_separados->fetch(PDO::FETCH_ASSOC)) {
					$usuario_pedidos_separados = $row_pedidos_separados['USUARIO'];
					$quantidade_pedidos_separados = $row_pedidos_separados['QUANTIDADE'];
			?>
				<tr>
					<td><?php echo $usuario_pedidos_separados; ?></td>
					<td><?php echo $quantidade_pedidos_separados; ?></td>
				</tr>
			<?php
				}
			?>