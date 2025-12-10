@extends('layouts.app')

@section('content')

<style>
    video, canvas {
        width: 100%;
        border-radius: 12px;
    }
</style>

<div class="container py-4">

    <h3 class="fw-bold text-center mb-3">Registrar Ponto</h3>
    <p class="text-muted text-center mb-4">Aponte a câmera para o seu rosto e clique no botão abaixo.</p>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <video id="camera" autoplay playsinline></video>
            <canvas id="fotoCanvas" class="d-none"></canvas>
        </div>
    </div>

    <div class="text-center">
        <button id="btnRegistrar" class="btn btn-primary btn-lg px-4">
            <i class="bi bi-camera-fill me-2"></i>
            Registrar Ponto
        </button>
    </div>

</div>

<form id="formPonto" action="{{ route('ponto.salvar') }}" method="POST">
    @csrf
    <input type="hidden" name="foto" id="inputFoto">
    <input type="hidden" name="latitude" id="inputLat">
    <input type="hidden" name="longitude" id="inputLng">
</form>

@endsection

@section('scripts')

<script>
    // === Abrir câmera ===
    const video = document.getElementById('camera');
    const canvas = document.getElementById('fotoCanvas');

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => { video.srcObject = stream })
        .catch(err => alert("Erro ao acessar câmera: " + err));

    // === Coletar localização ===
    function getLocation() {
        return new Promise(resolve => {
            navigator.geolocation.getCurrentPosition(
                pos => resolve(pos.coords),
                () => resolve(null)
            );
        });
    }

    // === Gerar foto e enviar ===
    document.getElementById('btnRegistrar').addEventListener('click', async () => {

        // Foto no canvas
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const ctx = canvas.getContext("2d");
        ctx.drawImage(video, 0, 0);

        const base64 = canvas.toDataURL("image/png");
        document.getElementById("inputFoto").value = base64;

        // Localização
        const coords = await getLocation();
        if (coords) {
            document.getElementById("inputLat").value = coords.latitude;
            document.getElementById("inputLng").value = coords.longitude;
        }

        document.getElementById("formPonto").submit();
    });
</script>

@endsection
