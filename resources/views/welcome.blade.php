<x-layout>
    <div class="text-center" x-data="{ count: 0 }">
        <h1 class="text-4xl font-extrabold text-indigo-600 mb-4">
            Laravel + Tailwind Berhasil!
        </h1>
        <p class="mb-6 text-gray-600">Klik tombol di bawah untuk tes Alpine.js:</p>

        <button
            @click="count++"
            class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow-lg transition"
        >
            Angka: <span x-text="count"></span>
        </button>
    </div>
</x-layout>
