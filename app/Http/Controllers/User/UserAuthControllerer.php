<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\DatePicker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class UserAuthControllerer extends Controller
{
   
    public function login()
    //get sso
    {session_start();

        if (!empty($_SESSION['_login_info'])) {
        $test = json_encode($_SESSION['_login_info']);
        $obj = json_decode($test);
        $user_db = User::where('student_id','=',$obj->studentId)->first();
        if(!empty($user_db)){
        $data_sso = Auth::login($user_db);
        session()->flash('success_sso', 'มีบัญชีนี้ลงทะเบียนในระบบแล้วสามารถเข้าสู่ระบบได้ทันที');
        // header('Location: https://www.dosl.rmuti.ac.th/sso/?logout&redirect=https://www.dosl.rmuti.ac.th');
        // Session::destroy();
        // Session::flush();
        return view('user.login');
        // header('Location: https://dosl.rmuti.ac.th');
        
        
        
        }else{
            $faculty_cut = $obj->faculty;
            $branch_cut = $obj->program;
            $data = array();
            $data['student_id'] = $obj->studentId;
            $data['personal_id'] = $obj->personalId;
            $data['prefix_name'] = $obj->prename;
            $data['first_name'] = $obj->firstNameThai;
            $data['last_name'] = $obj->lastNameThai;
            $data['email'] = $obj->mail;
            $data['password'] = bcrypt($obj->personalId);
            $data['faculty'] = Str::after($faculty_cut, 'คณะ');
            $data['branch'] = Str::after($branch_cut, 'สาขาวิชา');
            $data['created_at'] = now();
            $data['updated_at'] = now();
            DB::table('users')->insert($data);
            session()->flash('success_insert_sso', 'ลงทะเบียนสำเร็จ');
            session()->flash('session_studentId', $obj->studentId);
            session()->flash('session_password', $obj->personalId);
            // header('Location: https://www.dosl.rmuti.ac.th/sso/?logout&redirect=https://www.dosl.rmuti.ac.th');
            return view('user.login');
            // header('Location: https://dosl.rmuti.ac.th');
            // Session::destroy();
            // Session::flush();
            
           
        
        }
        
        }
        return view('user.login');
    }
    
    public function handleLogin(Request $request)
    {
        $remember = $request->has('remember');

        $get_active_date = DatePicker::where('is_active', '=', 1)->get();

        $credentials = $request->validate([
            'student_id' => 'required|max:13|regex:/^[0-9]{11}-[0-9]{1}$/',
            'password' => 'required',
        ], [
            'student_id.required' => 'กรุณาระบุนักศึกษา',
            'student_id.max' => 'ระบุรหัสนักศึกษาได้ไม่เกิน 13 หลัก รวมขีด',
            'student_id.regex' => 'รูปแบบรหัสนักศึกษาไม่ถูกต้อง',
            'password.required' => 'กรุณาระบุรหัสผ่าน',
        ]);

        if (Auth::attempt(['student_id' => $request->student_id, 'password' => $request->password], $remember)) {
            if ($get_active_date->isNotEmpty()) {
                $associative_arr = json_decode($get_active_date, true)[0];
                $data_start_date = date('d/m/Y', strtotime($associative_arr['start_date']));
                $data_end_date = date('d/m/Y', strtotime($associative_arr['end_date']));
                session()->flash('message', $data_start_date . ' ถึง ' . $data_end_date);
            }

            return redirect()->route('user.senddocument.index');
        } else {
            $user = User::where('student_id', $request->student_id)->first();

            if ($user) {
                return redirect()->back()->withErrors([
                    'password' => 'รหัสผ่านไม่ถูกต้อง',
                ]);
            } else {
                return redirect()->back()->withErrors([
                    'student_id' => 'ไม่พบรหัสนักศึกษานี้ในระบบ',
                ]);
            }
        }
    }

  
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login');
        // Session::flush();
        // return redirect()->route('user.login');
    }

    public function getSSO(Request $request)
    {
        $loginInfo = $request->session()->get('_login_info');
        dd($loginInfo);
        return view('sso')->with('loginInfo', $loginInfo);
    }

    public function clear()
    {
       // Clear the session
        
        Session::flush();
    
        // return redirect()->route('user.login');
        return redirect()->back();
    }
}