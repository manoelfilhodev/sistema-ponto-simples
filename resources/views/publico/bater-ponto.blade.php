<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Bater Ponto</title>

    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: #0c0f16;
            color: #fff;
        }

        .card-ponto {
            background: #141823;
            border-radius: 18px;
            padding: 28px;
            max-width: 420px;
            margin: auto;
            box-shadow: 0 0 25px rgba(0,0,0,0.55);
        }

        #camera {
            border-radius: 12px;
            width: 100%;
            height: auto;
            background: #000;
        }

        .btn-capturar {
            border-radius: 10px;
            font-size: 1.2rem;
            padding: 14px 28px;
            font-weight: bold;
        }

        /* Painel de status */
        .status-box {
            background: rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 16px;
            margin-top: 25px;
        }

        .status-item {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .status-item:last-child {
            border-bottom: none;
        }

        .status-label {
            opacity: .75;
        }

        .gps-loading { color: #ffd86b; font-weight: bold; }
        .gps-ok { color: #7CFF6B; font-weight: bold; }
        .gps-error { color: #FF6B6B; font-weight: bold; }

    </style>
</head>

<body>

<div class="container py-5">

    <div class="card-ponto">

        <h3 class="text-center fw-bold mb-2">Olá, {{ $user->name }}</h3>
        <p class="text-center text-muted mb-4">Tire uma foto para registrar seu ponto</p>

        <!-- CÂMERA -->
        <video id="camera" autoplay playsinline></video>

        <!-- FORM -->
        <form id="form-foto" method="POST" action="/bater-ponto/{{ $user->id }}">
            @csrf

            <input type="hidden" name="foto" id="foto">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="localidade" id="localidade">

            <div class="text-center mt-3">
                <button type="button" id="btnCapturar" 
                        class="btn btn-primary btn-capturar w-100 shadow">
                    📸 Capturar Foto
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success text-center mt-3">{{ session('success') }}</div>
            @endif
        </form>

        <!-- STATUS -->
        <div class="status-box mt-4">
            <div class="status-item">
                <span class="status-label">Status do GPS:</span>
                <span id="debugGps" class="gps-loading">Aguardando...</span>
            </div>

            <div class="status-item">
                <span class="status-label">Localidade:</span>
                <span id="debugLocal">---</span>
            </div>

            <div class="status-item">
                <span class="status-label">Foto capturada:</span>
                <span id="debugFoto">Não</span>
            </div>

            <div class="status-item">
                <span class="status-label">Última ação:</span>
                <span id="debugAcao">Aguardando...</span>
            </div>
        </div>

    </div>
</div>

<!-- CANVAS INVISÍVEL -->
<canvas id="canvas" width="320" height="240" class="d-none"></canvas>


<!-- SCRIPT -->
<script>

let gpsOk = false;

/* Atualiza debug */
function debugSet(id, msg, cls = null) {
    const el = document.getElementById(id);
    el.textContent = msg;
    if (cls) el.className = cls;
}

/* REVERSE GEOCODING (transformar latitude/longitude em cidade+bairro) */
async function obterLocalidade(lat, lng) {
    try {
        const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;
        const response = await fetch(url);
        const data = await response.json();

        let cidade = data.address.city || data.address.town || data.address.village || "Cidade Desconhecida";
        let bairro = data.address.suburb || data.address.neighbourhood || "Bairro";

        const local = `${cidade} — ${bairro}`;

        document.getElementById("localidade").value = local;
        debugSet("debugLocal", local);

    } catch (error) {
        debugSet("debugLocal", "Não identificado");
    }
}


/* OBTER GPS */
navigator.geolocation.getCurrentPosition(
    pos => {
        gpsOk = true;

        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;

        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;

        debugSet("debugGps", "OK ✓", "gps-ok");
        debugSet("debugAcao", "GPS carregado.");

        // Buscar nome do local
        obterLocalidade(lat, lng);
    },
    err => {
        gpsOk = false;
        debugSet("debugGps", "Erro ✗", "gps-error");
        debugSet("debugAcao", "Falha ao obter GPS.");
        alert("Ative seu GPS.");
    },
    { enableHighAccuracy: true }
);


/* CAPTURAR FOTO */
document.getElementById("btnCapturar").addEventListener("click", function() {

    if (!gpsOk) {
        alert("Aguarde o GPS carregar.");
        debugSet("debugAcao", "Tentou capturar sem GPS.");
        return;
    }

    debugSet("debugAcao", "Capturando foto...");

    const video = document.getElementById("camera");
    const canvas = document.getElementById("canvas");
    const ctx = canvas.getContext("2d");

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    ctx.drawImage(video, 0, 0);
    const base64 = canvas.toDataURL("image/png");

    document.getElementById("foto").value = base64;

    debugSet("debugFoto", "Sim ✓");
    debugSet("debugAcao", "Enviando dados...");

    document.getElementById("form-foto").submit();
});


/* INICIAR CÂMERA */
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        document.getElementById("camera").srcObject = stream;
    })
    .catch(err => alert("Erro ao acessar câmera: " + err));

</script>

</body>
</html>
