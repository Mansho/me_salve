<?php

/**

Arquivo integrante do sistema de Compras Coletivas desenvolvido por INKID
Autor: Caio de Oliveira Hodos
Contato: caio.hodos@inkid.net

Copyright 2011 INKID
contato@inkid.net
http://www.inkid.net
 
*/

echo "	<div style='position:absolute;float:left;width:100%;margin-bottom:20px;z-index:30'>
			<div style='position:relative;float:left;'>
				<img src='imagens/logo1.png'>
			</div>
			
			<div id='regiao_seleciona' style='position:relative;float:left;width:180px;border:1px solid #F00;border-radius:6px;color:#FFF;padding:4px;font-size:1.5em;margin-left:16px;margin-top:25px;' onclick=\"display_div('regiao_seleciona','none');display_div('escolhe_regiao','block')\">
			São Paulo
			</div>
			
			<div id='escolhe_regiao' style='position:relative;float:left;width:428px;margin-left:16px;margin-top:25px;display:none'>
				<div style='position:relative;float:left;width:178px;background-color:#6A0000;border:2px solid #F00;border-bottom:0px;border-top-right-radius:6px;border-top-left-radius:6px;color:#FFF;padding:4px;font-size:1.5em;text-indent:4px'>
				Escolha sua cidade
				</div>
				<div style='position:relative;float:left;width:428px;'>
					<div style='position:relative;float:left;width:186px;height:2px;background-color:#FFF;border-left:2px solid #F00'>
					</div>
					<div style='position:relative;float:left;width:238px;height:2px;background-color:#FFF;border-right:2px solid #F00;border-top:2px solid #F00;border-top-right-radius:6px;margin-top:-2px'>
					</div>
					<div style='position:relative;float:left;width:424px;height:110px;background-color:#FFF;border-right:2px solid #F00;border-left:2px solid #F00;font-size:1.1em;font-weight:bold;color:#6A0000'>
						<div style='position:relative;float:left;width:31.3%;padding:1%;overflow:hidden'>
							São Paulo
						</div>
						<div style='position:relative;float:left;width:31.3%;padding:1%;overflow:hidden'>
							Rio de Janeiro
						</div>
						<div style='position:relative;float:left;width:31.3%;padding:1%;overflow:hidden'>
							Rio de Grande do Norte
						</div>
						<div style='position:relative;float:left;width:31.3%;padding:1%;overflow:hidden'>
							Santa Catarina
						</div>
					</div>
					<div style='position:relative;float:left;width:424px;height:10px;background-color:#6A0000;border:2px solid #F00;border-top:0px;border-bottom-right-radius:6px;border-bottom-left-radius:6px'>
					</div>
				</div>
			</div>";
			
			switch ($_GET[error]) {
            case("1"):
                echo "	<div id='box_error' onclick=\"display_div('box_error','none')\">
							Preencha todos os campos obrigatórios
						</div>";
                break;
            case("2"):
                echo "	<div id='box_error' onclick=\"display_div('box_error','none')\">
							Digite um título para a sua oferta
						</div>";
                break;
			case("3"):
                echo "	<div id='box_error' onclick=\"display_div('box_error','none')\">
							A data de ativação e de encerramento deve ser posterior à atual 
						</div>";
                break;
			case("4"):
                echo "	<div id='box_error' onclick=\"display_div('box_error','none')\">
							A data de encerramento deve ser posterior à data de ativação
						</div>";
                break;
			case("5"):
                echo "	<div id='box_error' onclick=\"display_div('box_error','none')\">
							O valor sem desconto deve ser maior do que o valor promocional
						</div>";
                break;
			case("6"):
                echo "	<div id='box_error' onclick=\"display_div('box_error','none')\">
							A quantidade máxima de cupons disponíveis deve ser maior que a quantidade mínima
						</div>";
                break;
			case("7"):
                echo "	<div id='box_error' onclick=\"display_div('box_error','none')\">
							A largura da imagem não deve ultrapassar 1500 pixels
						</div>";
                break;
			case("8"):
                echo "	<div id='box_error' onclick=\"display_div('box_error','none')\">
							Altura da imagem não deve ultrapassar 1800 pixels
						</div>";
                break;
			case("9"):
                echo "	<div id='box_error' onclick=\"display_div('box_error','none')\">
							A imagem deve ter no máximo 100000 bytes
						</div>";
                break;
			case("10"):
                echo "	<div id='box_error' onclick=\"display_div('box_error','none')\">
							Formato de imagem não reconhecido
						</div>";
                break;
            default:
                break;
        }
			
	echo "</div>";

?>