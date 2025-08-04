@echo off
echo ============================================
echo Testing YouTube Video Generator System
echo ============================================
echo.

echo Testing API endpoints...
echo.

echo 1. Testing Laravel health...
curl -s http://localhost:8000/api/health || echo "Laravel not ready yet"

echo.
echo 2. Testing n8n health...
curl -s http://localhost:5678/health || echo "N8n not ready yet"

echo.
echo 3. Testing video generation webhook...
curl -X POST http://localhost:5678/webhook/complete-video-generation ^
     -H "Content-Type: application/json" ^
     -d "{\"topic\":\"Test Video\",\"duration\":2,\"user_id\":1,\"video_id\":\"test-123\",\"api_token\":\"test-token\"}" || echo "Webhook not ready yet"

echo.
echo ============================================
echo Test completed!
echo ============================================
pause
