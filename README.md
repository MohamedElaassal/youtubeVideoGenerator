# 🎬 VideoGenius AI - YouTube Video Generator SaaS



![VideoGenius AI](https://img.shields.io/badge/VideoGenius-AI%20Powered-blueviolet?style=for-the-badge&logo=youtube&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?style=for-the-badge&logo=docker&logoColor=white)

**Transform any topic into viral YouTube content with the power of AI**

[🚀 Live Demo](#demo) • [📖 Documentation](#documentation) • [🛠️ Installation](#installation) • [🤝 Contributing](#contributing)

</div>

---

## 🌟 Overview

VideoGenius AI is a revolutionary SaaS platform that automates the entire YouTube video creation process. From script generation to final upload, our AI-powered system handles everything, enabling creators to scale from weekly uploads to daily content production effortlessly.

### ✨ Key Features

- 🤖 **AI Script Generation** - GPT-4 powered viral script creation
- 🎨 **Smart Visual Selection** - Automatic stock footage and image selection
- 🗣️ **Professional Voiceover** - Natural AI voice synthesis with 40+ voices
- 🔄 **Autopilot Mode** - 24/7 automated video creation and scheduling
- 📺 **Direct YouTube Upload** - Seamless channel integration with OAuth 2.0
- 📊 **Advanced Analytics** - Real-time performance tracking and insights
- 🎯 **SEO Optimization** - AI-generated titles, descriptions, and tags
- 🌐 **Multi-language Support** - Create content in multiple languages

## 🏗️ Architecture

### Tech Stack

**Backend:**
- 🐘 **Laravel 12** - Modern PHP framework with elegant syntax
- 🔄 **Inertia.js** - SPA experience without API complexity
- 🐳 **Docker Compose** - Containerized microservices architecture
- 🗄️ **MySQL 8.0** - Robust relational database
- ⚡ **Redis** - High-performance caching and session storage
- 🔧 **n8n** - Workflow automation and AI orchestration

**Frontend:**
- 💚 **Vue.js 3** - Progressive JavaScript framework
- 🎨 **Tailwind CSS** - Utility-first CSS framework
- ✨ **Custom Animations** - Glassmorphism and particle effects
- 📱 **Responsive Design** - Mobile-first approach
- ⚡ **Vite** - Lightning-fast build tool

**AI & APIs:**
- 🧠 **OpenAI GPT-4 or Gemini** - Advanced script generation
- 🎤 **Text-to-Speech** - Multiple TTS providers
- 📸 **Pexels API** - High-quality stock media
- 📺 **YouTube API v3** - Direct channel integration
- 🔐 **Google OAuth 2.0** - Secure authentication

### System Architecture

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │   Backend       │    │   AI Services   │
│   (Vue.js)      │◄──►│   (Laravel)     │◄──►│   (GPT-4, TTS)  │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Web Server    │    │   Database      │    │   Media APIs    │
│   (Nginx)       │    │   (MySQL)       │    │   (Pexels)      │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         └───────────────────────┼───────────────────────┘
                                 ▼
                    ┌─────────────────┐
                    │   Docker        │
                    │   Compose       │
                    └─────────────────┘
```

## 🔧 n8n Workflow Integration

VideoGenius AI leverages **n8n** as the core automation engine that orchestrates the entire video creation pipeline. The workflow handles AI service coordination, media processing, and YouTube publishing in a visual, node-based environment.

### 📋 Workflow Import

The complete video generation workflow is defined in `complete_video_generator.json`. This workflow must be imported into your n8n instance to enable automated video creation.

**To import the workflow:**

1. **Access n8n Dashboard**
   ```
   http://localhost:5678
   ```

2. **Import Workflow**
   - Click "Import from File"
   - Select `workflows/complete_video_generator.json`
   - The workflow will automatically connect to Laravel backend

3. **Workflow Configuration**
   ```bash
   # No API credentials needed in n8n!
   # Laravel handles all external API integrations:
   # - OpenAI/GEMINI API (configured in Laravel .env)
   # - Pexels API (configured in Laravel .env)
   # - Google Cloud TTS (configured in Laravel .env)
   # - YouTube API (OAuth handled by Laravel)
   # 
   # n8n only needs Laravel webhook endpoints
   ```

### 🏗️ n8n Workflow Architecture

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Trigger       │    │   Script Gen    │    │   Media Search  │
│   (Webhook)     │───►│   (OpenAI)      │───►│   (Pexels API)  │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                │                       │
                                ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Status Update │    │   Voice Gen     │    │   Media Filter  │
│   (Laravel API) │◄───│   (TTS API)     │◄───│   (Processing)  │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Video Compile │    │   SEO Optimize  │    │   YouTube Upload│
│   (Python Script)│───►│   (AI Generated)│───►│   (API v3)      │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         └───────────────────────┼───────────────────────┘
                                 ▼
                    ┌─────────────────┐
                    │   Final Status  │
                    │   (Webhook)     │
                    └─────────────────┘
```

### 🎬 Workflow Nodes Breakdown

**1. Webhook Trigger**
- Receives video creation requests from Laravel
- Validates input parameters (topic, style, duration)
- Initiates the automation pipeline

**2. Script Generation (Laravel API Call)**
- Sends request to Laravel backend for script creation
- Laravel handles OpenAI GPT-4 integration internally
- Returns structured script with timestamps

**3. Media Selection (Laravel API Call)**
- Requests media assets from Laravel backend
- Laravel handles Pexels API integration and filtering
- Returns curated media URLs and metadata

**4. Voiceover Generation (Laravel API Call)**
- Sends script to Laravel for TTS processing
- Laravel manages TTS service integration
- Returns audio file URL and duration

**5. Video Compilation (Laravel Queue Job)**
- Triggers Laravel queue job for video assembly
- Laravel executes Python scripts internally
- Combines all assets into final MP4

**6. SEO Optimization (Laravel AI Service)**
- Requests optimized metadata from Laravel
- Laravel generates title, description, and tags
- Returns SEO-optimized content

**7. YouTube Upload (Laravel OAuth)**
- Triggers Laravel YouTube upload service
- Laravel handles OAuth authentication and API calls
- Returns upload status and video URL

**8. Status Updates (Laravel Webhooks)**
- Receives progress updates from Laravel
- Updates workflow execution status
- Triggers completion notifications

### ⚙️ Workflow Configuration

# Webhook URLs
LARAVEL_APP_URL=http://app:9000
N8N_WEBHOOK_URL=http://n8n:5678/webhook

# External API Endpoints
GEMINI_ENDPOINT=https://api.openai.com/v1
PEXELS_ENDPOINT=https://api.pexels.com/v1
YOUTUBE_ENDPOINT=https://www.googleapis.com/upload/youtube/v3
```

### 📊 Workflow Monitoring

Monitor your n8n workflows through:
- **Execution History**: Track success/failure rates
- **Performance Metrics**: Average processing times
- **Error Logs**: Debug failed executions
- **Resource Usage**: CPU and memory consumption

### 🔄 Workflow Customization

The `complete_video_generator.json` workflow can be customized for:
- **Different Content Types**: Educational, entertainment, news
- **Brand Guidelines**: Add custom intro/outro sequences
- **Publishing Schedules**: Set automated upload timing
- **Quality Settings**: Adjust video resolution and bitrate

**Advanced Customization:**
```javascript
// Example: Custom script generation prompt
{
  "prompt": "Create a {{$json.style}} YouTube script about {{$json.topic}} that is {{$json.duration}} long, includes viral hooks, and targets {{$json.audience}} audience.",
  "max_tokens": 1500,
  "temperature": 0.7
}
```

## 🚀 Installation

### Prerequisites

- Docker and Docker Compose
- Git
- Google Developer Account (for YouTube API)
- OpenAI API Key

### Quick Start

1. **Clone the repository**
```bash
git clone https://github.com/MohamedElaassal/youtubeVideoGenerator.git
cd youtubeVideoGenerator
```

2. **Environment Configuration**
```bash
cp .env.example .env
```

3. **Configure your environment variables**
```env
# Database
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=youtube_generator
DB_USERNAME=root
DB_PASSWORD=secret

# Google OAuth & YouTube API
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# AI Services
OPENAI_API_KEY=your_openai_api_key
PEXELS_API_KEY=your_pexels_api_key

# TTS Configuration
TTS_SERVICE=gTTS
TTS_LANGUAGE=en
```

4. **Build and start the application**
```bash
docker-compose up -d --build
```

5. **Install dependencies and setup**
```bash
# Install PHP dependencies
docker-compose exec app composer install

# Install Node.js dependencies
docker-compose exec app npm install --legacy-peer-deps

# Generate application key
docker-compose exec app php artisan key:generate

# Run database migrations
docker-compose exec app php artisan migrate

# Build frontend assets
docker-compose exec app npm run build
```

6. **Access the application**
- **Frontend:** http://localhost:8000
- **n8n Workflow:** http://localhost:5678
- **Database:** localhost:3306

## 📁 Project Structure

```
youtubeVideoGenerator/
├── app/
│   ├── Http/Controllers/           # Application controllers
│   ├── Models/                     # Eloquent models
│   ├── Services/                   # Business logic services
│   └── Jobs/                       # Queue jobs for video processing
├── resources/
│   ├── js/
│   │   ├── Pages/                  # Vue.js pages
│   │   ├── Components/             # Reusable Vue components
│   │   └── Layouts/                # Application layouts
│   └── css/                        # Stylesheets with animations
├── scripts/
│   ├── video_generator.py          # Python video assembly
│   ├── tts_generator.py            # Text-to-speech generation
│   └── requirements.txt            # Python dependencies
├── workflows/
│   └── complete_video_generator.json  # n8n workflow (REQUIRED IMPORT)
├── docker-compose.yml              # Container orchestration
├── Dockerfile                      # Application container
└── README.md                       # This file
```

### 🚨 Important: n8n Workflow Setup

**The `complete_video_generator.json` file contains the core automation logic and MUST be imported into your n8n instance for the platform to function properly.**

## 🎯 Usage

### Basic Workflow

1. **Sign in with Google** - Connect your YouTube channel
2. **Create a Video** - Provide a topic or keyword
3. **AI Processing** - Watch as AI generates script, selects visuals, and creates voiceover
4. **Review & Edit** - Make any necessary adjustments
5. **Publish** - Upload directly to your YouTube channel

### Autopilot Mode

1. **Configure Channel Settings** - Set your niche and preferences
2. **Enable Autopilot** - Choose your publishing schedule
3. **Relax** - AI creates and publishes videos automatically

### Advanced Features

- **Bulk Video Creation** - Generate multiple videos from a list of topics
- **Custom Voice Selection** - Choose from 40+ AI voices
- **Brand Customization** - Add your logo and brand colors
- **Analytics Dashboard** - Track performance across all videos

## 🔧 Configuration

### Google OAuth Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing
3. Enable YouTube Data API v3
4. Create OAuth 2.0 credentials
5. Add authorized redirect URIs:
   - `http://localhost:8000/auth/google/callback`
   - `https://yourdomain.com/auth/google/callback`

### AI Service Configuration

#### Gemini or OpenAI API
- Sign up at [OpenAI Platform](https://platform.openai.com/)
- Generate API key
- Add to `.env` file

#### Pexels API
- Register at [Pexels](https://www.pexels.com/api/)
- Get free API key (50,000 requests/month)
- Add to `.env` file

## 🚀 Deployment

### Production Deployment

1. **Prepare production environment**
```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false
```

2. **Optimize for production**
```bash
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
docker-compose exec app npm run build
```

3. **SSL Configuration** (recommended)
- Use Let's Encrypt with Nginx
- Update Google OAuth redirect URIs

### Scaling

- **Horizontal Scaling**: Use Docker Swarm or Kubernetes
- **Database**: Consider read replicas for high traffic
- **Queue Workers**: Scale queue containers based on load
- **CDN**: Implement for static assets and generated videos

## 🔍 API Documentation

### Example for the Video Creation Endpoint

```http
POST /api/videos
Content-Type: application/json
Authorization: Bearer {token}

{
  "topic": "How to learn programming",
  "style": "educational",
  "duration": "5-10 minutes",
  "voice": "en-US-female-1"
}
```

### Response

```json
{
  "id": "uuid",
  "status": "processing",
  "topic": "How to learn programming",
  "estimated_completion": "2024-01-01T12:00:00Z",
  "progress": 0
}
```

## 🧪 Testing

```bash
# Run PHP tests
docker-compose exec app php artisan test

# Run JavaScript tests
docker-compose exec app npm run test

# Run integration tests
docker-compose exec app php artisan test --testsuite=Feature
```

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

### Development Setup

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

### Code Style

- **PHP**: Follow PSR-12 standards
- **JavaScript**: Use ESLint configuration
- **CSS**: Follow BEM methodology
- **Commits**: Use conventional commit messages

## 📊 Performance

### Benchmarks

- **Video Generation Time**: 2-5 minutes average
- **Concurrent Users**: 1000+ supported
- **API Response Time**: <200ms average
- **Database Queries**: Optimized with caching

### Optimization Features

- **Redis Caching**: Session and application cache
- **Queue Processing**: Background video generation
- **Database Indexing**: Optimized queries
- **CDN Ready**: Static asset optimization

## 🔒 Security

- **OAuth 2.0**: Secure Google authentication
- **CSRF Protection**: Laravel built-in protection
- **Rate Limiting**: API endpoint protection
- **Input Validation**: Comprehensive sanitization
- **Encrypted Secrets**: Secure token storage



## 🙏 Acknowledgments

- **Laravel Community** - For the amazing framework
- **Vue.js Team** - For the reactive frontend framework
- **OpenAI** - For GPT-4 API access
- **Pexels** - For high-quality stock media
- **Docker** - For containerization technology

---


**Built with ❤️ by [Mohamed Elaassal](https://github.com/MohamedElaassal)**

⭐ Star this repository if you find it helpful!


</div>
