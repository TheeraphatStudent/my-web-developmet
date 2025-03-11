<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/../component.php');

class QrCodeReader extends Component
{
    public function render()
    {
?>
        <div id="camera-container" class="relative w-full h-full max-h-[675px] rounded-xl overflow-hidden">
            <video id="qr-video" width="1200" height="675" class=" bg-black/50 overflow-hidden" autoplay></video>
            <canvas id="qr-canvas" style="display: none;"></canvas>

            <div id="camera-bg" class="flex p-5 top-0 left-0 absolute w-full h-full gap-4">
                <div id="suggested" class="text-center w-fit min-w-[128px] h-fit px-3 py-1 rounded-lg font-medium text-lg"></div>


            </div>
        </div>

        <div id="qr-result"></div>

        <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
        <script type="module">
            import {
                CameraInit
            } from './components/camera/camera.js';

            document.addEventListener('DOMContentLoaded', () => {
                const cameraInit = new CameraInit();
            });
        </script>
<?php

    }
    public function getResponse() {}
}
