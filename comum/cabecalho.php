<?php

/**

Arquivo integrante do sistema de Compras Coletivas desenvolvido por INKID
Autor: Caio de Oliveira Hodos
Contato: caio.hodos@inkid.net

Copyright 2011 INKID
contato@inkid.net
http://www.inkid.net
 
*/

$sql = "SELECT * FROM $cidades_table";
$result_cidades = $db->query($sql);
$num_cidades = $db->num_rows($result_cidades);

for($j=0;$j<$num_cidades;$j++){
	$row = $db->fetch_array($result_cidades);
	
	if ($row['ID'] == $regiao) {
		$regiao_desc = $row['CIDADE'];
	}
}

echo "<div style='position:relative;float:left;width:100%;height:100px;z-index:30'>
		<div style='position:absolute;float:left;width:100%;z-index:30'>
			<div style='position:relative;float:left;'>
				<img src='imagens/logo1.png'>
			</div>
			
			<div id='regiao_seleciona' style='position:relative;float:left;width:180px;background-color:#AA0000;border:1px solid #F00;border-radius:6px;color:#FFF;padding:4px;font-size:1.5em;margin-left:16px;margin-top:25px;' onclick=\"display_div('regiao_seleciona','none');display_div('escolhe_regiao','block')\">
			<div style='position:relative;float:left;cursor:default'>$regiao_desc</div>
			<div style='position:relative;float:right;margin-right:3px;margin-top:1px;color:#D50000;cursor:default;font-size:0.9em'>&#9660;</div>
			</div>
			
			<div id='escolhe_regiao' style='position:relative;float:left;width:428px;margin-left:16px;margin-top:25px;display:none'>
				<div style='position:relative;float:left;width:178px;background-color:#950000;border:1px solid #D50000;border-bottom:0px;border-top-right-radius:6px;border-top-left-radius:6px;color:#FFF;padding:4px;font-size:1.5em;text-indent:4px' onclick=\"display_div('regiao_seleciona','block');display_div('escolhe_regiao','none')\">
					<div style='position:relative;float:left;cursor:default;margin-left:-3px'>Escolha sua cidade</div>
					<div style='position:relative;float:right;margin-right:3px;margin-top:1px;color:#D50000;cursor:default;font-size:0.9em'>&#9650;</div>
				</div>
				<div style='position:relative;float:left;width:428px;'>
					<div style='position:relative;float:left;width:186px;height:2px;background-color:#AA0000;border-left:1px solid #D50000'>
					</div>
					<div style='position:relative;float:left;width:238px;height:2px;background-color:#AA0000;border-right:1px solid #D50000;border-top:1px solid #D50000;border-top-right-radius:6px;margin-top:-1px'>
					</div>
					<div style='position:relative;float:left;width:424px;height:110px;background-color:#AA0000;border-right:1px solid #D50000;border-left:1px solid #D50000;font-size:1.1em;font-weight:bold;color:#FFF'>";
						mysql_data_seek($result, 0);
						
						for($j=0;$j<$num_cidades;$j++){
							$row = $db->fetch_array($result_cidades);
							
							echo "<div style='position:relative;float:left;width:31.3%;padding:1%;overflow:hidden'>" . $row['CIDADE'] . "</div>";
						}

echo "				</div>
					<div style='position:relative;float:left;width:424px;height:10px;background-color:#950000;border:1px solid #D50000;border-top:0px;border-bottom-right-radius:6px;border-bottom-left-radius:6px'>
					</div>
				</div>
			</div>";
			
			if (isCookieSet()) {
				if (isAdministrator($_SESSION[conta])) {
					echo "	<div style='position:relative;float:right;margin-top:25px;'>
								<a href='controle/painel.php'>
									<div style='position:relative;float:left;color:#FFF;font-size:1.4em;font-weight:bold;margin-right:6px'>Painel</div>
								</a>
								<a href='usuario/logout.php'>
									<div style='position:relative;float:left;color:#FFF;font-size:1.4em;font-weight:bold;border-left:2px solid #F00;padding-left:5px'>Sair</div>
								</a>
							</div>";
				}
				else {
					echo "	<div style='position:relative;float:right;margin-top:25px;'>
								<a href='../usuario/logout.php'>
									<div style='position:relative;float:left;color:#FFF;font-size:1.4em;font-weight:bold;margin-right:6px'>Sair</div>
								</a>
							</div>";
				}
			}
			else {
				echo "	<div style='position:relative;float:right;margin-top:25px;'>
							<a href='usuario/login.php'>
							<div style='position:relative;float:left;color:#FFF;font-size:1.4em;font-weight:bold;margin-right:6px'>Entrar</div>
							</a>
							<a href='usuario/cadastro.php'>
							<div style='position:relative;float:left;color:#FFF;font-size:1.4em;font-weight:bold;border-left:2px solid #F00;padding-left:5px'>Cadastre-se</div>
							</a>
						</div>";
			}
			
echo "	</div>
	</div>";
			
			switch ($_GET[error]) {
            case("1"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							Preencha todos os campos obrigatórios
						</div>";
                break;
            case("2"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							Digite um título para a sua oferta
						</div>";
                break;
			case("3"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							A data de ativação e de encerramento deve ser posterior à atual 
						</div>";
                break;
			case("4"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							A data de encerramento deve ser posterior à data de ativação
						</div>";
                break;
			case("5"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							O valor sem desconto deve ser maior do que o valor promocional
						</div>";
                break;
			case("6"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							A quantidade máxima de cupons disponíveis deve ser maior que a quantidade mínima
						</div>";
                break;
			case("7"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							A largura da imagem não deve ultrapassar 1500 pixels
						</div>";
                break;
			case("8"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							Altura da imagem não deve ultrapassar 1800 pixels
						</div>";
                break;
			case("9"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							A imagem deve ter no máximo 100000 bytes
						</div>";
                break;
			case("10"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							Formato de imagem não reconhecido
						</div>";
                break;
			case("11"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							E-mail já cadastrado
						</div>";
                break;
			case("12"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							As senhas não coincidem
						</div>";
                break;
			case("13"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							Saia do sistema para fazer um novo cadastro
						</div>";
                break;
			case("14"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							É necessário fazer login para acessar essa página
						</div>";
                break;
			case("15"):
                echo "	<div id='box_error' class='box_error' onclick=\"display_div('box_error','none')\">
							Você não tem permissão para acessar essa página
						</div>";
                break;
            default:
                break;
        }

?>