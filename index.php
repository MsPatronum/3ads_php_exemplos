<?php

/*
*  ╔══════════════════════════════════════════════════╗
*  ║   ONDE ESTOU? PRA ONDE VOU? O QUE É TUDO ISSO?   ║
*  ╚══════════════════════════════════════════════════╝
*   
*   Para ensinar PHP para todos vocês, utilizarei o modelo Model View Controller que funciona da seguinte forma:
*   O MVC separa o aplicativo em três componentes principais: o modelo (model), a visão (view) e o 
*   controlador (controller). O modelo representa os dados do aplicativo, a visão é responsável por exibir a 
*   interface do usuário e o controlador gerencia as interações do usuário e coordena as operações do modelo e da visão.
*
*   A estrutura que utilizaremos será essa. Os códigos serão todos separados nas pastas correspondentes e tudo se encontra
*   nesse arquivo aqui!
*
*   Neste código, implementamos um roteador simples !!!!!E QUE NÃO DEVE SER USADO EM SISTEMAS EM PRODUÇÃO!!!!! que mapeia as 
*   "rotas" da URL para os controladores, modelos e visualizações correspondentes para facilitar o envio de requisições entre 
*   um arquivo e outro.
*
*   Vocês devem procurar por um framework ou um estudo mais aprofundado de rotas!
*/

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>

    <?php

        /*  
        *  ╔═════════════════════════════════════╗
        *  ║   INCLUDE, REQUIRE e REQUIRE_ONCE   ║
        *  ╚═════════════════════════════════════╝
        *  
        *   include: O include é usado para incluir um arquivo PHP no script atual. Se o arquivo não for encontrado, o PHP 
        *   emitirá um aviso (warning) e continuará a execução do script. Se múltiplas inclusões do mesmo arquivo forem feitas, 
        *   o PHP irá incluí-lo novamente, gerando um aviso de redeclaração caso haja conflito de definições.
        *
        *   require: O require é semelhante ao include, mas trata a inclusão de arquivos como uma operação obrigatória. Se o 
        *   arquivo especificado não for encontrado, o PHP emitirá um erro fatal (fatal error) e interromperá a execução do script. 
        *   Assim como o include, o require também permite múltiplas inclusões do mesmo arquivo, podendo gerar erros de redeclaração.
        *
        *   require_once: O require_once é uma variação do require que garante que um arquivo seja incluído apenas uma vez, 
        *   independentemente de quantas vezes a inclusão seja solicitada. Ele verifica se o arquivo já foi incluído anteriormente e, 
        *   se sim, não o inclui novamente. Essa construção é útil para evitar problemas de redeclaração de funções ou classes.
        *
        */


        include 'include/header.php';
        require_once 'controller/ClienteController.php';

        // Obtém a rota da URL
        /*  
        *  ╔════════════════════════════════════╗
        *  ║   VARIÁVEIS GLOBAIS $GET E $POST   ║
        *  ╚════════════════════════════════════╝
        * 
        *   $_GET e $_POST são arrays superglobais no PHP usados para coletar dados enviados de um formulário HTML. A diferença 
        *   entre os dois é que o $_GET envia dados através da URL, enquanto o $_POST envia dados no corpo da solicitação HTTP. 
        *   O uso de $_GET é mais adequado para solicitar dados do servidor, enquanto o $_POST é mais apropriado para enviar 
        *   informações confidenciais, como senhas, para o servidor. Em ambos os casos, os dados são acessíveis em qualquer lugar 
        *   do código e são acessados através de suas chaves no array associativo.
        *   Utilizamos essas variáveis para transportar informações de um arquivo para outro no PHP via formulário.
        *   
        */
        $route = $_GET['route'] ?? 'home';


        /*
        *   Nessa parte, são definidos três arrays associativos: $route_controller, $route_model e $route_view. 
        *   Eles mapeiam as rotas da URL para os controladores, modelos e visualizações correspondentes. Por exemplo, 
        *   a rota "home" está associada ao controlador "HomeController", modelo "HomeModel" e visualização "HomeView".
        */

        // Mapeia as rotas para os controladores correspondentes
        $route_controller = [
            'home' => 'HomeController',
            'cliente' => 'ClienteController',
            'produto' => 'ProdutoController',
            // Adicione mais rotas conforme necessário
        ];
        $route_model = [
            'cliente' => 'ClienteModel',
            'produto' => 'ProdutoModel',
            // Adicione mais rotas conforme necessário
        ];
        $route_view = [
            'home' => 'HomeView',
            'cliente' => 'ClienteView',
            'produto' => 'ProdutoView',
            // Adicione mais rotas conforme necessário
        ];

        /*
        *   Nessa parte, verificamos se a rota fornecida na URL existe nos arrays de mapeamento. Se existir, obtém-se o nome do controlador, 
        *   modelo e visualização correspondentes. Em seguida, são incluídos os arquivos do controlador, modelo e visualização correspondentes. 
        *   Esses arquivos contêm as definições das classes. Após a inclusão dos arquivos, criamos as instâncias do controlador, modelo e 
        *   visualização. Para isso, utilizamos o 'new' seguido pelos nomes das classes obtidos anteriormente. Por fim, chamamos o método 
        *   handleRequest() no controlador, passando a ação apropriada. A ação é obtida a partir da variável $_GET['action'], que representa a 
        *   ação solicitada.
        *   Se nada disso estiver em acordo, é apresentada a informação "Rota inválida!".
        */

        // Verifica se a rota existe
        /*  aqui estamos verificando se na variável existe o valor de rota que estamos buscando, só conseguimos enviar e receber informações 
        *   se todas essas informações voltarem TRUE
        *   EX: Se estamos passando a rota CLIENTE o sistema buscará da seguinte forma:
        *   verifique na variável $route_controller se o valor CLIENTE está lá dentro. Tudo o que fica entre chaves [] é o valor que buscamos
        *   na variável:  $route_controller['CLIENTE'] 
        */
        if (isset($route_controller[$route]) && isset($route_model[$route]) && isset($route_view[$route])) {
            // Obtém o nome do controlador correspondente
            $controllerName = $route_controller[$route];
            $modelName = $route_model[$route];
            $viewName = $route_view[$route];
            
            // Inclui os arquivos do controlador, modelo e visualização
            // Aqui estamos concatenando os valores 'controller/[NOME DO CONTROLLER].php
            require_once 'controller/' . $controllerName . '.php';
            require_once 'model/' . $modelName . '.php';
            require_once 'view/' . $viewName . '.php';

            // Cria as instâncias do controlador, modelo e visulização
            $model = new $modelName();
            $controller = new $controllerName($model);
            $view = new $viewName($controller, $model);

            // Chama o método apropriado no controlador
            // aqui verificamos se existe uma ação sendo passada, caso não exista, a ação INDEX é exibida. Poderíamos modificar isso e retornar uma página de erro
            $action = isset($_GET['action']) ? $_GET['action'] : 'index';
            $controller->handleRequest($action);

        } elseif (isset($route_controller[$route]) && $route=='home'){

            // Obtém o nome do controlador correspondente
            $controllerName = $route_controller[$route];
            $viewName = $route_view[$route];
            
            // Inclui os arquivos do controlador, modelo e visualização
            require_once 'controller/' . $controllerName . '.php';
            require_once 'view/' . $viewName . '.php';

            // Cria as instâncias do controlador, modelo e visulização
            $controller = new $controllerName();
            $view = new $viewName($controller);

            // Chama o método apropriado no controlador
            $action = isset($_GET['action']) ? $_GET['action'] : 'index';
            $controller->handleRequest($action);


        } else {
            // Rota inválida
            echo 'Rota inválida!';
        }
    ?>


</body>
</html>



