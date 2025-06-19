import sys
import logging

logging.basicConfig(stream=sys.stderr)

# Path to your Flask application
sys.path.insert(0, "/mnt/volume-fsn1-1/web/search")

from app import app as application
