<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Faculty;
use App\Models\Admin\Prefix;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index()
    {
        $data_prefix_name = Prefix::all();
        $faculties = DB::table('faculties')->orderBy('faculty_code', 'ASC')->get();
        return view('user.profile', compact('data_prefix_name', 'faculties'));
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
            $output .= '<option value="' . $row->branch_name . '">'  . $row->branch_name . '</option>';
        }
        echo $output;
    }

    public function update(Request $request)
    {
        // dd($request->branch);
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'personal_id' => 'required|max:13|regex:/^[0-9]{13}$/|unique:users,personal_id,' . Auth::user()->id . ',id',
            'student_id' => 'required|max:13|regex:/^[0-9]{11}-[0-9]{1}$/|unique:users,student_id,' . Auth::user()->id . ',id',
            'faculty' => 'string|max:255',
            'branch' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id. ',id',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|max:32|required_with:current_password',
            'password_confirmation' => 'nullable|min:8|max:32|required_with:new_password|same:new_password',
        ], [
            'name.required' => 'กรุณาระบุชื่อ',

            'first_name.required' => 'กรุณาระบุชื่อ',
            'first_name.max' => 'ชื่อต้องไม่เกิน :max ตัวอักษร',

            'last_name.required' => 'กรุณาระบุนามสกุล',
            'last_name.unique' => 'นามต้องไม่เกิน :max ตัวอักษร',

            'personal_id.unique' => 'รหัสบัตรประจำตัวประชาชนนี้ถูกใช้ระบบแล้ว',
            'personal_id.required' => 'กรุณาระบุรหัสบัตรประจำตัวประชาชน',
            'personal_id.max' => 'ระบุรหัสบัตรประจำตัวประชาชนได้ไม่เกิน :max หลัก โดยไม่ต้องเติมขีด (`-`) ',
            'personal_id.regex' => 'รูปแบบไม่ถูกต้อง',

            'student_id.unique' => 'รหัสนักศึกษานี้ถูกใช้ระบบแล้ว',
            'student_id.max' => 'ระบุรหัสนักศึกษาได้ไม่เกิน :max หลัก รวมขีด (`-`)',
            'student_id.regex' => 'รูปแบบไม่ถูกต้อง',

            'branch.string' => 'กรุณาเลือกสาขา',
            'email.unique' => 'อีเมลนี้ถูกใช้ระบบแล้ว',
            'email.max' => 'ระบุอีเมลได้ไม่เกิน :max ตัวอักษร',
            'email.required' => 'กรุณาระบุอีเมล',

            'current_password.required' => 'กรุณาป้อนรหัสผ่านปัจจุบัน',
            'new_password.required_with' => 'กรุณาป้อนรหัสผ่านใหม่',
            'new_password.min' => 'รหัสผ่านใหม่ต้องมีอักขระอย่างน้อย 8 ตัว',
            'new_password.max' => 'รหัสผ่านใหม่ต้องไม่เกิน 32 ตัวอักษร',
            'password_confirmation.same' => 'การยืนยันรหัสผ่านและรหัสผ่านใหม่ต้องตรงกัน',
            'password_confirmation.required_with' => 'ช่องยืนยันรหัสผ่านจำเป็นต้องระบุเมื่อมีรหัสผ่านใหม่',
            'password_confirmation.min' => 'การยืนยันรหัสผ่านต้องมีอักขระอย่างน้อย 8 ตัว',
            'password_confirmation.max' => 'การยืนยันรหัสผ่านต้องมีอักขระไม่เกิน 32 ตัวอักษร',

        ]);
        $tranform = Faculty::find($request->faculty)->faculty_name;
        $user = User::findOrFail(auth()->user()->id);
        $user->prefix_name = $request->prefix_name;
        $user->first_name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->student_id = $request->student_id;
        $user->personal_id = $request->personal_id;
        $user->faculty = $tranform;
        $user->branch = $request->branch;

        if (!is_null($request->current_password)) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return redirect()->back()->withErrors('รหัสผ่านไม่ถูกต้อง');
            }
        }

        DB::table('send_documents')->where('user_id', Auth::user()->id)->update(['faculty_id' => Faculty::find($request->faculty)->id]);
        $user->save();

        return redirect()->back()->with('success', "อัพเดตข้อมูลสำเร็จ");
    }

}