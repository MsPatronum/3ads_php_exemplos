<?php

/*
*  ╔═══════════════════════╗
*  ║   QUE MAGIA É ESSA?   ║
*  ╚═══════════════════════╝
*   Esse é o arquivo que utilizaremos para estabelecer a conexão com nosso banco de dados.
*   Aqui definimos uma classe para essa conexão de onde todos os nossos MODELs farão a extensão.
*   Isso acontece pois quando fazemos a extensão em uma classe, utilizamos ela como base e 
*   adicionamos mais informações por cima, portanto, as classes que fizerem extensão de database
*   terão acesso às informações que estão descritas aqui mais as informações da propria classe.
*/


/**
 * Classe para gerenciar a conexão com o banco de dados.
 */
class Database {
  private $servername = "localhost"; // Nome do servidor de banco de dados
  private $username = "root"; // Nome de usuário do banco de dados
  private $password = ""; // Senha do banco de dados
  private $dbname = "cinema"; // Nome do banco de dados

  protected $conn; // Objeto de conexão com o banco de dados
  
  /**
   * Construtor da classe Database.
   * Cria uma nova instância de PDO para estabelecer a conexão com o banco de dados.
   */
  public function __construct() {
      try {
          // Cria a conexão com o banco de dados usando PDO
          $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
          // Define o modo de tratamento de erros como EXCEPTION para lançar exceções em caso de erro
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
          // Em caso de erro na conexão, exibe a mensagem de erro
          echo "Erro na conexão: " . $e->getMessage();
      }
  }

  /**
   * Função para desconectar do banco de dados.
   * Fecha a conexão com o banco de dados ao atribuir o valor nulo.
   */
  public function disconnect() {
    $this->conn = null;
  }
}


?>