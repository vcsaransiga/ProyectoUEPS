<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="mt-4 row">
                <div class="col-12">
                    <div class="card">
                        <div class="pb-1 card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="">Administración de Ventas</h5>
                                    <p class="mb-0 text-sm">Aquí puedes gestionar las ventas realizadas.</p>
                                </div>
                                <div class="col-6 text-end">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createSaleModal">
                                        <i class="fas fa-cart-plus me-2"></i> Registrar Venta
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif -->

                        <div class="tw-relative tw-overflow-x-auto tw-shadow-md sm:tw-rounded-lg tw-p-5">
                            <table class="tw-w-full tw-text-sm tw-text-left tw-text-gray-500">
                                <thead class="tw-text-xs tw-uppercase tw-bg-gray-50 tw-text-gray-700">
                                    <tr>
                                        <th class="tw-px-6 tw-py-3">ID</th>
                                        <th class="tw-px-6 tw-py-3">Cliente</th>
                                        <th class="tw-px-6 tw-py-3">Empleado</th>
                                        <th class="tw-px-6 tw-py-3">Fecha</th>
                                        <th class="tw-px-6 tw-py-3">Método de Pago</th>
                                        <th class="tw-px-6 tw-py-3">Total</th>
                                        <th class="tw-px-6 tw-py-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                        <tr class="tw-bg-white tw-border-b hover:tw-bg-gray-50">
                                            <td class="tw-px-6 tw-py-4">{{ $sale->id }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $sale->customer->custom_id }} - {{ $sale->customer->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $sale->employee->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y H:i') }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $sale->payment_method }}</td>
                                            <td class="tw-px-6 tw-py-4">$ {{ number_format($sale->total, 2) }}</td>
                                            <td class="tw-px-6 tw-py-4 tw-flex tw-space-x-2">
                                                {{-- Icono Editar --}}
                                                @if (!$sale->pdf_generated)
                                                    <a href="#"
                                                        class="tw-text-green-600 hover:tw-text-green-800"
                                                        title="Editar"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editSaleModal"
                                                        data-sale-id="{{ $sale->id }}"
                                                        data-customer-id="{{ $sale->customer_id }}"
                                                        data-payment-method="{{ $sale->payment_method }}"
                                                        data-comments="{{ $sale->comments }}">
                                                        <svg class="tw-w-6 tw-h-6" fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012ZM11.283 6.945 6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                @else
                                                {{-- Icono bloqueado (cuando ya no se puede editar) --}}
                                                    <svg class="tw-w-6 tw-h-6 tw-text-gray-500" fill="currentColor" viewBox="0 0 24 24"
                                                        title="Esta venta ya no se puede editar (PDF generado)">
                                                        <path fill-rule="evenodd"
                                                            d="M12 2a4 4 0 0 0-4 4v2H7a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2h-1V6a4 4 0 0 0-4-4Zm2 6V6a2 2 0 1 0-4 0v2h4Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif

                                                {{-- Icono PDF --}}
                                                <form action="{{ route('sales.generatePdf', $sale->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    <button type="submit" class="tw-text-red-600 hover:tw-text-red-800" title="Generar PDF">
                                                        <svg class="tw-w-6 tw-h-6" fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M6 2a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6H6Zm7 1.5L18.5 9H13a1 1 0 0 1-1-1V3.5Zm-4.25 8.25a.75.75 0 0 1 .75-.75h.5a2.25 2.25 0 1 1 0 4.5H10v.25a.75.75 0 0 1-1.5 0v-4Zm1.5.75v1.5h.5a.75.75 0 0 0 0-1.5h-.5Zm4.03 2.25a.75.75 0 0 0-.53 1.28l.72.72-.72.72a.75.75 0 1 0 1.06 1.06l.72-.72.72.72a.75.75 0 0 0 1.06-1.06l-.72-.72.72-.72a.75.75 0 0 0-1.06-1.06l-.72.72-.72-.72a.75.75 0 0 0-.53-.22ZM14 14a.75.75 0 0 1 .75-.75h.5a2.25 2.25 0 0 1 0 4.5h-.5a.75.75 0 0 1 0-1.5h.5a.75.75 0 0 0 0-1.5h-.5A.75.75 0 0 1 14 14Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Registrar Venta adaptado globalmente -->
    <div class="modal fade" id="createSaleModal" tabindex="-1" aria-labelledby="createSaleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSaleModalLabel">Registrar Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="background-color: red;"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('sales.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Cliente</label>
                            <select class="form-control" id="customer_id" name="customer_id" required>
                                <option value="">-- Seleccione un cliente --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->custom_id }} - {{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Método de Pago</label>
                            <input type="text" class="form-control" id="payment_method" name="payment_method" required>
                        </div>
                        <div class="mb-3">
                            <label for="comments" class="form-label">Comentarios</label>
                            <textarea class="form-control" id="comments" name="comments"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Productos</label>
                            <table class="table table-bordered" id="products-table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="products[0][product_id]" class="form-control product-select" required onchange="updatePrice(this)">
                                                <option value="">-- Seleccione --</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id_item }}" data-price="{{ $item->price }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" name="products[0][quantity]" class="form-control quantity" min="1" value="1" onchange="updateSubtotal(this)"></td>
                                        <td><input type="number" step="0.01" name="products[0][unit_price]" class="form-control unit-price" readonly></td>
                                        <td><input type="text" class="form-control subtotal" readonly></td>
                                        <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">X</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="addRow()">+ Agregar producto</button>
                        </div>
                        <div class="mb-3">
                            <label for="total" class="form-label">Total</label>
                            <input type="text" class="form-control" id="total" name="total" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Editar Venta -->
<div class="modal fade" id="editSaleModal" tabindex="-1" aria-labelledby="editSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSaleModalLabel">Editar Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="background-color: red;"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="#" id="editSaleForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_sale_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_customer_id" class="form-label">Cliente</label>
                            <select class="form-control" id="edit_customer_id" name="customer_id" required>
                                <option value="">-- Seleccione un cliente --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_payment_method" class="form-label">Método de Pago</label>
                            <input type="text" class="form-control" id="edit_payment_method" name="payment_method" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_comments" class="form-label">Comentarios</label>
                        <textarea class="form-control" id="edit_comments" name="comments"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Productos</label>
                        <table class="table table-bordered" id="edit-products-table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="edit-products-body"></tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="addEditRow()">+ Agregar producto</button>
                    </div>

                    <div class="mb-3 text-end">
                        <label class="form-label fw-bold">Total:</label>
                        <input type="text" class="form-control text-end" id="edit_total" name="total" value="0.00" readonly>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const itemsData = @json($items);
    let editProductIndex = 0;

    document.getElementById('editSaleModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const saleId = button.getAttribute('data-sale-id');
        const customerId = button.getAttribute('data-customer-id');
        const paymentMethod = button.getAttribute('data-payment-method');
        const comments = button.getAttribute('data-comments');

        const form = document.getElementById('editSaleForm');
        form.action = `/sales/${saleId}`;
        document.getElementById('edit_sale_id').value = saleId;
        document.getElementById('edit_customer_id').value = customerId;
        document.getElementById('edit_payment_method').value = paymentMethod;
        document.getElementById('edit_comments').value = comments;

        fetch(`/sales/${saleId}/products-json`)
            .then(response => response.json())
            .then(details => {
                const tbody = document.getElementById('edit-products-body');
                tbody.innerHTML = '';
                editProductIndex = 0;
                details.forEach(detail => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>
                            <select name="products[${editProductIndex}][product_id]" class="form-control" required onchange="updateEditPrice(this)">
                                <option value="">-- Seleccione --</option>
                                ${itemsData.map(item => `
                                    <option value="${item.id_item}" data-price="${item.price}" ${detail.product_id === item.id_item ? 'selected' : ''}>${item.name}</option>
                                `).join('')}
                            </select>
                        </td>
                        <td><input type="number" name="products[${editProductIndex}][quantity]" class="form-control quantity" min="1" value="${detail.quantity}" onchange="updateEditSubtotal(this)"></td>
                        <td><input type="number" step="0.01" name="products[${editProductIndex}][unit_price]" class="form-control unit-price" value="${detail.unit_price}" readonly></td>
                        <td><input type="text" class="form-control subtotal" value="${(detail.unit_price * detail.quantity).toFixed(2)}" readonly></td>
                        <td><button type="button" class="btn btn-danger" onclick="removeEditRow(this)">X</button></td>
                    `;
                    tbody.appendChild(row);
                    editProductIndex++;
                });
                updateEditTotal();
            });
    });

    function addEditRow() {
        const tableBody = document.getElementById('edit-products-body');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select name="products[${editProductIndex}][product_id]" class="form-control" required onchange="updateEditPrice(this)">
                    <option value="">-- Seleccione --</option>
                    ${itemsData.map(item => `
                        <option value="${item.id_item}" data-price="${item.price}">${item.name}</option>
                    `).join('')}
                </select>
            </td>
            <td><input type="number" name="products[${editProductIndex}][quantity]" class="form-control quantity" min="1" value="1" onchange="updateEditSubtotal(this)"></td>
            <td><input type="number" step="0.01" name="products[${editProductIndex}][unit_price]" class="form-control unit-price" readonly></td>
            <td><input type="text" class="form-control subtotal" readonly></td>
            <td><button type="button" class="btn btn-danger" onclick="removeEditRow(this)">X</button></td>
        `;
        tableBody.appendChild(row);
        editProductIndex++;
    }

    function updateEditPrice(select) {
        const price = select.options[select.selectedIndex].dataset.price;
        const row = select.closest('tr');
        row.querySelector('.unit-price').value = price;
        updateEditSubtotal(row.querySelector('.quantity'));
    }

    function updateEditSubtotal(input) {
        const row = input.closest('tr');
        const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
        const price = parseFloat(row.querySelector('.unit-price').value) || 0;
        const subtotal = quantity * price;
        row.querySelector('.subtotal').value = subtotal.toFixed(2);
        updateEditTotal();
    }

    function updateEditTotal() {
        let total = 0;
        document.querySelectorAll('#edit-products-table .subtotal').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('edit_total').value = total.toFixed(2);
    }

    function removeEditRow(button) {
        const row = button.closest('tr');
        row.remove();
        updateEditTotal();
    }
</script>

    <script>
        let productIndex = 1;

        function updatePrice(select) {
            const price = select.options[select.selectedIndex].dataset.price;
            const row = select.closest('tr');
            row.querySelector('.unit-price').value = price;
            updateSubtotal(row.querySelector('.quantity'));
        }

        function updateSubtotal(input) {
            const row = input.closest('tr');
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const price = parseFloat(row.querySelector('.unit-price').value) || 0;
            row.querySelector('.subtotal').value = (quantity * price).toFixed(2);
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(subtotal => {
                total += parseFloat(subtotal.value) || 0;
            });
            document.querySelector('#total').value = total.toFixed(2);
        }

        function removeRow(button) {
            const row = button.closest('tr');
            row.remove();
            updateTotal();
        }

        function addRow() {
            const tableBody = document.querySelector('#products-table tbody');
            const lastRow = tableBody.querySelector('tr');
            const newRow = lastRow.cloneNode(true);

            newRow.querySelectorAll('select, input').forEach(el => {
                if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } else {
                    el.value = el.classList.contains('quantity') ? 1 : '';
                }
            });

            newRow.querySelectorAll('[name]').forEach(el => {
                el.name = el.name.replace(/products\[\d+\]/, `products[${productIndex}]`);
            });

            tableBody.appendChild(newRow);
            productIndex++;
        }
    </script>
</x-app-layout>
