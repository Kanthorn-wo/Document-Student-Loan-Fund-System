<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Faculty;
use App\Models\Admins;
use App\Models\Staffs;
use App\Models\User;
use App\Models\User\SendDocuments;
use Illuminate\Support\Facades\DB;

class AdminIndexController extends Controller
{
    public function index()
    {

        $user_data = User::all();
        $staff_data = Staffs::all();
        $admin_data = Admins::all();
        $all_user_data = count($user_data) + count($staff_data) + count($admin_data);

        $file_doc = SendDocuments::all();
        $wait_doc = SendDocuments::where('status', '=', '0')->get();
        $approve_doc = SendDocuments::where('status', '=', '1')->get();
        $unapprove_doc = SendDocuments::where('status', '=', '2')->get();
        $back_edit_doc = SendDocuments::where('status', '=', '3')->get();

        $get_faculty_id_fk = SendDocuments::select('faculty_id')->get();
        $get_faculty_id_pk = Faculty::select('id')->get();

        $results = DB::table('send_documents')
        ->join('faculties', 'send_documents.faculty_id', '=', 'faculties.id')
        ->select('faculties.id', 'faculties.faculty_name', DB::raw('COUNT(*) as document_count'))
        ->groupBy('faculties.id', 'faculties.faculty_name')
        ->get();


       
        return view('admin.index',['results' => $results], compact('user_data', 'staff_data', 'admin_data', 'all_user_data', 'file_doc', 'approve_doc', 'unapprove_doc', 'wait_doc', 'back_edit_doc', ));
    }
}