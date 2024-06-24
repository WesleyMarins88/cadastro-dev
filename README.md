# Cadastro Dev - Guia de Configuração e Execução

Este guia descreve os passos para configurar e rodar o projeto de cadastro de desenvolvedores. A estrutura do projeto é composta por duas partes principais: backend e frontend, cada uma sendo um projeto Laravel separado.

## Estrutura do Projeto


    CADASTRO-DEV/
    ├── backend/
    │ └── ... (projeto Laravel)
    └── frontend/
    └── ... (projeto Laravel)


## Pré-requisitos

Certifique-se de ter as seguintes ferramentas instaladas em sua máquina:

- [PHP](https://www.php.net/downloads) >= 8.2
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) >= 14.x
- [NPM](https://www.npmjs.com/)
- [MySQL](https://www.mysql.com/downloads/) ou outro banco de dados compatível

## Configuração do Backend

1. **Clone o repositório**:
   
   ```bash
   git clone git@github.com:WesleyMarins88/cadastro-dev.git
   cd CADASTRO-DEV/backend
2. **Instale as dependências do PHP**:
   
   ```bash
   composer install
3. **Configure o arquivo .env:**
Copie o arquivo .env.example para .env:

    ```bash
    cp .env.example .env
4. **Gere a chave da aplicação:**
    ```bash
    php artisan key:generate
5. **Execute as migrações e seeders:**
    ```bash
    php artisan migrate --seed
6. **Inicie o servidor de desenvolvimento:**
   ```bash
   php artisan serve

## Configuração do Frontend
1. **Navegue para o diretório do frontend:**
   ```bash
   cd ../frontend
2. **Instale as dependências do PHP:**
   ```bash
   composer install
3. **Instale as dependências do Node.js:**
   ```bash
   npm install
4. **Configure o arquivo .env:**

   Copie o arquivo .env.example para .env:

   Configure as variáveis de ambiente no arquivo .env (especialmente a configuração do banco de dados).
      ```bash
       cp .env.example .env
5. **Gere a chave da aplicação:**
   ```bash
   php artisan key:generate
6. **Execute as migrações e seeders:**
   ```bash
   php artisan migrate
7. **Compile os assets:**
   ```bash
   // Durante o desenvolvimento:
   // npm run dev
   // Para produção:
   // npm run build
8. **Inicie o servidor de desenvolvimento:**
   ```bash
   php artisan serve

## Acesso à Aplicação
Acesse o backend em: http://127.0.0.1:8000
Acesse o frontend em: http://127.0.0.1:8000 (se estiver usando portas diferentes, ajuste as URLs de acordo)

## Notas Adicionais

Certifique-se de que o banco de dados está rodando e acessível conforme configurado nos arquivos .env.
Para questões de autenticação e configuração adicional, consulte a documentação do Laravel.
