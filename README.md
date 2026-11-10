# BeautyFlow

**Sistema Web para Gerenciamento de um Salão de Beleza**

## 1. Sobre o projeto

O BeautyFlow é um sistema web desenvolvido como Projeto Integrador do curso de Análise e Desenvolvimento de Sistemas da Universidade Santo Amaro (UNISA).

O projeto surgiu da necessidade de facilitar a administração de um salão de beleza que realizava seus agendamentos manualmente e não possuía um controle centralizado das informações dos clientes e dos atendimentos.

A proposta é reunir em um único ambiente os registros necessários para organizar a rotina do estabelecimento, facilitar consultas e auxiliar no acompanhamento das atividades.

## 2. Funcionalidades

O sistema possui os seguintes módulos:

- **Painel inicial:** apresenta informações gerais sobre o funcionamento do salão.
- **Clientes:** cadastro, consulta, edição, exclusão e histórico de atendimentos.
- **Serviços:** cadastro e gerenciamento dos serviços oferecidos.
- **Profissionais:** cadastro e gerenciamento dos profissionais.
- **Agendamentos:** registro, consulta, edição e acompanhamento dos agendamentos.
- **Controle financeiro:** registro dos valores cobrados e recebidos por atendimento, com acompanhamento de pagamentos pendentes, parciais e pagos.
- **Controle de acesso:** diferenciação entre administradora e funcionários, com permissões específicas para cada perfil.

## 3. Tecnologias utilizadas

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- XAMPP
- Visual Studio Code

## 4. Organização do projeto

O projeto está organizado em pastas de acordo com os módulos e responsabilidades do sistema:

- `agendamentos/`
- `auth/`
- `clientes/`
- `css/`
- `img/`
- `profissionais/`
- `servicos/`
- `index.php`

## 5. Execução local

Para executar o projeto em ambiente local, são necessários:

1. Instalar o XAMPP.
2. Iniciar os serviços Apache e MySQL.
3. Baixar o repositório BeautyFlow e colocar a pasta do projeto no diretório `C:\xampp\htdocs\`.
4. Acessar o phpMyAdmin pelo endereço `http://localhost/phpmyadmin`.
5. Criar um banco de dados com o nome `beautyflow`.
6. Selecionar o banco criado, acessar a opção **Importar** e selecionar o arquivo `beautyflow.sql`, disponível na pasta principal do projeto.
7. Configurar a conexão com o banco de dados no arquivo `config/conexao.php`, conforme as configurações do ambiente local.
8. Acessar `http://localhost/BeautyFlow/auth/criar_admin.php` para cadastrar o primeiro usuário administrador.
9. Após o cadastro, acessar o sistema pelo endereço `http://localhost/BeautyFlow/` e realizar o login.

**Observação:** O arquivo `config/conexao.php` contém configurações locais e não é disponibilizado publicamente no repositório. O arquivo `beautyflow.sql` contém a estrutura do banco de dados, sem registros de clientes.

## 6. Objetivo acadêmico

O BeautyFlow foi desenvolvido com o objetivo de aplicar conhecimentos de desenvolvimento web, banco de dados e programação na construção de uma solução para uma necessidade identificada no contexto de um salão de beleza.

## 7. Informações do projeto

**Instituição:** Universidade Santo Amaro – UNISA  
**Curso:** Análise e Desenvolvimento de Sistemas  
**Disciplina:** Projeto Integrador – Programação Web  
**Projeto:** BeautyFlow  
**Ano:** 2026

## 8. Repositório

[https://github.com/rafaela-santtos/BeautyFlow](https://github.com/rafaela-santtos/BeautyFlow)
