# Sistema de Consulta Médica

<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>

## Sobre o Projeto

Este é um sistema de consulta médica desenvolvido com **Laravel** no backend e **React.js** ou **JS puro** no frontend. O sistema permite que médicos realizem o login, atendam pacientes, prescrevam exames e receitas, e consultem o histórico dos atendimentos realizados.

## Pré-Requisitos

Antes de começar, você precisará ter o **Docker** e o **Docker Compose** instalados na sua máquina. Caso não tenha, siga os seguintes links para instalação:

- Instalar Docker
- Instalar Docker Compose

Além disso, é necessário ter o **Node.js** instalado para rodar o frontend com React.js ou JS puro.

## Estrutura do Projeto

Este repositório contém os seguintes diretórios:

- **backend**: O backend da aplicação, desenvolvido com Laravel.
- **frontend**: O frontend da aplicação, desenvolvido com React.js ou JS puro.
- **docker**: Arquivos de configuração para subir os containers no Docker.

## Instruções para Subir o Projeto

### 1. Clonar o Repositório

Clone este repositório para a sua máquina local:

```bash
git clone https://github.com/Alves7777/medical-clinic.git
cd medical-consultation-system
````

## 2. Subir o Backend (Laravel)

Para iniciar o backend com Laravel, siga os passos abaixo:

1. Navegue até o diretório do backend:

    ```bash
    cd backend
    ```

2. Construa e inicie os containers Docker:

    ```bash
    docker-compose up -d
    ```

   Isso irá iniciar o container do **Laravel** e do **PostgreSQL** para o banco de dados.

3. Acesse o container do Laravel:

    ```bash
    docker exec -it backend bash
    ```

4. Instale as dependências do Laravel dentro do container:

    ```bash
    composer install
    ```

5. Copie o arquivo `.env` de exemplo para o ambiente:

    ```bash
    cp .env.example .env
    ```

6. Gere a chave da aplicação:

    ```bash
    php artisan key:generate
    ```

7. Execute as migrações para configurar o banco de dados:

    ```bash
    php artisan migrate
    ```

Agora, o backend do Laravel deve estar rodando em `http://localhost:8000`.

---

## 3. Subir o Frontend (React.js ou JS Puro)

Para o frontend, siga os seguintes passos:

1. Navegue até o diretório do frontend:

    ```bash
    cd frontend
    ```

2. Instale as dependências do Node.js (caso esteja utilizando React.js):

    ```bash
    npm install
    ```

3. Inicie o servidor de desenvolvimento para o frontend:

    ```bash
    npm start
    ```

   O frontend estará acessível em `http://localhost:3000`.

---

## 4. Configuração do Banco de Dados

O sistema utiliza o PostgreSQL como banco de dados. O Laravel irá criar automaticamente as tabelas quando você rodar as migrações.

Caso deseje alterar a configuração do banco de dados, edite as seguintes variáveis no arquivo `.env` do backend:

```env
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=medical_consultation
DB_USERNAME=postgres
DB_PASSWORD=secret
```

## 5. Testar a Aplicação

Após configurar o backend e o frontend, você pode testar a aplicação:

- **Backend (API)**: Acesse `http://localhost:8000` para utilizar os endpoints da API.
- **Frontend (Interface)**: Acesse `http://localhost:3000` para visualizar a interface do sistema.

Verifique se todos os componentes estão funcionando corretamente. O backend irá expor os endpoints de consulta, cadastro e gestão dos atendimentos médicos, enquanto o frontend irá consumir esses endpoints para fornecer a interface do usuário.

---

## 6. Comandos Úteis

Aqui estão alguns comandos úteis para o gerenciamento do projeto com Docker e Laravel:

- **Subir todos os containers (backend + frontend)**:

  Suba todos os containers com o seguinte comando:

    ```bash
    docker-compose up -d
    ```

- **Parar todos os containers**:

  Para parar todos os containers, execute:

    ```bash
    docker-compose down
    ```

- **Verificar os logs dos containers**:

  Para visualizar os logs dos containers e verificar se há erros ou mensagens importantes, use:

    ```bash
    docker-compose logs
    ```

- **Acessar o container do backend**:

  Caso precise acessar o container do backend para rodar comandos diretamente dentro dele, use:

    ```bash
    docker exec -it backend bash
    ```

- **Reiniciar o container do backend**:

  Para reiniciar o container do backend, execute:

    ```bash
    docker-compose restart backend
    ```

- **Rodar as migrações no container do backend**:

  Se precisar rodar migrações diretamente dentro do container, use:

    ```bash
    docker exec -it backend php artisan migrate
    ```

- **Instalar dependências do Laravel dentro do container**:

  Caso precise instalar dependências dentro do container do backend, utilize:

    ```bash
    docker exec -it backend composer install
    ```

---
