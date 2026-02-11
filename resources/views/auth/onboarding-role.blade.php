<x-guest-layout>
    <div class="max-w-md mx-auto bg-white rounded-2xl p-6 shadow">
        <h1 class="text-xl font-bold text-gray-900">Choisir votre rôle</h1>
        <p class="text-sm text-gray-600 mt-1">Ce choix permet de vous diriger vers le bon espace.</p>

        <form method="POST" action="{{ route('onboarding.role.store') }}" class="mt-6 space-y-3">
            @csrf

            <label class="flex items-center gap-3 border rounded-xl p-4 cursor-pointer hover:bg-gray-50">
                <input type="radio" name="role" value="employee" class="h-4 w-4">
                <div>
                    <div class="font-semibold">Candidat (Employee)</div>
                    <div class="text-sm text-gray-600">Je cherche un emploi</div>
                </div>
            </label>

            <label class="flex items-center gap-3 border rounded-xl p-4 cursor-pointer hover:bg-gray-50">
                <input type="radio" name="role" value="recruiter" class="h-4 w-4">
                <div>
                    <div class="font-semibold">Recruteur (Recruiter)</div>
                    <div class="text-sm text-gray-600">Je publie des offres</div>
                </div>
            </label>

            @error('role')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <button class="w-full mt-3 bg-indigo-600 text-white rounded-xl py-2 font-semibold hover:bg-indigo-700">
                Continuer
            </button>
        </form>
    </div>
</x-guest-layout>
