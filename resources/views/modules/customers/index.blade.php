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
                                    @role('administrador')
                                        <h5 class="">Administración de Clientes</h5>
                                        <p class="mb-0 text-sm">Aquí puedes gestionar los clientes.</p>
                                    @else
                                        <h5 class="">Estudiantes</h5>
                                        <p class="mb-0 text-sm">Aquí puedes visualizar los clientes.</p>
                                    @endrole
                                </div>
                                <!--   @role('administrador')
    <div class="col-6 text-end">
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#createcustomerModal">
                                                    <i class="fas fa-user-plus me-2"></i> Agregar estudiante
                                                </button>
                                            </div>
@endrole -->
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Mensaje de éxito -->
                        <div id="message"
                            class="tw-hidden tw-bg-green-100 tw-border tw-border-green-400 tw-text-green-700 tw-px-4 tw-py-3 tw-mt-2 tw-rounded tw-relative"
                            role="alert">
                            <strong class="tw-font-bold">Éxito!</strong>
                            <span class="tw-block sm:tw-inline" id="message-text"></span>
                        </div>

                        <!-- Mensaje de error -->
                        <div id="message-error"
                            class="tw-hidden tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-px-4 tw-py-3 tw-mt-2 tw-rounded tw-relative"
                            role="alert">
                            <strong class="tw-font-bold">Error!</strong>
                            <span class="tw-block sm:tw-inline" id="message-text-error"></span>
                        </div>

                        <div class="tw-relative tw-overflow-x-auto tw-shadow-md sm:tw-rounded-lg tw-p-5">
                            <div
                                class="tw-flex tw-items-center tw-justify-between tw-pb-4 tw-bg-white dark:tw-bg-gray-900">


                                <div class="d-flex flex-row justify-content-start">

                                    @role('administrador')
                                        <div class="dropdown mr-3">
                                            <button class="btn btn-info dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Acción
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#" id="deleteSelected">Eliminar</a>
                                            </div>
                                        </div>
                                    @endrole
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Generar
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <a class="dropdown-item" href="{{ route('customers.pdf') }}"
                                                id="excel">PDF</a>
                                            <a class="dropdown-item" href="{{ route('customers.download-excel') }}"
                                                id="xls">Excel</a>
                                        </div>
                                    </div>
                                </div>

                                <label for="table-search" class="tw-sr-only">Search</label>
                                <div class="tw-relative">
                                    <div
                                        class="tw-absolute tw-inset-y-0 tw-rtl:tw-inset-r-0 tw-start-0 tw-flex tw-items-center tw-ps-3 tw-pointer-events-none">
                                        <svg class="tw-w-4 tw-h-4 tw-text-gray-500 dark:tw-text-gray-400"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="table-search-customers"
                                        class="tw-block tw-p-2 tw-ps-10 tw-text-sm tw-text-gray-900 tw-border tw-border-gray-300 tw-rounded-lg tw-w-80 tw-bg-gray-50 focus:tw-ring-blue-500 focus:tw-border-blue-500 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:focus:tw-ring-blue-500 dark:focus:tw-border-blue-500"
                                        placeholder="Buscar cliente..."
                                        onkeyup="searchTable('table-search-customers', 'table-customers')">
                                </div>
                            </div>
                            <table id="table-customers"
                                class="tw-w-full tw-text-sm tw-text-left tw-rtl:tw-text-right tw-text-gray-500 dark:tw-text-gray-400">
                                <thead
                                    class="tw-text-xs tw-text-gray-700 tw-uppercase tw-bg-gray-50 dark:tw-bg-gray-700 dark:tw-text-gray-400">
                                    <tr>
                                        @role('administrador')
                                            <th scope="col" class="tw-p-4">
                                                <div class="tw-flex tw-items-center">
                                                    <input id="select_all_ids" type="checkbox"
                                                        class="tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                                </div>
                                            </th>
                                        @endrole
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                ID
                                                <a
                                                    href="?sort=id&direction={{ $sortField === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Cédula
                                                <a
                                                    href="?sort=national_id&direction={{ $sortField === 'national_id' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Nombre
                                                <a
                                                    href="?sort=name&direction={{ $sortField === 'name' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Teléfono
                                                <a
                                                    href="?sort=phone&direction={{ $sortField === 'phone' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Correo electrónico
                                                <a
                                                    href="?sort=email&direction={{ $sortField === 'email' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Dirección
                                                <a
                                                    href="?sort=address&direction={{ $sortField === 'address' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        @role('administrador')
                                            <th scope="col" class="tw-px-6 tw-py-3">Acción</th>
                                        @endrole
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr id="customer_ids{{ $customer->id }}"
                                            class="tw-bg-white tw-border-b dark:tw-bg-gray-800 dark:tw-border-gray-700 hover:tw-bg-gray-50 dark:hover:tw-bg-gray-600">
                                            @role('administrador')
                                                <td class="tw-w-4 tw-p-4">
                                                    <div class="tw-flex tw-items-center">
                                                        <input type="checkbox" id="" name="ids"
                                                            class="checkbox_ids tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600"
                                                            value="{{ $customer->id }}">
                                                    </div>
                                                </td>
                                            @endrole
                                            <td class="tw-px-6 tw-py-4">
                                                {{ $customer->id }}
                                            </td>
                                            <td class="tw-px-6 tw-py-4">{{ $customer->national_id }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $customer->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $customer->phone }}</td>
                                            <td class="tw-px-6 tw-py-4">
                                                {{ $customer->email }}
                                            </td>
                                            <td class="tw-px-6 tw-py-4">
                                                {{ $customer->address }}
                                            </td>
                                            @role('administrador')
                                                <td class="tw-px-6 tw-py-4 tw-flex tw-space-x-2">
                                                    <a href="#"
                                                        class="tw-font-medium tw-text-blue-600 dark:tw-text-blue-500 hover:tw-underline"
                                                        data-bs-toggle="modal" data-bs-target="#editCustomerModal"
                                                        data-customer-id="{{ $customer->id }}"
                                                        data-customer-national_id="{{ $customer->national_id }}"
                                                        data-customer-name="{{ $customer->name }}"
                                                        data-customer-phone="{{ $customer->phone }}"
                                                        data-customer-email="{{ $customer->email }}"
                                                        data-customer-address="{{ $customer->address }}">
                                                        <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('customers.destroy', $customer->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="tw-font-medium tw-text-red-600 dark:tw-text-red-500 hover:tw-underline"
                                                            onclick="return confirm('Estas seguro de quieres eliminar este estudiante?')">
                                                            <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endrole
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div
                                class="tw-flex tw-items-center tw-justify-between tw-px-4 tw-py-3 tw-bg-white tw-border-t tw-border-gray-200 sm:tw-px-6">
                                <div class="tw-flex tw-items-center">
                                    <span class="tw-text-sm tw-text-gray-700 tw-mr-2">Mostrar</span>
                                    <select id="records-per-page"
                                        class="tw-form-select tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-offset-gray-100 focus:tw-ring-indigo-500">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                    <span class="tw-text-sm tw-text-gray-700 tw-ml-2">registros</span>
                                </div>
                                <div class="tw-flex tw-items-center">
                                    <span class="tw-text-sm tw-text-gray-700 tw-mr-2">Página</span>
                                    <div id="pagination-numbers" class="tw-flex tw-space-x-2">
                                        <!-- Los números de página se renderizarán aquí -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Edit Customer Modal -->
    <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomerModalLabel">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="editCustomerForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_national_id" class="form-label">Cédula</label>
                            <input type="text" class="form-control" id="edit_national_id" name="national_id"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_phone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="edit_phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Correo electrónico</label>
                            <input type="text" class="form-control" id="edit_email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="edit_address" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="edit_address" name="address" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>

<script>
    var editCustomerModal = document.getElementById('editCustomerModal');
    editCustomerModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var customerId = button.getAttribute('data-customer-id');
        var customerNationalId = button.getAttribute('data-customer-national_id');
        var customerName = button.getAttribute('data-customer-name');
        var customerPhone = button.getAttribute('data-customer-phone');
        var customerEmail = button.getAttribute('data-customer-email');
        var customerAddress = button.getAttribute('data-customer-address');

        var modalForm = editCustomerModal.querySelector('form');
        modalForm.action = '/info/customers/' + customerId;

        var modalNationalIdInput = editCustomerModal.querySelector('#edit_national_id');
        var modalNameInput = editCustomerModal.querySelector('#edit_name');
        var modalPhoneInput = editCustomerModal.querySelector('#edit_phone');
        var modalEmailInput = editCustomerModal.querySelector('#edit_email');
        var modalAddressInput = editCustomerModal.querySelector('#edit_address');

        modalNationalIdInput.value = customerNationalId;
        modalNameInput.value = customerName;
        modalPhoneInput.value = customerPhone;
        modalEmailInput.value = customerEmail;
        modalAddressInput.value = customerAddress;
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalRecords = {{ $customers->count() }};
        const tableId = 'table-customers';
        const paginationContainerId = 'pagination-numbers';
        const defaultRecordsPerPage = 10;

        initPagination(totalRecords, tableId, paginationContainerId, defaultRecordsPerPage);
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeDeleteAll({
            selectAllId: "#select_all_ids",
            checkboxClass: ".checkbox_ids",
            deleteButtonId: "#deleteSelected",
            deleteUrl: "{{ route('customer.delete') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#customer_ids"
        });
    });
</script>
