// Call the dataTables jQuery plugin
$(document).ready(function () {
  $('#dataTable').DataTable({
    responsive: false,
    lengthMenu: [10, 25, 50, 75, 100],
    "language": {
      "search": "ค้นหา:",
      "info": "Showing page _PAGE_ of _PAGES_",
      "lengthMenu": "แสดง _MENU_ รายการ",
      "zeroRecords": "ไม่พบข้อมูล - ขออภัย",
      "infoEmpty": "ไม่มีข้อมูล",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "show": "แสดง",
      "paginate": {
        "previous": "กลับ",
        "next": "ถัดไป"
      }
    }
  });
});

$(document).ready(function () {
  $('#onlyUser').DataTable({
    responsive: true,
    paging: false,
    info: false,
    searching: false,
    "language": {

      "zeroRecords": "ไม่พบข้อมูล - ขออภัย",
      "infoEmpty": "ไม่มีข้อมูล",
      "show": "แสดง",

    }
  });
});

// {
//   responsive: true,
//   paging: true,
//   lengthMenu: [10, 25, 50, 75, 100],
//   ordering: false,
//   info: false,
//   "language": {
//     "search": "ค้นหา:",
//     "zeroRecords": "ไม่พบข้อมูล - ขออภัย",
//     "info": '',
//     "infoEmpty": "ไม่มีข้อมูล",
//     "infoFiltered": "",
//     "show": "แสดง",
//     "paginate": {
//       "previous": "กลับ",
//       "next": "ถัดไป"
//     }
//   }
// }