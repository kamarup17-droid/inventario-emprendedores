@php
    $isEditing = isset($product) && $product->exists;
    $isActive = old() ? (bool) old('active') : ($product->active ?? true);
    $inputClass = 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500';
@endphp

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

    <div>
        <x-input-label for="name" value="Nombre del producto" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
            :value="old('name', $product->name ?? '')" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="sku" value="Código (SKU)" />
        <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full"
            :value="old('sku', $product->sku ?? '')" required />
        <x-input-error :messages="$errors->get('sku')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="category_id" value="Categoría" />
        <select id="category_id" name="category_id" class="{{ $inputClass }}" required>
            <option value="">Selecciona una categoría</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="min_stock" value="Stock mínimo (para alertas)" />
        <x-text-input id="min_stock" name="min_stock" type="number" min="0" class="mt-1 block w-full"
            :value="old('min_stock', $product->min_stock ?? 0)" required />
        <x-input-error :messages="$errors->get('min_stock')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="purchase_price" value="Precio de compra" />
        <x-text-input id="purchase_price" name="purchase_price" type="number" step="0.01" min="0"
            class="mt-1 block w-full" :value="old('purchase_price', $product->purchase_price ?? '')" required />
        <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="sale_price" value="Precio de venta" />
        <x-text-input id="sale_price" name="sale_price" type="number" step="0.01" min="0"
            class="mt-1 block w-full" :value="old('sale_price', $product->sale_price ?? '')" required />
        <x-input-error :messages="$errors->get('sale_price')" class="mt-2" />
    </div>

    <div>
        @if ($isEditing)
            <x-input-label value="Stock actual" />
            <p class="mt-1 rounded-md bg-gray-50 px-3 py-2 text-sm text-gray-700">
                {{ $product->stock }} unidades
                <span class="block text-xs text-gray-500">
                    El stock se modifica registrando entradas o salidas de inventario.
                </span>
            </p>
        @else
            <x-input-label for="stock" value="Stock inicial" />
            <x-text-input id="stock" name="stock" type="number" min="0" class="mt-1 block w-full"
                :value="old('stock', 0)" required />
            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
        @endif
    </div>

    <div>
        <x-input-label for="photo" value="Fotografía (JPG, PNG o WEBP, máx. 2 MB)" />
        <input id="photo" name="photo" type="file" accept="image/png,image/jpeg,image/webp"
            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200" />
        <x-input-error :messages="$errors->get('photo')" class="mt-2" />

        @if ($isEditing && $product->photo_url)
            <img src="{{ $product->photo_url }}" alt="{{ $product->name }}"
                class="mt-3 h-24 w-24 rounded-md border border-gray-200 object-cover">
        @endif
    </div>

    <div class="sm:col-span-2">
        <x-input-label for="description" value="Descripción" />
        <textarea id="description" name="description" rows="3"
            class="{{ $inputClass }}">{{ old('description', $product->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="sm:col-span-2">
        <input type="hidden" name="active" value="0">
        <label class="inline-flex items-center">
            <input type="checkbox" name="active" value="1" @checked($isActive)
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <span class="ms-2 text-sm text-gray-600">Producto activo (disponible para la venta)</span>
        </label>
    </div>
</div>