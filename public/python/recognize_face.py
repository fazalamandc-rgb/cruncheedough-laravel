import os
import sys
import cv2
import numpy as np
import json
from datetime import datetime

base_dir = os.path.dirname(os.path.abspath(__file__))
trainer_path = os.path.join(base_dir, 'trainer.yml')
user_map_path = os.path.join(base_dir, 'user_map.json')

# Load model and user map
if not os.path.exists(trainer_path) or not os.path.exists(user_map_path):
    print(json.dumps({"status": "error", "message": "Model files not found"}))
    sys.exit(1)

recognizer = cv2.face.LBPHFaceRecognizer_create()
recognizer.read(trainer_path)

with open(user_map_path, 'r') as f:
    user_map = json.load(f)

# Get image path from Laravel
image_path = sys.argv[1]

if not os.path.exists(image_path):
    print(json.dumps({"status": "error", "message": "Image file not found", "details": image_path}))
    sys.exit(1)

# Load and preprocess image
img = cv2.imread(image_path, cv2.IMREAD_GRAYSCALE)
if img is None:
    print(json.dumps({"status": "error", "message": "Failed to read image"}))
    sys.exit(1)

img = cv2.resize(img, (200, 200))
label, confidence = recognizer.predict(img)

user_id = user_map.get(str(label))

if user_id:
    print(json.dumps({
        "status": "success",
        "user_id": user_id,
        "image_filename": os.path.basename(image_path),
        "confidence": confidence
    }))
else:
    print(json.dumps({
        "status": "error",
        "message": "Face not recognized",
        "details": {"label": label, "confidence": confidence}
    }))
