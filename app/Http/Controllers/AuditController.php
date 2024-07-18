<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use OwenIt\Auditing\Models\Audit;
use App\Models\Audit;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AuditController extends Controller
{
    public function index()
    {
        $audits = Audit::all();
        $users = User::all();
        $roles = Role::all();
        return view('modules.audits.index', compact('audits', 'users', 'roles'));
    }
    public function charts()
    {
        // Obtener la cuenta de eventos por tipo
        $eventCounts = Audit::select('event', DB::raw('count(*) as count'))
            ->groupBy('event')
            ->pluck('count', 'event')->all();

        $events = ['created', 'updated', 'deleted', 'restored'];

        $eventCountsData = [];
        foreach ($events as $event) {
            $eventCountsData[$event] = $eventCounts[$event] ?? 0;
        }

        // Obtener los usuarios más activos
        $activeUsers = Audit::select('user_id', DB::raw('count(*) as count'))
            ->groupBy('user_id')
            ->orderBy('count', 'desc')
            ->take(10)
            ->with('user') // Asegúrate de tener una relación 'user' en tu modelo Audit
            ->get();

        $userNames = $activeUsers->pluck('user.name');
        $userCounts = $activeUsers->pluck('count');

        // Obtener los modelos más modificados
        $modifiedModels = Audit::select('auditable_type', DB::raw('count(*) as count'))
            ->groupBy('auditable_type')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        $modelNames = $modifiedModels->pluck('auditable_type');
        $modelCounts = $modifiedModels->pluck('count');

        return view('modules.audits.charts', compact('eventCountsData', 'userNames', 'userCounts', 'modelNames', 'modelCounts'));
    }


    public function generatePDF()
    {
        $audits = Audit::all();
        $date = date('d/m/Y H:i:s');

        $data = [
            'title' => 'Registros de Auditoría',
            'date' => $date,
            'audits' => $audits
        ];

        // Configurar el PDF para que sea horizontal (landscape)
        $pdf = PDF::loadView('modules.audits.pdf', $data)->setPaper('a2', 'landscape');
        $pdfName = "Registros Auditoría - {$date}.pdf";

        return $pdf->download($pdfName);
    }
}
