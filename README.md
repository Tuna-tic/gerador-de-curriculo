Gerador de Currículo Profissional (PHP, Dompdf, Bootstrap)

Este projeto consiste em um sistema completo para geração de currículos profissionais em formato PDF. A interface de preenchimento é moderna e responsiva, desenvolvida com HTML e Bootstrap 5, enquanto a lógica de processamento e a conversão para PDF são realizadas com PHP e a biblioteca Dompdf.
O projeto atende aos requisitos de desenvolvimento de UI/UX moderno, utilizando o framework Bootstrap e gerenciamento de versões via Git.

Requisitos e Funcionalidades Implementadas:
- Geração de PDF: Conversão do formulário preenchido em um documento PDF final.
- Controle de Versão (Git): Histórico de commits detalhado para rastreamento de todas as alterações.
- Design Responsivo: Utilização do Bootstrap 5 para garantir que o formulário seja visualmente agradável e funcional em diferentes tamanhos de tela (atendendo ao requisito de framework UI).
- Tema Customizado: Implementação de um tema Dark Mode (Neon) no formulário.
- Estrutura Dinâmica: Campos de Experiência Profissional que podem ser adicionados e removidos dinamicamente via JavaScript.
- Usabilidade: Correção de problemas de renderização de texto em navegadores com Modo Escuro forçado (<meta name="color-scheme" content="light">).
- Limpeza de Dados: Remoção completa da seção de Referências Pessoais, simplificando o escopo do currículo.

Tecnologias Utilizadas:
- PHP	Lógica de backend, tratamento dos dados do formulário e conversão para HTML.
- Dompdf:	Biblioteca PHP utilizada para renderizar o HTML/CSS gerado e exportá-lo como um arquivo PDF.
- Bootstrap 5	Framework CSS: para o design responsivo do formulário de entrada.
- HTML5 & CSS3:	Estrutura base do formulário e estilos personalizados (tema Dark Mode).
- JavaScript/jQuery	Manipulação do DOM (adição/remoção de campos de experiência) e requisição assíncrona (fetch) para download do PDF.

Para rodar este projeto, você precisa de um servidor local com suporte a PHP (como XAMPP, WAMP, MAMP ou PHP CLI).
Pré-requisitos:
- Um servidor web local (Ex: XAMPP).
- PHP 7.4 ou superior.
- Composer instalado (para gerenciar dependências PHP).
- Git (para clonar o repositório).

Passos de Instalação:
1 - Clonar o Repositório (ou fazer o download dos arquivos).
Em um prompt de comando utilize os comandos: 
git clone [LINK DO SEU REPOSITÓRIO NO GITHUB]
cd gerador-curriculo

2- Instalar Dompdf (Este projeto utiliza o Composer para instalar a biblioteca Dompdf. Certifique-se de que ele esteja na pasta raiz do projeto e execute em seu prompt de comando).
composer install

3 - Hospedar no seu servidor local: Mova a pasta do projeto para o diretório de documentos do seu servidor local (como por exemplo a pasta "htdocs" no XAMPP).

4 - Abra o seu navegador e acesse o caminho do projeto (Ex: http://localhost/gerador-curriculo/index.php).

Estrutura do projeto:
index.php	- Contém o backend (PHP) que processa os dados e gera o PDF, e o frontend (HTML/Bootstrap) do formulário.
script.js	- Contém a lógica JavaScript para adicionar campos de experiência e a requisição fetch para iniciar o download do PDF.
style.css	- Contém o CSS personalizado para o tema Dark Mode/Neon do formulário.
vendor/	- Pasta gerada pelo Composer, contendo a biblioteca Dompdf.
README.md	- Documentação do projeto.

Contribuição e Autor
Autor: Vitor de Souza Fernandes

Licença: Para Fins Acadêmicos
