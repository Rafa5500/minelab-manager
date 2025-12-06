<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MineLab Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-900 text-white font-sans antialiased">

    <nav class="bg-gray-800 border-b border-gray-700 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold text-emerald-400 flex items-center gap-2">
            <i class="ph ph-pickaxe"></i> MineLab
        </h1>

        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-400">Olá, {{ Auth::user()->name }}</span>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm bg-red-900 hover:bg-red-800 text-red-200 px-3 py-1 rounded transition flex items-center gap-1">
                    <i class="ph ph-sign-out"></i> Sair
                </button>
            </form>
        </div>
    </div>
    </nav>

    <main class="container mx-auto p-6">
        {{ $slot }}
    </main>

</body>
</html>

