<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Temporário</title>
</head>
<body style="background: #0b2e47; color: #fff; text-align:center; padding:50px;">

    <h1>Dashboard Funcional</h1>
    <p>Se você está vendo isso, o sistema está ok.</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button style="padding:10px 20px; font-size:18px;">Sair</button>
    </form>

</body>
</html>
