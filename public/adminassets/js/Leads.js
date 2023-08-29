"use strict";
var DataTableLeads = function () {
    var table;
    var dt;
    var statusName= ['Waiting Lead','Phoned Lea','Not Answering Lead','Call Again Lead','Wrong number Lead'];

    var initTable = function () {
        if(LeadStatus != 3){
            var Cl = [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'investment', name: 'investment'},
                {data: 'status', name: 'status'},
                {data: null, orderable: false, searchable: false},
                {data: 'created_at', name: 'created_at'},
                {data: null, orderable: false, searchable: false}
            ];
            var statusTarget = 5;
            var mailTarget = 6;
            var actionTarget = 8;
        }else{
            var Cl = [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'investment', name: 'investment'},
                {data: 'next_call', name: 'next_call'},
                {data: 'status', name: 'status'},
                {data: null, orderable: false, searchable: false},
                {data: 'created_at', name: 'created_at'},
                {data: null, orderable: false, searchable: false}
            ];
            var statusTarget = 6;
            var mailTarget = 7;
            var actionTarget = 9;
        }
        dt = $('#datatable-leads').DataTable({
            searchDelay: 1000,
            processing: true,
            serverSide: true,
            ajax: {
                url: baseHost + "Leads/"+LeadStatus+"/List",
                type: "POST"
            },
            order: [[0, 'desc']],
            columns: Cl,
            columnDefs: [
                {
                    targets: mailTarget,orderable: false,
                    render: function (data, type, row) {
                        var mailData  = '<table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">';
                        mailData +=`<tr><td>Send</td><td>`;
                        if(row.send_mail){
                            mailData +=`<span class="badge badge-light-success fs-8">`+row.send_mail+`</span>`;
                        }else{
                            mailData +=`<span class="badge badge-light-danger fs-8"> - </span>`;
                        }
                        mailData +=`</td></tr>`;

                        mailData +=`<tr><td>Url 1</td><td>`;
                        if(row.url1){
                            mailData +=`<span class="badge badge-light-success fs-8">`+row.url1+`</span>`;
                        }else{
                            mailData +=`<span class="badge badge-light-danger fs-8"> - </span>`;
                        }
                        mailData +=`</td></tr>`;

                        mailData +=`<tr><td>Url 2</td><td>`;
                        if(row.url2){
                            mailData +=`<span class="badge badge-light-success fs-8">`+row.url2+`</span>`;
                        }else{
                            mailData +=`<span class="badge badge-light-danger fs-8"> - </span>`;
                        }
                        mailData +=`</td></tr><table>`;

                        return mailData;
                    }
                },

                {
                    targets: statusTarget,orderable: false,
                    render: function (data, type, row) {
                        var selectBox = `<select class="form-control form-control-sm form-control-solid" onchange="leadStatusUpdate(this.value,'`+row.id+`')" id="statusSelect`+row.id+`">
                            <option value="" >Select</option>
                            <option value="0">Waiting Lead</option>
                            <option value="1">Phoned Lead</option>
                            <option value="2">Not Answering Lead</option>
                            <option value="3">Call Again Lead</option>
                            <option value="4">Wrong number Lead</option>
                        </select>
                        `
                        return selectBox;
                    }
                },
                {targets: actionTarget,orderable: false,
                    render: function (data, type, row) {
                        var a = `<div class="d-flex justify-content-end flex-shrink-0">
                    <a href="javascript:leadNote('`+row.id+`','`+row.name+`');" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"> 
                        <span class="svg-icon svg-icon-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z" fill="currentColor"></path>
                                <path opacity="0.3" d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z" fill="currentColor"></path>
                            </svg>
                        </span> 
                   </a>`
                        if(is_a == 1){
                            a +=`<a href="javascript:leadDelete('`+row.id+`','`+row.name+`','`+row.email+`','`+row.phone+`');" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"> 
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
                            </svg>
                        </span> 
                   </a>`
                        }
                        a +=`</div>`;
                        return a;
                    }
                }
            ]
        });
        table = dt.$;
        dt.on('draw', function () {
            KTMenu.createInstances();
        });
    }
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }
    return {
        init: function () {
            initTable();
            handleSearchDatatable();
            KTMenu.createInstances();
        },
        refresh: function (){
            $('#datatable-leads').DataTable().ajax.reload();
        }
    }
}();
DataTableLeads.init();

function leadStatusUpdate(status,leadID){
    if(status == ""){
        toastr.warning("Please select status");
    }else {
        var newDateInput = '';
        if (status == 3) {
            newDateInput = '<br><label style="width: 100%;text-align: left;">New Call Date<input id="swal-next-call" type="datetime-local" class="form-control form-control-sm"></label>';
        }


        Swal.fire({
            title: 'Do you want to continue processing?',
            html:
                '<textarea id="swal-note" placeholder="Add note" class="form-control form-control-sm"></textarea>' + newDateInput,
            icon: "question",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "Continue",
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: 'btn btn-danger'
            },
            preConfirm: function () {
                return new Promise(function (resolve) {
                    if (status == 3 && $('#swal-next-call').val() == '') {
                        swal.showValidationMessage("Please select date"); // Show error when validation fails.
                        swal.enableButtons(); // Enable the confirm button again.
                    } else {
                        swal.resetValidationMessage(); // Reset the validation message.
                        resolve([
                            $('#swal-note').val(),
                            $('#swal-next-call').val()
                        ]);
                    }
                })
            },
            didOpen: function () {
                $('#swal-note').focus();
                var myDate = new Date();

                let dateInput = document.getElementById("swal-next-call");
                dateInput.min = myDate.getFullYear() + '-' + ('0' + (myDate.getMonth() + 1)).slice(-2) + '-' + ('0' + myDate.getDate()).slice(-2) + 'T' + myDate.getHours() + ':' + ('0' + (myDate.getMinutes())).slice(-2);
            }
        }).then((result) => {

            if (result.isConfirmed) {
                if (result.value[1]) {
                    result.value[1] = moment(new Date(result.value[1])).format('YYYY-MM-DD HH:mm:ss');
                }
                $.ajax({
                    url: baseHost + "Lead/StatusUpdate",
                    type: 'post',
                    data: {leadID: leadID, status: status, note: result.value[0], nextCall: result.value[1]},
                    dataType: 'json',
                    success: function (json) {
                        if (json['status'] === 'Success') {
                            toastr.success(json['text']);
                            DataTableLeads.refresh();
                        } else {
                            toastr.error(json['text']);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error("An error occurred, try again later.");
                    }
                });

            } else {
                $('#statusSelect'+leadID).prop('selectedIndex',0);
                toastr.error("It is cancelled");
            }
        })
    }
}

function leadNote(leadID,userName){
    $('#leadNoteForm').trigger("reset");
    $('#leadNoteForm input[name="leadID"]').val(leadID);
    $('#leadNoteLists').html('');
    var notes = ``;

    $.ajax({
        url: baseHost + "Lead/Notes",
        type: 'post',
        data: {leadID:leadID},
        dataType: 'json',
        success: function (json) {
            if(json['status'] === 'Success'){
                json['data'].forEach(function(data, index) {
                    notes +=`<div class="d-flex justify-content-end mb-10">
                    <div class="d-flex flex-column align-items-end">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-3">
                                <span class="text-muted fs-7 mb-1">`+data.created_at+`</span>
                                <a  class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">User_`+data.userID+`</a>
                            </div>
                        </div>
                        <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text">`+data.note+`</div>
                    </div>
                </div>`;
                });
                $('#noteListUserInfo').html(userName);
                $('#leadNoteLists').html(notes);
                

                var scrollElement = document.querySelector("#leadNoteLists");
                var scroll = KTScroll.getInstance(scrollElement);

                var drawerElement = document.querySelector("#kt_drawer_chat");
                var drawer = KTDrawer.getInstance(drawerElement);
                drawer.toggle();

            }else{
                toastr.error(json['text']);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.error("An error occurred, try again later.");
        }
    });
}
function leadNoteNewSend(){

    var notes = ``;
    $.ajax({
        url: baseHost + "Lead/AddNote",
        type: 'post',
        data: $('#leadNoteForm').serialize(),
        dataType: 'json',
        success: function (json) {
            if(json['status'] === 'Success'){
                $('#leadNoteForm').trigger("reset");
                $('#leadNoteLists').html('');
                json['data'].forEach(function(data, index) {
                    notes +=`<div class="d-flex justify-content-end mb-10">
                    <div class="d-flex flex-column align-items-end">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-3">
                                <span class="text-muted fs-7 mb-1">`+data.created_at+`</span>
                                <a  class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">User_`+data.userID+`</a>
                            </div>
                        </div>
                        <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text">`+data.note+`</div>
                    </div>
                </div>`;
                });
                $('#leadNoteLists').html(notes);
            }else{
                toastr.error(json['text']);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.error("An error occurred, try again later.");
        }
    });
}
function leadDelete(leadID,leadName,leadEmail,leadPhone){
    Swal.fire({
        html: `Are you sure you want to delete the lead?<br><span class="badge badge-danger">${leadName}</span> <span class="badge badge-danger">${leadEmail}</span> <span class="badge badge-danger">${leadPhone}</span>`,
        icon: "question",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "Delete",
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: 'btn btn-danger'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: baseHost + "Lead/Delete",
                type: 'post',
                data: {leadID:leadID},
                dataType: 'json',
                success: function (json) {
                    if(json['status'] === 'Success'){
                        toastr.success(json['text']);
                        $('#datatable-leads').DataTable().ajax.reload();
                    }else{
                        toastr.error(json['text']);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error("An error occurred, try again later.");
                }
            });
        } else {
            toastr.error("It has been canceled.");
        }
    })
}