<nav class="bg-gray-800 p-4 flex justify-between items-center text-white">
    <div class="flex items-center gap-2">
        <span class="font-bold text-lg">NEWS</span>
    </div>
    <div class="flex items-center gap-4">
        <span>{{ session('email') }}</span>
        <a href="{{ route('news.index') }}" class=" hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Inicio</a>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class=" hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Salir</button>
        </form>
    </div>
</nav>
