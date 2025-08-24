<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show') }} Venta #{{ $venta->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Show') }} Venta #{{ $venta->id }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Detalles completos de la venta.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('ventas.index') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Volver</a>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 space-y-6">
                            <!-- Información general de la venta -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Información General</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Fecha de Venta</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Empleado</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if($venta->empleado)
                                                {{ $venta->empleado->nombre }} {{ $venta->empleado->apellido }}
                                                <span class="text-gray-500">({{ $venta->empleado->cedula }})</span>
                                            @else
                                                <span class="text-red-500">Empleado no encontrado</span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Total de la Venta</dt>
                                        <dd class="mt-1 text-lg font-bold text-green-600">${{ number_format($venta->total, 2) }}</dd>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalle de productos -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Productos Vendidos</h3>
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                                    Producto
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                                    Descripción
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                                    Cantidad
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                                    Precio Unitario
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                                    Subtotal
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($venta->productos as $producto)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $producto->nombre }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm text-gray-500">
                                                            {{ $producto->descripcion ?? 'Sin descripción' }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $producto->pivot->cantidad }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        ${{ number_format($producto->pivot->subtotal / $producto->pivot->cantidad, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        ${{ number_format($producto->pivot->subtotal, 2) }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                        No se encontraron productos en esta venta
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot class="bg-gray-50">
                                            <tr>
                                                <td colspan="4" class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                                    Total:
                                                </td>
                                                <td class="px-6 py-3 text-sm font-bold text-green-600">
                                                    ${{ number_format($venta->total_venta, 2) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Resumen estadístico -->
                            <div class="bg-blue-50 p-6 rounded-lg">
                                <h3 class="text-lg font-medium text-blue-900 mb-4">Resumen</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $venta->productos->count() }}</div>
                                        <div class="text-sm text-blue-800">Productos diferentes</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $venta->productos->sum('pivot.cantidad') }}</div>
                                        <div class="text-sm text-blue-800">Unidades totales</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">${{ number_format($venta->productos->avg('pivot.subtotal'), 2) }}</div>
                                        <div class="text-sm text-blue-800">Subtotal promedio</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información de timestamps -->
                            <div class="text-xs text-gray-500 border-t pt-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <strong>Creado:</strong> {{ $venta->created_at ? $venta->created_at->format('d/m/Y H:i:s') : 'N/A' }}
                                    </div>
                                    <div>
                                        <strong>Actualizado:</strong> {{ $venta->updated_at ? $venta->updated_at->format('d/m/Y H:i:s') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
