#!/usr/bin/env python3
"""
Pixabay API Client for YouTube Video Generator
Free API with 5000 requests/hour limit
"""

import requests
import json
import sys
import logging

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

class PixabayClient:
    def __init__(self, api_key):
        self.api_key = api_key
        self.base_url = "https://pixabay.com/api"

    def search_videos(self, query, per_page=10, video_type="film"):
        """Search for videos on Pixabay"""
        params = {
            'key': self.api_key,
            'q': query,
            'video_type': video_type,
            'category': 'backgrounds',
            'per_page': per_page,
            'safesearch': 'true',
            'order': 'popular'
        }

        try:
            response = requests.get(f"{self.base_url}/videos/", params=params)
            response.raise_for_status()
            return response.json()
        except Exception as e:
            logger.error(f"Pixabay video search error: {e}")
            return {"hits": []}

    def search_images(self, query, per_page=10, image_type="photo"):
        """Search for images on Pixabay"""
        params = {
            'key': self.api_key,
            'q': query,
            'image_type': image_type,
            'category': 'backgrounds',
            'per_page': per_page,
            'safesearch': 'true',
            'order': 'popular',
            'min_width': 1920,
            'min_height': 1080
        }

        try:
            response = requests.get(f"{self.base_url}/", params=params)
            response.raise_for_status()
            return response.json()
        except Exception as e:
            logger.error(f"Pixabay image search error: {e}")
            return {"hits": []}

def main():
    if len(sys.argv) != 4:
        logger.error("Usage: python3 pixabay_client.py <api_key> <query> <media_type>")
        sys.exit(1)

    api_key = sys.argv[1]
    query = sys.argv[2]
    media_type = sys.argv[3]  # 'video' or 'image'

    client = PixabayClient(api_key)

    if media_type == 'video':
        results = client.search_videos(query, per_page=5)
        media_list = []

        for hit in results.get('hits', []):
            # Get medium quality video URL
            video_url = hit.get('videos', {}).get('medium', {}).get('url')
            if video_url:
                media_list.append({
                    'type': 'video',
                    'url': video_url,
                    'title': hit.get('tags', 'Video'),
                    'duration': hit.get('duration', 10)
                })

        print(json.dumps(media_list))

    elif media_type == 'image':
        results = client.search_images(query, per_page=8)
        media_list = []

        for hit in results.get('hits', []):
            # Get large image URL
            image_url = hit.get('largeImageURL') or hit.get('webformatURL')
            if image_url:
                media_list.append({
                    'type': 'image',
                    'url': image_url,
                    'title': hit.get('tags', 'Image')
                })

        print(json.dumps(media_list))

    else:
        logger.error("Media type must be 'video' or 'image'")
        sys.exit(1)

if __name__ == "__main__":
    main()
