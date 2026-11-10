# Análise de Requisitos – BeautyFlow

## 1. Apresentação

O BeautyFlow é um sistema web desenvolvido para auxiliar no gerenciamento das atividades de um salão de beleza. A aplicação permite organizar informações de clientes, serviços, profissionais e agendamentos, além de oferecer recursos de controle financeiro e gerenciamento de usuários.

O sistema foi desenvolvido utilizando PHP, MySQL, HTML, CSS e JavaScript, com execução em ambiente local por meio do XAMPP.

## 2. Requisitos Funcionais

Os requisitos funcionais descrevem as principais operações que o sistema deve realizar.

| Código | Requisito |
|---|---|
| RF01 | Permitir que usuários cadastrados realizem login no sistema. |
| RF02 | Permitir o encerramento da sessão do usuário. |
| RF03 | Permitir cadastrar clientes. |
| RF04 | Permitir consultar e editar os dados dos clientes. |
| RF05 | Permitir excluir clientes, conforme o nível de permissão. |
| RF06 | Permitir consultar o histórico de agendamentos dos clientes. |
| RF07 | Permitir cadastrar, consultar, editar e excluir serviços. |
| RF08 | Permitir cadastrar, consultar, editar e excluir profissionais. |
| RF09 | Permitir cadastrar agendamentos vinculando cliente, serviço e profissional. |
| RF10 | Permitir consultar, editar e excluir agendamentos, conforme as permissões. |
| RF11 | Permitir atualizar a situação do agendamento para Agendado, Confirmado, Concluído, Cancelado ou Faltou. |
| RF12 | Permitir registrar se um cancelamento ocorreu com antecedência ou em cima da hora. |
| RF13 | Permitir informar o valor cobrado e o valor recebido em cada agendamento. |
| RF14 | Permitir acompanhar a situação do pagamento como Pendente, Parcial ou Pago. |
| RF15 | Permitir indicar se determinado agendamento exige sinal e registrar o valor recebido. |
| RF16 | Apresentar no painel principal a quantidade de clientes, serviços, profissionais e agendamentos do dia. |
| RF17 | Apresentar informações financeiras no painel, com acesso exclusivo da administradora. |
| RF18 | Permitir que a administradora cadastre, edite e gerencie os usuários do sistema. |
| RF19 | Disponibilizar consulta de informações sobre faltas e cancelamentos dos clientes. |

## 3. Requisitos Não Funcionais

Os requisitos não funcionais definem características de qualidade e funcionamento do sistema.

- **RNF01 – Usabilidade:** apresentar interface simples, organizada e de fácil utilização.
- **RNF02 – Segurança:** exigir autenticação para acessar as funcionalidades internas.
- **RNF03 – Proteção de senhas:** armazenar senhas utilizando mecanismo de hash.
- **RNF04 – Controle de acesso:** restringir funcionalidades de acordo com o perfil do usuário.
- **RNF05 – Organização:** manter o código-fonte dividido em módulos e arquivos com funções específicas.
- **RNF06 – Compatibilidade:** funcionar em ambiente local com PHP, MySQL e servidor Apache, utilizando o XAMPP.
- **RNF07 – Integridade dos dados:** utilizar identificadores e relacionamentos entre as tabelas do banco de dados.

## 4. Regras de Negócio

As regras de negócio estabelecem condições para a utilização correta do BeautyFlow.

- **RN01:** Somente usuários autenticados podem acessar as áreas internas do sistema.
- **RN02:** O sistema possui dois perfis de acesso: administradora e funcionário.
- **RN03:** Somente a administradora pode cadastrar e gerenciar usuários.
- **RN04:** As operações de exclusão de registros são restritas à administradora.
- **RN05:** Todo agendamento deve estar relacionado a um cliente, um serviço e um profissional.
- **RN06:** Cada agendamento deve possuir uma situação registrada no sistema.
- **RN07:** Os valores cobrados e recebidos são registrados individualmente em cada agendamento.
- **RN08:** A situação do pagamento deve indicar se está pendente, parcial ou pago.
- **RN09:** A necessidade de sinal pode ser definida no momento do agendamento, considerando a decisão da administradora ou do atendimento.
- **RN10:** As informações financeiras são disponibilizadas somente para a administradora.

## 5. Perfis de Usuário

### Administradora

Possui acesso às funcionalidades de gerenciamento do salão, incluindo cadastro e gerenciamento de usuários, controle dos registros e visualização das informações financeiras.

### Funcionário

Pode utilizar as funcionalidades operacionais do sistema, como cadastro e consulta de clientes, serviços, profissionais e agendamentos, respeitando as restrições de acesso.

## 6. Considerações

Os requisitos apresentados correspondem às funcionalidades implementadas na versão atual do BeautyFlow. A documentação poderá ser atualizada conforme novas funcionalidades forem desenvolvidas.
