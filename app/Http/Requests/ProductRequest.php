<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // El acceso ya lo controla el middleware de roles
    }

    public function rules(): array
    {
        $product = $this->route('product');

        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($product)],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['required', 'numeric', 'min:0'],
            'min_stock' => ['required', 'integer', 'min:0'],
            'active' => ['boolean'],
        ];

        // El stock inicial solo se pide al crear; después cambia con movimientos
        if ($this->isMethod('post')) {
            $rules['stock'] = ['required', 'integer', 'min:0'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'unique' => 'Ya existe un producto con ese :attribute.',
            'exists' => 'La :attribute seleccionada no es válida.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'min.numeric' => 'El campo :attribute no puede ser negativo.',
            'max.string' => 'El campo :attribute no puede superar los :max caracteres.',
            'max.file' => 'La :attribute no puede pesar más de 2 MB.',
            'image' => 'El archivo debe ser una imagen.',
            'mimes' => 'La imagen debe ser JPG, PNG o WEBP.',
            'uploaded' => 'No se pudo subir la imagen. Verifica que pese menos de 2 MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'categoría',
            'sku' => 'código (SKU)',
            'name' => 'nombre',
            'description' => 'descripción',
            'photo' => 'fotografía',
            'purchase_price' => 'precio de compra',
            'sale_price' => 'precio de venta',
            'stock' => 'stock inicial',
            'min_stock' => 'stock mínimo',
        ];
    }
}