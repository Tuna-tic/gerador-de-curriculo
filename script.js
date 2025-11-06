$(document).ready(function() {

    // 1. TEMPLATE DE EXPERIÊNCIAS DINÂMICAS

    function getExperienciaTemplate() {
  
        return `
            <div class="experiencia-item p-3 mb-3 border rounded bg-light">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Empresa</label>
                        <input type="text" class="form-control" name="empresa[]" placeholder="Nome da Empresa" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Cargo</label>
                        <input type="text" class="form-control" name="cargo[]" placeholder="Seu Cargo" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Início</label>
                        <input type="month" class="form-control" name="inicio_exp[]" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fim (ou Atual)</label>
                        <input type="month" class="form-control" name="fim_exp[]">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descrição das Atividades</label>
                        <textarea class="form-control" name="descricao_exp[]" rows="3" placeholder="Principais responsabilidades e resultados."></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-3 remove-experiencia">Remover</button>
            </div>
        `;
    }

    // Adiciona o primeiro item de experiência ao carregar
    $('#experiencias-container').append(getExperienciaTemplate());

    // 2. LÓGICA DE ADICIONAR E REMOVER EXPERIÊNCIA

    // Adicionar Experiência
    $('#add-experiencia').click(function() {
        $('#experiencias-container').append(getExperienciaTemplate());
    });

    // Remover Experiência
    $(document).on('click', '.remove-experiencia', function() {
        // Impede a remoção se for o único item
        if ($('.experiencia-item').length > 1) {
            $(this).closest('.experiencia-item').remove();
        } else {
            alert("É necessário manter pelo menos uma seção de experiência.");
        }
    });

    // 3. LÓGICA DE GERAÇÃO DO PDF

    $('#btn-gerar-pdf').click(function() {
        const form = $('form')[0];
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Gerando...');

        const formData = new FormData(form);
        formData.append('gerar_curriculo', 1);

        fetch('index.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro de rede ou servidor: ' + response.statusText);
            }
            
            const contentType = response.headers.get('Content-Type');
            if (contentType && contentType.indexOf('application/pdf') !== -1) {
                return response.blob();
            } else {
                return response.text().then(text => {
                    throw new Error('O servidor não retornou um PDF válido. Resposta: ' + text.substring(0, 500) + '...');
                });
            }
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'curriculo_gerado.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error('Erro na geração do PDF:', error);
            alert('Falha ao gerar o currículo: ' + error.message);
        })
        .finally(() => {
            $btn.prop('disabled', false).text('Gerar Currículo (Download JS)');
        });
    });
});