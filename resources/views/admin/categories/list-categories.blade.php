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
        width: '100%',
        placeholder: 'وبسایت انتخاب نمایید'
    });
    
    // On Edit
    $(document).ready(function() {


        $(document).on('click' , '.action-add', function(){
            var this_ = $(this)
            $('.ajaxForm').attr('action', "{{route('admin.category.add')}}")
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

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {

            var title = $( 'select[name="title"] option:checked' ).val();
            var blocked = $( 'select[name="blocked"] option:checked' ).val();
            var status = $( 'select[name="status"] option:checked' ).val();
            var title = $( 'input[name="title"]' ).val();
            var slug = $( 'input[name="slug"]' ).val();
            var link = $( 'input[name="link"]' ).val();

            if( !data[5].includes(status) ){
                return false;
            }

            if(title && !data[2].includes(title) ){
                return false;
            }

            if(slug && !data[3].includes(slug) ){
                return false;
            }

            if(link && !data[4].includes(link) ){
                return false;
            }

            return true
        }
    );
</script>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">فیلتر </h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                    <li><a data-action=""><i class="feather icon-rotate-cw categories-data-filter"></i></a></li>
                    <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="categories-list-filter">
                    <form>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="categories-list-department">عنوان</label>
                                <fieldset class="form-group">
                                    <input type="text" name="title" value="" class="form-control filter" dir="ltr" placeholder="عنوان">
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="categories-list-department">اسلاگ</label>
                                <fieldset class="form-group">
                                    <input type="text" name="slug" value="" class="form-control filter" dir="ltr" placeholder="اسلاگ">
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="categories-list-department">لینک</label>
                                <fieldset class="form-group">
                                    <input type="text" name="link" value="" class="form-control filter" dir="ltr" placeholder="لینک">
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="categories-list-status">وضعیت</label>
                                <fieldset class="form-group">
                                    <select class="form-control filter" name="status" id="categories-list-status">
                                        <option value="">همه</option>
                                        <option value="فعال شده">فعال شده</option>
                                        <option value="غیر فعال شده">غیر فعال شده</option>
                                        <option value="حذف شده">حذف شده</option>
                                    </select>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Data list view starts -->
    <section id="data-list-view" class="data-list-view-header">
        <div class="row d-flex div-action-btns" dir="ltr">
            
            <button type="button" class="btn bg-gradient-info mr-1 waves-effect waves-light action-add-new" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="feather icon-plus"></i> افزودن دسته بندی جدید
            </button>
        </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
                    <div class="modal-content">
                        <section class="todo-form">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenter">افزودن دسته بندی جدید</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form id="add-category" class="todo-input ajaxForm" method="POST" action="{{ route('admin.category.add') }}">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{$parent_id}}">
                                <div class="modal-body">
                                    <fieldset class="form-group">
                                        <label for="categories-list-websites">وبسایت متصل</label>
                                        <select class="form-control filter select2" data-placeholder="انتخاب نمایید" name="websites[]" multiple id="categories-list-websites">
                                            {{-- <option value="">انتخاب نمایید</option> --}}
                                            @forelse ($websites as $website)
                                                <option value="{{$website->id}}">{{$website->name}} ({{$website->url}})</option>
                                            @empty
                                                
                                            @endforelse
                                        </select>
                                        <small class="help-block text-danger error-websites"></small>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <input type="text" class="new-todo-item-title form-control" name="name" placeholder="عنوان">
                                        <small class="help-block text-danger error-name"></small>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <textarea class="new-todo-item-desc form-control" rows="3" name="description_full" placeholder="توضیحات"></textarea>
                                        <small class="help-block text-danger error-description_full"></small>
                                    </fieldset>
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox" name="actived_at" checked value="1">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">فعال</span>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox" name="show_menu" checked value="1">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">نمایش در منو</span>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                        <button type="submit" class="btn btn-primary add-todo-item waves-effect waves-light" form="add-category">
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
        <form action="{{ route('admin.categories.update') }}" method="POST" id="form-datatable">
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
                            <th>نام</th>
                            <th>اسلاگ</th>
                            <th>لینک</th>
                            <th>پراپرتی ها</th>
                            <th>وضعیت</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $key => $category)
                            <tr row="{{$category->id}}">
                                <td col="id">{{$category->id}}</td>
                                <td col="order_by" class="" style="width: 10px">
                                    <div class="hidden">{{$category->order_by}}</div>
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="touchspin" value="{{$category->order_by}}" name="order_by[{{$category->id}}]">
                                    </div>
                                    <input type="hidden" name="ids[]" value="{{$category->id}}">
                                </td>
                                <td col="name" class=""><a href="{{ route('admin.categories.list', ['parent_id'=>$category->id]) }}">{{$category->name}}</a></td>
                                <td col="slug" class=""><a href="{{ route('admin.categories.list', ['parent_id'=>$category->id]) }}">{{$category->slug}}</a></td>
                                <td col="link"> 
                                    <a href="{{($category->link) ? $category->link : 'category/'.$category->slug}}">لینک</a> 
                                    <span class="hidden">{{$category->link}}</span> 
                                </td>
                                <td col="link"> 
                                    <span class="badge badge-glow">{{$category->properties_count}}</span> 
                                    @if ($category->properties_active)
                                        <a href="{{ route('admin.properties.list', ['category_id'=>$category->id]) }}">
                                            پراپرتی ها
                                        </a>
                                    @endif
                                </td>
                                <td col="verify">
                                    @if($category->deleted_at)
                                    <div class="chip chip-warning">
                                        <div class="chip-body">
                                            <div class="chip-text">حذف شده</div>
                                        </div>
                                    </div>
                                    @elseif ($category->actived_at)
                                        <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                        <input type="checkbox" class="custom-control-input" name="actived_at[{{$category->id}}]" id="customSwitch{{$category->id}}" checked onclick="changeStatus('{{ route('admin.category.update.status', ['id'=> $category->id]) }}',this)">
                                            <label class="custom-control-label" for="customSwitch{{$category->id}}">
                                                <span class="switch-text-left">فعال</span>
                                                <span class="switch-text-right">غیر فعال</span>
                                            </label>
                                        </div>
                                        <div class="hidden">فعال شده</div>
                                    @else
                                        <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                            <input type="checkbox" class="custom-control-input" name="actived_at[{{$category->id}}]" id="customSwitch{{$category->id}}" onclick="changeStatus('{{ route('admin.category.update.status', ['id'=> $category->id]) }}',this)">
                                            <label class="custom-control-label" for="customSwitch{{$category->id}}">
                                                <span class="switch-text-left">فعال</span>
                                                <span class="switch-text-right">غیر فعال</span>
                                            </label>
                                        </div>
                                        <div class="hidden">غیر فعال شده</div>
                                    @endif
                                    
                                </td>
                                <td col="action" class="td-action">
                                    <a href="{{ route('admin.category.edit', ['slug'=>$category->slug]) }}">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <span class="action-delete" onclick="deleteRow('{{ route('admin.category.delete', ['id'=>$category->id]) }}', '{{$category->id}}')"><i class="feather icon-trash"></i></span>
                                
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
@endsection