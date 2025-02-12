<?php

namespace App\Http\Controllers;

use App\Models\VendedorProyecto;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class VendedorProyectoController extends Controller
{
    public function index()
    {
        $vendedores = User::role('vendedor')->get();
        $proyectos = Project::all();
        $vendedorProyectos = VendedorProyecto::with(['vendedor', 'proyecto'])->get();

        return view('modules.ventas.index', compact('vendedores', 'proyectos', 'vendedorProyectos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendedor_id' => 'required|exists:users,id',
            'proyecto_id' => 'required|exists:projects,id',
        ]);

        VendedorProyecto::create($request->all());
        return redirect()->back()->with('success', 'Vendedor asignado correctamente al proyecto.');
    }

    public function destroy($id)
    {
        $vendedorProyecto = VendedorProyecto::findOrFail($id);
        $vendedorProyecto->delete();
        return redirect()->back()->with('success', 'Asignación eliminada correctamente.');
    }
}
