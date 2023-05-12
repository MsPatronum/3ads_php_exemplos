<?php

require_once('config/config.php');
require_once conexao;
// Modelo

/**
 * Classe responsável pelo modelo de dados relacionados aos clientes.
 * Estende a classe Database, que contém a lógica de conexão com o banco de dados.
 */
class ClienteModel extends Database
{
    protected $conn;
    
    /**
     * Obtém todos os clientes do banco de dados.
     * @return array Retorna um array contendo os clientes encontrados.
     */
    public function getAllClientes()
    {
        // Executa uma consulta SQL para obter todos os clientes da tabela "clientes"
        $stmt = $this->conn->query("SELECT * FROM clientes");
        
        // Retorna todos os resultados como um array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtém um cliente específico com base no seu ID.
     * @param $id ID do cliente a ser buscado.
     * @return array|false Retorna um array com os dados do cliente encontrado ou false se não for encontrado.
     */
    public function getClienteById($id) {
        // Prepara uma consulta SQL para obter um cliente específico com base no ID
        $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE id = :id");
        
        // Associa o valor do parâmetro :id ao valor fornecido
        $stmt->bindParam(':id', $id);
        
        // Executa a consulta
        $stmt->execute();
        
        // Retorna o resultado como um array associativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Insere um novo cliente no banco de dados.
     * @param $nome Nome do cliente.
     * @param $cpf CPF do cliente.
     * @param $telefone Telefone do cliente.
     */
    public function insertCliente($nome, $cpf, $telefone)
    {
        // Prepara uma consulta SQL para inserir um novo cliente na tabela "clientes"
        $stmt = $this->conn->prepare("INSERT INTO clientes (nome, cpf, telefone) VALUES (:nome, :cpf, :telefone)");
        
        // Associa os valores dos parâmetros aos valores fornecidos
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':telefone', $telefone);
        
        // Executa a consulta
        $stmt->execute();
    }

    /*  ╔══════════════════════════════╗
    *   ║   EXECUTANDO UMA PROCEDURE   ║
    *   ╚══════════════════════════════╝
    *   Para entender como funciona a execução por uma procedure, podemos fazer da seguinte forma:
    */
    public function insertClienteProcedure($nome, $cpf, $telefone){
        try {
            // Prepara uma chamada de procedure para inserir um novo cliente na tabela "clientes"
            $stmt = $this->conn->prepare("CALL P_inserirCliente (:nome, :cpf, :telefone)");
    
            // Associa os valores dos parâmetros aos valores fornecidos
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':telefone', $telefone);
    
            // Executa a chamada de procedure
            $stmt->execute();
            
            // Verifica se ocorreu algum erro na execução
            $error = $stmt->errorInfo();
            if ($error[0] !== '00000') {
                throw new Exception("Erro na execução da procedure: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Erro na execução da consulta: " . $e->getMessage();
        }
    }


    /**
     * Atualiza os dados de um cliente existente no banco de dados.
     * @param $id ID do cliente a ser atualizado.
     * @param $nome Novo nome do cliente.
     * @param $cpf Novo CPF do cliente.
     * @param $telefone Novo telefone do cliente.
     * @return bool Retorna true se a atualização foi bem-sucedida ou false caso contrário.
     */
    public function updateCliente($id, $nome, $cpf, $telefone) {
        // Define a consulta SQL para atualizar os dados do cliente com base no ID
        $query = "UPDATE clientes SET nome = :nome, cpf = :cpf, telefone = :telefone WHERE id = :id";
        
        // Prepara a consulta
        $stmt = $this->conn->prepare($query);
        
        // Associa os valores dos parâmetros aos valores fornecidos
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':telefone', $telefone);
        
        // Executa a consulta e retorna o resultado da execução
        return $stmt->execute();
    }

    /**
     * Exclui um cliente do banco de dados com base no seu ID.
     * @param $id ID do cliente a ser excluído.
     * @return bool Retorna true se a exclusão foi bem-sucedida ou false caso contrário.
     */
    public function excluirCliente($id) {
        try {
            // Prepara uma consulta SQL para excluir um cliente com base no ID
            $stmt = $this->conn->prepare("DELETE FROM clientes WHERE id = :id");
            
            // Associa o valor do parâmetro :id ao valor fornecido
            $stmt->bindParam(':id', $id);
            
            // Executa a consulta
            $stmt->execute();
            
            // Retorna true para indicar que a exclusão foi bem-sucedida
            return true;
        } catch(PDOException $e) {
            // Em caso de erro, exibe a mensagem de erro e retorna false
            echo "Erro na exclusão: " . $e->getMessage();
            return false;
        }
    }
}
