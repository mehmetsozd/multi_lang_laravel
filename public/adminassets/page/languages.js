"use strict";
var DataTableLanguages = function () {
    var table;
    var dt;

    var initTable = function () {
        var Cl = [
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: null, name: 'is_default' },
            { data: null, orderable: false },
        ];
        dt = $('#datatable-languages').DataTable({
            searchDelay: 1000,
            processing: true,
            serverSide: true,
            ajax: {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: baseHost + "language/list",
                type: "POST"
            },
            order: [[0, 'desc']],
            columns: Cl,
            columnDefs: [
                {
                    targets: 2, orderable: true,
                    render: function (data, type, row) {
                        return `<div class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                <input class="form-check-input language_defualt" type="checkbox" value="1" `+ (row.is_default == '1' ? 'checked' : '') + ` languageid="` + row.id + `"/>
                            </div>`;
                    }
                },
                {
                    targets: 3, orderable: false,
                    render: function (data, type, row) {
                        return `<div class="d-flex justify-content-end">
                            <div class="ms-2">
                                <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/>
                                            <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"/>
                                            <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a href="javascript:languageEdit('`+ row.id + `')" class="menu-link px-3">Edit</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="javascript:languageDelete('`+ row.id + `')" class="menu-link text-danger px-3">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    }
                }
            ]
        });
        table = dt.$;
        dt.on('draw', function () {
            KTMenu.createInstances();
            defualtLangChange();
        });
    }
    var defualtLangChange = function () {
        $(".language_defualt").each(function (index) {
            this.addEventListener('change', function () {
                var language_id = $(this).attr('languageid');
                var is_defualt = $(this).prop('checked') ? 1 : 0;
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: baseHost + "language/defualt",
                    type: "PUT",
                    data: { language_id: language_id, is_defualt: is_defualt },
                    success: function (data) {
                        toastr.success(data.message);
                        DataTableLanguages.refresh();
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
        refresh: function () {
            $('#datatable-languages').DataTable().ajax.reload();
        }
    }
}();

function languageDelete(language_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: baseHost + "language/delete",
                type: "DELETE",
                data: { language_id: language_id },
                success: function (data) {
                    toastr.success(data.message);
                    DataTableLanguages.refresh();
                },
                error: function (data) {
                    console.log(data);
                    toastr.error(data.responseJSON.message);
                }
            });
        }
    });
}

function languageEdit(language_id) {
    $('#language_edit_modal #language_edit_form #currentPhoto').css('background-image', 'url()');
    $('#language_edit_modal #language_edit_form #currentPhoto2').css('background-image', 'url()');
    $('#language_edit_modal #language_edit_form')[0].reset();
    $('#language_edit_modal #language_edit_form #language_id').val('');

    if (language_id == 0) {
        $('#language_edit_modal').find('.modal-title').text('Create New Language');
        $('#language_edit_modal').modal('show');
    } else {
        $('#language_edit_modal').find('.modal-title').text('Edit Language');
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: baseHost + "language/edit",
            type: "GET",
            data: { language_id: language_id },
            success: function (data) {
                $('#language_edit_modal').modal('show');
                $('#language_edit_modal #language_edit_form #language_id').val(data.id);
                $('#language_edit_modal #language_edit_form #name').val(data.name);
                $('#language_edit_modal #language_edit_form #code').val(data.code);

            },
            error: function (data) {
                console.log(data);
                toastr.error(data.responseJSON.message);
            }
        });

    }


}

// On document ready
KTUtil.onDOMContentLoaded(function () {
    DataTableLanguages.init();
    languageEditAndCreate.init();
});


"use strict";
var languageEditAndCreate = function () {
    var t, e, i;
    return {
        init: function () {
            t = document.querySelector("#language_edit_form");
            e = document.querySelector("#language_edit_form_submit");


            e.addEventListener("click", (function (n) {

                n.preventDefault();
                if (!t.checkValidity()) {
                    t.classList.add('was-validated');
                    toastr.error("Hata tespit edildi. Lütfen bilgilerinizi kontrol ediniz.");
                    return;
                } else {
                    e.setAttribute("data-kt-indicator", "on");
                    e.disabled = !0;


                    var form_data = new FormData();

                    form_data.append('language_id', $('#language_edit_form #language_id').val());
                    form_data.append('name', $('#language_edit_form #name').val());
                    form_data.append('code', $('#language_edit_form #code').val());

                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: baseHost + "language/update",
                        type: 'post',
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (json, textStatus, xhr) {
                            toastr.success(json.message);
                            $('#language_edit_modal').modal('hide');
                            DataTableLanguages.refresh()
                        },
                        error: function (json, textStatus, xhr) {
                            toastr.error(json.responseJSON.message);
                        },
                        complete: function (xhr, textStatus) {
                            e.removeAttribute("data-kt-indicator");
                            e.disabled = !1;
                        }

                    });


                }

            }))
        }

    }
}();
