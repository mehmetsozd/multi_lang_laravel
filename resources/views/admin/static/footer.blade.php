</div>
</div>
</div>
</div>
</div>
</div>



<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <span class="svg-icon">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
			<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
			<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
		</svg>
	</span>
</div>


<div class="modal fade" tabindex="-1" id="service_edit_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Modal title</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                    </svg></span>
                </div>
            </div>

            <div class="modal-body">
                <form id="service_edit_form">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="image-input image-input-outline fv-row" data-kt-image-input="true">
                                <div class="image-input-wrapper w-125px h-125px" id="currentPhoto"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change Picture">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="photo" id="photo" accept=".png, .jpg, .jpeg"/>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="image-input image-input-outline fv-row" data-kt-image-input="true">
                                <div class="image-input-wrapper w-125px h-125px" id="currentPhoto2"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change Picture">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="photo2" id="photo2" accept=".png, .jpg, .jpeg"/>
                                </label>
                                900x150
                            </div>
                        </div>

                    </div>


                    <input type="hidden" name="service_id" id="service_id" value="">
                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 mt-5 fs-6" >
                        @php($active = 'active')
                        @foreach(Config::get('app.app_langs') as $lang)
                        <li class="nav-item">
                            <a class="nav-link {{ $active }}" data-bs-toggle="tab" href="#kt_tab_pane_service_{{$lang}}">{{ strtoupper($lang) }}</a>
                        </li>
                        @php($active = '')
                        @endforeach
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        @php($active = 'active')
                        @foreach(Config::get('app.app_langs') as $lang)
                        <div class="tab-pane fade show {{ $active }}" id="kt_tab_pane_service_{{ $lang }}" role="tabpanel">
                            <div class="fv-row mb-10">
                                <label for="name_{{ $lang }}" class="required form-label">Name {{strtoupper($lang)}}</label>
                                <input name="name_{{ $lang }}" id="name_{{ $lang }}" class="form-control form-control-solid">
                            </div>
                            <div class="fv-row mb-10">
                                <label for="description_{{ $lang }}" class="required form-label">Description {{strtoupper($lang)}}</label>
                                <textarea name="description_{{ $lang }}" id="description_{{ $lang }}" class="form-control form-control-solid min-h-100px"></textarea>
                            </div>
                        </div>
                        @php($active = '')
                        @endforeach
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <div class="text-center">
                    <button type="submit" id="service_edit_form_submit" class="btn btn-lg btn-primary w-100">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="translate_edit_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Modal title</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
    </svg></span>
                </div>
            </div>

            <div class="modal-body">
                <form id="translate_edit_form">
                    <div class="hover-scroll-overlay-y pe-6 me-n6" style="height: 415px">
                    <div class="row">
                        <input type="hidden" name="translate_id" id="translate_id" value="">
                        @if(@$defualtTranslates)
                            <script>
                                var defualtTranslates = '@json($defualtTranslates)';

                            </script>
                            @foreach($defualtTranslates as $defualtTranslateKey => $defualtTranslateValue)
                                @if(!is_array($defualtTranslateValue))
                                    <div class="col-md-6 mb-5">
                                        <label for="translate[{{$defualtTranslateKey}}]" class="required form-label">{{ $defualtTranslateValue }}</label>
                                        <input name="translate[{{$defualtTranslateKey}}]" id="translate_{{$defualtTranslateKey}}" class="form-control form-control-solid">
                                    </div>
                                @else
                                    @foreach($defualtTranslateValue as $defualtTranslateValueKey=> $defualtTranslateValueValue)
                                        @if(!is_array($defualtTranslateValueValue))
                                        <div class="col-md-6 mb-5">
                                            <label for="translate[{{$defualtTranslateKey}}][{{$defualtTranslateValueKey}}]" class="required form-label">{{$defualtTranslateKey}} {{ $defualtTranslateValueValue }}</label>
                                            <input name="translate[{{$defualtTranslateKey}}][{{$defualtTranslateValueKey}}]" id="translate_{{$defualtTranslateKey}}_{{$defualtTranslateValueKey}}" class="form-control form-control-solid">
                                        </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endif


                    </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <div class="text-center">
                    <button type="submit" id="translate_edit_form_submit" class="btn btn-lg btn-primary w-100">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="language_edit_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Modal title</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
    </svg></span>
                </div>
            </div>

            <div class="modal-body">
                <form id="language_edit_form">
                    <div class="row">
                        <input type="hidden" name="language_id" id="language_id" value="">
                        <div class="col-md-6">
                            <div class="fv-row mb-10">
                                <label for="code" class="required form-label">Code (Küçük harf)</label>
                                <input name="code" id="code" class="form-control form-control-solid">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fv-row mb-10">
                                <label for="name" class="required form-label">Name</label>
                                <input name="name" id="name" class="form-control form-control-solid">
                            </div>
                        </div>

                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <div class="text-center">
                    <button type="submit" id="language_edit_form_submit" class="btn btn-lg btn-primary w-100">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var baseHost = '/admin/';

</script>


<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('adminassets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('adminassets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('adminassets/plugins/custom/typedjs/typedjs.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->

<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset('adminassets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('adminassets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('adminassets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('adminassets/js/custom/utilities/modals/users-search.js') }}"></script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->



<link href="{{ asset('adminassets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('adminassets/plugins/custom/datatables/datatables.bundle.js') }}"></script>


<script src="{{ asset('adminassets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
<script src="{{ asset('adminassets/plugins/custom/jstree/jstree.bundle.js') }}"></script>


<!-- <script src="{{ asset('adminassets/plugins/custom/ckeditor/ckeditor-inline.bundle.js') }}"></script>
<script src="{{ asset('adminassets/plugins/custom/ckeditor/ckeditor-balloon.bundle.js') }}"></script>
<script src="{{ asset('adminassets/plugins/custom/ckeditor/ckeditor-balloon-block.bundle.js') }}"></script>
<script src="{{ asset('adminassets/plugins/custom/ckeditor/ckeditor-document.bundle.js') }}"></script> -->


<script>
    var defultLang = '{{ env('APP_DEFUALT_LANG') }}';
    var langs = '{{ env('APP_LANG') }}'.split(",");
</script>
<style>
    .ck-editor__editable_inline {
        max-height: 400px;
    }
</style>
</body>
</html>
