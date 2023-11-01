<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use App\Models\Staffs;
use App\Models\User;
use App\Models\User\SendDocuments;

class StaffDashboradController extends Controller
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

        return view('staff.index', compact('user_data', 'staff_data', 'admin_data', 'all_user_data', 'file_doc', 'approve_doc', 'unapprove_doc', 'wait_doc', 'back_edit_doc', ));
    }
}
