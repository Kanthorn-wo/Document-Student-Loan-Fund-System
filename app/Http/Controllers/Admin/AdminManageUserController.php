<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Faculty;
use App\Models\Admin\Prefix;
use App\Models\Admin\SendDocument;
use App\Models\Staffs;
use App\Models\User;
use App\Models\User\SendDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminManageUserController extends Controller
{
    public function index()
    {

        $prefix_data = Prefix::all();
        $staff_all = Staffs::all();
        return view('admin.manageuser.index', compact('staff_all', 'prefix_data', ));
    }

    public function addStaff(Request $request)
    {
        $request->validate([
            'prefix_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'rank' => 'required',
            'email' => 'required|email|unique:staffs,email',
            'password' => 'required|min:8|max:32',
        ]);

        $data = array();
        $data['prefix_name'] = $request->prefix_name;
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['rank'] = $request->rank;
        $data['password'] = bcrypt($request->password);
        $data['created_at'] = now();
        $data['updated_at'] = now();
        DB::table('staffs')->insert($data);
        return redirect()->back()->with('success', "บันทึกข้อมูลสำเร็จ");
    }

    public function updateStaff(Request $request, $id)
    {
        // dd($request, $id);

        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:staffs,email,' . $id,
            'rank' => 'nullable|max:255',

        ], [
            'first_name.required' => 'กรุณาระบุชื่อ',
            'first_name.max' => 'ระบุชื่อได้ไม่เกิน max: ตัวอักษร',
            'last_name.required' => 'กรุณาระบุนามสกุล',
            'last_name.max' => 'ระบุนามสกุลได้ไม่เกิน max: ตัวอักษร',
            'name.required' => 'กรุณาระบุชื่อ',
            'email.required' => 'กรุณาระบุอีเมล',
            'email.unique' => 'อีเมลนี้ถูกใช้งานในระบบแล้ว',
            'email.max' => 'ระบุอีเมลได้ไม่เกิน max: ตัวอักษร',
            'rank.max' => 'ระบุตำแหน่งได้ไม่เกิน max: ตัวอักษร',

        ]);

        $update = Staffs::findOrFail($id);
        $update->prefix_name = $request->prefix_name;
        $update->first_name = $request->first_name;
        $update->last_name = $request->last_name;
        $update->email = $request->email;
        $update->rank = $request->rank;
        $update->save();
        return redirect()->back()->with('success', "อัพเดตข้อมูลสำเร็จ");
    }

    public function deleteStaff($id)
    {
        Staffs::findOrFail($id)->forceDelete();
        return redirect()->back()->with('success', "ลบข้อมูลสำเร็จ");
    }

    public function userList()
    {
        $prefix_data = Prefix::all();
        $faculties = DB::table('faculties')->get();
        $user_all = User::paginate(10);
        return view('admin.manageuser.userlist', [
            'users' => $user_all,
            'total' => $user_all->total(),
            'faculties' => $faculties,
            'prefix_name' => $prefix_data,
        ]);
    }

    public function searchUser(Request $request)
    {
        $prefix_name = Prefix::all();
        $faculties = DB::table('faculties')->get();
        $search_text = $request['search'];
        $result = DB::table('users')
            ->where('first_name', 'LIKE', '%' . $search_text . '%')
            ->orWhere('last_name', 'LIKE', '%' . $search_text . '%')
            ->orWhere('student_id', 'LIKE', '%' . $search_text . '%')
            ->orWhere('personal_id', 'LIKE', '%' . $search_text . '%')
            ->paginate(10);
        $result->appends($request->all());
        // dd($result);

        return view('admin.manageuser.search', compact('result', 'faculties', 'prefix_name'));
    }

    public function updateUser(Request $request, $id)
    {
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'personal_id' => 'required|max:13|regex:/^[0-9]{13}$/|unique:users,personal_id,' . $id . ',id',
            'student_id' => 'required|max:13|regex:/^[0-9]{11}-[0-9]{1}$/|unique:users,student_id,' . $id . ',id',
            'faculty' => 'max:255',
            'branch' => 'max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id . ',id',
            'password' => 'nullable',
        ], [
            'name.required' => 'กรุณาระบุชื่อ',

            'first_name.required' => 'กรุณาระบุชื่อ',
            'first_name.max' => 'ชื่อต้องไม่เกิน :max ตัวอักษร',

            'last_name.required' => 'กรุณาระบุนามสกุล',
            'last_name.unique' => 'นามต้องไม่เกิน :max ตัวอักษร',

            'personal_id.unique' => 'รหัสบัตรประจำตัวประชาชนนี้ถูกใช้ระบบแล้ว',
            'personal_id.required' => 'กรุณาระบุรหัสบัตรประจำตัวประชาชน',
            'personal_id.max' => 'ระบุรหัสบัตรประจำตัวประชาชนได้ไม่เกิน :max หลัก โดยไม่ต้องเติมขีด (`-`) ',
            'personal_id.regex' => 'บัตรประจำตัวประชาชนรูปแบบไม่ถูกต้อง',

            'student_id.unique' => 'รหัสนักศึกษานี้ถูกใช้ระบบแล้ว',
            'student_id.max' => 'ระบุรหัสนักศึกษาได้ไม่เกิน :max หลัก รวมขีด (`-`)',
            'student_id.regex' => 'รหัสนักศึกษารูปแบบไม่ถูกต้อง',

            'email.unique' => 'อีเมลนี้ถูกใช้ระบบแล้ว',
            'email.max' => 'ระบุอีเมลได้ไม่เกิน :max ตัวอักษร',
            'email.required' => 'กรุณาระบุอีเมล',

            'password.required' => 'กรุณาระบุรหัสผ่าน',
            'password.min' => 'กรุณาระบุรหัสผ่านอย่างน้อย min: ตัวอักษร',
            'password.max' => 'กรุณาระบุรหัสผ่านไม่เกิน max: ตัวอักษร',

        ]);
        $documents = SendDocuments::where('user_id', $id)->get();
      
        foreach ($documents as $document) {
            $document->update(['faculty_id' => $request->faculty_id]);
        }
        $tranform = Faculty::find($request->faculty_id)->faculty_name;
        $user = User::findOrFail($id);
        $user->prefix_name = $request->prefix_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->student_id = $request->student_id;
        $user->personal_id = $request->personal_id;
        $user->faculty = $tranform;
        $user->branch = $request->branch;
        if (!$request->password) {
            $user->password = $request->old_password;
        } else {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->back()->with('success', "อัพเดตข้อมูลสำเร็จ");
    }

    public function deleteUser($id)
    {

        $file_user = SendDocument::where('user_id', $id)->get();
        if ($file_user->count()) {
            foreach ($file_user as $file) {
                $get_file = $file->img;
                // delete file code here
                $file_path = $get_file;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }
        User::find($id)->forceDelete();
        return redirect()->back()->with('success', "ลบข้อมูลสำเร็จ");
    }

    public function mySend($id)
    {
        $data_prefix_name = Prefix::all();
        $send_doc = SendDocuments::where('user_id', '=', $id)->orderByDesc('created_at')->get();
        // dd($send_doc);
        return view('admin.manageuser.mysend', compact('send_doc', 'data_prefix_name'));
    }

    public function fetchBranch(Request $request)
    {
        $id_faculty = $request->get('select');
        $result = array();
        $query = DB::table('faculties')
            ->join('branches', 'faculties.id', '=', 'branches.faculty_id')
            ->select('branches.branch_name')
            ->where('faculties.id', $id_faculty)
            ->groupBy('branches.branch_name')
            ->get();
        $output = '<option value="">-- เลือกสาขา --</option>';
        foreach ($query as $row) {
            $output .= '<option value="' . $row->branch_name . '">' . $row->branch_name . '</option>';
        }
        echo $output;
    }

}