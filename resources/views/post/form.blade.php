<div class="space-y-6">
    
    <div>
        <x-input-label for="titulo" :value="__('Titulo')"/>
        <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo', $post?->titulo)" autocomplete="titulo" placeholder="Titulo"/>
        <x-input-error class="mt-2" :messages="$errors->get('titulo')"/>
    </div>
    <div>
        <x-input-label for="contenido" :value="__('Contenido')"/>
        <x-text-input id="contenido" name="contenido" type="text" class="mt-1 block w-full" :value="old('contenido', $post?->contenido)" autocomplete="contenido" placeholder="Contenido"/>
        <x-input-error class="mt-2" :messages="$errors->get('contenido')"/>
    </div>
    <div>
        <x-input-label for="publicado" :value="__('Publicado')"/>
        <x-text-input id="publicado" name="publicado" type="text" class="mt-1 block w-full" :value="old('publicado', $post?->publicado)" autocomplete="publicado" placeholder="Publicado"/>
        <x-input-error class="mt-2" :messages="$errors->get('publicado')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>