@php
use Illuminate\Support\Facades\Session;

echo '<h1>Clear Session</h1>';
session_start();
if (!empty($_SESSION['_login_info'])) {
$test = json_encode($_SESSION['_login_info']);
$obj = json_decode($test);

if($obj->gidNumber == 4500){
echo 'คุณเป็นนักศึกษา<br>';
foreach ($obj as $key => $value) {
echo $key . ': ' . $value . '<br>';
}

}else{
echo 'สำหรับนักศึกษาเท่านั้น';
}




}else{
echo 'No Session<br>';
}

@endphp
<div>
  <a href="{{ route('clear.session') }}" class=" btn btn-danger btn-user btn-block">
    Clear
  </a>
</div>
<div>
  <a href="{{ route('user.login') }}" class=" btn btn-danger btn-user btn-block">
    Back
  </a>
</div>

<div>
  <a href="https://www.dosl.rmuti.ac.th/sso/?logout&redirect=https://www.dosl.rmuti.ac.th/testsso"
    class=" btn btn-danger btn-user btn-block">
    Logout SSO</a>
</div>