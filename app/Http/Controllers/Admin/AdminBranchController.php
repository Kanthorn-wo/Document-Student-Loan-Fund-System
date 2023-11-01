<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use App\Models\Admin\Faculty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBranchController extends Controller
{
    public function index()
    {
        $faculty_data = Faculty::all();
        $branch_data = Branch::all();
        return view('admin.branch.index', compact('faculty_data', 'branch_data'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required',
            'branch_code' => 'required|integer|between:0,999999|unique:branches',
            'branch_name' => 'required|max:255|unique:branches|not_regex:/สาขา/',

        ], [
            'faculty_id.required' => 'กรุณาเลือกคณะ',
            'branch_code.required' => 'กรุณาป้อนรหัสสาขา',
            'branch_code.integer' => 'กรุณาป้อนรหัสสาขาเป็นตัวเลข 0-9 เท่านั้น',
            'branch_code.between' => 'ป้อนรหัสสาขาเป็นตัวเลขได้ไม่เกิน 6 หลัก',
            'branch_code.unique' => 'รหัสสาขาซ้ำ',
            'branch_name.required' => 'กรุณาป้อนชื่อสาขา',
            'branch_name.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
            'branch_name.unique' => 'ชื่อสาขาซ้ำ',
            'branch_name.not_regex' => 'ไม่ต้องป้อนคำว่า"สาขา"',

        ]

        );
        $branch_concast = $request->branch_name;
        $data = array();
        $data['faculty_id'] = $request->faculty_id;
        $data['branch_code'] = $request->branch_code;
        $data['branch_name'] = $branch_concast;

        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table('branches')->insert($data);
        return redirect()->back()->with('success', "บันทึกข้อมูลสำเร็จ");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'faculty_id' => 'required',
            'branch_code' => 'required|integer|between:0,9999|unique:branches,branch_code,' . $id,
            'branch_name' => 'required|max:255|unique:branches,branch_name,' . $id,
            'abbreviation_name' => 'max:255',
        ], [
            'faculty_id.required' => 'กรุณาเลือกคณะ',
            'branch_code.required' => 'กรุณาป้อนรหัสสาขา',
            'branch_code.integer' => 'กรุณาป้อนรหัสสาขาเป็นตัวเลขเท่านั้น',
            'branch_code.between' => 'ป้อนเลขได้ไม่เกิน 4 หลัก',
            'branch_code.unique' => 'รหัสสาขาซ้ำ',
            'branch_name.required' => 'กรุณาป้อนชื่อสาขา',
            'branch_name.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
            'branch_name.unique' => 'ชื่อสาขาซ้ำ',

        ]
        );
        $branch_concast = $request->branch_name;
        $update = Branch::find($id)->update([
            'faculty_id' => $request->faculty_id,
            'branch_name' => $branch_concast,
            'branch_code' => $request->branch_code,
            'update_at' => now(),
        ]);

        return redirect()->route('admin.branch.index')->with('success', "อัพเดตข้อมูลสำเร็จ");
    }

    public function delete($id)
    {
         //หาคณะนักศึกษา
         $results = User ::select('branch')
         ->distinct()
         ->get();
         //เอาค่าณะที่ไม่ซ้ำเหมือน group by
         $distinctValues = $results->pluck('branch')->unique();
         //เอาชื่อคณะ
         $fac_names = Branch::pluck('branch_name');
         //เอาค่าที่ไมตรงกันจาก 2 ตัวแปรนี้
         $notMatchingValues = $fac_names->diff($distinctValues);
         //เอาข้อมูลจาก id ที่ส่งมา
         $faculty = Branch::find($id);
         //เข้าถึงชื่อผ่าน id ที่ส่งมา
         $faculty_name =  $faculty->branch_name;
         
         if ($notMatchingValues->contains($faculty_name)) {
            Branch::find($id)->forceDelete();
            return redirect()->back()->with('success', "ลบข้อมูลสำเร็จ");
         } else {
             // ค่าใน $faculty_name ไม่มีอยู่ใน $notMatchingValues
             return redirect()->back()->withErrors('ไม่สามารถลบข้อมูลนี้ได้เนื่องจากมีการใช้งานฟิลด์นี้อยู่');
         }
        
         //ลบข้อมูลออกจาก DB

        Branch::find($id)->forceDelete();
        return redirect()->back()->with('success', "ลบข้อมูลสำเร็จ");
    }
}