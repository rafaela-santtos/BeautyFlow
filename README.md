# BEAUTYFLOW 
## Sistema de Gestão para Salões de Beleza

BeautyFlow é um sistema de gestão desenvolvido para auxiliar salões de beleza no controle e acompanhamento de seus clientes, serviços e agendamentos, transformando os dados dos atendimentos em informações úteis para a gestão do negócio.

## SOBRE O PROJETO 
O BeautyFlow nasceu da necessidade de organizar, em um único sistema, as principais informações relacionadas aos clientes de um salão de beleza. O sistema terá como foco o gerenciamento da carteira de clientes, permitindo acompanhar seu histórico de atendimentos, serviços realizados, frequência, cancelamentos e faltas. Além disso, o sistema contará com agendamento de serviços e relatórios gerenciais, permitindo analisar o movimento do salão e identificar padrões de consumo dos clientes.


## OBJETIVO 
Desenvolver uma solução que facilite a gestão de clientes e forneça informações que auxiliem o responsável pelo salão na tomada de decisões.

O sistema deverá permitir, entre outras funcionalidades:

* Cadastrar e consultar clientes;
* Cadastrar e gerenciar serviços;
* Realizar agendamentos;
* Registrar atendimentos;
* Controlar cancelamentos e faltas;
* Aplicar regras de sinal para clientes com histórico de não comparecimento;
* Consultar o histórico dos clientes;
* Analisar a frequência dos clientes;
* Identificar os serviços mais realizados;
* Gerar relatórios sobre o movimento do salão.


## FUNCIONALIDADES 

### Gestão de Clientes
* Cadastro de clientes;
* Consulta e pesquisa;
* Atualização de dados;
* Histórico de atendimentos;
* Histórico de serviços realizados;
* Controle de faltas e cancelamentos;
* Acompanhamento da frequência dos clientes.

### Gestão de Serviços
* Cadastro de serviços;
* Definição de valores;
* Edição de serviços;
* Ativação e desativação de serviços;
* Consulta dos serviços disponíveis.

### Agendamentos
* Criação de agendamentos;
* Seleção de cliente e serviço;
* Definição de data e horário;
* Registro do profissional responsável;
* Registro do status do atendimento;
* Registro de cancelamentos;
* Registro de não comparecimento.

### Controle de Sinal
O sistema possuirá uma regra específica para clientes que apresentarem histórico de não comparecimento sem aviso prévio. Nesses casos, o próximo agendamento poderá exigir o pagamento de um sinal. 
O responsável pelo salão poderá, excepcionalmente, liberar o agendamento sem sinal.

### Relatórios
O sistema deverá fornecer informações para acompanhamento do negócio, como:
* Quantidade de clientes atendidos;
* Novos clientes;
* Quantidade de atendimentos;
* Cancelamentos;
* Faltas;
* Serviços mais realizados;
* Frequência dos clientes;
* Movimento mensal.



## REGRAS DE NEGÓCIO 

* **RN01:** Um cliente deverá possuir um cadastro único no sistema.
* **RN02:** Um cliente poderá possuir vários agendamentos.
* **RN03:** Cada agendamento deverá estar associado a um único cliente.
* **RN04:** O sistema deverá verificar disponibilidade do horário antes de confirmar um agendamento.
* **RN05:** Um cancelamento deverá alterar o status do agendamento para *Cancelado*.
* **RN06:** Um cancelamento poderá resultar ou não em um novo agendamento.
* **RN07:** Clientes que faltarem sem aviso prévio poderão ter o pagamento de sinal exigido no próximo agendamento.
* **RN08:** Cancelamentos realizados com aviso prévio não deverão ser considerados faltas.
* **RN09:** O responsável pelo salão poderá liberar excepcionalmente um agendamento sem sinal.
* **RN10:** Caso o cliente não compareça ao atendimento sem aviso prévio após o pagamento do sinal, o sinal não será devolvido.
* **RN11:** Todo atendimento realizado deverá estar relacionado a um cliente e aum serviço.
* **RN12:** Todo atendimento realizado deverá registrar o profissional responsável pela execução do serviço.
* **RN13:** Somente atendimentos com status *Realizado* deverão ser considerados nos indicadores de atendimentos e serviços realizados.
* **RN14:** A frequência do cliente deverá ser calculada com base em seus atendimentos realizados.
* **RN15:** Os dados dos atendimentos deverão ser utilizados para a geração dos relatórios gerenciais.
   


## TECNOLOGIAS 

### Backend
* Java
* Spring Boot
* API REST

### Banco de dados
* A definir

### Frontend
* A definir

### Modelagem e documentação
* UML
* Draw.io
* GitHub

As tecnologias serão definidas e atualizadas conforme o desenvolvimento do projeto.



## ARQUITETURA DO PROJETO 
O projeto será desenvolvido de forma incremental, seguindo etapas de análise, desenvolvimento, testes e evolução da interface.

BeautyFlow

│

├── 📄 Documentação

│

├── 🧠 Requisitos e regras de negócio

│

├── 📐 Modelagem UML

│

├── 🗄️ Banco de dados

│

├── ⚙️ Backend

│

├── 📱 Interface

│

└── 🧪 Testes



 ## EVOLUÇÃO PLANEJADA 
* Definição da proposta do sistema
* Definição dos módulos principais
* Definição das principais regras de negócio
* Documentação dos requisitos
* Modelagem UML
* Modelagem do banco de dados
* Desenvolvimento do backend
* Desenvolvimento da API
* Desenvolvimento da interface responsiva
* Implementação dos relatórios
* Testes do sistema
* Deploy



## VISÃO FUTURA 
O BeautyFlow será desenvolvido inicialmente com uma arquitetura que permita sua utilização em dispositivos móveis.
A interface será planejada com foco em responsividade e experiência de uso em smartphones, permitindo futuramente sua evolução para uma aplicação mobile.



## DESENVOLVEDORA 

Rafaela Santana

*Estudante de Análise e Desenvolvimento de Sistemas, com interesse em desenvolvimento de software, qualidade de software e tecnologia.*



## STATUS DO PROJETO 
*Em desenvolvimento*



### O projeto está sendo desenvolvido de forma incremental, desde a etapa de análise e documentação até a implementação e testes.
