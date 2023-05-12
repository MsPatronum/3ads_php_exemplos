<?php
// Visualização

class ClienteView
{
    public function showClientes($clientes)
    {
        // Exibe o cabeçalho da tabela
        echo '<h2>Lista de Clientes</h2>';
        echo '<table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Ação</th>
                </tr>';
        
        // Itera sobre a lista de clientes e exibe cada um como uma linha da tabela
        foreach ($clientes as $cliente) {
            echo '<tr>';
            echo '<td>' . $cliente['id'] . '</td>';
            echo '<td>' . $cliente['nome'] . '</td>';
            echo '<td>' . $cliente['cpf'] . '</td>';
            echo '<td>' . $cliente['telefone'] . '</td>';
            echo '<td><a href="index.php?route=cliente&&action=edit&cliente_id=' . $cliente['id'] . '">Editar</a> | <a href="index.php?route=cliente&&action=delete&cliente_id=' . $cliente['id'] . '">Excluir</a></td>';
            ;
            echo '</tr>';
        }
        
        // Fecha a tabela
        echo '</table>';
        
        // Exibe um link para adicionar um novo cliente
        echo '<br>';
        echo '<a href="index.php?route=cliente&&action=insert">Adicionar Cliente</a><br>';
        echo '<a href="index.php?route=cliente&&action=insertprocedure">Adicionar Cliente Procedure</a>';
    }
    
    public function showInsertForm()
    {
        // Exibe o formulário para inserir um novo cliente
        echo '<h2>Adicionar Cliente</h2>';
        echo '<form method="POST" action="index.php?route=cliente&&action=insert">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required><br><br>
                
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required><br><br>
                
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" required><br><br>
                
                <input type="submit" value="Inserir">
            </form>';
    }
    public function showInsertFormProcedure()
    {
        // Exibe o formulário para inserir um novo cliente
        echo '<h2>Adicionar Cliente</h2>';
        echo '<form method="POST" action="index.php?route=cliente&&action=insertprocedure">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required><br><br>
                
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required><br><br>
                
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" required><br><br>
                
                <input type="submit" value="Inserir">
            </form>';
    }

    public function showEditForm($cliente) {
        // Exibe o formulário para editar um cliente existente
        echo '<h2>Editar Cliente</h2>';
        echo '<form method="POST" action="index.php?route=cliente&&action=update">
                <input type="hidden" name="id" value="' . $cliente['id'] . '">
                <label>Nome:</label>
                <input type="text" name="nome" value="' . $cliente['nome'] . '"><br>
                <label>CPF:</label>
                <input type="text" name="cpf" value="' . $cliente['cpf'] . '"><br>
                <label>Telefone:</label>
                <input type="text" name="telefone" value="' . $cliente['telefone'] . '"><br>
                <input type="submit" value="Salvar">
            </form>';
    }
}
?>


