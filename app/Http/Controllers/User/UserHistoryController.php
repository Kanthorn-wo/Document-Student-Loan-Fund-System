<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Prefix;
use App\Models\User;
use App\Models\User\SendDocuments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHistoryController extends Controller
{
    public function index()
    {
        $data_prefix_name = Prefix::all();
        $user_id = Auth::user()->id;
        $send_doc = SendDocuments::where('user_id', '=', $user_id)->orderByDesc('created_at')->get();

        return view('user.history.index', compact('send_doc', 'data_prefix_name'));
    }

    public function updateDocUser(Request $request, $id)
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
                'comment' => 'แก้ไขข้อมูลเอกสาร และไฟล์ pdf เมื่อ :' . Carbon::now()->format('d/m/Y-H:i:s น.'),
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
                'comment' => 'แก้ไขข้อมูลเอกสาร เมื่อ :' . Carbon::now()->format('d/m/Y-H:i:s น.'),
                'updated_at' => null,

            ]);

            return redirect()->back()->with('success', "อัพเดตข้อมูลสำเร็จ");
        }

    }
}
