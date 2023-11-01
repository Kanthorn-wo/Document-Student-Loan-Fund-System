<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Faculty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminFacultyController extends Controller
{
    public function index()
    {
        $faculty_data = Faculty::orderBy('faculty_code', 'ASC')->get();
        return view('admin.faculty.index,', compact('faculty_data'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'faculty_name' => 'required|string|max:255|unique:faculties|not_regex:/คณะ/',
            'faculty_code' => 'required|integer|between:0,9999|unique:faculties',
        ],
            ['faculty_name.required' => 'กรุณาป้อนชื่อคณะ',
                'faculty_name.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
                'faculty_name.unique' => 'ชื่อคณะซ้ำ',
                'faculty_name.string' => 'ป้อนชื่อคณะเป็นตัวอักษรเท่านั้น',

                'faculty_name.not_regex' => 'ไม่ต้องป้อนคำว่า"คณะ"',
                'faculty_code.required' => 'กรุณาป้อนรหัสคณะ',
                'faculty_code.integer' => 'กรุณาป้อนรหัสคณะเป็นตัวเลข 0-9 เท่านั้น',
                'faculty_code.unique' => 'รหัสคณะซ้ำ',
                'faculty_code.between' => 'ป้อนเลขได้ไม่เกิน 4 หลัก',
            ]
        );
        $faculty_concast = $request->faculty_name;

        // Query Builder
        $data = array();
        $data['faculty_code'] = $request->faculty_code;
        $data['faculty_name'] = $faculty_concast;
        $data['created_at'] = now();
        $data['updated_at'] = now();
        DB::table('faculties')->insert($data);
        return redirect()->back()->with('success', "บันทึกข้อมูลสำเร็จ");
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'faculty_name' => 'required|max:255|unique:faculties,faculty_name,' . $id,
            'faculty_code' => 'required|max:255|unique:faculties,faculty_code,' . $id,
        ],
            ['faculty_name.required' => 'กรุณาป้อนชื่อคณะ',
                'faculty_name.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
                'faculty_name.unique' => 'ชื่อคณะซ้ำ',
                'faculty_name.not_regex' => 'ไม่ต้องป้อนคำว่า"คณะ"',
                'faculty_code.required' => 'กรุณาป้อนรหัสคณะ',
                'faculty_code.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
                'faculty_code.unique' => 'รหัสคณะซ้ำ',
            ]
        );
        $faculty_concast = $request->faculty_name;

        $update = Faculty::find($id)->update([
            'faculty_name' => $faculty_concast,
            'faculty_code' => $request->faculty_code,
            'update_at' => now(),
        ]);

        return redirect()->route('admin.faculty.index')->with('success', "อัพเดตข้อมูลสำเร็จ");

    }
    public function delete($id)
    {
        //หาคณะนักศึกษา
        $results = User ::select('faculty')
        ->distinct()
        ->get();
        //เอาค่าณะที่ไม่ซ้ำเหมือน group by
        $distinctValues = $results->pluck('faculty')->unique();
        //เอาชื่อคณะ
        $fac_names = Faculty::pluck('faculty_name');
        //เอาค่าที่ไมตรงกันจาก 2 ตัวแปรนี้
        $notMatchingValues = $fac_names->diff($distinctValues);
        //เอาข้อมูลจาก id ที่ส่งมา
        $faculty = Faculty::find($id);
        //เข้าถึงชื่อผ่าน id ที่ส่งมา
        $faculty_name =  $faculty->faculty_name;
        
        if ($notMatchingValues->contains($faculty_name)) {
            // ค่าใน $faculty_name มีอยู่ใน $notMatchingValues (ไม่มีคนใช้)
            Faculty::find($id)->forceDelete();
        return redirect()->back()->with('success', "ลบข้อมูลสำเร็จ");
        } else {
            // ค่าใน $faculty_name ไม่มีอยู่ใน $notMatchingValues
            return redirect()->back()->withErrors('ไม่สามารถลบข้อมูลนี้ได้เนื่องจากมีการใช้งานฟิลด์นี้อยู่');
        }
       
        //ลบข้อมูลออกจาก DB
        
    }
}