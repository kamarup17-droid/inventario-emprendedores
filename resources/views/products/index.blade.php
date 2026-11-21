<x-app-layout>
    @php $isAdmin = auth()->user()->isAdmin(); @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Productos</h2>

            @if ($isAdmin)
                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                    Nuevo producto
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-flash-messages />

            <form method="GET" action="{{ route('products.index') }}"
                  class="mb-4 grid grid-cols-1 gap-3 rounded-lg bg-white p-4 shadow-sm sm:grid-cols-4">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Buscar por nombre o SKU..."
                       class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:col-span-2">

                <select name="category"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Todas las categorías</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <div class="flex items-center gap-2">
                    <x-primary-button>Filtrar</x-primary-button>
                    <a href="{{ route('products.index') }}" class="px-2 text-sm text-gray-600 hover:text-gray-900">Limpiar</a>
                </div>
            </form>

            <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Producto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Categoría</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Precio venta</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500">Stock</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500">Estado</th>
                            @if ($isAdmin)
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($products as $product)
                            <tr>
                                <td class="px-6 py-4">
                                    @if ($product->photo_url)
                                        <img src="{{ $product->photo_url }}" alt="{{ $product->name }}"
                                             class="h-12 w-12 rounded-md object-cover">
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-md bg-gray-100 text-[10px] text-gray-400">
                                            Sin foto
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500">{{ $product->category->name }}</td>

                                <td class="px-6 py-4 text-right text-sm text-gray-900">
                                    $ {{ number_format($product->sale_price, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-center text-sm">
                                    @if ($product->stock <= $product->min_stock)
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                            {{ $product->stock }} · Stock bajo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                            {{ $product->stock }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center text-sm">
                                    @if ($product->active)
                                        <span class="text-green-700">Activo</span>
                                    @else
                                        <span class="text-gray-400">Inactivo</span>
                                    @endif
                                </td>

                                @if ($isAdmin)
                                    <td class="px-6 py-4 text-right text-sm">
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="text-indigo-600 hover:text-indigo-900">Editar</a>

                                        <form method="POST" action="{{ route('products.destroy', $product) }}"
                                              class="ml-3 inline"
                                              onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 7 : 6 }}" class="px-6 py-8 text-center text-sm text-gray-500">
                                    No se encontraron productos.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>