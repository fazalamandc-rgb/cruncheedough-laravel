import cv2
import json
import sys

# Access the default camera
cap = cv2.VideoCapture(0)

if not cap.isOpened():
    print(json.dumps({"status": "error", "message": "Cannot open camera"}))
    sys.exit()

ret, frame = cap.read()

if ret:
    file_path = "public/captured_image.jpg"  # relative to Laravel root
    cv2.imwrite(file_path, frame)
    print(json.dumps({"status": "success", "image": "captured_image.jpg"}))
else:
    print(json.dumps({"status": "error", "message": "Failed to capture image"}))

cap.release()
cv2.destroyAllWindows()
