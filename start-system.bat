@echo off
echo ============================================
echo YouTube Video Generator SaaS - Full Setup
echo ============================================
echo.

echo Step 1: Building and starting Docker containers...
docker-compose up -d --build

echo.
echo Step 2: Waiting for containers to be ready...
timeout /t 30 /nobreak > nul

echo.
echo Step 3: Running database migrations...
docker-compose exec app php artisan migrate --force

echo.
echo Step 4: Generating application key...
docker-compose exec app php artisan key:generate

echo.
echo Step 5: Installing Python dependencies...
docker-compose exec app pip3 install -r /app/scripts/requirements.txt

echo.
echo Step 6: Setting up queue worker...
docker-compose exec -d app php artisan queue:work redis

echo.
echo ============================================
echo SYSTEM READY!
echo ============================================
echo.
echo Access your application:
echo - Main App: http://localhost:8000
echo - N8n Workflows: http://localhost:5678 (admin/password123)
echo - Demo Login: Use demo@example.com / password
echo.
echo Next steps:
echo 1. Go to http://localhost:5678 and import the workflow
echo 2. Import: docker/n8n/workflows/complete-video-generator.json
echo 3. Activate the workflow
echo 4. Test video generation!
echo.
pause
