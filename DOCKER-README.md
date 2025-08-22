# YouTube Video Generator - Docker Setup

## 🚀 Quick Start with Docker

This setup provides a complete containerized environment for the YouTube Video Generator application with n8n automation.

### Prerequisites

- Docker Desktop installed
- Docker Compose installed
- At least 4GB RAM available
- Ports 8000, 5678, 3306, 6379 available

### 🏗️ Architecture

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Laravel App   │    │      n8n        │    │     MySQL       │
│   (Port 8000)   │◄──►│   (Port 5678)   │◄──►│   (Port 3306)   │
└─────────────────┘    └─────────────────┘    └─────────────────┘
        │                       │                       │
        └───────────────────────┼───────────────────────┘
                               │
                    ┌─────────────────┐
                    │     Redis       │
                    │   (Port 6379)   │
                    └─────────────────┘
```

### 🔧 Services

| Service | Description | Port | Credentials |
|---------|-------------|------|-------------|
| **app** | Laravel Application | 8000 | - |
| **webserver** | Nginx Web Server | 80 | - |
| **db** | MySQL Database | 3306 | root/secret |
| **redis** | Redis Cache & Queues | 6379 | - |
| **queue** | Laravel Queue Worker | - | - |
| **n8n** | Automation Platform | 5678 | admin/n8npassword |
| **ffmpeg** | Video Processing | - | - |

## 🚀 Getting Started


### Linux/Mac Users:
```bash
chmod +x start.sh
./start.sh
```

### Manual Setup:
```bash
# 1. Copy environment file
cp .env.docker .env

# 2. Build containers
docker-compose build --no-cache

# 3. Start services
docker-compose up -d

# 4. Wait for database (30 seconds)
sleep 30

# 5. Run migrations
docker-compose exec app php artisan migrate:fresh --seed

# 6. Generate app key
docker-compose exec app php artisan key:generate

# 7. Clear caches
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache

# 8. Set permissions
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

## 🌐 Access Points

- **Laravel Application**: http://localhost:8000
- **n8n Workflows**: http://localhost:5678
- **MySQL Database**: localhost:3306
- **Redis**: localhost:6379

## 🔐 Default Credentials

### n8n Dashboard
- **URL**: http://localhost:5678
- **Username**: admin
- **Password**: n8npassword

### MySQL Database
- **Host**: localhost
- **Port**: 3306
- **Database**: ytVideoGen
- **Username**: root
- **Password**: secret

## 🤖 n8n Workflows

The application includes 3 pre-configured workflows:

### 1. Video Generation Workflow
**File**: `docker/n8n/workflows/video-generation.json`

**Flow**:
1. Receives webhook with video topic
2. Generates script using OpenAI GPT-4
3. Fetches relevant visuals from Pexels
4. Creates voiceover using ElevenLabs TTS
5. Assembles video using FFmpeg
6. Updates video status in database

**Webhook URL**: `http://localhost:5678/webhook/video-generation`

### 2. YouTube Upload Workflow
**File**: `docker/n8n/workflows/youtube-upload.json`

**Flow**:
1. Receives upload request
2. Gets video details from database
3. Uploads to YouTube using API
4. Updates upload status

**Webhook URL**: `http://localhost:5678/webhook/youtube-upload`

### 3. Autopilot Workflow
**File**: `docker/n8n/workflows/autopilot.json`

**Flow**:
1. Runs daily via cron schedule
2. Gets scheduled video topics
3. Triggers video generation for each
4. Waits for processing completion
5. Automatically uploads to YouTube

## 🔑 API Keys Configuration

### Required API Keys

1. **OpenAI API Key**
   - Sign up at: https://platform.openai.com/
   - Add to n8n credentials as "OpenAI API"

2. **ElevenLabs API Key**
   - Sign up at: https://elevenlabs.io/
   - Add to n8n credentials as "ElevenLabs API"

3. **Pexels API Key**
   - Sign up at: https://www.pexels.com/api/
   - Add to n8n credentials as "Pexels API"

4. **Google OAuth & YouTube API**
   - Already configured in `.env.docker`
   - Update with your actual credentials

### Adding API Keys to n8n

1. Visit http://localhost:5678
2. Login with admin/n8npassword
3. Go to Settings → Credentials
4. Add new credentials for each service
5. Import the workflow files
6. Update credential references in workflows

## 📁 Project Structure

```
project/
├── docker/
│   ├── nginx/           # Nginx configuration
│   ├── php/             # PHP configuration
│   └── n8n/
│       └── workflows/   # n8n workflow definitions
├── docker-compose.yml   # Docker services configuration
├── Dockerfile          # Laravel app container
├── .env.docker         # Environment variables for Docker
├── start.sh           # Linux/Mac startup script

```

## 🔧 Development Commands

### Container Management
```bash
# Start all services
docker-compose up -d

# Stop all services
docker-compose down

# View logs
docker-compose logs -f app
docker-compose logs -f n8n

# Restart specific service
docker-compose restart app
```

### Laravel Commands
```bash
# Run artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan queue:work
docker-compose exec app php artisan cache:clear

# Access container shell
docker-compose exec app bash
```

### Database Operations
```bash
# Access MySQL
docker-compose exec db mysql -u root -p

# Backup database
docker-compose exec db mysqldump -u root -p ytVideoGen > backup.sql

# Restore database
docker-compose exec -T db mysql -u root -p ytVideoGen < backup.sql
```

## 🐛 Troubleshooting

### Common Issues

1. **Port Already in Use**
   ```bash
   # Check what's using the port
   netstat -tulpn | grep :8000
   
   # Kill process or change port in docker-compose.yml
   ```

2. **Database Connection Failed**
   ```bash
   # Wait longer for database to initialize
   sleep 60
   
   # Check database logs
   docker-compose logs db
   ```

3. **Permission Denied**
   ```bash
   # Fix permissions
   docker-compose exec app chmod -R 777 storage bootstrap/cache
   ```

4. **n8n Workflows Not Working**
   - Check API keys are properly configured
   - Verify webhook URLs are accessible
   - Check n8n logs: `docker-compose logs n8n`

### Reset Everything
```bash
# Stop and remove everything
docker-compose down -v
docker system prune -a

# Start fresh
 ./start.sh
```

## 📊 Monitoring

### Health Checks
```bash
# Check all containers status
docker-compose ps

# Check resource usage
docker stats

# Test application
curl http://localhost:8000
curl http://localhost:5678
```

### Logs
```bash
# View all logs
docker-compose logs -f

# View specific service logs
docker-compose logs -f app
docker-compose logs -f n8n
docker-compose logs -f queue
```

## 🔄 Updates

### Update Application
```bash
# Pull latest changes
git pull

# Rebuild containers
docker-compose build --no-cache

# Restart services
docker-compose up -d
```

### Update Dependencies
```bash
# Update PHP dependencies
docker-compose exec app composer update

# Update Node dependencies
docker-compose exec app npm update
```

## 🚀 Production Deployment

For production deployment:

1. Update `.env.docker` with production values
2. Set `APP_ENV=production` and `APP_DEBUG=false`
3. Configure proper domain names
4. Set up SSL certificates
5. Use external database and Redis services
6. Configure proper backup strategies
7. Set up monitoring and alerting

## 📋 Testing the Complete Workflow

1. **Access Application**: http://localhost:8000
2. **Login**: Use demo login or Google OAuth
3. **Create Video**: Go to dashboard, create new video
4. **Test n8n**: Check http://localhost:5678 for workflow execution
5. **Monitor Progress**: Watch logs and database for updates
6. **Verify Output**: Check generated videos and YouTube uploads

## 💡 Performance Optimization

### Resource Allocation
- Increase memory limits in `docker-compose.yml`
- Add more queue workers for parallel processing
- Use SSD storage for better I/O performance

### Scaling
- Use Docker Swarm or Kubernetes for horizontal scaling
- Separate video processing to dedicated servers
- Implement CDN for video storage and delivery

## 🆘 Support

If you encounter issues:

1. Check logs: `docker-compose logs -f`
2. Verify all services are running: `docker-compose ps`
3. Test individual components
4. Check API keys and credentials
5. Review n8n workflow configurations

---

**Happy Video Generating! 🎬**
