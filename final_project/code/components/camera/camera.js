class CameraInit {
    video = null;
    canvas = null;
    content = null;
    result = null;
    suggested = null;
    reloadBtn = null;
    cameraBg = null;

    constructor() {
        this.video = document.getElementById("qr-video");
        this.canvas = document.getElementById("qr-canvas");
        this.context = this.canvas.getContext("2d");
        this.result = document.getElementById("qr-result");

        this.cameraBg = document.getElementById('camera-bg');
        this.suggested = document.getElementById('suggested');
        this.reloadBtn = document.getElementById('reload');

        this.initializeCamera();
    }

    initializeCamera() {
        this.updateSuggested("อย่าลืมเชื่อมต่อกับกล้อง", "bg-red/40");

        navigator.mediaDevices.getUserMedia({
            video: { facingMode: "environment" }
        })
            .then(this.permissionAccept.bind(this))
            .catch(this.permissionError.bind(this));
    }

    updateSuggested(text, bgClass = "bg-red/40") {
        this.suggested.textContent = text;
        this.suggested.className = `${bgClass} text-white text-center w-fit min-w-[128px] h-fit px-3 py-1 rounded-lg font-medium text-lg`;
    }

    permissionAccept(stream) {
        this.video.srcObject = stream;
        this.video.play();

        this.cameraBg.classList.replace("bg-black/20", "bg-red/20");

        this.updateSuggested("วาง QR Code ไว้ในกรอบ", "bg-black/40");
        this.reloadBtn.classList.add('hidden');

        requestAnimationFrame(this.tick.bind(this));
    }

    permissionError() {
        this.cameraBg.classList.replace("bg-red/20", "bg-black/20");

        this.updateSuggested("อย่าลืมเชื่อมต่อกับกล้อง");
        this.reloadBtn.classList.remove('hidden');

        this.reloadBtn.addEventListener('click', () => {
            navigator.mediaDevices.getUserMedia({ video: true })
            window.location.reload();

        })
    }

    tick() {
        if (this.video.readyState === this.video.HAVE_ENOUGH_DATA) {
            this.canvas.height = this.video.videoHeight;
            this.canvas.width = this.video.videoWidth;

            this.context.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);

            const imageData = this.context.getImageData(0, 0, this.canvas.width, this.canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: "dontInvert",
            });

            if (code) {
                alert("QR Code detected: " + code.data);
                this.result.innerText = "QR Code detected: " + code.data;
            } else {
                this.result.innerText = "No QR code detected.";
            }
        }

        requestAnimationFrame(this.tick.bind(this));
    }
}

export { CameraInit }