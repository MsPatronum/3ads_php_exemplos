<?php
// Visualização

class FilmeView
{
    public function showFilmes($filmes)
    {
        // Exibe o cabeçalho da tabela
        echo '<h2>Lista de Filmes</h2>';
        echo '<table>
                <tr>
                    <th>ID</th>
                    <th>TITULO</th>
                    <th>DURAÇÃO</th>
                    <th>CLASSIFICAÇÃO INDICATIVA</th>
                    <th>GÊNERO</th>
                    <th>DIRETOR</th>
                    <th>SINOPSE</th>
                </tr>';
        
        // Itera sobre a lista de filmes e exibe cada um como uma linha da tabela
        foreach ($filmes as $filme) {
            echo '<tr>';
            echo'<td>'.$filme['id'].'</td>';
            echo'<td>'.$filme['titulo'].'</td>';
            echo'<td>'.$filme['duracao'].'</td>';
            echo'<td>'.$filme['classificacao_indicativa'].'</td>';
            echo'<td>'.$filme['genero'].'</td>';
            echo'<td>'.$filme['diretor'].'</td>';
            echo'<td>'.$filme['sinopse'].'</td>';
            echo '</tr>';
        }
        
        // Fecha a tabela
        echo '</table>';
        
    }
}
?>


