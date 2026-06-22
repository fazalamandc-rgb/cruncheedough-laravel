<!-- resources/views/recognize_face.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Auto Face Recognition</title>
</head>
<body>
    <video id="video" width="320" height="240" autoplay></video>
    <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>

    <form id="uploadForm" method="POST" action="{{ route('recognize-face') }}">
        @csrf
        <input type="hidden" name="image" id="image">
    </form>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        const form = document.getElementById('uploadForm');
        const imageDataField = document.getElementById('image');

        // Start webcam
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;

                // Wait 2 seconds, capture image, and submit
                setTimeout(() => {
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    const imageData = canvas.toDataURL('image/jpeg');
                    imageDataField.value = imageData;
                    form.submit();
                }, 2000); // adjust delay if needed
            })
            .catch((err) => {
                alert("Error accessing webcam: " + err);
            });
    </script>
</body>
</html>
