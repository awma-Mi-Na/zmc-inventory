<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class GetAuditController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, string $date)
    {
        $title = "Audit";
        $datas = Audit::with('user')->whereDate('created_at', $date)->get();
        // return $datas;
        $columns = ['USER', 'AFFECTED MODEL', 'MODEL ID', 'EVENT',  'OLD VALUES', 'NEW VALUES', 'IP'];
        // return view('audit', compact('title', 'datas', 'date', 'columns'));
        return Pdf::loadView('audit', compact('title', 'datas', 'date', 'columns'))->setPaper('a4', 'landscape')->stream("Audit ($date).pdf");
    }
}
