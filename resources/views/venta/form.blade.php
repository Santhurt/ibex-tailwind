<div class="space-y-6">
    
    <div>
        <x-input-label for="fecha" :value="__('Fecha')"/>
        <x-text-input id="fecha" name="fecha" type="text" class="mt-1 block w-full" :value="old('fecha', $venta?->fecha)" autocomplete="fecha" placeholder="Fecha"/>
        <x-input-error class="mt-2" :messages="$errors->get('fecha')"/>
    </div>
    <div>
        <x-input-label for="total" :value="__('Total')"/>
        <x-text-input id="total" name="total" type="text" class="mt-1 block w-full" :value="old('total', $venta?->total)" autocomplete="total" placeholder="Total"/>
        <x-input-error class="mt-2" :messages="$errors->get('total')"/>
    </div>
    <div>
        <x-input-label for="empleado_id" :value="__('Empleado Id')"/>
        <x-text-input id="empleado_id" name="empleado_id" type="text" class="mt-1 block w-full" :value="old('empleado_id', $venta?->empleado_id)" autocomplete="empleado_id" placeholder="Empleado Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('empleado_id')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>