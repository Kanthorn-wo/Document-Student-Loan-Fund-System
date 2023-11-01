<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Faculty;
use App\Models\Admin\Prefix;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRegisterController extends Controller
{
    public function index()
    {
        $prefix_data = Prefix::all();
        $faculties = DB::table('faculties')->orderBy('faculty_code', 'ASC')->get();
        return view('user.register', compact('faculties', 'prefix_data'));
    }

    public function getBranch(Request $request)
    {
        $id_faculty = $request->get('select');
        $result = array();
        $query = DB::table('faculties')
            ->join('branches', 'faculties.id', '=', 'branches.faculty_id')
            ->select('branches.branch_name', 'branches.branch_code')
            ->where('faculties.id', $id_faculty)
            ->groupBy('branches.branch_name', 'branches.branch_code')
            ->orderBy('branches.branch_code', 'asc')
            ->get();
        $output = '<option value="">เลือกสาขา</option>';
        foreach ($query as $row) {
            $output .= '<option value="' . $row->branch_name . '">' . $row->branch_code . ' | ' . $row->branch_name . '</option>';
        }
        echo $output;
    }

    public function store(Request $request)
    {

        $request->validate([
            'student_id' => 'required|unique:users|max:13|regex:/^[0-9]{11}-[0-9]{1}$/',
            'personal_id' => 'required|max:13|unique:users|regex:/^[0-9]{13}$/',
            'email' => 'required|unique:users|max:255',
            'first_name' => 'required|max:255|regex:/^[\p{Thai}]+$/u',
            'last_name' => 'required|max:255|regex:/^[\p{Thai}]+$/u',
            'password' => 'required|min:8|max:32|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/',
            'confirm-password' => 'required|min:8|max:32|required_with:password|same:password|',
            'prefix_name' => 'required',
            'faculty' => 'required',
            'branch' => 'required',

        ], [
            'student_id.required' => 'กรุณาระบุรหัสนักศึกษา',
            'student_id.unique' => 'รหัสนักศึกษานี้ถูกใช้ระบบแล้ว',
            'student_id.max' => 'ระบุรหัสนักศึกษาได้ไม่เกิน :max หลัก รวมขีด (`-`)',
            'student_id.regex' => 'รูปแบบไม่ถูกต้อง',

            'personal_id.unique' => 'รหัสบัตรประจำตัวประชาชนนี้ถูกใช้ระบบแล้ว',
            'personal_id.required' => 'กรุณาระบุรหัสบัตรประจำตัวประชาชน',
            'personal_id.max' => 'ระบุรหัสบัตรประจำตัวประชาชนได้ไม่เกิน :max หลัก โดยไม่ต้องเติมขีด (`-`) ',
            'personal_id.regex' => 'รูปแบบไม่ถูกต้อง',

            'email.unique' => 'อีเมลนี้ถูกใช้ระบบแล้ว',
            'email.max' => 'ระบุอีเมลได้ไม่เกิน :max ตัวอักษร',
            'email.required' => 'กรุณาระบุอีเมล',

            'password.required' => 'กรุณาระบุรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีอย่างน้อย :min ตัวอักษร',
            'password.max' => 'รหัสผ่านต้องไม่เกิน :max ตัวษร',
            'password.regex' => 'รูปแบบไม่ถูกต้อง',
            'confirm-password.required' => 'กรุณาระบุยืนยันรหัสผ่าน',
            'confirm-password.min' => 'รหัสผ่านยืนยันต้องมีอย่างน้อย :min ตัว',
            'confirm-password.max' => 'รหัสผ่านยืนยันต้องไม่เกิน :max ตัว',
            'confirm-password.same' => 'รหัสผ่านและรหัสผ่านยืนยันต้องตรงกัน',

            'prefix_name.required' => 'กรุณาระบุคำนำหน้า',

            'first_name.required' => 'กรุณาระบุชื่อ',
            'first_name.max' => 'ชื่อต้องไม่เกิน :max ตัวอักษร',
            'first_name.regex' => 'กรุณาระบุชื่อภาษาไทย',

            'last_name.required' => 'กรุณาระบุนามสกุล',
            'last_name.max' => 'นามสกุลต้องไม่เกิน :max ตัวอักษร',
            'last_name.regex' => 'กรุณาระบุนามสกุลภาษาไทย',

            'faculty.required' => 'กรุณาระบุคณะ',

            'branch.required' => 'กรุณาระบุสาขา',

        ]);
        //แปลงจาก faculty id เป็น faculty name
        $tranform = Faculty::find($request->faculty)->faculty_name;
        $isUnique = User::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->doesntExist();
        // dd($isUnique);
        if (!$isUnique) {
            return back()
                ->withErrors(['first_name' => 'มีชื่อนี้ในระบบแล้ว', 'last_name' => 'มีนามสกุลนี้ในระบบแล้ว'])
                ->withInput();
        }

        // User::insert([
        //     'student_id' => $request->student_id,
        //     'personal_id' => $request->personal_id,
        //     'prefix_name' => $request->prefix_name,
        //     'first_name' => $request->first_name,
        //     'last_name' => $request->last_name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        //     'faculty' => $tranform,
        //     'branch' => $request->branch,
        //     'created_at' => $now,
        //     'updated_at' => $now,
        // ]);
        $data = array();
        $data['student_id'] = $request->student_id;
        $data['personal_id'] = $request->personal_id;
        $data['prefix_name'] = $request->prefix_name;
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['faculty'] = $tranform;
        $data['branch'] = $request->branch;
        $data['created_at'] = now();
        $data['updated_at'] = now();
        DB::table('users')->insert($data);
        return redirect()->route('user.login')->with('success', "ลงทะเบียนสำเร็จสามารถเข้าสู่ระบบได้ทันที");
    }
}
