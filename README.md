# 🕒 Systex — Sistema de Ponto Simples  

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red?logo=laravel)](https://laravel.com/)  
[![PHP](https://img.shields.io/badge/PHP-8.2-blue?logo=php)](https://www.php.net/)  
[![MySQL](https://img.shields.io/badge/MySQL-8.0-blue?logo=mysql)](https://www.mysql.com/)  
[![Node.js](https://img.shields.io/badge/Node.js-20-green?logo=node.js)](https://nodejs.org/)  
[![Composer](https://img.shields.io/badge/Composer-2.x-orange?logo=composer)](https://getcomposer.org/)  
[![License](https://img.shields.io/badge/license-Systex%20Proprietary-lightgrey)](#-licença)  

Sistema de **registro e gestão de ponto** desenvolvido em **Laravel 11**, projetado para empresas que desejam uma solução simples, segura e eficiente para controle de jornada.  
O colaborador registra o ponto pelo **mobile (foto + geolocalização)** e o administrador gerencia tudo pelo **painel web**, com relatórios, filtros e exportações.

---

## 🚀 Tecnologias Utilizadas
- **Laravel 11**  
- **PHP 8.2+**  
- **MySQL 8**  
- **Composer**  
- **Node.js + Vite**  
- **TailwindCSS**  

---

## 📂 Estrutura de Pastas

```
/app
   /Http/Controllers      # Lógica do sistema de ponto
   /Models                # Modelos do Eloquent
/config                   # Configurações gerais
/database                 # Migrations
/public                   # Ponto de entrada, CSS, JS e uploads
/resources/views/ponto    # Views exclusivas do sistema de ponto
/routes                   # Rotas web e API
```

---

## ⚙️ Funcionalidades

### 🎯 Mobile / PWA
- Registro por **CPF**
- Tira **foto** no momento do ponto
- Captura de **data e hora**
- Captura de **latitude e longitude**
- Bloqueio de usuário desativado
- Suporte a uso em **tablet da empresa (PWA)**

### 🖥️ Painel Web
- Dashboard completo
- Cadastro de colaboradores
- Bloquear e liberar acesso
- Relatórios com filtros avançados
- Exportação **Excel e PDF**
- Histórico de fotos e batidas
- Filtros por período, colaborador e cliente

---

## 📊 Dashboard
- Batidas do dia  
- Total por período  
- Últimos registros  
- Resumo por colaborador  
- Indicadores de presença e ausência  

---

## 🔧 Instalação

### Pré-requisitos
- PHP 8.2+
- Composer 2.x
- MySQL 8
- Node.js 18+

### Passos

```bash
# Clonar o repositório
git clone https://github.com/manoelfilhodev/sistema-ponto-simples.git

# Entrar no diretório
cd sistema-ponto-simples

# Instalar dependências do back-end
composer install

# Instalar dependências do front-end
npm install && npm run dev

# Criar arquivo .env
cp .env.example .env

# Gerar key
php artisan key:generate

# Rodar migrations
php artisan migrate

# Iniciar o servidor
php artisan serve
```

---

## 📜 Licença

Este projeto é de uso interno da **Systex Sistemas Inteligentes**.  
Não é permitida a reprodução ou uso comercial sem autorização.

---

## 👨‍💻 Autor

**Systex Sistemas Inteligentes**  
🌐 systex.com.br  
📧 manoel.filho.mf@  
