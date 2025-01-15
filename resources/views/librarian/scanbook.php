<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
</head>
<body>
    <h3>QR Code Scanner</h3>
    <video id="preview" style="width: 100%; border: 1px solid #ccc;" autoplay></video>

    <script>
        // Inisialisasi scanner dan video element
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

        // Event listener saat QR code terdeteksi
        scanner.addListener('scan', function (content) {
            console.log('QR Code ditemukan:', content);
            // Redirect atau tampilkan informasi berdasarkan QR code
            window.location.href = content;  // Ganti dengan logika Anda
        });

        // Mengakses kamera
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);  // Start kamera pertama
            } else {
                alert('Kamera tidak ditemukan!');
            }
        }).catch(function (e) {
            console.error(e);
            alert('Gagal mengakses kamera: ' + e);
        });
    </script>
</body>
</html>
