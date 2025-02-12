<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Exports\UserExport;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort', 'id'); // Campo por defecto
        $sortDirection = $request->get('direction', 'asc'); // Dirección por defecto
        $roles = Role::all();

        $users = User::orderBy($sortField, $sortDirection)->get();

        return view('modules.users.index', compact('users', 'roles', 'sortField', 'sortDirection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/u',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/u',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|boolean',
            'roles' => 'required|array|min:1',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.regex' => 'El nombre no puede contener números',
            'last_name.required' => 'El apellido es obligatorio',
            'last_name.regex' => 'El apellido no puede contener números',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ser una dirección de correo electrónico válida',
            'email.unique' => 'El correo electrónico ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'La confirmación de la contraseña no coincide',
            'status.required' => 'El estado es obligatorio',
            'roles.required' => 'Debes seleccionar al menos un rol',
        ]);

        // Crea el usuario con los datos, cifrando la contraseña
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);

        // Asigna los roles seleccionados
        $user->assignRole($request->roles);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        $roles = Role::all(); // Obtiene todos los roles disponibles, incluyendo "Vendedor"
        return view('modules.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'status' => 'required|boolean',
            'roles' => 'nullable|array', // Permitir que roles sea opcional
        ], [
            'name.required' => 'El nombre es obligatorio',
            'last_name.required' => 'El apellido es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ser una dirección de correo electrónico válida',
            'email.unique' => 'El correo electrónico ya está registrado',
            'status.required' => 'El estado es obligatorio',
        ]);

        // Actualiza los datos del usuario
        $user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        // Sincroniza los roles seleccionados
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $users = User::where('id', 'LIKE', "%$searchTerm%")
            ->orWhere('name', 'LIKE', "%$searchTerm%")
            ->orWhere('last_name', 'LIKE', "%$searchTerm%")
            ->orWhere('email', 'LIKE', "%$searchTerm%")
            ->get();

        $roles = Role::all();
        return view('modules.users.index', compact('users', 'roles'));
    }

    public function deactivateAll(Request $request)
    {
        $ids = $request->ids;

        if (!is_array($ids) || empty($ids)) {
            return response()->json(["error" => "No se han seleccionado usuarios."]);
        }

        User::whereIn('id', $ids)->update(['status' => 0]);

        return response()->json(["success" => "Usuarios seleccionados desactivados exitosamente."]);
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;

        if (!is_array($ids) || empty($ids)) {
            return response()->json(["error" => "No se han seleccionado usuarios."]);
        }

        User::whereIn('id', $ids)->delete();

        return response()->json(["success" => "Usuarios seleccionados eliminados exitosamente."]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function generatePDF()
    {
        $users = User::all();
        $date = date('d/m/Y H:i:s');

        $data = [
            'title' => 'Registros de Usuarios',
            'date' => $date,
            'users' => $users
        ];

        $pdf = PDF::loadView('modules.users.pdf', $data);
        $pdfName = "Usuarios - {$date}.pdf";

        return $pdf->download($pdfName);
    }

    public function exportExcel()
    {
        $date = date('d-m-Y H:i:s');
        $excelName = "Usuarios {$date}.xlsx";
        return Excel::download(new UserExport, $excelName);
    }

    public function getUserRoles(User $user)
    {
        return response()->json(['roles' => $user->roles->pluck('name')->toArray()]);
    }
}
