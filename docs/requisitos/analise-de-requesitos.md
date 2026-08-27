# Análise de Requisitos — BeautyFlow

## 1. Identificação do Projeto

**Nome do projeto:** BeautyFlow  
**Tipo:** Sistema de Gestão para Salões de Beleza  
**Desenvolvedora:** Rafaela Santana  
**Status:** Em desenvolvimento

## 2. Introdução

O BeautyFlow é um sistema de gestão desenvolvido com o objetivo de auxiliar salões de beleza no gerenciamento de clientes, serviços, profissionais, agendamentos e atendimentos.
A proposta surgiu a partir da necessidade de organizar as informações do salão em um único sistema, permitindo não apenas o armazenamento dos dados, mas também o acompanhamento do histórico dos clientes e a geração de informações úteis para a gestão do negócio.
O sistema será desenvolvido de forma incremental, começando pela implementação das principais regras de negócio e evoluindo posteriormente para banco de dados, API, interface e testes.


## 3. Problema Identificado
Salões de beleza podem lidar diariamente com uma grande quantidade de informações, como:

- Dados dos clientes;
- Serviços realizados;
- Horários agendados;
- Profissionais responsáveis;
- Cancelamentos;
- Faltas;
- Histórico de atendimentos;
- Valores dos serviços;
- Frequência dos clientes.

Quando essas informações são controladas de forma manual ou descentralizada, pode ocorrer dificuldade para localizar dados, acompanhar o histórico dos clientes e identificar padrões de atendimento.
Além disso, a ausência de um controle adequado sobre faltas pode gerar prejuízos ao salão, principalmente quando clientes não comparecem sem aviso prévio.
O BeautyFlow busca centralizar essas informações e aplicar regras que auxiliem na organização da agenda e na gestão dos clientes.


## 4. Objetivo Geral

Desenvolver um sistema de gestão para salões de beleza capaz de organizar clientes, serviços, profissionais, agendamentos e atendimentos, permitindo o acompanhamento do histórico e a geração de informações para auxiliar na tomada de decisões.


## 5. Objetivos Específicos
O sistema deverá permitir:

- Cadastrar clientes;
- Consultar e pesquisar clientes;
- Atualizar dados dos clientes;
- Cadastrar serviços;
- Controlar os serviços disponíveis;
- Cadastrar profissionais;
- Realizar agendamentos;
- Verificar disponibilidade de horários;
- Registrar atendimentos realizados;
- Registrar cancelamentos;
- Registrar faltas;
- Controlar o histórico de faltas sem aviso;
- Aplicar a regra de sinal para clientes que faltaram sem aviso prévio;
- Consultar o histórico de atendimentos;
- Acompanhar a frequência dos clientes;
- Identificar os serviços mais realizados;
- Gerar relatórios gerenciais.


## 6. Público-Alvo

O sistema será destinado principalmente a:

### 6.1 Responsável pelo salão
Poderá utilizar o sistema para:

- Acompanhar clientes;
- Consultar agenda;
- Acompanhar atendimentos;
- Analisar faltas e cancelamentos;
- Consultar relatórios;
- Acompanhar o movimento do salão.

### 6.2 Recepcionista
Poderá utilizar o sistema para:

- Cadastrar clientes;
- Localizar clientes;
- Realizar agendamentos;
- Consultar disponibilidade;
- Cancelar agendamentos;
- Registrar faltas;
- Registrar atendimentos.

### 6.3 Profissionais
Poderão ter seus atendimentos associados aos respectivos agendamentos e registros realizados no sistema.


## 7. Escopo do Sistema

### 7.1 Dentro do escopo
A primeira versão do sistema contemplará:

- Gestão de clientes;
- Gestão de serviços;
- Gestão de profissionais;
- Agendamentos;
- Controle de status dos agendamentos;
- Registro de atendimentos;
- Controle de faltas;
- Controle de cancelamentos;
- Regra de sinal para clientes com falta sem aviso;
- Histórico dos clientes;
- Relatórios básicos.

### 7.2 Fora do escopo inicial
Algumas funcionalidades poderão ser implementadas futuramente, como:

- Aplicativo mobile;
- Integração com WhatsApp;
- Envio automático de lembretes;
- Integração com sistemas de pagamento;
- Notificações automáticas;
- Autenticação de usuários;
- Integração com plataformas externas.

Essas funcionalidades não fazem parte da primeira versão e poderão ser incorporadas conforme a evolução do projeto.


# 8. Requisitos Funcionais
Os requisitos funcionais representam **o que o sistema deverá fazer**.

### RF01 — Cadastrar cliente
O sistema deverá permitir o cadastro de clientes contendo informações necessárias para sua identificação e contato.

Dados iniciais:
- ID;
- Nome;
- Sobrenome;
- Telefone;
- E-mail.

### RF02 — Consultar cliente
O sistema deverá permitir pesquisar clientes cadastrados.

A pesquisa poderá utilizar informações como:
- Nome;
- Sobrenome;
- Telefone.

### RF03 — Identificar cliente
O sistema deverá utilizar um identificador único para cada cliente.

O ID será utilizado internamente pelo sistema para garantir que os registros sejam associados à cliente correta.

### RF04 — Atualizar dados do cliente
O sistema deverá permitir a atualização dos dados cadastrais da cliente sem criar um novo cadastro.

Exemplo:
Se Maria alterar o número de telefone, o sistema deverá atualizar o telefone do cadastro existente.

### RF05 — Cadastrar serviço
O sistema deverá permitir cadastrar os procedimentos oferecidos pelo salão.

Exemplos:
- Progressiva;
- Corte;
- Hidratação;
- Tranças;
- Escova.

### RF06 — Gerenciar serviço
O sistema deverá permitir:

- Consultar serviços;
- Editar serviços;
- Alterar preços;
- Ativar serviços;
- Desativar serviços.

### RF07 — Cadastrar profissional

O sistema deverá permitir o cadastro dos profissionais responsáveis pela execução dos serviços.

### RF08 — Realizar agendamento
O sistema deverá permitir criar um agendamento informando:

- Cliente;
- Serviço;
- Profissional;
- Data;
- Horário.

### RF09 — Verificar disponibilidade

Antes de confirmar um agendamento, o sistema deverá verificar se o profissional possui disponibilidade para a data e horário selecionados.

### RF10 — Consultar agendamento

O sistema deverá permitir consultar os agendamentos realizados.

### RF11 — Cancelar agendamento
O sistema deverá permitir cancelar um agendamento.

O cancelamento deverá alterar o status do agendamento para **CANCELADO**, preservando o registro no histórico.

### RF12 — Registrar falta
O sistema deverá permitir registrar quando uma cliente não comparecer ao atendimento sem aviso prévio.

O status do agendamento deverá ser alterado para **FALTOU**.

### RF13 — Registrar atendimento
O sistema deverá permitir registrar um atendimento realizado.

O registro deverá estar relacionado a:
- Cliente;
- Serviço;
- Profissional;
- Data.

### RF14 — Consultar histórico

O sistema deverá permitir consultar o histórico de agendamentos e atendimentos de uma cliente.

### RF15 — Controlar faltas

O sistema deverá registrar a quantidade de faltas sem aviso prévio de cada cliente.

### RF16 — Aplicar regra de sinal

O sistema deverá identificar clientes que possuam histórico de falta sem aviso prévio e indicar que o próximo agendamento deverá exigir sinal.

### RF17 — Permitir exceção de sinal

O sistema deverá permitir que o responsável pelo salão libere excepcionalmente um agendamento sem sinal, mesmo quando a cliente possuir exigência de sinal.

### RF18 — Registrar sinal

Quando houver exigência de sinal, o sistema deverá permitir registrar a informação referente ao sinal do agendamento.

### RF19 — Gerar relatório de frequência

O sistema deverá permitir consultar informações relacionadas à frequência das clientes, considerando os atendimentos realizados.

### RF20 — Gerar relatório de serviços

O sistema deverá permitir identificar os serviços mais realizados em determinado período.

### RF21 — Gerar relatório de movimento

O sistema deverá apresentar informações sobre o movimento do salão, incluindo dados como:
- Quantidade de atendimentos;
- Novos clientes;
- Serviços realizados;
- Cancelamentos;
- Faltas.


# 9. Requisitos Não Funcionais
Os requisitos não funcionais representam **como o sistema deverá funcionar**.

### RNF01 — Usabilidade
O sistema deverá possuir uma estrutura simples e intuitiva, permitindo que a recepcionista consiga realizar as operações sem necessidade de conhecimentos técnicos.

### RNF02 — Manutenibilidade
O código deverá ser organizado de forma que novas funcionalidades possam ser adicionadas futuramente.

### RNF03 — Escalabilidade
A arquitetura deverá permitir a evolução do sistema para uma aplicação mais completa.

### RNF04 — Responsividade
A futura interface deverá ser adaptável a diferentes tamanhos de tela, especialmente dispositivos móveis.

### RNF05 — Integridade dos dados
O sistema deverá preservar os registros históricos de clientes, agendamentos e atendimentos, evitando exclusões desnecessárias que possam comprometer os dados.

### RNF06 — Identificação única
Cada cliente deverá possuir um identificador único no sistema.

### RNF07 — Organização
As funcionalidades deverão ser separadas de acordo com suas responsabilidades, facilitando manutenção e evolução do software.

### RNF08 — Testabilidade
As principais regras de negócio deverão ser desenvolvidas de forma que possam ser testadas automaticamente.


# 10. Regras de Negócio

### RN01
Cada cliente deverá possuir um cadastro único no sistema.

### RN02
Uma cliente poderá possuir vários agendamentos.

### RN03
Cada agendamento deverá estar associado a uma única cliente.

### RN04
O sistema deverá verificar a disponibilidade do profissional antes de confirmar um agendamento.

### RN05
O cancelamento deverá alterar o status do agendamento para **CANCELADO**.

### RN06
O agendamento cancelado deverá permanecer registrado no histórico.

### RN07
Um cancelamento realizado com aviso prévio não deverá ser considerado falta.

### RN08
Quando uma cliente não comparecer ao atendimento sem aviso prévio, o agendamento deverá ser registrado como **FALTOU**.

### RN09
A falta sem aviso prévio deverá ser registrada no histórico da cliente.

### RN10
Clientes com histórico de falta sem aviso poderão ter sinal exigido no próximo agendamento.

### RN11
O responsável pelo salão poderá liberar excepcionalmente o agendamento sem sinal.

### RN12
O sinal não será uma exigência obrigatória para todas as clientes.

### RN13
O sistema deverá diferenciar cancelamentos de faltas.

### RN14
Um atendimento realizado deverá estar relacionado a uma cliente e a um serviço.

### RN15
Todo atendimento realizado deverá registrar o profissional responsável pela execução do serviço.

### RN16
Somente atendimentos realizados deverão ser considerados nos indicadores de serviços realizados.

### RN17
A frequência da cliente deverá ser calculada com base nos atendimentos realizados.

### RN18
Os dados dos atendimentos deverão ser utilizados para geração dos relatórios gerenciais.

### RN19
O histórico da cliente deverá permanecer disponível mesmo após alterações em seus dados cadastrais.

### RN20
O ID da cliente deverá permanecer associado aos seus registros mesmo quando seus dados pessoais forem atualizados.


# 11. Fluxos Principais do Sistema

## 11.1 Cadastro de nova cliente
Cliente entra em contato

        ↓
Recepcionista solicita dados

        ↓
Sistema verifica se já existe cadastro

        ↓
Cliente não encontrada

        ↓
Cadastrar cliente

        ↓
Sistema gera ID

        ↓
Cadastro concluído

## 11.2 Agendamento
Cliente solicita horário

        ↓
Recepcionista identifica cliente

        ↓
Seleciona serviço

        ↓
Seleciona profissional

        ↓
Seleciona data

        ↓
Seleciona horário

        ↓
Sistema verifica disponibilidade

        ↓
Horário disponível?

      ↙       ↘
    NÃO       SIM
     ↓         ↓
     
Buscar          Verificar
outro          necessidade
horário        de sinal

                ↓
          Confirmar agendamento
          
# 12. Fluxo de Identificação da Cliente
Quando existirem clientes com nomes semelhantes, a recepcionista poderá utilizar informações adicionais para localizar o cadastro correto.

Exemplo:
Nome: Maria

        ↓
Existem várias Marias

        ↓
Informar sobrenome

        ↓
Ainda existem cadastros semelhantes?

        ↓
Utilizar telefone para confirmação

        ↓
Sistema encontra o ID correto


O ID será utilizado internamente para associar o agendamento à cliente correta.

# 13. Fluxo de Cancelamento
Cliente solicita cancelamento

        ↓
Recepcionista identifica cliente

        ↓
Localiza agendamento

        ↓
Confirma cancelamento

        ↓
Status = CANCELADO

        ↓
Agendamento permanece no histórico

        ↓
Cliente deseja remarcar?

       ↙       ↘
     NÃO       SIM
      ↓         ↓
    Finaliza   Criar novo
               agendamento

O cancelamento não deverá ser considerado uma falta quando realizado de acordo com a regra estabelecida pelo salão.

# 14. Fluxo de Falta
Cliente possui agendamento

        ↓
Horário do atendimento chega

        ↓
Cliente não comparece

        ↓
Cliente não informa o salão

        ↓
Status = FALTOU

        ↓
Registrar falta no histórico

        ↓
Atualizar controle de faltas

        ↓
Próximo agendamento poderá exigir sinal

# 15. Fluxo de Sinal
O sinal será utilizado como uma medida de controle para clientes que apresentarem histórico de falta sem aviso prévio.

Cliente solicita novo agendamento

        ↓
Sistema verifica histórico

        ↓
Possui falta sem aviso?

       ↙       ↘
     NÃO       SIM
      ↓         ↓
Agendamento   Sinal necessário

normal            ↓
             Responsável pode
             
             liberar exceção
             
# 16. Fluxo de Atendimento
Cliente possui agendamento

        ↓
Cliente comparece

        ↓
Serviço é realizado

        ↓
Status = REALIZADO

        ↓
Registrar atendimento

        ↓
Associar:
- Cliente
- Serviço
- Profissional
- Data
  
        ↓
Atualizar histórico

# 17. Status dos Agendamentos
O sistema deverá trabalhar inicialmente com os seguintes status:

Status = 	Significado

AGENDADO =	Horário registrado no sistema

CONFIRMADO =	Agendamento confirmado

REALIZADO	= Cliente compareceu e o serviço foi realizado

CANCELADO	= Cliente cancelou o agendamento

FALTOU = Cliente não compareceu e não avisou

# 18. Dados Principais do Sistema
### 18.1 Cliente
*ID
*Nome
*Sobrenome
*Telefone
*E-mail
*Quantidade de faltas sem aviso
*Sinal obrigatório

### 18.2 Serviço
*ID
*Nome
*Descrição
*Preço
*Status

### 18.3 Profissional
*ID
*Nome
*Especialidade
*Status

### 18.4 Agendamento
*ID
*Cliente
*Serviço
*Profissional
*Data
*Horário
*Status
*Sinal

### 18.5 Atendimento
*ID
*Cliente
*Serviço
*Profissional
*Data
*Valor
*Status
*Observação

### 20. Relacionamentos Principais

### Cliente → Agendamento
Uma cliente poderá possuir vários agendamentos.
* Cardinalidade:
Cliente 1 ───────── N Agendamento

### Cliente → Atendimento
Uma cliente poderá possuir vários atendimentos.
* Cardinalidade:
Cliente 1 ───────── N Atendimento

### Serviço → Agendamento
Um serviço poderá estar presente em vários agendamentos.
* Cardinalidade:
Serviço 1 ───────── N Agendamento

### Serviço → Atendimento
Um serviço poderá estar presente em vários atendimentos.
* Cardinalidade:
Serviço 1 ───────── N Atendimento

### Profissional → Agendamento
Uma profissional poderá possuir vários agendamentos.
* Cardinalidade:
Profissional 1 ───────── N Agendamento

### Profissional → Atendimento
Uma profissional poderá realizar vários atendimentos.
* Cardinalidade:
Profissional 1 ───────── N Atendimento

# 20. Critérios de Aceitação
Os critérios de aceitação serão utilizados posteriormente para verificar se as funcionalidades foram implementadas corretamente.

* CA01 — Cadastro
Dado que a cliente não esteja cadastrada, quando a recepcionista informar os dados obrigatórios, então o sistema deverá criar um novo cadastro e gerar um ID único.

* CA02 — Atualização
Dado que a cliente já esteja cadastrada, quando seu telefone for alterado, então o sistema deverá atualizar o telefone sem criar outro cadastro.

* CA03 — Agendamento
Dado que exista disponibilidade, quando a recepcionista solicitar o agendamento, então o sistema deverá registrar o horário.

* CA04 — Horário ocupado
Dado que o profissional esteja ocupado no horário solicitado, quando a recepcionista tentar realizar o agendamento, então o sistema deverá informar que o horário está indisponível.

* CA05 — Cancelamento
Dado que exista um agendamento, quando a cliente solicitar seu cancelamento, então o sistema deverá alterar o status para CANCELADO e manter o registro no histórico.

* CA06 — Falta
Dado que a cliente não compareça e não avise, quando a falta for registrada, então o sistema deverá alterar o status para FALTOU.

* CA07 — Sinal
Dado que a cliente possua histórico de falta sem aviso, quando for realizado um novo agendamento, então o sistema deverá indicar a necessidade de sinal.

* CA08 — Atendimento
Dado que a cliente compareça, quando o serviço for concluído, então o sistema deverá registrar o atendimento como REALIZADO.

* CA09 — Relatórios
Dado que existam atendimentos registrados, quando o responsável consultar os relatórios, então o sistema deverá utilizar os atendimentos realizados para gerar os indicadores.

# 21. Evolução do Projeto
O desenvolvimento será realizado de forma incremental.

### Fase 1 — Análise
- Levantamento do problema;
- Requisitos;
- Regras de negócio;
- Definição dos fluxos.
*Status: Concluída.*

### Fase 2 — Modelagem
- Identificação das classes;
- Atributos;
- Relacionamentos;
- Diagrama de classes UML.
*Status: Próxima etapa.*

### Fase 3 — Desenvolvimento Java
- Criação das classes;
- Atributos;
- Métodos;
- Regras de negócio;
- Interação pelo terminal.

### Fase 4 — Testes
- Testes unitários;
- Validação das regras;
- JUnit.
  
### Fase 5 — Banco de Dados
- Modelagem;
- SQL;
- Integração com Java.
  
### Fase 6 — Backend
- Spring Boot;
- API REST;
- Endpoints;
- Integração com banco.
  
### Fase 7 — Interface
- Criação da interface;
- Responsividade;
- Integração com a API.
  
### Fase 8 — Relatórios
- Indicadores;
- Frequência;
- Serviços mais realizados;
- Faltas;
- Cancelamentos;
- Movimento mensal.

### Fase 9 — Deploy
Publicação do sistema em ambiente de hospedagem.

# 22. Conclusão

O BeautyFlow será desenvolvido com o objetivo de fornecer uma solução organizada para gerenciamento de salões de beleza, centralizando informações relacionadas a clientes, serviços, profissionais, 
agendamentos e atendimentos. A análise de requisitos estabelecida neste documento servirá como base para as próximas etapas do desenvolvimento, especialmente para a modelagem UML e implementação das classes em Java.
O projeto será desenvolvido de maneira incremental, permitindo a evolução da solução desde uma aplicação inicial em Java até uma arquitetura composta por banco de dados, API REST, interface e testes automatizados.
