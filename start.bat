@echo off
echo 🚀 Starting YouTube Video Generator Application...

:: Copy environment file
copy .env.docker .env

:: Build and start containers
echo 📦 Building Docker containers...
docker-compose build --no-cache

echo 🔧 Starting services...
docker-compose up -d

:: Wait for database to be ready
echo ⏳ Waiting for database to be ready...
timeout /t 30 /nobreak

:: Run database migrations
echo 🗄️ Running database migrations...
docker-compose exec app php artisan migrate:fresh --seed

:: Generate application key
echo 🔑 Generating application key...
docker-compose exec app php artisan key:generate

:: Clear caches
echo 🧹 Clearing caches...
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache

:: Set permissions
echo 📂 Setting permissions...
docker-compose exec app chmod -R 777 storage bootstrap/cache

echo ✅ Setup complete!
echo.
echo 🌐 Application URLs:
echo    - Laravel App: http://localhost:8000
echo    - n8n Workflows: http://localhost:5678
echo    - MySQL: localhost:3306
echo    - Redis: localhost:6379
echo.
echo 🔐 n8n Login:
echo    - Username: admin
echo    - Password: n8npassword
echo.
echo 📋 Next Steps:
echo    1. Visit http://localhost:8000 to access the application
echo    2. Visit http://localhost:5678 to configure n8n workflows
echo    3. Import the workflow files from docker/n8n/workflows/
echo    4. Configure API keys in n8n for OpenAI, ElevenLabs, and Pexels

pause
