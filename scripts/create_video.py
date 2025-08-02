#!/usr/bin/env python3
"""
Video Assembly Script for YouTube Video Generator
Uses free services: gTTS, FFmpeg, Pixabay, Unsplash
"""

import json
import sys
import os
import requests
import subprocess
from pathlib import Path
import tempfile
import logging

# Set up logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

def download_file(url, local_path):
    """Download file from URL to local path"""
    try:
        response = requests.get(url, stream=True, timeout=30)
        response.raise_for_status()

        with open(local_path, 'wb') as f:
            for chunk in response.iter_content(chunk_size=8192):
                f.write(chunk)

        logger.info(f"Downloaded: {local_path}")
        return True
    except Exception as e:
        logger.error(f"Failed to download {url}: {e}")
        return False

def create_video_from_images(image_paths, output_path, duration_per_image=3):
    """Create video from images using FFmpeg"""
    try:
        # Create input file list for FFmpeg
        with tempfile.NamedTemporaryFile(mode='w', suffix='.txt', delete=False) as f:
            for img_path in image_paths:
                f.write(f"file '{img_path}'\n")
                f.write(f"duration {duration_per_image}\n")
            # Add last image again for proper ending
            if image_paths:
                f.write(f"file '{image_paths[-1]}'\n")
            input_list_path = f.name

        # FFmpeg command to create video from images
        cmd = [
            'ffmpeg', '-y',  # Overwrite output file
            '-f', 'concat',
            '-safe', '0',
            '-i', input_list_path,
            '-vf', 'scale=1920:1080:force_original_aspect_ratio=decrease,pad=1920:1080:(ow-iw)/2:(oh-ih)/2',
            '-r', '30',  # Frame rate
            '-c:v', 'libx264',
            '-pix_fmt', 'yuv420p',
            output_path
        ]

        result = subprocess.run(cmd, capture_output=True, text=True)

        # Clean up
        os.unlink(input_list_path)

        if result.returncode == 0:
            logger.info(f"Video created: {output_path}")
            return True
        else:
            logger.error(f"FFmpeg error: {result.stderr}")
            return False

    except Exception as e:
        logger.error(f"Error creating video from images: {e}")
        return False

def add_audio_to_video(video_path, audio_path, output_path):
    """Add audio to video using FFmpeg"""
    try:
        cmd = [
            'ffmpeg', '-y',
            '-i', video_path,
            '-i', audio_path,
            '-c:v', 'copy',
            '-c:a', 'aac',
            '-shortest',  # End when shortest stream ends
            output_path
        ]

        result = subprocess.run(cmd, capture_output=True, text=True)

        if result.returncode == 0:
            logger.info(f"Audio added to video: {output_path}")
            return True
        else:
            logger.error(f"FFmpeg audio error: {result.stderr}")
            return False

    except Exception as e:
        logger.error(f"Error adding audio to video: {e}")
        return False

def main():
    if len(sys.argv) != 2:
        logger.error("Usage: python3 create_video.py '<json_data>'")
        sys.exit(1)

    try:
        # Parse input data
        data = json.loads(sys.argv[1])
        video_id = data['video_id']
        media_list = data['media_list']
        voiceover_path = data['voiceover_path']

        logger.info(f"Creating video {video_id} with {len(media_list)} media items")

        # Create temp directory for this video
        temp_dir = Path(f"/tmp/video_{video_id}")
        temp_dir.mkdir(exist_ok=True)

        # Download media files
        image_paths = []
        video_paths = []

        for i, media in enumerate(media_list):
            if media['type'] == 'image':
                local_path = temp_dir / f"image_{i}.jpg"
                if download_file(media['url'], local_path):
                    image_paths.append(str(local_path))
            elif media['type'] == 'video':
                local_path = temp_dir / f"video_{i}.mp4"
                if download_file(media['url'], local_path):
                    video_paths.append(str(local_path))

        # Create video from images if we have any
        if image_paths:
            images_video_path = temp_dir / "images_video.mp4"
            if create_video_from_images(image_paths, str(images_video_path)):
                video_paths.append(str(images_video_path))

        # For now, use the first video or images video
        if video_paths:
            base_video_path = video_paths[0]
        else:
            logger.error("No media available for video creation")
            sys.exit(1)

        # Add voiceover if available
        final_video_path = f"/tmp/final_video_{video_id}.mp4"

        if os.path.exists(voiceover_path):
            if add_audio_to_video(base_video_path, voiceover_path, final_video_path):
                logger.info(f"Video completed: {final_video_path}")
            else:
                # Fallback: copy base video
                import shutil
                shutil.copy2(base_video_path, final_video_path)
                logger.info(f"Video completed (no audio): {final_video_path}")
        else:
            # No voiceover, just copy the base video
            import shutil
            shutil.copy2(base_video_path, final_video_path)
            logger.info(f"Video completed (no voiceover): {final_video_path}")

        # Clean up temp directory
        import shutil
        shutil.rmtree(temp_dir, ignore_errors=True)

        logger.info("Video assembly completed successfully")
        print(f"SUCCESS: {final_video_path}")

    except Exception as e:
        logger.error(f"Error in main: {e}")
        sys.exit(1)

if __name__ == "__main__":
    main()
