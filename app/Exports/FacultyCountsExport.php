<?php

namespace App\Exports;

use App\Models\Admin\FileDocument;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FacultyCountsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $id;
    protected $rowNumber = 1;
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function collection()
    {
        return FileDocument::find($this->id)->senddocuments()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Subject',
            'Student ID',
            'Personal ID',
            'Prefix Name',
            'First Name',
            'Last Name',
            'Faculty',
            'Branch',
            'Year',
            'Term',
            'Amount',
            'Type Loan',
            'Created At',
            'Updated At',
            'Status',
            'Comment',
        ];
    }

    public function map($row): array
    {
        $rowNumber = $this->rowNumber++;
        $type_loan_status = '';
        if ($row->type_loan == 11) {
            $type_loan_status = 'ก.1 ผู้กู้ยืมรายเก่าเลื่อนระดับชั้น';
        } elseif ($row->type_loan == 21) {
            $type_loan_status = 'ก.2 ผู้กู้ยืมรายใหม่';
        } elseif ($row->type_loan == 22) {
            $type_loan_status = 'ก.2 ผู้กู้ยืมรายเก่าย้ายสภานศึกษา';
        } elseif ($row->type_loan == 23) {
            $type_loan_status = 'ก.2 ผู้กู้ยืมรายเก่าเปลี่ยนระดับชั้น';
        }

        $review_status = '';
        if ($row->status == 0) {
            $review_status = 'รอตรวจสอบ';
        } elseif ($row->status == 1) {
            $review_status = 'อนุมัติ';
        } elseif ($row->status == 2) {
            $review_status = 'ไม่อนุมัติ';
        }

        $check_null_update = '';
        if ($row->updated_at == null) {
            $check_null_update = 'รอตรวจสอบ';
        } else {
            $check_null_update = $row->updated_at;
        }

        return [
            $rowNumber,
            $row->filedocument->subject,
            $row->user->student_id,
            (string) $row->user->personal_id,
            $row->user->prefix_name,
            $row->user->first_name,
            $row->user->last_name,
            $row->user->faculty,
            $row->user->branch,
            $row->year,
            $row->term,
            $row->amount,
            $type_loan_status,
            $row->created_at,
            $check_null_update,
            $review_status,
            $row->comment,
        ];

    }

}