<?php
// Controlador

class ClienteController
{
    // Declaração da propriedade $model, que armazena uma instância do modelo relacionado ao controlador.
    private $model;

    /**
     * Construtor da classe ClienteController.
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
                // Se a ação for 'list', obtém todos os clientes do modelo
                $clientes = $this->model->getAllClientes();
                
                // Chama o método listClientes(), passando a lista de clientes como argumento
                $this->listClientes($clientes);
                
                // Desconecta o modelo do banco de dados
                $this->model->disconnect(); 
                break;
                
            case 'insert':
                // Se a ação for 'insert' e o método da requisição for POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Obtém os dados do cliente a partir dos parâmetros da requisição
                    $nome = $_POST['nome'];
                    $cpf = $_POST['cpf'];
                    $telefone = $_POST['telefone'];
                    
                    // Chama o método insertCliente() do modelo, passando os dados do cliente
                    $this->model->insertCliente($nome, $cpf, $telefone);
                    
                    // Após a inserção, obtém novamente a lista de clientes atualizada
                    // chamando o método getAllClientes() do modelo
                    $this->listClientes($this->model->getAllClientes());
                } else {
                    // Se o método da requisição não for POST, chama o método showInsertForm()
                    // para exibir o formulário de inserção de clientes
                    $this->showInsertForm();
                }
                break;
            case 'insertprocedure':
                // Se a ação for 'insert' e o método da requisição for POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Obtém os dados do cliente a partir dos parâmetros da requisição
                    $nome = $_POST['nome'];
                    $cpf = $_POST['cpf'];
                    $telefone = $_POST['telefone'];
                    
                    // Chama o método insertCliente() do modelo, passando os dados do cliente
                    $this->model->insertClienteProcedure($nome, $cpf, $telefone);
                    
                    // Após a inserção, obtém novamente a lista de clientes atualizada
                    // chamando o método getAllClientes() do modelo
                    $this->listClientes($this->model->getAllClientes());
                } else {
                    // Se o método da requisição não for POST, chama o método showInsertForm()
                    // para exibir o formulário de inserção de clientes
                    $this->showInsertFormProcedure();
                }
            break;
                
            case 'edit':
                // Se a ação for 'edit' e o método da requisição for GET e o parâmetro cliente_id estiver definido
                if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cliente_id'])) {
                    // Obtém o ID do cliente a partir dos parâmetros da requisição
                    $clienteId = $_GET['cliente_id'];
                    
                    // Chama o método getClienteById() do modelo, passando o ID do cliente
                    $cliente = $this->model->getClienteById($clienteId);
                    
                    if ($cliente) {
                        // Se o cliente for encontrado, chama o método showEditForm()
                        // para exibir o formulário de edição do cliente
                        $this->showEditForm($cliente);
                    } else {
                        // Caso contrário, exibe a mensagem de 'Cliente não encontrado!'
                        echo 'Cliente não encontrado!';
                    }
                }
                break;
                
            case 'update':
                // Se a ação for 'update' e o método da requisição for POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Obtém os dados do cliente a partir dos parâmetros da requisição
                    $id = $_POST['id'];
                    $nome = $_POST['nome'];
                    $cpf = $_POST['cpf'];
                    $telefone = $_POST['telefone'];
                    
                    // Chama o método updateCliente() do modelo, passando os dados atualizados do cliente
                    $this->model->updateCliente($id, $nome, $cpf, $telefone);
                }
                
                // Após a atualização, obtém novamente a lista de clientes atualizada
                // chamando o método getAllClientes() do modelo
                $this->listClientes($this->model->getAllClientes());
                break;
                
            case 'delete':
                // Se a ação for 'delete' e o método da requisição for GET e o parâmetro cliente_id estiver definido
                if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cliente_id'])) {
                    // Obtém o ID do cliente a partir dos parâmetros da requisição
                    $clienteId = $_GET['cliente_id'];
                    
                    // Chama o método excluirCliente() do modelo, passando o ID do cliente a ser excluído
                    $this->model->excluirCliente($clienteId);
                }
                
                // Obtém novamente a lista de clientes atualizada após a exclusão,
                // chamando o método getAllClientes() do modelo
                $clientes = $this->model->getAllClientes();
                
                // Chama o método listClientes(), passando a lista de clientes atualizada como argumento
                $this->listClientes($clientes);
                break;
                
            default:
                // Se a ação não corresponder a nenhuma das ações definidas, exibe a mensagem de 'Ação inválida!'
                echo 'Ação inválida!';
                break;
        }
    }
    
   /**
     * Exibe a lista de clientes na interface do usuário.
     * @param $clientes Lista de clientes a ser exibida.
     */
    public function listClientes($clientes)
    {
        // Cria uma nova instância da classe ClienteView, passando o controlador e o modelo como argumentos
        $view = new ClienteView($this, $this->model);
        
        // Chama o método showClientes() da classe ClienteView, passando a lista de clientes como argumento
        $view->showClientes($clientes);
    }

    /**
     * Exibe o formulário de inserção de clientes na interface do usuário.
     */
    public function showInsertForm()
    {
        // Cria uma nova instância da classe ClienteView, passando o controlador e o modelo como argumentos
        $view = new ClienteView($this, $this->model);
        
        // Chama o método showInsertForm() da classe ClienteView
        $view->showInsertForm();
    }

    public function showInsertFormProcedure()
    {
        // Cria uma nova instância da classe ClienteView, passando o controlador e o modelo como argumentos
        $view = new ClienteView($this, $this->model);
        
        // Chama o método showInsertForm() da classe ClienteView
        $view->showInsertFormProcedure();
    }

    /**
     * Exibe o formulário de edição de um cliente específico na interface do usuário.
     * @param $cliente Dados do cliente a serem exibidos no formulário.
     */
    public function showEditForm($cliente)
    {
        // Cria uma nova instância da classe ClienteView, passando o controlador e o modelo como argumentos
        $view = new ClienteView($this, $this->model);
        
        // Chama o método showEditForm() da classe ClienteView, passando os dados do cliente como argumento
        $view->showEditForm($cliente);
    }
}
