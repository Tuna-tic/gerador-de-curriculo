<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_POST['gerar_curriculo'])) {
    // 1. CAPTURA E TRATAMENTO DOS DADOS

    $nome = htmlspecialchars($_POST['nome'] ?? 'Nome Não Informado');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $nascimento = htmlspecialchars($_POST['nascimento'] ?? 'Não Informado');
    $telefone = htmlspecialchars($_POST['telefone'] ?? 'Não Informado');
    $endereco = htmlspecialchars($_POST['endereco'] ?? 'Não Informado');
    
    $caracteristica_profissional = htmlspecialchars($_POST['caracteristica_profissional'] ?? '');
    $formacao_academica = htmlspecialchars($_POST['formacao_academica'] ?? '');
    $cursos_adicionais = htmlspecialchars($_POST['cursos_adicionais'] ?? '');

    $empresas = $_POST['empresa'] ?? [];
    $cargos = $_POST['cargo'] ?? [];
    $exp_inicios = $_POST['inicio_exp'] ?? []; 
    $exp_fins = $_POST['fim_exp'] ?? [];
    $exp_descricoes = $_POST['descricao_exp'] ?? [];
    $exp_empresas = $empresas;
    $exp_cargos = $cargos;
    
    $idade = 'Não Informado';

    // Cálculo da Idade
    if (!empty($_POST['nascimento'])) {
        $data_nascimento = new DateTime($_POST['nascimento']);
        $hoje = new DateTime();
        $intervalo = $data_nascimento->diff($hoje);
        $idade = $intervalo->y . ' anos';
    }
    
    // 2. MONTAGEM DO HTML DO CURRÍCULO

    // A) DEFINIÇÃO DO CSS
    $css_curriculo = "
<style>
    /* ... (Seu CSS completo deve estar aqui) ... */
</style>
";

    // B) MONTAGEM DO HTML
    $html_curriculo = "
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <title>{$nome} - Currículo</title>
    {$css_curriculo} 
</head>
<body>
    <div class='curriculo-output'>
        <h2 style='text-align: center;'>{$nome}</h2>
        
        <p class='contato' style='text-align: center;'>
            {$email} | 
            {$telefone} | 
            {$idade} |
            {$endereco}
        </p>
        
        <h3>Resumo Profissional</h3>
        <p>{$caracteristica_profissional}</p>
        
        <h3>Formação Acadêmica</h3>
        <p>{$formacao_academica}</p>
        
        <h3>Cursos e Certificações</h3>
        <p>{$cursos_adicionais}</p>
        
        <h3>Experiência Profissional</h3>
        <ul>
";

// Loop para Experiências
for ($i = 0; $i < count($exp_cargos); $i++) {
    $html_curriculo .= "
        <li>
            <div class='experiencia-titulo'>{$exp_cargos[$i]} em {$exp_empresas[$i]}</div>
            <div class='experiencia-detalhe'>{$exp_inicios[$i]} - {$exp_fins[$i]}</div>
            <p>{$exp_descricoes[$i]}</p>
        </li>
    ";
}

$html_curriculo .= "
        </ul>
        
        </div>
</body>
</html>
";

    // 3. CONFIGURAÇÃO E GERAÇÃO DO PDF

    $options = new Options();
    $options->set('isRemoteEnabled', TRUE); 
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html_curriculo);

    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    if (ob_get_contents()) {
        ob_end_clean();
    }
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="curriculo_gerado.pdf"');

    echo $dompdf->output();

    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Currículo</title>

    <meta name="color-scheme" content="light">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
    
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

    <div class="container my-5">
        <h1 class="text-center mb-4 text-primary">Gerador de Currículo Profissional</h1>
        <p class="text-center text-muted">Preencha os dados abaixo e clique em Gerar Currículo.</p>

        <form action="index.php" method="POST" class="p-4 shadow-lg rounded bg-white" onsubmit="return false;">
            
            <fieldset class="border p-3 mb-4 rounded">
                <legend class="h4 text-primary">Dados Pessoais</legend>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-md-4">
                        <label for="nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="nascimento" name="nascimento">
                    </div>
                    <div class="col-md-4">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX">
                    </div>
                    <div class="col-md-4">
                        <label for="endereco" class="form-label">Endereço (Cidade/Estado)</label>
                        <input type="text" class="form-control" id="endereco" name="endereco">
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-3 mb-4 rounded">
                <legend class="h4 text-primary">Resumo Profissional</legend>
                <div class="mb-3">
                    <label for="caracteristica_profissional" class="form-label">Resumo e Objetivos</label>
                    <textarea class="form-control" id="caracteristica_profissional" name="caracteristica_profissional" rows="4" placeholder="Breve descrição de suas qualificações, objetivos e área de interesse."></textarea>
                </div>
            </fieldset>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <fieldset class="border p-3 rounded h-100">
                        <legend class="h4 text-primary">Formação Acadêmica</legend>
                        <label for="formacao_academica" class="form-label">Descrição da Formação</label>
                        <textarea class="form-control" id="formacao_academica" name="formacao_academica" rows="4" placeholder="Ex: Bacharel em Sistemas de Informação - UFPE (2018 - 2022)"></textarea>
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset class="border p-3 rounded h-100">
                        <legend class="h4 text-primary">Cursos e Certificações</legend>
                        <label for="cursos_adicionais" class="form-label">Detalhes</label>
                        <textarea class="form-control" id="cursos_adicionais" name="cursos_adicionais" rows="4" placeholder="Liste cursos, workshops e certificações relevantes."></textarea>
                    </fieldset>
                </div>
            </div>

            <fieldset class="border p-3 mb-4 rounded">
                <legend class="h4 text-primary">Experiência Profissional</legend>
                
                <div id="experiencias-container" class="mb-3">
                    </div>
                
                <button type="button" class="btn btn-outline-success btn-sm w-100" id="add-experiencia">
                    <i class="fas fa-plus"></i> Adicionar Experiência
                </button>
            </fieldset>

            <div class="d-grid mt-4">
                <button type="button" id="btn-gerar-pdf" class="btn btn-lg btn-primary">
                    Gerar Currículo (Download JS)
                </button>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
            crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>

</body>
</html>