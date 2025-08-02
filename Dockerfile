FROM php:8.2

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    ffmpeg \
    python3 \
    python3-pip \
    && rm -rf /var/lib/apt/lists/*

# Install Python dependencies for video processing
COPY scripts/requirements.txt /tmp/requirements.txt
RUN pip3 install -r /tmp/requirements.txt

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Python packages for TTS
RUN pip3 install gTTS pydub

# Set working directory
WORKDIR /var/www/html

# Copy application files
# Copy application code
COPY . /var/www

# Copy Python scripts to accessible location
COPY scripts/ /app/scripts/
RUN chmod +x /app/scripts/*.py

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies and build assets
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 8000

# Start application
CMD php artisan serve --host=0.0.0.0 --port=8000
