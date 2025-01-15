<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>QR Code Scanner</h3>
    <div class="row">
        <div class="col-md-6">
            <!-- Video stream untuk kamera -->
            <video id="preview" style="width: 100%; border: 1px solid #ccc;" autoplay></video>
        </div>
        <div class="col-md-6">
            <div class="alert alert-info" id="qr-result">
                Scan QR Code untuk melihat detail barang.
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    // Fungsi untuk menangkap hasil scan QR Code
    scanner.addListener('scan', function (content) {
        console.log('QR Code ditemukan:', content);

        // Redirect ke URL yang didapat dari QR Code
        window.location.href = content;
    });

    // Aktifkan kamera
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]); // Start kamera pertama (depan atau belakang)
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
