<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Prefix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPrefixController extends Controller
{
    public function index()
    {
        $prefix_name = Prefix::all();
        return view('admin.prefix.index', compact('prefix_name'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'prefix_name' => 'required|max:255|unique:prefixes',
        ],
            ['prefix_name.required' => 'กรุณาป้อนชื่อคำนำหน้า',
                'prefix_name.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
                'prefix_name.unique' => 'ชื่อคำนำหน้าซ้ำ',
            ]
        );

        // Query Builder
        $data = array();
        $data['prefix_name'] = $request->prefix_name;
        $data['created_at'] = now();
        $data['updated_at'] = now();
        DB::table('prefixes')->insert($data);
        return redirect()->back()->with('success', "บันทึกข้อมูลสำเร็จ");
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'prefix_name' => 'required|max:255',
        ],
            ['prefix_name.required' => 'กรุณาป้อนชื่อคำนำหน้า',
                'prefix_name.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
                'prefix_name.unique' => 'ชื่อคำนำหน้าซ้ำ',
            ]
        );

        $update = Prefix::find($id)->update([
            'prefix_name' => $request->prefix_name,
            'update_at' => now(),
        ]);

        return redirect()->route('admin.prefix.index')->with('success', "อัพเดตข้อมูลสำเร็จ");

    }
    public function delete($id)
    {
        //ลบข้อมูลออกจาก DB
        Prefix::find($id)->forceDelete();

        // return response()->json(['massage' => 'ลบข้อมูลสำเร็จ']);
        return redirect()->back()->with('success', "ลบข้อมูลสำเร็จ");
    }
}
