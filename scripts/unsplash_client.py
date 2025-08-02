#!/usr/bin/env python3
"""
Unsplash API Client for YouTube Video Generator
Free API with 50 requests/hour limit for demo/development
"""

import requests
import json
import sys
import logging

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

class UnsplashClient:
    def __init__(self, access_key):
        self.access_key = access_key
        self.base_url = "https://api.unsplash.com"
        self.headers = {
            'Authorization': f'Client-ID {access_key}',
            'Accept-Version': 'v1'
        }

    def search_photos(self, query, per_page=10, orientation="landscape"):
        """Search for photos on Unsplash"""
        params = {
            'query': query,
            'per_page': per_page,
            'orientation': orientation,
            'order_by': 'relevant',
            'content_filter': 'high'
        }

        try:
            response = requests.get(
                f"{self.base_url}/search/photos",
                headers=self.headers,
                params=params
            )
            response.raise_for_status()
            return response.json()
        except Exception as e:
            logger.error(f"Unsplash search error: {e}")
            return {"results": []}

def main():
    if len(sys.argv) != 3:
        logger.error("Usage: python3 unsplash_client.py <access_key> <query>")
        sys.exit(1)

    access_key = sys.argv[1]
    query = sys.argv[2]

    client = UnsplashClient(access_key)
    results = client.search_photos(query, per_page=8)

    media_list = []

    for photo in results.get('results', []):
        # Get regular size image URL (suitable for 1920x1080)
        image_url = photo.get('urls', {}).get('regular')
        if image_url:
            media_list.append({
                'type': 'image',
                'url': image_url,
                'title': photo.get('alt_description') or photo.get('description') or 'Unsplash Image',
                'credit': f"Photo by {photo.get('user', {}).get('name', 'Unknown')} on Unsplash"
            })

    print(json.dumps(media_list))

if __name__ == "__main__":
    main()
