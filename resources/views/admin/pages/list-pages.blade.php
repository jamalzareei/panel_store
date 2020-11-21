@extends('layouts.master')

@section('head')

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
<style>
    .action-add, .action-filters{display: none;}
    .div-action-btns{transform: translate(0, 64px);}
</style>
@endsection

@section('footer')
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script>
    
    $(".select2").select2({
        dir: "rtl",
        dropdownAutoWidth: true,
        width: '100%'
    });
    
    // On Edit
    $(document).ready(function() {


        $(document).on('click' , '.action-add', function(){
            var this_ = $(this)
            $('.ajaxForm').attr('action', "{{route('admin.page.add')}}")
            $('.ajaxForm #data-phone, .ajaxForm #data-email').attr('disabled', false)
            $('.ajaxForm').reset();
            $(".add-new-data").addClass("show");
            $(".overlay-bg").addClass("show");
        });

        var table = $('.data-list-view').DataTable();
        
        // Event listener to the two range filtering inputs to redraw on input
        $('select.filter').change( function() {
            table.draw();
        } );
        $('.filter').keyup( function() {
            table.draw();
        } );

        $(document).on('click' , '.action-edit', function(e){
            var this_ = $(this)
            e.stopPropagation();
            var key = this_.attr('key');

            $('#data-firstname').val(this_.attr('firstname'));
            $('#data-lastname').val(this_.attr('lastname'));
            $('#data-phone').val(this_.attr('phone'));
            $('#data-email').val(this_.attr('email'));
            $('#data-verify').prop('checked',this_.attr('active'));

            $('.ajaxForm').attr('action', this_.attr('action'))
            $('.ajaxForm #data-phone, .ajaxForm #data-email').attr('disabled', true)
            $('#item_id').val(this_.attr('item_id'))
            
            $(".add-new-data").addClass("show");
            $(".overlay-bg").addClass("show");
        });
        

    } );

    
</script>
@endsection

@section('content')

    <!-- Data list view starts -->
    <section id="data-list-view" class="data-list-view-header">
        <div class="row d-flex div-action-btns" dir="ltr">
        
            <button type="button" class="btn bg-gradient-info mr-1 waves-effect waves-light action-add-new" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="feather icon-plus"></i> افزودن صفحه جدید
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
                <div class="modal-content">
                    <section class="todo-form">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterh5">افزودن صفحه جدید</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="add-branch" class="todo-input ajaxForm" method="POST" action="{{ route('admin.page.add') }}">
                            @csrf
                            <div class="modal-body">
                                <fieldset class="form-group">
                                    <input type="number" dir="rtl" class="new-todo-item-name form-control" name="name" placeholder="موقعیت عددی">
                                    <small class="help-block text-danger error-name"></small>
                                </fieldset>
                            </div>
                            <div class="modal-body">
                                <fieldset class="form-group">
                                    <input type="text" class="new-todo-item-name form-control" name="name" placeholder="نام صفحه">
                                    <small class="help-block text-danger error-name"></small>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <button type="submit" class="btn btn-primary add-todo-item waves-effect waves-light" form="add-branch">
                                        <i class="feather icon-check d-block "></i>
                                        <span class="">افزودن </span>
                                    </button>
                                </fieldset>
                                <fieldset class="form-group position-relative has-icon-left mb-0 d-none d-lg-block">
                                    <button type="button" class="btn btn-outline-light waves-effect waves-light" data-dismiss="modal">
                                        <i class="feather icon-x d-block d-lg-none"></i>
                                        <span class="d-none d-lg-block">بستن</span></button>
                                </fieldset>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.pages.update') }}" method="POST" id="form-datatable">
            @csrf
            <div class="action-btns d-none">
                <div class="btn-dropdown mr-1 mb-1">
                    <div class="btn-group dropdown actions-dropodown">
                        <button type="button" class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            عملیات
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item" name="type" value="active"><i class="feather icon-trash"></i>فعال سازی</button>
                            <button class="dropdown-item" name="type" value="deactive"><i class="feather icon-archive"></i>غیر فعال</button>
                            <button class="dropdown-item" name="type" value="delete"><i class="feather icon-trash"></i>حذف</button>
                            <button class="dropdown-item" name="type" value="update"><i class="feather icon-save"></i>بروزرسانی <small>(موقعیت/فعال)</small></button>
                            <button class="dropdown-item" name="type" value="print"><i class="feather icon-file"></i>پرینت</button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- DataTable starts -->
            <div class="table-responsive">
                <table class="table data-list-view">
                    <thead>
                        <tr>
                            <th></th>
                            <th>موقعیت</th>
                            <th>عنوان</th>
                            <th>کاربر ایجاد کننده</th>
                            <th>وضعیت</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pages as $key => $page)
                            <tr row="{{$page->id}}">
                                <td col="id">{{$page->id}}</td>
                                <td col="order_by" class="" style="width: 10px">
                                    <div class="hidden">{{$page->order_by}}</div>
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="touchspin" value="{{$page->order_by}}" name="order_by[{{$page->id}}]">
                                    </div>
                                    <input type="hidden" name="ids[]" value="{{$page->id}}">
                                </td>
                                <td col="name" class=""><a href="{{ route('admin.page.get', ['slug' => $page->slug]) }}">{{$page->name}}</a></td>
                                <td col="user" class=""><a href="{{ route('admin.page.get', ['slug' => $page->slug]) }}">{{$page->user->full_name ?? ''}}</a></td>
                                <td col="verify">
                                    @if ($page && !$page->actived_at)
                                        <div class="chip chip-danger my-1">
                                            <div class="chip-body">
                                                <div class="avatar bg-rgba-white">
                                                    <i class="fas fa-info"></i>
                                                </div>
                                                <span class="chip-text">غیر فعال</span>
                                            </div>
                                        </div>
                                        <div class="hidden">غیر فعال</div>
                                    @elseif ($page && $page->actived_at && !$page->admin_actived_at)
                                        <div class="chip chip-info my-1">
                                            <div class="chip-body">
                                                <div class="avatar bg-rgba-white">
                                                    <i class="fas fa-info"></i>
                                                </div>
                                                <span class="chip-text">در انتظار تایید</span>
                                            </div>
                                        </div>
                                        <div class="hidden">در انتظار تایید</div>
                                    @elseif ($page && $page->actived_at && $page->admin_actived_at)
                                        <div class="chip chip-success my-1">
                                            <div class="chip-body">
                                                <div class="avatar bg-rgba-white">
                                                    <i class="fas fa-check"></i>
                                                </div>
                                                <span class="chip-text">تایید شده</span>
                                            </div>
                                        </div>
                                        <div class="hidden">تایید شده</div>
                                    @endif
                                    
                                </td>
                                <td col="action" class="td-action form-inline">
                                    <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                        <input type="checkbox" class="custom-control-input" name="actived_at[{{$page->id}}]" id="customSwitchpage{{$page->id}}" {{$page->actived_at ? 'checked' : ''}}  onclick="changeStatus('{{ route('admin.page.update.status', ['id'=> $page->id]) }}',this)">
                                        <label class="custom-control-label" for="customSwitchpage{{$page->id}}">
                                            <span class="switch-text-left">فعال</span>
                                            <span class="switch-text-right">غیر فعال</span>
                                        </label>
                                    </div>
                                
                                    <a class="float-right" href="{{ route('admin.page.get', ['slug' => $page->slug]) }}">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            
                        @endforelse
                        
                    </tbody>
                </table>
            </div>
            <!-- DataTable ends -->
        </form>

    </section>
    <!-- Data list view end -->
{{-- @endif --}}

@endsection