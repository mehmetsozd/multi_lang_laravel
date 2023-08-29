"use strict";
var DataTableTranslates = function () {
    var table;
    var dt;

    var initTable = function () {
        var Cl = [
            { data: 'code', name: 'code' },
            { data: null, orderable: false },
        ];
        dt = $('#datatable-translates').DataTable({
            searchDelay: 1000,
            processing: true,
            serverSide: true,
            ajax: {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: baseHost + "translate/list",
                type: "POST"
            },
            order: [[0, 'desc']],
            columns: Cl,
            columnDefs: [
                {
                    targets: 1, orderable: false,
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
                                        <a href="javascript:translateEdit('`+ row.id + `')" class="menu-link px-3">Edit</a>
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
        });
    }
    return {
        init: function () {
            initTable();
            KTMenu.createInstances();
        },
        refresh: function () {
            $('#datatable-translates').DataTable().ajax.reload();
        }
    }
}();
function translateEdit(translate_id) {
    $('#translate_edit_modal').find('.modal-title').text('Edit Translate');
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: baseHost + "translate/edit",
        type: "GET",
        data: { translate_id: translate_id },
        success: function (data) {
            $('#translate_edit_modal').modal('show');
            $('#translate_edit_modal #translate_edit_form #translate_id').val(data.id);
            $.each(JSON.parse(defualtTranslates), function (key, value) {
                if(jQuery.isPlainObject(value)){
                    $.each(value, function (key2, value2) {
                        $('#translate_edit_form #translate_'+key+'_'+key2).val(data.translate[key][key2]);
                    });
                }else{
                    $('#translate_edit_form #translate_'+key).val(data.translate[key]);
                }
            });
        },
        error: function (data) {
            console.log(data);
            toastr.error(data.responseJSON.message);
        }
    });
}

// On document ready
KTUtil.onDOMContentLoaded(function () {
    DataTableTranslates.init();
    translateEditAndCreate.init();
});


"use strict";
var translateEditAndCreate = function () {
    var t, e, i,f;
    return {
        init: function () {
            t = document.querySelector("#translate_edit_modal");
            e = document.querySelector("#translate_edit_form_submit");
            f = document.querySelector("#translate_edit_form");


            e.addEventListener("click", (function (n) {

                n.preventDefault();
                if(!f.checkValidity()){
                    f.classList.add('was-validated');
                    toastr.error("Hata tespit edildi. Lütfen bilgilerinizi kontrol ediniz.");
                    return;
                }else {
                    e.setAttribute("data-kt-indicator", "on");
                    e.disabled = !0;


                    let form_data = new FormData();
                    $.each(JSON.parse(defualtTranslates), function (key, value) {
                        if(jQuery.isPlainObject(value)){
                            $.each(value, function (key2, value2) {
                                form_data.append('translate['+key+']['+key2+']', $('#translate_edit_form #translate_'+key+'_'+key2).val());
                            });
                        }else{
                            form_data.append('translate['+key+']', $('#translate_edit_form #translate_'+key).val());
                        }
                    });
                    form_data.append('translate_id', $('#translate_edit_form #translate_id').val());

                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: baseHost + "translate/update",
                        type: 'post',
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (json, textStatus, xhr) {
                            toastr.success(json.message);
                            $('#translate_edit_modal').modal('hide');
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
function objLength(obj){
    var i=0;
    for (var x in obj){
        if(obj.hasOwnProperty(x)){
            i++;
        }
    }
    return i;
}
