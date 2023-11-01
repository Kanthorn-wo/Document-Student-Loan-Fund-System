<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FacultyCountsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AdminExportController extends Controller
{
    public function exportToExcel($id)
    {
        return Excel::download(new FacultyCountsExport($id), 'report' . $id . '.xlsx');
    }
}
