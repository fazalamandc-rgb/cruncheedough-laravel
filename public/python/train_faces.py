import cv2
import os
import numpy as np
import json

folder = "public/face_images"
trainer_path = "public/python/trainer.yml"
user_map_path = "public/python/user_map.json"

# Check if folder exists
if not os.path.exists(folder):
    print(json.dumps({"status": "error", "message": "Face images folder not found."}))
    exit()

# Check if folder has any .jpg files
image_files = [f for f in os.listdir(folder) if f.endswith(".jpg")]
if not image_files:
    print(json.dumps({"status": "error", "message": "No images found for training."}))
    exit()

recognizer = cv2.face.LBPHFaceRecognizer_create()
faces = []
labels = []
user_map = {}

for idx, filename in enumerate(image_files):
    path = os.path.join(folder, filename)
    img = cv2.imread(path, cv2.IMREAD_GRAYSCALE)
    if img is None:
        continue  # Skip unreadable images
    faces.append(img)
    labels.append(idx + 1)
    user_map[str(idx + 1)] = filename

recognizer.train(faces, np.array(labels))
recognizer.save(trainer_path)

with open(user_map_path, "w") as f:
    json.dump(user_map, f)

print(json.dumps({"status": "success", "message": "Training completed successfully."}))
