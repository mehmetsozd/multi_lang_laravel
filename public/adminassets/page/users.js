"use strict";
var DataTableUsers = function () {
    var table;
    var dt;

    var initTable = function () {
        var Cl = [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: null, name: 'is_admin'},
            {data: 'created_at', name: 'created_at'}
        ];
        dt = $('#datatable-users').DataTable({
            searchDelay: 1000,
            processing: true,
            serverSide: true,
            ajax: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: baseHost + "user/list",
                type: "POST"
            },
            order: [[0, 'desc']],
            columns: Cl,
            columnDefs: [
                {
                    targets: 3,orderable: true,
                    render: function (data, type, row) {
                        return `<div class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                <input class="form-check-input admin_status" type="checkbox" value="1" `+(row.is_admin?'checked':'')+` userid="`+row.id+`"/>
                            </div>`;
                    }
                },
            ]
        });
        table = dt.$;
        dt.on('draw', function () {
            KTMenu.createInstances();
            userAdminChange();
        });
    }
    var userAdminChange = function () {
        $( ".admin_status" ).each(function( index ) {
            this.addEventListener('change', function () {
                var user_id = $(this).attr('userid');
                var is_admin = $(this).prop('checked') ? 1 : 0;
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: baseHost + "user/admin",
                    type: "PUT",
                    data: {user_id:user_id,is_admin:is_admin},
                    success: function (data) {
                        toastr.success(data.message);
                    },
                    error: function (data) {
                        toastr.error(data.responseJSON.message);
                    }
                });
            });
        });
    }
    return {
        init: function () {
            initTable();
            KTMenu.createInstances();
        },
        refresh: function (){
            $('#datatable-users').DataTable().ajax.reload();
        }
    }
}();
// On document ready
KTUtil.onDOMContentLoaded(function() {
    DataTableUsers.init();
});
