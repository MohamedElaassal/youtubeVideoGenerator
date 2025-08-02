# YouTube Video Generator - Free Services Setup Guide

## Overview
This YouTube Video Generator SaaS uses completely **FREE** services to create videos automatically:

- **Google Gemini**: Free AI script generation (1M tokens/day)
- **Pixabay**: Free stock videos (5000 requests/hour)  
- **Unsplash**: Free stock images (50 requests/hour for demo)
- **gTTS**: Free Google Text-to-Speech (unlimited)
- **FFmpeg**: Free video processing (open source)

## Quick Start with Docker

### 1. Get Free API Keys

**Gemini API (Free):**
- Visit: https://makersuite.google.com/app/apikey
- Sign in with Google account
- Click "Create API key"
- Copy the key

**Pixabay API (Free):**
- Visit: https://pixabay.com/api/docs/
- Create account and verify email
- Copy your API key from account settings

**Unsplash API (Free for Development):**
- Visit: https://unsplash.com/developers
- Create developer account
- Create new app
- Copy Access Key

### 2. Configure Environment

Create `.env` file in project root:
```bash
# Database
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=youtube_generator
DB_USERNAME=laravel_user
DB_PASSWORD=secure_password

# Laravel
APP_NAME="YouTube Generator"
APP_ENV=local
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=true
APP_URL=http://localhost:8000

# API Keys (FREE)
GEMINI_API_KEY=your_gemini_api_key_here
PIXABAY_API_KEY=your_pixabay_api_key_here
UNSPLASH_ACCESS_KEY=your_unsplash_access_key_here

# Redis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# N8n
N8N_BASIC_AUTH_ACTIVE=true
N8N_BASIC_AUTH_USER=admin
N8N_BASIC_AUTH_PASSWORD=password123
```

### 3. Update N8n Workflow Keys

Edit `docker/n8n/workflows/video-generation.json` and replace:
```javascript
gemini_api_key: "YOUR_GEMINI_API_KEY"
pixabay_api_key: "YOUR_PIXABAY_API_KEY" 
unsplash_access_key: "YOUR_UNSPLASH_ACCESS_KEY"
```

### 4. Start the Application

```bash
# Build and start all services
docker-compose up --build

# In separate terminal - run database migrations
docker-compose exec app php artisan migrate

# Generate application key
docker-compose exec app php artisan key:generate
```

### 5. Access the Application

- **Main App**: http://localhost:8000
- **N8n Workflows**: http://localhost:5678 (admin/password123)

## How It Works

### Free Video Generation Process:

1. **Script Generation**: Gemini AI creates engaging YouTube scripts
2. **Media Collection**: Pixabay provides background videos, Unsplash provides images
3. **Voice Creation**: gTTS converts script to natural speech audio
4. **Video Assembly**: FFmpeg combines media, audio, and effects
5. **YouTube Upload**: Automated upload via Google API

### Cost Breakdown (FREE for Development):

- **Gemini**: 1 million tokens/day free (≈500 video scripts)
- **Pixabay**: 5000 API requests/hour free (≈200 videos/hour)
- **Unsplash**: 50 requests/hour free (≈50 image sets/hour)
- **gTTS**: Unlimited free text-to-speech
- **FFmpeg**: Open source, completely free
- **Hosting**: Your own Docker containers

## Production Scaling

For production with millions of videos:

1. **Gemini Pro**: $0.50 per 1M tokens (very affordable)
2. **Pixabay Pro**: $9.99/month for unlimited requests
3. **Unsplash+**: $10/month for 10,000 requests
4. **ElevenLabs**: Premium TTS if needed
5. **Cloud Storage**: AWS S3 for video storage

## API Endpoints

The Laravel application provides these API endpoints for n8n:

- `POST /api/videos/{id}/status` - Update video generation status
- `POST /api/videos/{id}/youtube` - Update YouTube upload status
- `GET /api/autopilot/topics` - Get next topic for autopilot
- `POST /api/autopilot/complete` - Mark autopilot video complete

## Demo Features

- **Demo Login**: Skip OAuth setup during development
- **Manual Topics**: Test video generation with custom topics
- **Progress Tracking**: Real-time status updates
- **Autopilot Mode**: Fully automated video creation

## Free Service Limits

During development (1 month period):

- **Videos per day**: ~200-500 depending on complexity
- **API costs**: $0 (all free tiers)
- **Storage**: Local Docker volumes (free)
- **Bandwidth**: Your server only

Perfect for:
- MVP development
- Testing and validation
- Demo presentations
- Small-scale content creation

## Troubleshooting

**If videos fail to generate:**
1. Check API keys in n8n workflow
2. Verify Python dependencies: `docker-compose exec app pip3 list`
3. Check n8n logs: `docker-compose logs n8n`
4. Test FFmpeg: `docker-compose exec app ffmpeg -version`

**If workflows don't trigger:**
1. Import workflows manually in n8n interface
2. Activate workflows in n8n
3. Check webhook URLs match Laravel routes

## Next Steps

1. Test demo login and video generation
2. Configure your actual API keys
3. Import and activate n8n workflows
4. Generate your first automated video!

The system is designed to be **completely free** for development and testing, making it perfect for building your MVP before scaling to production.
