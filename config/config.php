<?php 
/*
*  ╔═══════════════════════╗
*  ║   QUE MAGIA É ESSA?   ║
*  ╚═══════════════════════╝
*   Este é o arquivo que utilizaremos para configurar nosso ambiente de desenvolvimento.
*   Sintam-se livres para utilizá-lo em outros projetos PHP.
*
*   Aqui temos a definição de algumas variáveis globais para o nosso sistema. Essas variáveis
*   se comportam de uma forma um pouco diferente. 
*   Ao invés de chamá-las com o sinal de cifrão ($), apenas chamaremos o nome da variável após
*   o include dessas configurações em nosso arquivo de trabalho atual.
*/

define('raiz',$_SERVER['DOCUMENT_ROOT'].'/3ads_php_exemplos');   // Aqui definimos a URL base do nosso site
define('img_raiz', raiz.'/images');                         // Caso exista alguma que deverá ser armazenada 
                                                            // em nosso servidor, faremos o apontamento por aqui
define('conexao',raiz.'/config/conexao.php');               // conexao padrão do site com o banco de dados
define('funcoes',raiz.'/includes/funcoes.php');             // arquivo de funcoes a serem acessadas no sistema todo
date_default_timezone_set("America/Sao_Paulo");             // definindo DATETIME para nosso site
?>