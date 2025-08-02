#!/usr/bin/env python3
"""
Google Text-to-Speech (gTTS) Client for YouTube Video Generator
Completely free TTS service with good quality
"""

from gtts import gTTS
import sys
import os
import logging

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

def create_speech(text, output_path, language='en', slow=False):
    """Create speech audio file from text using gTTS"""
    try:
        # Create gTTS object
        tts = gTTS(text=text, lang=language, slow=slow)

        # Save to file
        tts.save(output_path)

        logger.info(f"Speech created: {output_path}")
        return True

    except Exception as e:
        logger.error(f"Error creating speech: {e}")
        return False

def main():
    if len(sys.argv) < 3:
        logger.error("Usage: python3 gtts_client.py '<text>' <output_path> [language] [slow]")
        sys.exit(1)

    text = sys.argv[1]
    output_path = sys.argv[2]
    language = sys.argv[3] if len(sys.argv) > 3 else 'en'
    slow = sys.argv[4].lower() == 'true' if len(sys.argv) > 4 else False

    if create_speech(text, output_path, language, slow):
        print(f"SUCCESS: {output_path}")
    else:
        print("ERROR: Failed to create speech")
        sys.exit(1)

if __name__ == "__main__":
    main()
