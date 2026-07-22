# 💰 SisPoupo - Sistema de Administração Financeira

O **SisPoupo** é uma plataforma de gestão e administração financeira desenvolvida para ajudar usuários a terem controle total sobre suas finanças pessoais ou empresariais. O sistema permite o registro de receitas, despesas, acompanhamento de saldos e geração de relatórios através de um painel (Dashboard) intuitivo e responsivo.

## 🎯 Principais Funcionalidades (Visão Geral)

Como um sistema de administração financeira, o SisPoupo está estruturado para contemplar os seguintes módulos e recursos:
- **Dashboard Financeiro:** Visão geral com resumo consolidado de saldos, fluxo de caixa, total de receitas e despesas.
- **Gestão de Lançamentos:** Registro rápido e detalhado de movimentações (entradas e saídas) categorizadas.
- **Controle de Contas:** Gerenciamento de diferentes contas bancárias e carteiras virtuais.
- **Relatórios e Gráficos:** Geração de extratos mensais e análises visuais para melhor tomada de decisão financeira.
- **Autenticação Segura:** Controle de acesso de usuários garantindo a privacidade das informações financeiras.

## 🚀 Tecnologias e Versões dos Componentes

O SisPoupo é construído com tecnologias sólidas e amplamente adotadas no mercado, garantindo segurança e escalabilidade. Abaixo estão as versões dos principais componentes utilizados no projeto:

- **Linguagem e Backend:**
  - **PHP:** `^7.3` ou `^8.0`
  - **Laravel Framework:** `^8.75` (Base do sistema, lidando com rotas, segurança e banco de dados)
  - **Composer:** Gerenciador de dependências do ecossistema PHP

- **Frontend e Interface:**
  - **Bootstrap:** `v5.3.8` (Framework CSS base utilizado para o layout responsivo e componentes do sistema)
  - **jQuery:** `v4.0.0` (Biblioteca JavaScript para manipulação do DOM e requisições assíncronas)
  - **Blade:** Motor de templates nativo do Laravel para construção dinâmica das telas

## 🛠️ Como o Projeto é Feito (Arquitetura)

O sistema segue rigorosamente o padrão **MVC (Model-View-Controller)**:
1. **Model (Dados):** Interage com o banco de dados utilizando o **Eloquent ORM** do Laravel. Isso garante segurança contra injeções de SQL e facilita muito a manipulação matemática e as consultas de relatórios financeiros.
2. **View (Interface):** As telas (dashboard, formulários de transações) ficam localizadas na pasta `resources/views` e são construídas com a extensão `.blade.php`. A identidade visual conta com os componentes do **Bootstrap 5.3.8**, enquanto os comportamentos dinâmicos são gerenciados pelo **jQuery 4.0.0**.
3. **Controller (Lógica):** Controladores (como o `DashboardController`) processam as regras de negócio, recebendo dados do usuário, realizando os cálculos financeiros e enviando as informações para as Views adequadas.
4. **Banco de Dados:** Utiliza o sistema de `migrations` do Laravel para criar e manter o versionamento de toda a estrutura do banco (tabelas de usuários, movimentações, categorias, etc.).

## ⚙️ Pré-requisitos para Execução

Para rodar o SisPoupo localmente no seu computador, certifique-se de ter os seguintes requisitos:
- **PHP** (versão 7.3 ou 8.0+)
- **Composer** (instalado globalmente)
- Um **Servidor Web** local (Apache, Nginx ou utilizar o embutido do PHP)
- Um **Banco de Dados** (como MySQL ou PostgreSQL)

## 💻 Como Rodar Localmente

Siga o passo a passo abaixo para configurar o ambiente de desenvolvimento e executar a aplicação:

1. **Acesse a pasta do projeto:**
   ```bash
   cd /caminho/para/SisPoupo
   ```

2. **Instale as dependências de backend (Laravel e bibliotecas):**
   ```bash
   composer install
   ```

3. **Configure as variáveis de ambiente:**
   Copie o arquivo de configuração e edite os dados do seu banco de dados (campos `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`):
   ```bash
   cp .env.example .env
   ```

4. **Gere a chave de criptografia da aplicação:**
   ```bash
   php artisan key:generate
   ```

5. **Crie as tabelas no banco de dados:**
   ```bash
   php artisan migrate
   ```

6. **Inicie o servidor de desenvolvimento:**
   ```bash
   php artisan serve
   ```
   
> **Acesso:** Após iniciar o servidor, abra o navegador e acesse `http://localhost:8000`.

## 📜 Licença

O SisPoupo é desenvolvido utilizando o framework Laravel, que é um software de código aberto licenciado sob a [licença MIT](https://opensource.org/licenses/MIT).
