# HealthGuide – Activity Provider para Inven!RA

## Descrição do Projeto

O **HealthGuide** é um sistema que fornece guias de saúde personalizados através da arquitetura **Inven!RA**. Este *Activity Provider* permite que clínicos configurem e disponibilizem guias de orientação em saúde para pacientes, integrando-se com sistemas LMS através da especificação Inven!RA.

O sistema foi desenvolvido em **PHP** e está disponível em:  

https://healthguide-activityprovider.onrender.com

---

## Arquitetura e Tecnologias

- **Linguagem:** PHP 8.2
- **Servidor Web:** Apache
- **Padrão de Design:** Singleton
- **Deploy:** Render (com Docker)
- **Arquitetura:** RESTful seguindo especificação Inven!RA

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

**Corpo do pedido:**
```json
{
  "activityID": "demo2025"
}
```

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

**Fluxo de utilização:**
- Na primeira chamada a `getInstance()`, a instância é criada e a base de dados é povoada com os guias de saúde
- Nas chamadas subsequentes, a mesma instância é retornada, evitando duplicação de dados e recursos

Este padrão é especialmente adequado para gerir recursos partilhados como conexões a bases de dados, garantindo consistência e eficiência.

---

## Guias de Saúde Disponíveis

O sistema oferece seis categorias de guias especializados:

| Categoria | Descrição |
|-----------|-----------|
| **Nutrição e Alimentação** | Orientações sobre alimentação equilibrada e saudável |
| **Exercício Físico** | Recomendações de atividade física adaptadas |
| **Saúde Mental** | Estratégias de gestão de stress e bem-estar |
| **Prevenção de Doenças** | Medidas preventivas e rastreios recomendados |
| **Medicação e Tratamentos** | Informação sobre terapêuticas prescritas |
| **Hábitos de Vida Saudável** | Sono, hidratação e rotinas diárias |

---

## Estrutura do Projeto

```
healthguide_singleton/
│
├── index.php                    # Router principal e endpoints REST
├── .htaccess                    # Configuração Apache (URL rewrite)
├── Dockerfile                   # Container Docker
├── render.yaml                  # Configuração Render
│
├── classes/
│   └── SingletonDB.php          # Implementação do padrão Singleton
│
└── templates/
    ├── index.html               # Página inicial
    └── guia.html                # Visualização de guias
```

---

## Como Testar

### Testes via Browser

**Página inicial:**  
https://healthguide-activityprovider.onrender.com/

**Configuração:**  
https://healthguide-activityprovider.onrender.com/config-healthguide

**Visualizar guia:**  
https://healthguide-activityprovider.onrender.com/guia-healthguide?activityID=demo2025


---

## Referências Bibliográficas

Gamma, E., Helm, R., Johnson, R., & Vlissides, J. (2000). *Padrões de Projeto: Soluções Reutilizáveis de Software Orientado a Objetos. Bookman.

Morgado, L., & Cassola, F. (2022). Activity Providers na Inven!RA. Universidade Aberta. 

Grilo, R., Baptista, R., Schlemmer, E., Gütl, C., Beck, D., Coelho, A., & Morgado, L. (2022). Assessment and Tracking of Learning Activities on a
Remote Computer Networking Laboratory Using the Inven!RA Architecture. 

Cardoso, P., Morgado, L., & Coelho, A. (2020). Authoring Game-Based Learning Activities that are Manageable by Teachers. 

---



**Pedro Pereira - 1102837  
**Mestrado em Engenharia Informática e Tecnologia Web  
**Universidade Aberta  
**Arquitetura e Padrões de Software  
Ano Letivo:  2025/2026
 
