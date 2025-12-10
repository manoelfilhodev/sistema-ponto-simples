const video = document.getElementById('camera');
const canvas = document.getElementById('canvas');
const fotoInput = document.getElementById('foto');

// Abrir câmera
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        video.srcObject = stream;
    })
    .catch(err => alert("Erro ao acessar câmera."));

// Capturar a foto — MAS SEM ENVIAR
document.getElementById('btnCapturar').addEventListener('click', () => {
    const ctx = canvas.getContext("2d");

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0);

    const base64 = canvas.toDataURL("image/png");
    fotoInput.value = base64;

    console.log("📸 Foto capturada com sucesso!");
});
