import sys
import time
import cv2
import json

# Capture user ID from the command-line argument
user_id = sys.argv[1]

# Define the path to save the captured image
image_path = "C:/inetpub/wwwroot/larval-Crunchee/public/face_images/user_" + str(user_id) + "_" + str(int(time.time())) + ".jpg"

# Open the webcam
cap = cv2.VideoCapture(0)

# Check if the webcam is opened
if not cap.isOpened():
    print("Error: Could not open webcam.")
    sys.exit()

# Capture an image
ret, frame = cap.read()

if ret:
    # Save the captured image
    cv2.imwrite(image_path, frame)

    # Release the camera
    cap.release()

    # Prepare success message and output
    output = {
        'status': 'success',
        'message': 'Face image captured successfully',
        'image_filename': image_path.split('/')[-1]  # Get just the filename (e.g., user_1_20250421135635.jpg)
    }
    print(json.dumps(output))
else:
    # Release the camera and output error
    cap.release()
    print(json.dumps({'status': 'error', 'message': 'Failed to capture image'}))
