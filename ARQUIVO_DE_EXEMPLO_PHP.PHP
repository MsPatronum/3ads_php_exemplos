<?php
/*
*  ╔═══════════════════════╗
*  ║   QUE MAGIA É ESSA?   ║
*  ╚═══════════════════════╝
*   EXPLICAÇÕES NO FINAL DO ARQUIVO 
*
*/



// Variáveis

// Declaração e atribuição de valor a uma variável
$nome = "João";
$idade = 25;
$salario = 1500.50;

// Exibindo o conteúdo das variáveis
echo "Nome: " . $nome . "<br>";
echo "Idade: " . $idade . "<br>";
echo "Salário: " . $salario . "<br>";

// Funções

// Definindo uma função simples
function calcularSoma($a, $b) {
    return $a + $b;
}

// Chamando a função e exibindo o resultado
$resultado = calcularSoma(10, 5);
echo "Resultado da soma: " . $resultado . "<br>";

// Classes

// Definindo uma classe simples
class Pessoa {
    // Propriedades da classe
    public $nome;
    public $idade;
    
    // Método construtor
    public function __construct($nome, $idade) {
        $this->nome = $nome;
        $this->idade = $idade;
    }
    
    // Método da classe
    public function exibirDados() {
        echo "Nome: " . $this->nome . "<br>";
        echo "Idade: " . $this->idade . "<br>";
    }
}

// Criando uma instância da classe Pessoa
$pessoa = new Pessoa("Maria", 30);

// Chamando o método da classe para exibir os dados
$pessoa->exibirDados();


/*  
*   As variáveis são utilizadas para armazenar valores, como nome, idade e salário. 
*   Elas podem receber diferentes tipos de dados, como strings, números inteiros e números de ponto flutuante.
*   
*   As funções permitem agrupar um conjunto de instruções que podem ser chamadas em diferentes partes do 
*   programa. No exemplo, a função calcularSoma() recebe dois parâmetros, realiza a soma e retorna o resultado.
*   
*   As classes são estruturas utilizadas para criar objetos, que são instâncias das classes. No exemplo, a classe 
*   Pessoa possui propriedades como nome e idade, além de métodos como __construct() e exibirDados(). O método 
*   construtor é executado automaticamente ao criar um objeto da classe, enquanto o método exibirDados() exibe as 
*   informações da pessoa.
*
*   Ao criar uma instância de uma classe, o construtor é chamado automaticamente, permitindo que você defina o 
*   estado inicial dos objetos e execute qualquer lógica necessária antes deles serem utilizados. Isso é útil 
*   para garantir que os objetos tenham um estado consistente e estejam prontos para serem usados assim que são 
*   criados. Em PHP, o método construtor é definido utilizando o nome especial __construct() dentro da classe. Ele 
*   pode receber parâmetros, que são passados no momento da criação do objeto, permitindo que você configure as 
*   propriedades da classe com valores específicos.
*   
*/


?>