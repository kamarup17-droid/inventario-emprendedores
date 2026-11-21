<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Nueva categoría</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    @include('categories._form')

                    <div class="mt-6 flex items-center gap-4">
                        <x-primary-button>Guardar</x-primary-button>
                        <a href="{{ route('categories.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>