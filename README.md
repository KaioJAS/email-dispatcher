```markdown
# 📧 Email Dispatcher

Sistema web para gerenciamento e disparo de emails em massa, desenvolvido com Laravel e Vue.js.

## 🚀 Tecnologias Utilizadas

### Backend
- **Laravel 11** - Framework PHP
- **MySQL** - Banco de dados
- **Redis** - Cache e sessões
- **RabbitMQ** - Fila de processamento
- **Laravel Sanctum** - Autenticação API
- **Docker** - Containerização

### Frontend
- **Vue.js 3** - Framework JavaScript
- **Pinia** - Gerenciamento de estado
- **Vue Router** - Roteamento
- **PrimeVue** - Biblioteca de componentes UI
- **Tailwind CSS** - Framework CSS
- **Axios** - Cliente HTTP

### Outros
- **Mailtrap** - Teste de emails
- **Vite** - Build tool

## 📋 Pré-requisitos

- Docker e Docker Compose
- Node.js 18+ (para desenvolvimento local)
- Conta no Mailtrap para testes de email

## 🛠️ Instalação

### 1. Clone o repositório
```bash
git clone https://github.com/KaioJAS/email-dispatcher.git
cd email-dispatcher
```

### 4. Inicie os containers
```bash
docker compose up -d --build
```

### 6. Instale as dependências do Frontend
```bash
docker compose exec node npm install

### 7. Configure o ambiente
```bash
cp .env.example .env
docker compose exec app php artisan key:generate
```

### 8. Configure o arquivo .env
```env
# Database
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=email_dispatcher
DB_USERNAME=laravel
DB_PASSWORD=secret

# Queue
QUEUE_CONNECTION=rabbitmq

# Cache/Session
CACHE_STORE=redis
SESSION_DRIVER=redis
REDIS_HOST=redis

# Email (Mailtrap)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_username_mailtrap
MAIL_PASSWORD=sua_senha_mailtrap
MAIL_ENCRYPTION=tls

# RabbitMQ
RABBITMQ_HOST=rabbitmq
RABBITMQ_PORT=5672
RABBITMQ_USER=admin
RABBITMQ_PASSWORD=secret
RABBITMQ_VHOST=email_vhost
```

### 9. Execute as migrações e seeders
```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

### 10. Configure o RabbitMQ
```bash
docker compose exec rabbitmq rabbitmqctl add_vhost email_vhost
docker compose exec rabbitmq rabbitmqctl set_permissions -p email_vhost admin ".*" ".*" ".*"
```

### 11. Inicie os serviços
```bash
# Frontend
docker compose exec node npm run dev

# Queue Worker
docker compose exec app php artisan queue:work rabbitmq --verbose &
```

## 🎯 Como Usar

### Acesso ao Sistema
1. Acesse: `http://localhost:8000`
2. Faça login com as credenciais:
   - **Email:** admin@test.com
   - **Senha:** 123456

### Dashboard
- Visualize estatísticas de emails enviados, pendentes e com erro
- Acompanhe gráficos de envios por dia
- Monitore métricas

### Gerenciamento de Emails
1. Navegue para "Controle de Emails"
2. Clique em "Criar novo disparo"
3. Preencha:
   - Título do email
   - Email do remetente
   - Destinatários (separados por vírgula)
   - Conteúdo (com editor rico)
4. Clique em "Criar agora"
5. Acompanhe o status na listagem

## ✨ Funcionalidades

- ✅ **Autenticação Segura** - Login com tokens Bearer
- ✅ **Dashboard Interativo** - Estatísticas e gráficos
- ✅ **Editor Rico** - Interface WYSIWYG para criação de emails
- ✅ **Processamento em Fila** - RabbitMQ para envios assíncronos
- ✅ **Interface Responsiva** - Design adaptável para mobile/desktop
- ✅ **Paginação Inteligente** - Listagem otimizada de emails
- ✅ **Validação Robusta** - Validação de formulários e dados
- ✅ **Status em Tempo Real** - Acompanhamento do status dos envios

## 🔧 Comandos Úteis

### Development
```bash
# Executar testes
docker compose exec app php artisan test

# Limpar cache
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear

# Ver logs
docker compose exec app tail -f storage/logs/laravel.log

# Monitorar fila
docker compose exec app php artisan queue:monitor

# Build frontend
docker compose exec node npm run build
```

## 👨‍💻 Desenvolvedor

Desenvolvido com ❤️ para demonstração de habilidades Full Stack com Laravel e Vue.js.
```