#!/bin/bash
"""
Installation script for Python dependencies
Run this in your Docker container or local environment
"""

# Install Python packages
pip3 install -r requirements.txt

# Verify installations
echo "Verifying installations..."
python3 -c "import gtts; print('gTTS installed successfully')"
python3 -c "import requests; print('Requests installed successfully')"

echo "All Python dependencies installed successfully!"
echo ""
echo "Available scripts:"
echo "- create_video.py: Main video assembly script"
echo "- pixabay_client.py: Pixabay API client for videos/images"
echo "- unsplash_client.py: Unsplash API client for images"
echo "- gtts_client.py: Google Text-to-Speech client"
echo ""
echo "Usage examples:"
echo "python3 gtts_client.py 'Hello world' /tmp/speech.mp3"
echo "python3 pixabay_client.py YOUR_API_KEY 'nature' video"
echo "python3 unsplash_client.py YOUR_ACCESS_KEY 'landscape'"
