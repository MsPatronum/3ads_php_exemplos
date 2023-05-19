<?php
// Controlador

class FilmeController
{
    // Declaração da propriedade $model, que armazena uma instância do modelo relacionado ao controlador.
    private $model;

    /**
     * Construtor da classe FilmeController.
     * Recebe uma instância do modelo como parâmetro e atribui à propriedade $model.
     * @param $model Instância do modelo relacionado ao controlador.
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    
    /**
     * Manipula a requisição recebida pelo controlador com base na ação especificada.
     * @param $action Ação a ser executada pelo controlador.
     */
    public function handleRequest($action)
    {
        // Utiliza uma estrutura switch para determinar qual ação será executada
        switch ($action) {
            case 'list':
                // Se a ação for 'list', obtém todos os filmes do modelo
                $filmes = $this->model->getAllFilmes();
                
                // Chama o método listfilmes(), passando a lista de filmes como argumento
                $this->listFilmes($filmes);
                
                // Desconecta o modelo do banco de dados
                $this->model->disconnect(); 
                break;
                
            default:
                // Se a ação não corresponder a nenhuma das ações definidas, exibe a mensagem de 'Ação inválida!'
                echo 'Ação inválida!';
                break;
        }
    }
    
   /**
     * Exibe a lista de filmes na interface do usuário.
     * @param $filmes Lista de filmes a ser exibida.
     */
    public function listFilmes($filmes)
    {
        // Cria uma nova instância da classe FilmeView, passando o controlador e o modelo como argumentos
        $view = new FilmeView($this, $this->model);
        
        // Chama o método showFilmes() da classe FilmeView, passando a lista de filmes como argumento
        $view->showFilmes($filmes);
    }
}
