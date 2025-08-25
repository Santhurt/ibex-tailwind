<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create') }} Venta
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Create') }} Venta</h1>
                            <p class="mt-2 text-sm text-gray-700">Agregar productos a la venta.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('ventas.index') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Volver</a>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8">
                            <!-- Sección para agregar productos -->
                            <div class="mb-6 p-6 bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Agregar Productos</h3>

                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                                    <!-- Select de productos -->
                                    <div class="md:col-span-2">
                                        <label for="producto_select" class="block text-sm font-medium text-gray-700 mb-1">Producto</label>
                                        <select id="producto_select" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccione un producto</option>
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}" data-stock="{{ $producto->stock }}">
                                                    {{ $producto->nombre }} (Stock: {{ $producto->stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Input cantidad -->
                                    <div>
                                        <label for="cantidad_input" class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                                        <input type="number" id="cantidad_input" min="1" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="1">
                                    </div>

                                    <!-- Precio unitario (solo lectura) -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                                        <div id="precio_display" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 bg-gray-100 text-sm">$0.00</div>
                                    </div>

                                    <!-- Botón agregar -->
                                    <div>
                                        <button type="button" id="agregar_producto" class="w-full rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @if ($message = Session::get('success'))
                                <div class="bg-green-500 text-white font-bold p-4 rounded-lg mb-4">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif

                            @if ($message = Session::get('error'))
                                <div class="bg-red-500 text-white font-bold p-4 rounded-lg mb-4">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif

                            <!-- Tabla de productos agregados -->
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Productos en la Venta</h3>
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Producto</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Cantidad</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Precio Unit.</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Subtotal</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productos_tabla" class="bg-white divide-y divide-gray-200">
                                            <!-- Los productos se agregarán dinámicamente aquí -->
                                        </tbody>
                                    </table>
                                </div>
                                <div id="no_productos" class="text-center py-8 text-gray-500">
                                    No hay productos agregados a la venta
                                </div>
                            </div>

                            <!-- Total y botón confirmar -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-medium text-gray-900">Total de la Venta:</h3>
                                    <span id="total_venta" class="text-2xl font-bold text-green-600">$0.00</span>
                                </div>

                                <form id="form_venta" method="POST" action="{{ route('ventas.store') }}">
                                    @csrf
                                    <!-- <input type="hidden" id="empleado_hidden" name="empleado_id"> -->
                                    <div id="productos_hidden"></div>

                                    <button type="submit" id="confirmar_venta" class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                        Confirmar Venta
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let productosVenta = [];
            let totalVenta = 0;

            const productoSelect = document.getElementById('producto_select');
            const cantidadInput = document.getElementById('cantidad_input');
            const precioDisplay = document.getElementById('precio_display');
            const agregarBtn = document.getElementById('agregar_producto');
            const productosTabla = document.getElementById('productos_tabla');
            const noProductos = document.getElementById('no_productos');
            const totalVentaDisplay = document.getElementById('total_venta');
            const confirmarBtn = document.getElementById('confirmar_venta');
            // const empleadoSelect = document.getElementById('empleado_id');
            // const empleadoHidden = document.getElementById('empleado_hidden');
            const productosHidden = document.getElementById('productos_hidden');

            // Actualizar precio cuando cambie la selección del producto
            productoSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const precio = selectedOption.getAttribute('data-precio') || '0';
                precioDisplay.textContent = '$' + parseFloat(precio).toFixed(2);
            });

            /* Actualizar empleado hidden cuando cambie la selección
            empleadoSelect.addEventListener('change', function() {
                empleadoHidden.value = this.value;
                actualizarBotonConfirmar();
            }); */

            // Agregar producto
            agregarBtn.addEventListener('click', function() {
                const productoId = productoSelect.value;
                const cantidad = parseInt(cantidadInput.value);
                const selectedOption = productoSelect.options[productoSelect.selectedIndex];

                if (!productoId || !cantidad || cantidad <= 0) {
                    alert('Por favor seleccione un producto y una cantidad válida.');
                    return;
                }

                const stock = parseInt(selectedOption.getAttribute('data-stock'));
                const precio = parseFloat(selectedOption.getAttribute('data-precio'));
                const nombreProducto = selectedOption.textContent.split(' (Stock:')[0];

                if (cantidad > stock) {
                    alert(`No hay suficiente stock. Stock disponible: ${stock}`);
                    return;
                }

                // Verificar si el producto ya está en la venta
                const productoExistente = productosVenta.find(p => p.id == productoId);
                if (productoExistente) {
                    if (productoExistente.cantidad + cantidad > stock) {
                        alert(`No hay suficiente stock. Ya tiene ${productoExistente.cantidad} en la venta. Stock disponible: ${stock}`);
                        return;
                    }
                    productoExistente.cantidad += cantidad;
                    productoExistente.subtotal = productoExistente.cantidad * precio;
                } else {
                    productosVenta.push({
                        id: productoId,
                        nombre: nombreProducto,
                        cantidad: cantidad,
                        precio: precio,
                        subtotal: cantidad * precio
                    });
                }

                actualizarTablaProductos();
                actualizarTotal();

                // Limpiar campos
                productoSelect.value = '';
                cantidadInput.value = '';
                precioDisplay.textContent = '$0.00';
            });

            function actualizarTablaProductos() {
                if (productosVenta.length === 0) {
                    productosTabla.innerHTML = '';
                    noProductos.style.display = 'block';
                } else {
                    noProductos.style.display = 'none';
                    productosTabla.innerHTML = productosVenta.map((producto, index) => `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${producto.nombre}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${producto.cantidad}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$${producto.precio.toFixed(2)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$${producto.subtotal.toFixed(2)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button type="button" onclick="eliminarProducto(${index})" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </td>
                        </tr>
                    `).join('');
                }
                actualizarBotonConfirmar();
            }

            function actualizarTotal() {
                totalVenta = productosVenta.reduce((total, producto) => total + producto.subtotal, 0);
                totalVentaDisplay.textContent = '$' + totalVenta;
            }

            function actualizarBotonConfirmar() {
                // const tieneEmpleado = empleadoSelect.value !== '';
                const tieneProductos = productosVenta.length > 0;
                confirmarBtn.disabled = !(tieneProductos);

                // Actualizar campos hidden
                if (tieneProductos) {
                    productosHidden.innerHTML = productosVenta.map((producto, index) => `
                        <input type="hidden" name="productos[${index}][id]" value="${producto.id}">
                        <input type="hidden" name="productos[${index}][cantidad]" value="${producto.cantidad}">
                        <input type="hidden" name="productos[${index}][precio]" value="${producto.precio}">
                    `).join('');
                }
            }

            // Función global para eliminar productos
            window.eliminarProducto = function(index) {
                productosVenta.splice(index, 1);
                actualizarTablaProductos();
                actualizarTotal();
            };

            // Inicializar
            actualizarTablaProductos();
        });
    </script>
</x-app-layout>
