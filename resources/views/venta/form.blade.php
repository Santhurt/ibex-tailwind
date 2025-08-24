<div class="space-y-6">
    
    <div>
        <x-input-label for="total" :value="__('Total')"/>
        <x-text-input id="total" name="total" type="text" class="mt-1 block w-full" :value="old('total', $venta?->total)" autocomplete="total" placeholder="Total"/>
        <x-input-error class="mt-2" :messages="$errors->get('total')"/>
    </div>
    <div>
        <x-input-label for="id_producto" :value="__('Id Producto')"/>
        <x-text-input id="id_producto" name="id_producto" type="text" class="mt-1 block w-full" :value="old('id_producto', $venta?->id_producto)" autocomplete="id_producto" placeholder="Id Producto"/>
        <x-input-error class="mt-2" :messages="$errors->get('id_producto')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>