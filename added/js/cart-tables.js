$(function () {
    $("#example1").DataTable({"scrollY": 200,"scrollX": true});

    $('#example2').DataTable({"paging": true,"lengthChange": false,"searching": false,"ordering": true,
          "info": true,"autoWidth": false
    });
});
