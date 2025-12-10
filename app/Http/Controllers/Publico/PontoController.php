<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ponto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PontoController extends Controller
{
    // 1️⃣ Exibe tela para digitar o CPF
    public function acessoPublico()
    {
        return view('publico.acesso');
    }

    // 2️⃣ Valida CPF
    public function validarCpf(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string'
        ]);

        $user = User::where('cpf', $request->cpf)->first();

        if (!$user) {
            return back()->with('erro', 'CPF não encontrado no sistema.');
        }

        return redirect()->route('ponto.tela', $user->id);
    }

    // 3️⃣ Tela de bater ponto
    public function telaBaterPonto(User $user)
    {
        return view('publico.bater-ponto', compact('user'));
    }

    // 4️⃣ Registrar ponto
    public function registrarPontoPublico(Request $request, $userId)
    {
        Log::info("🟦 Etapa 1: Entrou no método registrarPontoPublico");

        Log::info("🟦 Etapa 2: Dados recebidos", [
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'foto_informada' => strlen($request->foto) > 10 ? 'SIM' : 'NÃO'
        ]);

        // ========== Buscar usuário ==========
        $user = User::find($userId);

        if (!$user) {
            Log::error("❌ ERRO: Usuário não encontrado para ID: $userId");
            return back()->with('erro', 'Usuário inválido. Tente novamente.');
        }

        Log::info("🟩 Etapa 0: Usuário encontrado", [
            'id' => $user->id,
            'nome' => $user->name
        ]);


        // ========== Validar campos ==========
        Log::info("🟦 Etapa 3: Iniciando validação dos campos");

        $request->validate([
            'foto' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        Log::info("🟩 Etapa 4: Validação concluída com sucesso");


        // ========== Verificar último ponto ==========
        Log::info("🟦 Etapa 5: Buscando último ponto do usuário");

        $ultimo = Ponto::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($ultimo) {
            Log::info("🟩 Etapa 6: Último ponto encontrado", [
                'ultimo_tipo' => $ultimo->tipo,
                'ultimo_horario' => $ultimo->data_hora
            ]);

            $ultimoHorario = Carbon::parse($ultimo->data_hora);
            $agora = Carbon::now();

            $difSegundos = $ultimoHorario->diffInSeconds($agora, false); // permite negativo


            Log::info("🕒 Hora agora: " . now());
            Log::info("🕒 Hora último ponto: " . $ultimo->data_hora);
            Log::info("🕒 Diferença em segundos: " . $difSegundos);

            // Regra para evitar spam
            if ($difSegundos < 20) {
                Log::warning("⚠️ Etapa Bloqueio: Ponto muito próximo");
                return back()->with('erro', 'Aguarde alguns segundos para registrar novamente.');
            }
        } else {
            Log::info("ℹ️ Nenhum ponto anterior encontrado.");
        }


        // ========== Tipo do ponto ==========
        $tipo = $ultimo && $ultimo->tipo === 'entrada' ? 'saida' : 'entrada';

        Log::info("🟦 Etapa 7: Tipo definido como: $tipo");


        // ========== Salvar imagem ==========
        Log::info("🟦 Etapa 8: Preparando imagem para salvar");

        $rawImage = str_replace('data:image/png;base64,', '', $request->foto);
        $rawImage = base64_decode($rawImage);

        $filename = 'pontos/' . uniqid() . '.png';
        Storage::disk('public')->put($filename, $rawImage);

        Log::info("🟩 Etapa 9: Imagem salva com sucesso", ['arquivo' => $filename]);


        // ========== Inserir no banco ==========
        Log::info("🟦 Etapa 10: Tentando salvar registro no banco");

        try {
            // Coordenadas
            $lat = $request->latitude;
            $lng = $request->longitude;

            // Buscar nome do local
            $localidade = $this->buscarLocalidade($lat, $lng);

            $registro = Ponto::create([
                'user_id'    => $user->id,
                'tipo'       => $tipo,
                'foto'       => $filename,
                'lat'        => $lat,
                'lng'        => $lng,
                'localidade' => $localidade,   // 🔥 Aqui é onde salvamos o nome da localização
                'origem'     => 'web',
                'data_hora'  => now(),
            ]);

            Log::info("🟩 Etapa 11: Registro salvo com sucesso", [
                'id' => $registro->id
            ]);

            return back()->with('success', 'Ponto registrado com sucesso!');
        } catch (\Exception $e) {

            Log::error("❌ ERRO AO INSERIR NO BANCO: " . $e->getMessage());
            return back()->with('erro', 'Erro ao registrar o ponto. Informe o suporte.');
        }
    }

    private function buscarLocalidade($lat, $lng)
    {
        try {
            Log::info("🌍 Buscando localidade para LAT=$lat LNG=$lng");

            $url = "https://api.bigdatacloud.net/data/reverse-geocode-client?latitude={$lat}&longitude={$lng}&localityLanguage=pt";

            $response = Http::timeout(10)->get($url);

            Log::info("🌍 Resposta da API BigDataCloud:", [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if (!$response->successful()) {
                Log::error("🚨 API retornou erro HTTP: " . $response->status());
                return "Local não identificado";
            }

            $data = $response->json();

            $cidade = $data['city']
                ?? $data['locality']
                ?? $data['principalSubdivision']
                ?? null;

            $bairro = $data['locality']
                ?? $data['suburb']
                ?? $data['neighbourhood']
                ?? null;

            if ($cidade && $bairro) {
                $local = "{$cidade} — {$bairro}";
                Log::info("📍 Local completo identificado: $local");
                return $local;
            }

            Log::warning("⚠ Local identificou apenas cidade: " . ($cidade ?? "NENHUMA"));
            return $cidade ?? "Local não identificado";
        } catch (\Exception $e) {
            Log::error("❌ Erro ao buscar localidade: " . $e->getMessage());
            return "Local não identificado";
        }
    }
}
