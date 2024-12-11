<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="mt-4 row">
                <div class="col-12">
                    <div class="card">
                        <div class="pb-0 card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="">Administración de Usuarios</h5>
                                    <p class="mb-0 text-sm">Aquí puedes gestionar los usuarios.</p>
                                </div>
                                <div class="col-6 text-end">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#createUserModal">
                                        <i class="fas fa-user-plus me-2"></i> Agregar usuario
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="tw-relative tw-overflow-x-auto tw-shadow-md sm:tw-rounded-lg tw-p-5">
                            <div
                                class="tw-flex tw-items-center tw-justify-between tw-pb-4 tw-bg-white dark:tw-bg-gray-900">

                                <div class="d-flex flex-row justify-content-start">
                                    <div class="dropdown mr-3">
                                        <button class="btn btn-info dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Acción
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#" id="deactivateSelected">Desactivar</a>
                                            <a class="dropdown-item" href="#" id="deleteSelected">Eliminar</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Generar
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <a class="dropdown-item" href="{{ route('users.pdf') }}" id="excel">PDF</a>
                                            <a class="dropdown-item" href="{{ route('users.download-excel') }}"
                                                id="xls">Excel</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tw-flex-1 tw-flex tw-justify-end">
                                    <label for="table-search" class="tw-sr-only">Search</label>
                                    <div class="tw-relative">
                                        <div
                                            class="tw-absolute tw-inset-y-0 tw-start-0 tw-flex tw-items-center tw-ps-3 tw-pointer-events-none">
                                            <svg class="tw-w-4 tw-h-4 tw-text-gray-500 dark:tw-text-gray-400"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="table-search-users"
                                            class="tw-block tw-p-2 tw-ps-10 tw-text-sm tw-text-gray-900 tw-border tw-border-gray-300 tw-rounded-lg tw-w-80 tw-bg-gray-50 focus:tw-ring-blue-500 focus:tw-border-blue-500 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:focus:tw-ring-blue-500 dark:focus:tw-border-blue-500"
                                            placeholder="Buscar usuario..."
                                            onkeyup="searchTable('table-search-users', 'users-table')">
                                    </div>
                                </div>
                            </div>

                            <table id="users-table"
                                class="tw-w-full tw-text-sm tw-text-left tw-rtl:tw-text-right tw-text-gray-500 dark:tw-text-gray-400">
                                <thead
                                    class="tw-text-xs tw-text-gray-700 tw-uppercase tw-bg-gray-50 dark:tw-bg-gray-700 dark:tw-text-gray-400">
                                    <tr>
                                        <th scope="col" class="tw-p-4">
                                            <div class="tw-flex tw-items-center">
                                                <input id="select_all_ids" type="checkbox"
                                                    class="tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                            </div>
                                        </th>
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
                                                Apellido
                                                <a
                                                    href="?sort=last_name&direction={{ $sortField === 'last_name' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Email
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
                                                Estado
                                                <a
                                                    href="?sort=status&direction={{ $sortField === 'status' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Roles</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Acción</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $user)
                                        <tr id="user_ids{{ $user->id }}"
                                            class="tw-bg-white tw-border-b dark:tw-bg-gray-800 dark:tw-border-gray-700 hover:tw-bg-gray-50 dark:hover:tw-bg-gray-600">
                                            <td class="tw-w-4 tw-p-4">
                                                <div class="tw-flex tw-items-center">
                                                    <input type="checkbox" id="" name="ids"
                                                        class="checkbox_ids tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600"
                                                        value="{{ $user->id }}">
                                                </div>
                                            </td>
                                            <td class="tw-px-6 tw-py-4">{{ $user->id }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $user->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $user->last_name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $user->email }}</td>
                                            <td class="tw-px-6 tw-py-4">
                                                <div class="tw-flex tw-items-center">
                                                    <div
                                                        class="tw-h-2.5 tw-w-2.5 tw-rounded-full {{ $user->status ? 'tw-bg-green-500' : 'tw-bg-red-500' }} tw-me-2">
                                                    </div> {{ $user->status ? 'Activo' : 'Inactivo' }}
                                                </div>
                                            </td>
                                            <td class="tw-px-6 tw-py-4">
                                                <button class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#viewRolesModal" data-user-id="{{ $user->id }}">
                                                    Ver
                                                </button>
                                            </td>
                                            <td class="tw-px-6 tw-py-4 tw-flex tw-space-x-2">
                                                <a href="#"
                                                    class="tw-font-medium tw-text-blue-600 dark:tw-text-blue-500 hover:tw-underline"
                                                    data-bs-toggle="modal" data-bs-target="#editUserModal"
                                                    data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                                    data-user-last_name="{{ $user->last_name }}"
                                                    data-user-email="{{ $user->email }}"
                                                    data-user-status="{{ $user->status }}">
                                                    <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="tw-font-medium tw-text-red-600 dark:tw-text-red-500 hover:tw-underline"
                                                        onclick="return confirm('Estas seguro de que quieres eliminar este usuario?')">
                                                        <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
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

    <!-- Create User Modal -->
    <!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Agregar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: red"></button>
            </div>
            <div class="modal-body">
                <form id="createUserForm" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            pattern="[A-Za-záéíóúÁÉÍÓÚñÑüÜ ]+" title="Solo se permiten letras" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Apellido</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name"
                            pattern="[A-Za-záéíóúÁÉÍÓÚñÑüÜ ]+" title="Solo se permiten letras" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="status" class="form-label">Estado</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="roles" class="form-label">Roles</label>
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input @error('roles') is-invalid @enderror" type="checkbox" id="role_{{ $role->id }}" name="roles[]"
                                    value="{{ $role->name }}" {{ (is_array(old('roles')) && in_array($role->name, old('roles'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_{{ $role->id }}">{{ ucfirst($role->name) }}</label>
                            </div>
                        @endforeach
                        @error('roles')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_last_name" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="edit_last_name" name="last_name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Estado</label>
                            <select class="form-control" id="edit_status" name="status">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_roles" class="form-label">Roles</label>
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="edit_role_{{ $role->id }}"
                                        name="roles[]" value="{{ $role->name }}">
                                    <label class="form-check-label"
                                        for="edit_role_{{ $role->id }}">{{ ucfirst($role->name) }}</label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- View Roles Modal -->
    <div class="modal fade" id="viewRolesModal" tabindex="-1" aria-labelledby="viewRolesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewRolesModalLabel">Roles del Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="rolesList" class="list-group">
                        <!-- Los roles se insertarán aquí dinámicamente -->
                    </ul>
                    <div id="noRolesMessage" class="alert alert-warning d-none mt-3" role="alert">
                        Este usuario no tiene roles asignados.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('error'))
            // Reabrir el modal de creación de usuario si hay un error
            var createUserModal = new bootstrap.Modal(document.getElementById('createUserModal'));
            createUserModal.show();
        @endif
    });
</script>


<script>
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    document.addEventListener('DOMContentLoaded', function () {
        var editUserModal = document.getElementById('editUserModal');
        editUserModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-user-id');
            var userName = button.getAttribute('data-user-name');
            var userLastName = button.getAttribute('data-user-last_name');
            var userEmail = button.getAttribute('data-user-email');
            var userStatus = button.getAttribute('data-user-status');

            var modalForm = editUserModal.querySelector('form');
            modalForm.action = '/info/users/' + userId;

            var modalNameInput = editUserModal.querySelector('#edit_name');
            var modalLastNameInput = editUserModal.querySelector('#edit_last_name');
            var modalEmailInput = editUserModal.querySelector('#edit_email');
            var modalStatusInput = editUserModal.querySelector('#edit_status');

            modalNameInput.value = userName;
            modalLastNameInput.value = userLastName;
            modalEmailInput.value = userEmail;
            modalStatusInput.value = userStatus;

            // Limpiar los roles seleccionados
            editUserModal.querySelectorAll('input[type="checkbox"][name="roles[]"]').forEach(function (
                checkbox) {
                checkbox.checked = false;
            });

            // Obtener y marcar los roles del usuario
            fetch('/info/users/' + userId + '/roles')
                .then(response => response.json())
                .then(data => {
                    data.roles.forEach(function (role) {
                        var roleCheckbox = editUserModal.querySelector(
                            'input[type="checkbox"][name="roles[]"][value="' + role +
                            '"]');
                        if (roleCheckbox) {
                            roleCheckbox.checked = true;
                        }
                    });
                });
        });
    });

    var viewRolesModal = document.getElementById('viewRolesModal');
    viewRolesModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-user-id');
        var rolesList = document.getElementById('rolesList');

        rolesList.innerHTML = '';

        fetch('/info/users/' + userId + '/roles')
            .then(response => response.json())
            .then(data => {
                if (data.roles.length > 0) {
                    data.roles.forEach(function (role) {
                        var listItem = document.createElement('li');
                        listItem.textContent = capitalizeFirstLetter(role);
                        listItem.classList.add('list-group-item');
                        rolesList.appendChild(listItem);
                    });
                } else {
                    var listItem = document.createElement('li');
                    listItem.textContent = 'No tiene roles asignados';
                    listItem.classList.add('list-group-item');
                    rolesList.appendChild(listItem);
                }
            });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const totalRecords = {{ $users->count() }};
        const tableId = 'users-table';
        const paginationContainerId = 'pagination-numbers';
        const defaultRecordsPerPage = 10;

        initPagination(totalRecords, tableId, paginationContainerId, defaultRecordsPerPage);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        initializeDeleteAll({
            selectAllId: "#select_all_ids",
            checkboxClass: ".checkbox_ids",
            deleteButtonId: "#deleteSelected",
            deleteUrl: "{{ route('user.delete') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#user_ids"
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        initializeDeactivateAll({
            selectAllId: "#select_all_ids",
            checkboxClass: ".checkbox_ids",
            deactivateButtonId: "#deactivateSelected",
            deactivateUrl: "{{ route('user.deactivate') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#user_ids"
        });
    });
</script>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        var createUserModal = document.getElementById('createUserModal');
        createUserModal.addEventListener('show.bs.modal', function (event) {

            var modalForm = createUserModal.querySelector('form');

            var modalNameInput = editUserModal.querySelector('name');
            var modalLastNameInput = editUserModal.querySelector('last_name');
            var modalEmailInput = editUserModal.querySelector('email');
            var modalPasswordInput = editUserModal.querySelector('password');
            var modalStatusInput = editUserModal.querySelector('status');

            modalNameInput.value = userName;
            modalLastNameInput.value = userLastName;
            modalEmailInput.value = userEmail;
            modalPasswordInput.value = password;
            modalStatusInput.value = userStatus;

        });
    });
    var viewRolesModal = document.getElementById('viewRolesModal');
    viewRolesModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-user-id');
        var rolesList = document.getElementById('rolesList');

        rolesList.innerHTML = '';

        fetch('/info/users/' + userId + '/roles')
            .then(response => response.json())
            .then(data => {
                if (data.roles.length > 0) {
                    data.roles.forEach(function (role) {
                        var listItem = document.createElement('li');
                        listItem.textContent = capitalizeFirstLetter(role);
                        listItem.classList.add('list-group-item');
                        rolesList.appendChild(listItem);
                    });
                } else {
                    var listItem = document.createElement('li');
                    listItem.textContent = 'No tiene roles asignados';
                    listItem.classList.add('list-group-item');
                    rolesList.appendChild(listItem);
                }
            });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fields = [
            { id: 'password', iconId: 'password-icon' },
            { id: 'password_confirmation', iconId: 'password-confirmation-icon' }
        ];

        fields.forEach(field => {
            const inputElement = document.getElementById(field.id);

            // Estilos en línea para eliminar íconos predeterminados del navegador
            inputElement.style.webkitAppearance = 'none'; // Chrome, Safari, Edge
            inputElement.style.mozAppearance = 'textfield'; // Firefox
            inputElement.style.appearance = 'none'; // General para navegadores modernos
            inputElement.style.paddingRight = '2.5rem'; // Espacio para el ícono personalizado

            // Eliminar pseudo-elementos nativos dinámicos
            const style = document.createElement('style');
            style.innerHTML = `
                #${field.id}::-ms-reveal,
                #${field.id}::-ms-clear,
                #${field.id}::-webkit-clear-button,
                #${field.id}::-webkit-inner-spin-button {
                    display: none !important; /* Ocultar íconos predeterminados */
                }
            `;
            document.head.appendChild(style);

            // Crear el ícono personalizado
            const iconElement = document.createElement('i');
            iconElement.classList.add('fas', 'fa-eye', 'position-absolute', 'text-muted');
            iconElement.style.cursor = 'pointer';
            iconElement.style.right = '1rem';
            iconElement.style.top = '50%';
            iconElement.style.transform = 'translateY(-50%)';
            iconElement.id = field.iconId;

            // Crear un contenedor para el input y el ícono
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.display = 'flex';
            wrapper.style.alignItems = 'center';
            wrapper.style.width = '100%';

            // Insertar el contenedor antes del input y mover el input dentro del contenedor
            inputElement.parentNode.insertBefore(wrapper, inputElement);
            wrapper.appendChild(inputElement);
            wrapper.appendChild(iconElement);

            // Alternar entre mostrar y ocultar contraseña
            iconElement.addEventListener('click', function () {
                const type = inputElement.getAttribute('type') === 'password' ? 'text' : 'password';
                inputElement.setAttribute('type', type);
                iconElement.classList.toggle('fa-eye');
                iconElement.classList.toggle('fa-eye-slash');
            });
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('password_confirmation');

        // Función para verificar si las contraseñas coinciden
        const checkPasswordsMatch = () => {
            const password = passwordField.value;
            const confirmPassword = confirmPasswordField.value;

            if (confirmPassword === '') {
                // Restaurar bordes si el campo está vacío
                passwordField.style.borderColor = '';
                confirmPasswordField.style.borderColor = '';
                return;
            }

            if (password === confirmPassword) {
                // Cambiar los bordes a verde si coinciden
                passwordField.style.borderColor = '#90ee90'; // Verde claro
                confirmPasswordField.style.borderColor = '#90ee90'; // Verde claro
            } else {
                // Cambiar los bordes a rojo si no coinciden
                passwordField.style.borderColor = 'red';
                confirmPasswordField.style.borderColor = 'red';
            }
        };

        // Escuchar eventos para actualizar los bordes dinámicamente
        passwordField.addEventListener('input', checkPasswordsMatch);
        confirmPasswordField.addEventListener('input', checkPasswordsMatch);
    });
</script>
