# 📊 Telegram Bot Analytics Dashboard – Vue 3 + Laravel + Inertia

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red)](https://laravel.com)
[![Vue](https://img.shields.io/badge/Vue-3.x-green)](https://vuejs.org)
[![Inertia](https://img.shields.io/badge/Inertia-1.x-purple)](https://inertiajs.com)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-14%2B-blue)](https://www.postgresql.org)

A **production‑ready web dashboard** for Telegram bot analytics.  
Displays command usage heatmap (GitHub‑style), hourly charts, auto‑moderation rule editor, and active reminders.  
Built with **Laravel 12**, **Vue 3**, **Inertia.js**, **Tailwind CSS**, **ApexCharts**, and **PostgreSQL**.

## ✨ Features

- 🔥 **Command heatmap** – 365‑day GitHub‑style activity calendar.
- 📈 **Analytics charts** – commands per hour, top users.
- ⚖️ **Auto‑moderation CRUD** – create/edit/delete rules (bot enforces them).
- ⏰ **Reminder viewer** – see active reminders, cancel them.
- 🎨 **Modern UI** – Tailwind CSS, smooth animations, responsive.
- ⚡ **Real‑time ready** – Laravel Reverb integration (optional).
- 🗄️ **Shared database** – same PostgreSQL as the bot.

## 🚀 Quick Start (Local)

### Prerequisites
- PHP 8.2+ (8.5 supported)
- Composer 2.x
- Node.js 20+ & npm
- PostgreSQL 14+

### Installation
```bash
git clone https://github.com/lelextb/telegram-bot-analytics-dashboard.git
cd telegram-bot-analytics-dashboard
composer install
npm install --legacy-peer-deps
cp .env.example .env
# Configure database (PostgreSQL) and app URL
php artisan key:generate
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
npm run build
php artisan serve
```

Visit `http://localhost:8000` – login: `admin@example.com` / `password`.

### Environment Variables (.env)
```ini
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=telegram_dashboard
DB_USERNAME=dashboard
DB_PASSWORD=secret
```

### For Development (Hot Reload)
```bash
npm run dev
# In another terminal
php artisan serve
```

## 🖥️ Production Deployment

- **Web server**: Nginx + PHP‑FPM (configuration example below)
- **Queue worker**: `php artisan queue:work` (if using notifications)
- **Realtime (optional)**: `php artisan reverb:start`

### Nginx Configuration (snippet)
```nginx
server {
    listen 80;
    server_name dashboard.example.com;
    root /var/www/telegram-dashboard/public;
    index index.php;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🔗 Integration with Telegram Bot

- The bot writes command logs, reminders, and reads moderation rules from the same database.
- No extra API calls – just point the bot's `DATABASE_URL` to this same PostgreSQL instance.
- The dashboard will immediately reflect bot activity.

## 🧪 Testing
```bash
php artisan test
npm run test
```

## 📝 License
MIT – free to use and modify.
