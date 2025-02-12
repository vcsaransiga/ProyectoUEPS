@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Asignar Vendedores a Proyectos</h2>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('vendedor-proyecto.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-700">Vendedor:</label>
            <select name="vendedor_id" class="w-full p-2 border rounded-lg">
                @foreach($vendedores as $vendedor)
                    <option value="{{ $vendedor->id }}">{{ $vendedor->name }} ({{ $vendedor->email }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Proyecto:</label>
            <select name="proyecto_id" class="w-full p-2 border rounded-lg">
                @foreach($proyectos as $proyecto)
                    <option value="{{ $proyecto->id }}">{{ $proyecto->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-700">
            Asignar Vendedor
        </button>
    </form>

    <!-- Lista de Vendedores Asignados -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4">Vendedores Asignados</h3>
        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Vendedor</th>
                    <th class="border p-2">Proyecto</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendedorProyectos as $vp)
                    <tr class="text-center">
                        <td class="border p-2">{{ $vp->vendedor->name }}</td>
                        <td class="border p-2">{{ $vp->proyecto->name }}</td>
                        <td class="border p-2">
                            <form action="{{ route('vendedor-proyecto.destroy', $vp->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta asignación?');">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white p-1 rounded-lg hover:bg-red-700">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($vendedorProyectos->isEmpty())
                    <tr>
                        <td colspan="3" class="border p-2 text-gray-500">No hay vendedores asignados aún.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
