<div class="space-y-6">
    
    <div>
        <x-input-label for="nombre" :value="__('Nombre')"/>
        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $producto?->nombre)" autocomplete="nombre" placeholder="Nombre"/>
        <x-input-error class="mt-2" :messages="$errors->get('nombre')"/>
    </div>
    <div>
        <x-input-label for="descripcion" :value="__('Descripcion')"/>
        <x-text-input id="descripcion" name="descripcion" type="text" class="mt-1 block w-full" :value="old('descripcion', $producto?->descripcion)" autocomplete="descripcion" placeholder="Descripcion"/>
        <x-input-error class="mt-2" :messages="$errors->get('descripcion')"/>
    </div>
    <div>
        <x-input-label for="precio" :value="__('Precio')"/>
        <x-text-input id="precio" name="precio" type="text" class="mt-1 block w-full" :value="old('precio', $producto?->precio)" autocomplete="precio" placeholder="Precio"/>
        <x-input-error class="mt-2" :messages="$errors->get('precio')"/>
    </div>
    <div>
        <x-input-label for="stock" :value="__('Stock')"/>
        <x-text-input id="stock" name="stock" type="text" class="mt-1 block w-full" :value="old('stock', $producto?->stock)" autocomplete="stock" placeholder="Stock"/>
        <x-input-error class="mt-2" :messages="$errors->get('stock')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>