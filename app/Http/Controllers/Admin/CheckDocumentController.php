<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Faculty;
use App\Models\Admin\Prefix;
use App\Models\User;
use App\Models\User\SendDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckDocumentController extends Controller
{

    public function index()
    {

        $send_doc = SendDocuments::orderByDesc('created_at')->get();
        return view('admin.checkdoucument.index', compact('send_doc', ));
    }

    public function approve($id)
    {

        $update = SendDocuments::findOrFail($id);
        $update->status = 1;
        $update->comment = null;
        $update->save();
        User::where('id', $update->user_id)->update(['process' => 0]);
        return redirect()->back()->with('success', "อนุมัติเอกสารแล้ว");
    }

    public function disapproval(Request $request, $id)
    {

        $request->validate([
            'comment' => 'required|max:255',
        ],
            ['comment.required' => 'กรุณาป้อนฟิลนี้',
                'comment.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',

            ]
        );

        $update = SendDocuments::findOrFail($id);
        $update->status = 2;
        $update->comment = $request->comment;

        $update->save();
        // User::where('id', $update->user_id)->update(['process' => 0]);
        return redirect()->back()->with('success', "ไม่อนุมัติเอกสารแล้ว");
    }
    public function backedit(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|max:255',
        ],
            ['comment.required' => 'กรุณาป้อนฟิลนี้',
                'comment.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',

            ]
        );
        $update = SendDocuments::findOrFail($id);
        $update->status = 3;
        $update->comment = $request->comment;

        $update->save();
        return redirect()->back()->with('success', "ส่งเอกสารกลับแก้ไข");
    }

    function list(Request $request) {
        $data_prefix_name = Prefix::all();
        $file_doc = DB::table('file_documents')->orderBy('id', 'desc')->get();
        $faculties = DB::table('faculties')->orderBy('faculty_code', 'asc')->get();
        $req_status = $request->status;
        $req_row = $request->row;
        $req_faculty = $request->faculty;
        $req_year = $request->year;
        $req_file_doc = $request->file_doc;
        if ($request->faculty == 'all') {
            $approve = SendDocuments::where('status', '=', $req_status)
                ->where('year', '=', $req_year)
                ->where('file_document_id', '=', $req_file_doc)
                ->paginate($request->row);
        } else {
            $approve = SendDocuments::where('status', '=', $req_status)
                ->where('faculty_id', '=', $req_faculty)
                ->where('year', '=', $req_year)
                ->where('file_document_id', '=', $req_file_doc)
                ->paginate($request->row);
        }
        $approve->appends($request->all());
        return view('admin.checkdoucument.approve', compact('approve', 'req_status', 'req_row', 'faculties', 'req_faculty', 'req_year', 'file_doc', 'req_file_doc', 'data_prefix_name'));
    }

}