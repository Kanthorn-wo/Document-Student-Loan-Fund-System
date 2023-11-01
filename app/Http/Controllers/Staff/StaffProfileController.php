<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staffs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffProfileController extends Controller
{
    public function index()
    {
        return view('staff.profile.profile');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id . ',id',
            'rank' => 'nullable|max:255',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|max:32|required_with:current_password',
            'password_confirmation' => 'nullable|min:8|max:32|required_with:new_password|same:new_password',
        ], [
            'name.required' => 'กรุณาระบุชื่อ',
            'email.unique' => 'อีเมลนี้มีในระบบแล้ว',
            'rank.max' => 'ระบุตำแหน่งได้ไม่เกิน max: ตัวอักษร',
            'current_password.required' => 'กรุณาป้อนรหัสผ่านปัจจุบัน',
            'new_password.required_with' => 'กรุณาป้อนรหัสผ่านใหม่',
            'new_password.min' => 'รหัสผ่านใหม่ต้องมีอักขระอย่างน้อย 8 ตัว',
            'new_password.max' => 'รหัสผ่านใหม่ต้องไม่เกิน 32 ตัวอักษร',
            'password_confirmation.same' => 'การยืนยันรหัสผ่านและรหัสผ่านใหม่ต้องตรงกัน',
            'password_confirmation.required_with' => 'ช่องยืนยันรหัสผ่านจำเป็นต้องระบุเมื่อมีรหัสผ่านใหม่',
            'password_confirmation.min' => 'การยืนยันรหัสผ่านต้องมีอักขระอย่างน้อย 8 ตัว',
            'password_confirmation.max' => 'การยืนยันรหัสผ่านต้องไม่เกิน 32 ตัวอักษร',

        ]);

        $user = Staffs::findOrFail($id);
        $user->first_name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->rank = $request->rank;

        if (!is_null($request->current_password)) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return redirect()->back()->withErrors('รหัสผ่านไม่ถูกต้อง');
            }
        }

        $user->save();

        return redirect()->back()->with('success', "อัพเดตข้อมูลสำเร็จ");
    }
}
