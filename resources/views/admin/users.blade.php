@include('admin.static.header')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">Users</div>
            </div>
            <div class="card-body p-5">
                <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4" id="datatable-users">
                    <thead>
                    <tr class="text-start text-gray-700 fw-bolder fs-7 text-uppercase">
                        <th class="w-100px">id</th>
                        <th class="min-w-100px">Name</th>
                        <th class="min-w-100px">Email</th>
                        <th class="min-w-100px">Admin</th>
                        <th class="min-w-100px">Created at</th>
                    </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600 fs-7">
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@include('admin.static.footer')
<script src="{{ asset('adminassets/page/users.js') }}"></script>
