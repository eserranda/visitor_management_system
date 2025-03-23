document.getElementById('camera_on').addEventListener('click', function() {
    cameraOn();
});

function cameraOn() {
    const cameraOn = document.getElementById('camera_on');
    const cameraElement = document.getElementById('camera');
    const captureButton = document.getElementById('capture');
    const retakeButton = document.getElementById('retake');
    const previewElement = document.getElementById('preview');
    // untuk menyimpan data gambar
    const hiddenInput = document.getElementById('captured_image');
    
    let stream;
    
    // Fungsi untuk memulai kamera
    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: true, 
                audio: false 
            });
            cameraElement.srcObject = stream;
            
            // Sembunyikan tombol aktifkan kamera
            cameraOn.style.display = 'none';

            // Tampilkan elemen kamera dan tombol ambil foto
            cameraElement.style.display = 'block';
            captureButton.style.display = 'inline-block';
            
            // Sembunyikan preview dan tombol lainnya
            previewElement.style.display = 'none';
            retakeButton.style.display = 'none';
        } catch (err) {
            console.error('Error accessing camera:', err);
            alert('Tidak dapat mengakses kamera. Mohon periksa izin kamera pada browser Anda.');
        }
    }
    
    // Fungsi untuk menghentikan kamera
    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    }
    
    // Fungsi untuk mengambil foto
    function captureImage() {
        const canvas = document.createElement('canvas');
        const size = Math.min(cameraElement.videoWidth, cameraElement.videoHeight);
        canvas.width = size;
        canvas.height = size;
        
        const context = canvas.getContext('2d');
        
        // Membuat clip circle
        context.beginPath();
        context.arc(size/2, size/2, size/2, 0, Math.PI * 2, true);
        context.closePath();
        context.clip();
        
        // Menggambar gambar di tengah
        const offsetX = (cameraElement.videoWidth - size) / 2;
        const offsetY = (cameraElement.videoHeight - size) / 2;
        context.drawImage(
            cameraElement, 
            offsetX, offsetY, size, size,
            0, 0, size, size
        );
        
        // Konversi gambar ke base64
        const imageData = canvas.toDataURL('image/jpeg');
        
        // Tampilkan preview dan sembunyikan kamera
        previewElement.src = imageData;
        previewElement.style.display = 'block';
        cameraElement.style.display = 'none';
        
        // Tampilkan tombol ambil ulang dan konfirmasi, sembunyikan tombol ambil foto
        captureButton.style.display = 'none';
        retakeButton.style.display = 'inline-block';
        
        // Simpan data gambar ke hidden input
        hiddenInput.value = imageData;
    }
    
    // Fungsi untuk mengambil ulang foto
    function retakeImage() {
        // Tampilkan kamera dan tombol ambil foto kembali
        cameraElement.style.display = 'block';
        captureButton.style.display = 'inline-block';
        
        // Sembunyikan preview dan tombol lainnya
        previewElement.style.display = 'none';
        retakeButton.style.display = 'none';
        
        // Reset nilai hidden input
        hiddenInput.value = '';
    }
    
    // Event listeners
    if (captureButton) {
        captureButton.addEventListener('click', captureImage);
    }
    
    if (retakeButton) {
        retakeButton.addEventListener('click', retakeImage);
    }
    
    // Mulai kamera jika elemen video ada
    if (cameraElement) {
        startCamera();
    }
    
    // Bersihkan saat halaman ditutup
    window.addEventListener('beforeunload', stopCamera);
}