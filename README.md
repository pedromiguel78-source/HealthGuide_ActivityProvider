# HealthGuide – Activity Provider para Inven!RA

## Descrição do Projeto

O **HealthGuide** é um sistema que fornece guias de saúde personalizados através da arquitetura **Inven!RA**. Este *Activity Provider* permite que clínicos configurem e disponibilizem guias de orientação em saúde para pacientes, integrando-se com sistemas LMS através da especificação Inven!RA.

O sistema foi desenvolvido em **PHP** e está disponível em:  

https://healthguide-activityprovider.onrender.com

Repositório GitHub:

https://github.com/pedromiguel78-source/HealthGuide_ActivityProvider.git

---

## Arquitetura e Tecnologias

- **Linguagem:** PHP 8.2
- **Servidor Web:** Apache
- **Padrão de Design:** Singleton, Facade
- **Deploy:** Render (com Docker)
- **Arquitetura:** RESTful seguindo especificação Inven!RA

---

## Deploy (Render)

Evolução arquitetural do projeto, encontram-se disponíveis duas versões:

- **Versão inicial (Singleton):**  
  https://healthguide-activityprovider.onrender.com

- **Versão evoluída (Singleton + Facade):**  
  https://healthguide-activityprovider-1.onrender.com

---

## Endpoints Implementados

O HealthGuide implementa os cinco serviços obrigatórios da arquitetura Inven!RA:

### 1. Configuração da Atividade
**GET** `/config-healthguide`  
Interface HTML para o clínico configurar os parâmetros do guia de saúde.

### 2. Parâmetros JSON
**GET** `/json-params-healthguide`  
Retorna a estrutura de parâmetros configuráveis em formato JSON.

### 3. Deployment
**GET** `/deploy-healthguide?activityID={id}`  
Gera o URL de lançamento da atividade para uma instância específica.

### 4. Lista de Analytics
**GET** `/analytics-list-healthguide`  
Disponibiliza a lista de métricas quantitativas e qualitativas recolhidas.

### 5. Obtenção de Analytics
**POST** `/analytics-healthguide`  
Recebe o ID da atividade e retorna os dados analíticos correspondentes.

### Endpoint Adicional
**GET** `/guia-healthguide?activityID={id}`  
Visualização do guia de saúde pelo paciente.

---

## Padrão Singleton

O sistema utiliza o padrão de criação **Singleton** para gerir a base de dados de guias de saúde, garantindo que apenas uma instância da conexão existe durante a execução da aplicação.

### Funcionamento

A classe `SingletonDB` implementa o padrão através de:

1. **Construtor privado** – Impede a criação direta de instâncias  
2. **Atributo estático** – Armazena a única instância da classe  
3. **Método getInstance()** – Ponto de acesso global à instância  

Este padrão é especialmente adequado para gerir recursos partilhados como conexões a bases de dados, garantindo consistência e eficiência.

---

## Padrão Facade

No âmbito do tópico de **padrões de estrutura**, foi introduzido no projeto o padrão **Facade**, mantendo-se o Singleton previamente existente.

O objetivo da aplicação do Facade foi reduzir a dependência entre os endpoints HTTP e a lógica interna do Activity Provider. Para esse efeito, o ficheiro `index.php` passou a assumir o papel de *front controller*, delegando no `HealthGuideFacade` a coordenação dos principais fluxos do sistema.

O `HealthGuideFacade` atua como ponto de entrada único para operações como:
- obtenção dos parâmetros JSON;
- deployment de instâncias da atividade;
- disponibilização e recolha de analytics;
- obtenção dos dados necessários à renderização do guia.

Internamente, o Facade articula serviços especializados, encapsulando a complexidade do 
subsistema e fornecendo uma interface simples e estável aos endpoints.


---
## Padrão Observer

No âmbito do tópico de **padrões de comportamento**, foi introduzido no projeto o padrão **Observer**, mantendo-se os padrões previamente implementados (Singleton e Facade).

A aplicação deste padrão surgiu da necessidade de reagir a eventos relevantes do sistema sem introduzir dependências diretas entre os serviços principais e os componentes responsáveis pela recolha e tratamento de analytics.

Neste contexto:
- o **Analytics Subject Handler** assume o papel de *Subject*;
- os **Analytics Collectors** (qualitativos e quantitativos) funcionam como *Observers*;
- sempre que ocorre um evento relevante, o Subject notifica automaticamente os Observers registados.

Desta forma, os serviços principais limitam-se a sinalizar a ocorrência de eventos, ficando a cargo dos Observers o processamento das ações associadas, como o acesso e atualização de métricas. Esta abordagem reduz o acoplamento entre componentes, melhora a separação de responsabilidades e facilita a evolução do sistema sem necessidade de alterar código existente.

---
## Estrutura do Projeto

    HealthGuide_ActivityProvider/
    │
    ├── classes/
    │   ├── SingletonDB.php
    │   │
    │   ├── facade/
    │   │   └── HealthGuideFacade.php
    │   │
    │   ├── observer/
    │   │   ├── ActivityEventBus.php
    │   │   ├── Observer.php
    │   │   └── observers/
    │   │       ├── DeploymentObserver.php
    │   │       └── GuideViewedObserver.php
    │   │
    │   └── services/
    │       ├── AnalyticsService.php
    │       ├── ConfigService.php
    │       ├── DeploymentService.php
    │       ├── GuideService.php
    │       └── ParamsService.php
    │
    ├── templates/
    │   ├── styles/
    │   │   └── common.css
    │   ├── config-healthguide.php
    │   ├── guia.html
    │   ├── index.html
    │   ├── ui-analytics-list.html
    │   ├── ui-deploy.html
    │   └── ui-json-params.html
    │
    ├── .htaccess
    ├── Dockerfile
    ├── index.php
    ├── README.md
    ├── render.yaml
    └── test_singleton.php

---



## Referências Bibliográficas

Gamma, E., Helm, R., Johnson, R., & Vlissides, J. (2000). *Padrões de Projeto: Soluções Reutilizáveis de Software Orientado a Objetos. Bookman.

Morgado, L., & Cassola, F. (2022). Activity Providers na Inven!RA. Universidade Aberta. 

Grilo, R., Baptista, R., Schlemmer, E., Gütl, C., Beck, D., Coelho, A., & Morgado, L. (2022). Assessment and Tracking of Learning Activities on a
Remote Computer Networking Laboratory Using the Inven!RA Architecture. 

Cardoso, P., Morgado, L., & Coelho, A. (2020). Authoring Game-Based Learning Activities that are Manageable by Teachers. 

---


Pedro Pereira - 1102837  
Mestrado em Engenharia Informática e Tecnologia Web  
Universidade Aberta  
Arquitetura e Padrões de Software  
Ano Letivo:  2025/2026
 
