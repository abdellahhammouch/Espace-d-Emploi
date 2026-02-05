<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Recherche utilisateurs
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Résultats pour : <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $q }}</span>
                </p>

                @if($users->isEmpty())
                    <p class="text-sm text-gray-500">Aucun utilisateur trouvé.</p>
                @else
                    <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($users as $u)
                            <li class="py-4 flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $u->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $u->email }}</p>
                                </div>

                                {{-- Plus tard: bouton "Inviter" --}}
                                <span class="text-xs text-gray-400">à venir</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
 