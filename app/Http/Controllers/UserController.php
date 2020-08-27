<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class UserController extends Controller
{
    public function users()
    {
        $users = User::orderBy('id', 'DESC')->paginate(15);
        //return response()->json($users);
        return view('users', compact('users'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function exportCSV()
    {
        $date = date('Y-m-d_H:i:s');
        $filename = 'users_' . $date . '.xlsx';
        return Excel::download(new UsersExport, $filename);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function importExportView()
    {
        return view('import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import()
    {
        $file = Excel::import(new UsersImport, request()->file('file'));
        if($file){
            return redirect('users')->with('success', 'Import Users Succeeded');
        }
        //return back();
    }

    public function exportPDF()
    {
        $date = date('Y-m-d_H:i:s');
        $filename = 'users_' . $date . '.pdf';
        $users = User::get();
        $count = User::count();
        $pdf = PDF::loadView('pdf', compact('users', 'count'));
        return $pdf->download($filename);
    }
}
