<x-recruitconnect-layout>
    <div class="max-w-lg mx-auto mt-20 text-center bg-white p-10 rounded-xl shadow">
        <span class="material-symbols-outlined text-6xl text-red-500">error</span>
        <h1 class="text-2xl font-bold mt-4">Payment Failed</h1>
        <p class="text-gray-600 mt-2">
            Your payment was not completed. Please try again.
        </p>
        <a href="{{ route('profile.edit', ['tab' => 'security']) }}"
           class="mt-6 inline-block px-6 py-3 bg-[#137fec] text-white font-bold rounded-lg hover:opacity-90 transition">
           Back to Security Settings
        </a>
    </div>
</x-recruitconnect-layout>
