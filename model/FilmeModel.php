<?php

require_once('config/config.php');
require_once conexao;
// Modelo

/**
 * Classe responsável pelo modelo de dados relacionados aos filme.
 * Estende a classe Database, que contém a lógica de conexão com o banco de dados.
 */
class FilmeModel extends Database
{
    protected $conn;
    
    /**
     * Obtém todos os filmes do banco de dados.
     * @return array Retorna um array contendo os filmes encontrados.
     */
    public function getAllFilmes()
    {
        // Executa uma consulta SQL para obter todos os filmes da tabela "filmes"
        $stmt = $this->conn->query("SELECT * FROM filmes");
        
        // Retorna todos os resultados como um array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
