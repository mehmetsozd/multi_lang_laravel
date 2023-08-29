@include('admin.static.header')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Çeviriler</span>
                </h3>
            </div>
            <div class="card-body p-5">
                <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4" id="datatable-translates">
                    <thead>
                    <tr class="text-start text-gray-700 fw-bolder fs-7 text-uppercase">
                        <th class="w-150px">Dil</th>
                        <th class="min-w-10px">#</th>
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
<script src="{{ asset('adminassets/page/translates.js?b') }}"></script>
