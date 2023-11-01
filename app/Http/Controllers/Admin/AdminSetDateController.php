<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\DatePicker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSetDateController extends Controller
{
    public function index()
    {

        $active_now = DatePicker::where('is_active', '=', 1)->get();
        $date_data = DatePicker::all();

        return view('admin.setdate.index', compact('date_data', 'active_now'));
    }

    public function checkDate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ],
            ['start_date.required' => 'กรุณาเลือกวันเริ่มต้น',
                'start_date.before' => 'วันที่เริ่มต้นต้องเป็นวันที่ก่อนวันที่สิ้นสุด',
                'end_date.required' => 'กรุณาเลือกวันสิ้นสุด',
                'end_date.after' => 'วันที่สิ้นสุดต้องเป็นวันที่หลังวันที่เริ่มต้น',

            ]
        );

        $count = DB::table('date_pickers')->count();
        if ($count < 5) {
            DatePicker::insert([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => 0,
            ]);
            return redirect()->back()->with('success', "บันทึกข้อมูลสำเร็จ");
        } else {
            return redirect()->back()->withErrors('เพิ่มข้อมูลได้สูงสุด 5 แถว กรุณาลบช้อมูลที่ไม่จำเป็นหากต้อกการเพิ่มข้อมูล');
        }

    }

    public function active($id)
    {

        DB::table('date_pickers')->update(['is_active' => 0]);
        DB::table('date_pickers')->where('id', $id)->update(['is_active' => 1]);
        return redirect()->back()->with('success', "บันทึกข้อมูลสำเร็จ");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ],
            ['start_date.required' => 'กรุณาเลือกวันเริ่มต้น',
                'start_date.before' => 'วันที่เริ่มต้นต้องเป็นวันที่ก่อนวันที่สิ้นสุด',
                'end_date.required' => 'กรุณาเลือกวันสิ้นสุด',
                'end_date.after' => 'วันที่สิ้นสุดต้องเป็นวันที่หลังวันที่เริ่มต้น',

            ]
        );

        $update = DatePicker::find($id)->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        return redirect()->back()->with('success', "อัพเดทข้อมูลสำเร็จ");

    }

    public function delete($id)
    {
        //ลบข้อมูลออกจาก DB
        DatePicker::find($id)->forceDelete();

        // return response()->json(['massage' => 'ลบข้อมูลสำเร็จ']);
        return redirect()->back()->with('success', "ลบข้อมูลสำเร็จ");
    }

}