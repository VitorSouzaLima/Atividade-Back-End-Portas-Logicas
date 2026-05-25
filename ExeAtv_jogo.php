<?php
// Define os valores iniciais padrão caso a página acabe de ser aberta
$inputA = isset($_POST['inputA']) ? (int)$_POST['inputA'] : 1;
$inputB = isset($_POST['inputB']) ? (int)$_POST['inputB'] : 0;
$inputC = isset($_POST['inputC']) ? (int)$_POST['inputC'] : 1;

$gate1 = isset($_POST['gate1']) ? $_POST['gate1'] : 'AND';
$gate2 = isset($_POST['gate2']) ? $_POST['gate2'] : 'OR';

// Função para processar as portas lógicas
function calcularPorta($porta, $a, $b) {
    switch ($porta) {
        case 'AND': return ($a && $b) ? 1 : 0;
        case 'OR':  return ($a || $b) ? 1 : 0;
        case 'XOR': return ($a ^ $b) ? 1 : 0;
        case 'NOT': return (!$a) ? 1 : 0; // NOT inverte apenas a primeira entrada
        default: return 0;
    }
}

// Executa os cálculos do circuito interativo
$resultadoMeio = calcularPorta($gate1, $inputA, $inputB);
$resultadoFinal = calcularPorta($gate2, $resultadoMeio, $inputC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Circuito Lógico</title>
    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --text-color: #f8fafc;
            --primary: #38bdf8;
            --success: #22c55e;
            --danger: #ef4444;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: var(--primary);
            margin-bottom: 5px;
        }

        .instrucoes {
            color: #94a3b8;
            margin-bottom: 35px;
            text-align: center;
            max-width: 600px;
        }

        /* Estilização do Circuito */
        .circuito-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            background: var(--card-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .coluna {
            display: flex;
            flex-direction: column;
            gap: 30px;
            align-items: center;
        }

        .rotulo {
            font-size: 0.8rem;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: -25px;
            z-index: 1;
        }

        /* Selects estilizados para Entradas e Portas */
        select {
            background-color: #0f172a;
            color: var(--text-color);
            border: 2px solid #475569;
            padding: 10px 15px;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            outline: none;
            transition: 0.3s;
            text-align: center;
        }

        /* Cores dinâmicas para os selects de entrada baseados no valor */
        select.entrada-1 { border-color: var(--success); color: var(--success); }
        select.entrada-0 { border-color: #64748b; color: #94a3b8; }

        select.porta {
            border-color: var(--primary);
            color: var(--primary);
        }

        select:hover {
            opacity: 0.9;
        }

        .linha-conexao {
            color: #475569;
            font-weight: bold;
            font-size: 1.5rem;
        }

        /* Display de Saída */
        .bit-saida {
            font-weight: bold;
            font-size: 1.6rem;
            padding: 15px 30px;
            border-radius: 6px;
            min-width: 50px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            transition: 0.3s;
        }

        .saida-1 { background-color: var(--success); color: white; box-shadow: 0 0 15px rgba(34, 197, 94, 0.4); }
        .saida-0 { background-color: #475569; color: #cbd5e1; }
    </style>
</head>
<body>

    <h1>Simulador de Circuito Lógico ⚡</h1>
    <p class="instrucoes">Mude livremente as entradas (A, B, C) e as portas lógicas. O circuito calcula o resultado automaticamente a cada clique!</p>

    <form method="POST" action="" id="circuitoForm">
        <div class="circuito-container">
            
            <div class="coluna">
                <span class="rotulo">Entrada A</span>
                <select name="inputA" class="entrada-<?php echo $inputA; ?>" onchange="this.form.submit()">
                    <option value="1" <?php if($inputA == 1) echo 'selected'; ?>>1 (Ligado)</option>
                    <option value="0" <?php if($inputA == 0) echo 'selected'; ?>>0 (Desligado)</option>
                </select>

                <span class="rotulo">Entrada B</span>
                <select name="inputB" class="entrada-<?php echo $inputB; ?>" onchange="this.form.submit()">
                    <option value="1" <?php if($inputB == 1) echo 'selected'; ?>>1 (Ligado)</option>
                    <option value="0" <?php if($inputB == 0) echo 'selected'; ?>>0 (Desligado)</option>
                </select>
            </div>

            <div class="linha-conexao"> ➔ </div>

            <div class="coluna">
                <span class="rotulo">Porta 1</span>
                <select name="gate1" class="porta" onchange="this.form.submit()">
                    <option value="AND" <?php if($gate1 == 'AND') echo 'selected'; ?>>AND</option>
                    <option value="OR" <?php if($gate1 == 'OR') echo 'selected'; ?>>OR</option>
                    <option value="XOR" <?php if($gate1 == 'XOR') echo 'selected'; ?>>XOR</option>
                    <option value="NOT" <?php if($gate1 == 'NOT') echo 'selected'; ?>>NOT (Só de A)</option>
                </select>
            </div>

            <div class="linha-conexao"> ➔ </div>

            <div class="coluna">
                <span class="rotulo" style="margin-bottom:-5px;">Intermediário</span>
                <div class="bit-saida saida-<?php echo $resultadoMeio; ?>" style="font-size: 1.1rem; padding: 10px 20px;">
                    <?php echo $resultadoMeio; ?>
                </div>

                <span class="rotulo">Entrada C</span>
                <select name="inputC" class="entrada-<?php echo $inputC; ?>" onchange="this.form.submit()">
                    <option value="1" <?php if($inputC == 1) echo 'selected'; ?>>1 (Ligado)</option>
                    <option value="0" <?php if($inputC == 0);