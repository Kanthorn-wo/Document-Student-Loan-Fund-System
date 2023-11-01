@extends('layout.usertemplate')
@section('content')
@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert" id="alert">
  <ul class="pl-4 my-2">
    <li id="success">{{ session('success') }}</li>
  </ul>
</div>
@endif
<div class="table-responsive">
  <table class="table  text-center" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th>ลำดับ</th>
        <th>ชื่อเอกสาร</th>
        <th>รหัสนักศึกษา</th>
        <th>ชื่อ-นามสกุล</th>
        <th>จำนวนเงินที่กู้</th>
        <th>ปีการศึกษา</th>
        <th>ภาคการศึกษา</th>
        <th>สถานะ</th>
        <th>ดูรายล่ะเอียด</th>
        <th></th>


      </tr>
    </thead>
    @php
    $index = 1;
    @endphp
    <tbody>
      @foreach ($send_doc as $row)
      <tr>
        <th scope="row">{{ $index++ }}</th>
        <td>{{$row->filedocument->subject}}</td>
        <td>{{$row->user->student_id}}</td>
        <td>{{$row->user->first_name}} {{$row->user->last_name}}</td>
        <td>{{$row->amount}}</td>
        <td>{{$row->year}}</td>
        <td>{{$row->term}}</td>
        <td>@if ($row->status == 0)
          <p style="color: rgb(59, 46, 199)">รอตรวจสอบ</p>
          @elseif ($row->status == 1)
          <p style="color: rgb(11, 234, 74)">อนุมัติ</p>
          @elseif ($row->status == 2)
          <p style="color: rgb(255, 32, 7)">ไม่อนุมัติ</p>
          @elseif ($row->status == 3)
          <p style="color: #f6c23e">ส่งกลับแก้ไข</p>
          @endif
        </td>
        <td>
          <a class="btn btn-primary" type="button"> <i class="far fa-eye"></i></a>
        </td>
        @if ($row->status == 3)
        <td><a class="btn btn-warning" type="button">แก้ไข</a></td>
        @else

        @endif


      </tr>
      @endforeach
    </tbody>

  </table>

</div>
@endsection

@push('scripts')

@endpush