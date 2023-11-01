<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Faculty;
use App\Models\Admin\FileDocument;
use App\Models\Admin\Prefix;
use App\Models\Admin\SendDocument;
use App\Models\User;
use App\Models\User\SendDocuments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminFileDocument extends Controller
{
    public function index()
    {
      
        $file_doc = FileDocument::orderBy('id', 'desc')->get();

        return view("admin.filedocument.index", compact('file_doc'));
    }

    public function fileList($id)
    {
        
        function getCountByStatus($facultyCounts, $status)
        {
            $result = [];
            foreach ($facultyCounts as $facultyCount) {
                if ($facultyCount->status == $status) {
                    $result[$facultyCount->faculty_id] = $facultyCount->count;
                }
            }
            return $result;
        }

        $facultyCounts = FileDocument::find($id)->senddocuments()->select('faculty_id', DB::raw('count(*) as count'), 'status')
            ->groupBy('faculty_id', 'status')
            ->get();

        $facultyList = $facultyCounts->groupBy('faculty_id')->keys();
        // dd($facultyCounts);
        $countsWait = getCountByStatus($facultyCounts, '0');
        $countsApprove = getCountByStatus($facultyCounts, '1');
        $countsUnapprove = getCountByStatus($facultyCounts, '2');

        $faculty = Faculty::all();
        $wait_doc = FileDocument::find($id)->senddocuments()->where('status', '=', 0)->get();
        $approve_doc = FileDocument::find($id)->senddocuments()->where('status', '=', 1)->get();
        $unapprove_doc = FileDocument::find($id)->senddocuments()->where('status', '=', 2)->get();
        $all_doc = FileDocument::find($id)->senddocuments()->get();
        $data_prefix_name = Prefix::all();
        $list_doc = FileDocument::find($id);
        $doc_query = $list_doc->senddocuments()
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view("admin.filedocument.list", compact('doc_query',
            'list_doc',
            'data_prefix_name',
            'wait_doc',
            'approve_doc',
            'unapprove_doc',
            'all_doc',
            'faculty',
            'facultyCounts',
            'facultyList',
            'countsWait',
            'countsApprove',
            'countsUnapprove'
        ));

    }

    public function deletelist($id)
    {
        $data_img = SendDocument::findOrFail($id)->img;
        if (file_exists($data_img)) {
            unlink($data_img);
        }
        $ids = SendDocument::findOrFail($id);
        $ids->delete();
        User::where('id', $ids->user_id)->update(['process' => 0]);
        return redirect()->back()->with('success', "ลบข้อมูลสำเร็จ");
    }

    public function updateDocAdmin(Request $request, $id)
    {

        $request->validate([
            'img' => 'max:10240|mimes:pdf',
            'amount' => 'numeric|gt:-1',

        ], [
            'amount.numeric' => 'จำนวนเงินที่กู้ต้องเป็นตัวเลขเท่านั้น',
            'amount.gt' => 'จำนวนเงินที่กู้ห้ามต่ำกว่า 0',
            'img.mimes' => 'ต้องส่งเป็นไฟล์นามสกุล .pdf เท่านั้น',
            'img.max' => 'ต้องส่งเป็นไฟล์ .pdf ได้ไม่เกิน 10 MB',
        ]);

        $service_img = $request->file('img');
        //อัพเดทภาพและชื่อ
        if ($service_img) {
            // dd('อัพเดตชื่อและภาพ');
            $name_generate = hexdec(uniqid()); //เจนเนอเรจ ชื่อภาพ
            $img_extention = strtolower($service_img->getClientOriginalExtension()); //ดึงนามสกุลไฟล์
            $combine_name_ext = $name_generate . '.' . $img_extention; //รวมชื่อที่เจนมากับนามสกุลไฟล์

            $upload_location = 'image/services/';
            $full_path = $upload_location . $combine_name_ext;

            SendDocuments::find($id)->update([
                'img' => $full_path,
                'status' => 0,
                'amount' => $request->amount,
                'year' => $request->year,
                'term' => $request->term,
                'type_loan' => $request->type_loan,
                'comment' => '(Admin)แก้ไขข้อมูลเอกสาร และไฟล์ pdf เมื่อ :' . Carbon::now()->format('d/m/Y-H:i:s น.'),
                'updated_at' => null,

            ]);
            $old_img = $request->old_img;
            if (file_exists($old_img)) {
                unlink($old_img);
            }

            $service_img->move($upload_location, $combine_name_ext);

            $id = Auth::id();
            User::where('id', $id)->update(['process' => 1]);
            return redirect()->back()->with('success', "อัพเดตข้อมูล และไฟล์ .pdf สำเร็จ");
        } else {

            SendDocuments::find($id)->update([
                'status' => 0,
                'amount' => $request->amount,
                'year' => $request->year,
                'term' => $request->term,
                'type_loan' => $request->type_loan,
                'comment' => '(Admin)แก้ไขข้อมูลเอกสาร เมื่อ :' . Carbon::now()->format('d/m/Y-H:i:s น.'),
                'updated_at' => null,

            ]);

            return redirect()->back()->with('success', "อัพเดตข้อมูลสำเร็จ");
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'subject' => 'required|max:255|unique:file_documents',
            'note' => 'max:255',
        ],
            ['subject.required' => 'กรุณาป้อนชื่อเอกสาร',
                'subject.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
                'subject.unique' => 'ชื่อเอกสารซ้ำ',
            ]
        );
        // Query Builder
        $data = array();
        $data['subject'] = $request->subject;
        $data['admin_id'] = Auth::user()->id;
        $data['status'] = $request->status;
        $data['note'] = $request->note;
        $data['attachment'] = json_encode($request->inputs1, JSON_UNESCAPED_UNICODE);
        $data['piece'] = json_encode($request->inputs2, JSON_UNESCAPED_UNICODE);
        $data['created_at'] = now();
        $data['updated_at'] = now();
        DB::table('file_documents')->insert($data);
        return redirect()->back()->with('success', "บันทึกข้อมูลสำเร็จ");
    }

    public function edit($id)
    {
        $file_document = FileDocument::find($id);

        return view('admin.filedocument.edit', compact('file_document'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'subject' => 'required|max:255|unique:file_documents,subject,' . $id,
            'note' => 'max:255',
        ],
            ['subject.required' => 'กรุณาป้อนชื่อเอกสาร',
                'subject.max' => 'ป้อนอักขระได้ไม่เกิน 255 ตัวอักษร',
                'subject.unique' => 'ชื่อเอกสารซ้ำ',
            ]
        );
        DB::table('file_documents')
            ->where('id', $id)
            ->update([
                'subject' => $request->input('subject'),
                'note' => $request->input('note'),
                'status' => $request->input('status'),
                'admin_id' => Auth::user()->id,
                'updated_at' => now(),
                'attachment' => json_encode($request->input('inputs1'), JSON_UNESCAPED_UNICODE),
                'piece' => json_encode($request->input('inputs2'), JSON_UNESCAPED_UNICODE),
            ]);
        return redirect()->route('admin.filledoc.add')->withSuccess("อัพเดตข้อมูลสำเร็จ");

    }

    public function delete($id)
    {

        //ลบข้อมูลออกจาก DB
        $data = FileDocument::findOrFail($id);
        $check_row = $data->senddocuments;
        if (count($check_row) > 0) {

            return redirect()->back()->withErrors('ไม่สามารถลบข้อมูลนี้ได้เนื่องจากมีข้อมูลในไฟล์นี้');
        } else {
            $data->forceDelete();
            return redirect()->back()->withSuccess('ลบข้อมูลสำเร็จ');
        }

    }
}