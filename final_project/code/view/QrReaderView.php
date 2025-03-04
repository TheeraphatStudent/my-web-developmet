<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style/main.css">
</head>

<body>
    <h1>QR Code Scanner</h1>
    <video id="qr-video" width="100%" height="auto" autoplay></video>

    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const video = document.getElementById("qr-video");
            const canvas = document.getElementById("qr-canvas");
            const context = canvas.getContext("2d");
            const resultDiv = document.getElementById("qr-result");

            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment"
                    }
                })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                    requestAnimationFrame(tick);
                })
                .catch(function(err) {
                    console.error("Error accessing the camera: ", err);
                });

            function tick() {
                if (video.readyState === video.HAVE_ENOUGH_DATA) {
                    canvas.height = video.videoHeight;
                    canvas.width = video.videoWidth;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                    const code = jsQR(imageData.data, imageData.width, imageData.height, {
                        inversionAttempts: "dontInvert",
                    });

                    if (code) {
                        resultDiv.innerText = "QR Code detected: " + code.data;
                    } else {
                        resultDiv.innerText = "No QR code detected.";
                    }
                }

                requestAnimationFrame(tick);
            }
        });
    </script>
</body>

</html>