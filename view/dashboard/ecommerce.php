<?php
include('../../controller/tecnologia/sistema.php');
//$conn = new PDO("oci:dbname=".$tns.";charset=UTF8", $db_username,$db_password);
$conn = Sistema::getConexao();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Dashboard E-commerce</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <script src="../../view/tecnologia/js/jquery.js"></script>
    <script src="../../view/tecnologia/js/dx.all.js"></script>
    <link rel="stylesheet" href="../../view/tecnologia/css/style.css">
    <link rel="stylesheet" href="../../view/tecnologia/css/bootstrap.css">
	<script>
	setTimeout(function() {
	   window.location.reload();
	}, 60000);
	</script>
<meta charset="utf-8">
</head>

<body class="dx-viewport">
	<div class="container-fluid">
   	<?php
		$hora = date('H:i', strtotime($time));
		//echo 'Hora : '.$hora;
		$onzeetrinta = date('H:i', strtotime('11:30'));
		$doze = date('H:i', strtotime('12:00'));
		$dezesseteetrinta = date('H:i', strtotime('17:30'));
		$dezoito = date('H:i', strtotime('18:00'));
		
		if($hora >= $onzeetrinta and $hora <= $doze or $hora >= $dezesseteetrinta and $hora <= $dezoito){
	?>
   		<div class="row" id="grid-masonry">
			<div class="col-md-6 thumbnail">
				<label for="" class="text-center">Pedidos separados por usuário</label>
				<table class="table table-responsive table-striped">
					<thead>
						<th>Usuário</th>
						<th>Quantidade</th>
					</thead>
					<tbody>
					<?php
						include('../../controller/dashboard/ecommercePedidosSeparadosPorUsuario.php');
					?>
					</tbody>
				</table>
			</div>
			<div class="col-md-6 thumbnail">
				<label for="" class="text-center">Peças separadas por usuário</label>
				<table class="table table-responsive table-striped">
					<thead>
						<th>Usuário</th>
						<th>Quantidade</th>
					</thead>
					<tbody>
					<?php
						include('../../controller/dashboard/ecommercePecasSeparadasPorUsuario.php');
					?>
					</tbody>
				</table>
			</div>
		</div>
   		<?php
		}
		else{
		?>
    	<div class="row" id="grid-masonry">
    		<div class="col-md-4 thumbnail">
				<label for="" class="text-center">Pedidos por status</label>
				<table class="table table-responsive table-striped">
					<thead>
						<th>Status</th>
						<th>Quantidade</th>
					</thead>
					<tbody>
					<?php
						include('../../controller/dashboard/ecommercePedidosStatus.php');
					?>
					</tbody>
				</table>
    		</div>
    		<div class="col-md-4 thumbnail">
				<label for="" class="text-center">Pedidos a separar</label>
				<?php
					include('../../controller/dashboard/ecommercePedidosSeparar.php');
				?>
			</div>
			
			<div class="col-md-4 thumbnail">
				<label for="" class="text-center">Peças a separar</label>
				<?php
					include('../../controller/dashboard/ecommercePecasSeparar.php');
				?>
			</div>
   			
    		<div class="col-md-8 thumbnail">
				<label for="" class="text-center">Pedido mais antigo a separar</label>
				<table class="table table-responsive table-striped pedido-antigo">
					<thead>
						<th>OS</th>
						<th>Data</th>
						<th>Pedido</th>
					</thead>
					<tbody>
					<?php
						include('../../controller/dashboard/ecommercePedidoMaisAntigoSeparar.php');
					?>
					</tbody>
				</table>
    		</div>
    		<div class="col-md-8 thumbnail">
				<label for="" class="text-center">Produtos faltantes por quantidade solicitada</label>
				<table class="table table-responsive table-striped ">
					<thead>
						<th>Codigo</th>
						<th>Nome</th>
						<th>Solicitado</th>
						<th>Saldo Ocorrência</th>
						<th>Saldo Endereçamento</th>
						<th>Saldo Picking</th>
						<th>Saldo Pulmão</th>
					</thead>
					<tbody>
					<?php
						include('../../controller/dashboard/ecommerceProdutosFaltantes.php');
					?>
					</tbody>
				</table>
    		</div>
    		<div class="col-md-8 thumbnail">
				<label for="" class="text-center">Itens sem picking</label>
				<table class="table table-responsive table-striped">
					<thead>
						<th>OS</th>
						<th>Data OS</th>
						<th>Código</th>
						<th>Nome</th>
						<th>Quantidade</th>
					</thead>
					<tbody>
					<?php
						include('../../controller/dashboard/ecommerceItensSemPicking.php');
					?>
					</tbody>
				</table>
    		</div>
    		<div class="col-md-4 thumbnail">
				<label for="" class="text-center">Pedidos sem rastreamento JadLog à mais de 24 horas</label>
					<?php
						include('../../controller/dashboard/ecommercePedidosSemRastreamentoJadlog.php');
					?>
    		</div>
    	</div>
    	<?php
		}
		?>
    </div>
    <!--div class="footer">
    	<div class="container-fluid">
    		<p class="text-center">© Copyright New Solution 2017 - Desenvolvido por Junior Zavaschi</p>
    	</div>
    </div-->
<script>
	document.write(unescape("%3Cdiv%20class%3D%22footer%22%3E%0A%20%20%20%20%09%3Cdiv%20class%3D%22container-fluid%22%3E%0A%20%20%20%20%09%09%3Cp%20class%3D%22text-center%22%3E%A9%20Copyright%20New%20Solution%202017<strong>%20-%20Desenvolvido%20por%20Junior%20Zavaschi%3C/p%3E%0A%20%20%20%20%09%3C/div%3E%0A%20%20%20%20%3C/div%3E</strong>"));
</script>
<?php
	$conn = null;	
?>
<script src="../../view/tecnologia/js/bootstrap.js"></script>
<script src="../../view/tecnologia/js/masonry.pkgd.js"></script>
<script>
$('#grid-masonry').masonry({
  // options...
	itemSelector: '.thumbnail'
});	
</script>
</body>
</html>