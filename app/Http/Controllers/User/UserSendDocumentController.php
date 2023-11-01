<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\DatePicker;
use App\Models\Admin\Faculty;
use App\Models\Admin\FileDocument;
use App\Models\User;
use App\Models\User\SendDocuments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use App\Models\Admin\Branch;
class UserSendDocumentController extends Controller
{
    public function index()
    {
        $file_doc = FileDocument::orderBy('id', 'desc')->where('status', '=', '1')->get();
        $currentDate = Date::today();
        $get_active_date = DatePicker::where('is_active', '=', 1)->get();
        $check_process = Auth::user()->process;
        if ($get_active_date->isNotEmpty()) {
            $associative_arr = json_decode($get_active_date, true)[0];

            if ($currentDate->between($associative_arr['start_date'], $associative_arr['end_date'])) {
                return view('user.senddocument.index', compact('file_doc', 'associative_arr'));
            } else {
                return view('user.senddocument.alertdate', compact('associative_arr'));
            }

        } else {
            return view('user.senddocument.emptydate');
        }

    }

    public function add($id)
    {

        $file_doc = FileDocument::find($id);
        return view('user.senddocument.add', compact('file_doc'));
    }

    public function store(Request $request, $id)
    {
        
        $request->validate([
            'img' => 'required|file|max:10240|mimes:pdf',
            'amount' => 'required|numeric|gt:-1|regex:/^[0-9]+$/',
            'term' => 'required',

        ],
            ['amount.numeric' => 'จำนวนเงินที่กู้ต้องเป็นตัวเลขเท่านั้น',
                'amount.gt' => 'จำนวนเงินที่กู้ห้ามต่ำกว่า 0',
                'amount.regex' => 'จำนวนเงินที่กู้รูปแบบไม่ถูกต้อง',
                'img.mimes' => 'ต้องส่งเป็นไฟล์นามสกุล .pdf เท่านั้น',
                'img.max' => 'ต้องส่งเป็นไฟล์ .pdf ได้ไม่เกิน 10 MB',
            ], );

        
        //encode img
        $service_img = $request->file('img');
        $name_generate = hexdec(uniqid()); 
        $img_extention = strtolower($service_img->getClientOriginalExtension()); 
        $combine_name_ext = $name_generate . '.' . $img_extention; 

        $upload_location = 'image/services/';
        $full_path = $upload_location . $combine_name_ext;
        // find branch user
        $find_branch_user = Auth::user()->branch; 
        //get branch user search in row table branches
        $find_row_branch = Branch::where('branch_name','=',$find_branch_user)->first(); 
        //get data in attr faculty_id
        $faculty_id = $find_row_branch->faculty_id; 
       
        SendDocuments::insert([
            'user_id' => Auth::user()->id,
            'file_document_id' => $id,
            'faculty_id' =>  $faculty_id,
            'img' => $full_path,
            'status' => 0,
            'amount' => $request->amount,
            'year' => $request->year,
            'term' => $request->term,
            'type_loan' => $request->type_loan,
            'created_at' => Carbon::now(),

        ]);

        $service_img->move($upload_location, $combine_name_ext);

        $id = Auth::id();
        User::where('id', $id)->update(['process' => 1]);

        return redirect()->route('user.senddocument.history')->with('success', "ส่งเอกสารสำเร็จ");
    }

}