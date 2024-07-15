<?php
session_start();

// Inicializa os alunos se não existir
if (!isset($_SESSION['alunos'])) {
    $_SESSION['alunos'] = [];
}

// Função para calcular média e resultado
function calcularResultado($notas) {
    $total = array_sum($notas);
    $media = $total / count($notas);
    return [$total, $media];
}

// Função para mostrar menu
function mostrarMenu() {
    echo "1. Cadastrar Aluno\n";
    echo "2. Atribuir Notas\n";
    echo "3. Mostrar Resultados\n";
    echo "0. Sair\n";
}

// Loop principal
while (true) {
    mostrarMenu();
    $opcao = intval(trim(fgets(STDIN)));

    if ($opcao === 1) {
        if (count($_SESSION['alunos']) < 5) {
            echo "Nome do Aluno: ";
            $nome = trim(fgets(STDIN));
            $_SESSION['alunos'][] = ['nome' => $nome, 'notas' => []];
            echo "Aluno cadastrado: $nome\n";
        } else {
            echo "Limite de 5 alunos alcançado!\n";
        }
    } elseif ($opcao === 2) {
        if (empty($_SESSION['alunos'])) {
            echo "Nenhum aluno cadastrado!\n";
            continue;
        }
        echo "Escolha o aluno (0 a " . (count($_SESSION['alunos']) - 1) . "): ";
        $index = intval(trim(fgets(STDIN)));

        if (isset($_SESSION['alunos'][$index])) {
            echo "Atribuindo notas para: " . $_SESSION['alunos'][$index]['nome'] . "\n";
            for ($i = 1; $i <= 4; $i++) {
                do {
                    echo "Nota $i (0 a 10): ";
                    $nota = floatval(trim(fgets(STDIN)));
                } while ($nota < 0 || $nota > 10);
                $_SESSION['alunos'][$index]['notas'][] = $nota;
            }
            echo "Notas atribuídas!\n";
        } else {
            echo "Aluno inválido!\n";
        }
    } elseif ($opcao === 3) {
        foreach ($_SESSION['alunos'] as $aluno) {
            list($total, $media) = calcularResultado($aluno['notas']);
            $status = $media < 4 ? 'Reprovado' : ($media <= 6 ? 'Recuperação' : 'Aprovado');
            echo "{$aluno['nome']} - Total: $total, Média: $media, Status: $status\n";
        }
    } elseif ($opcao === 0) {
        echo "Saindo...\n";
        break;
    } else {
        echo "Opção inválida!\n";
    }
}
?>
