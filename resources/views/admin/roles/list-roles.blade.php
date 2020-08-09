@extends('layouts.master')

@section('head')

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('footer')
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

<script>
    
    $(".select2").select2({
        dir: "rtl",
        dropdownAutoWidth: true,
        width: '100%'
    });
    $(document).ready(function() {

        $(document).on('click' , '.action-add', function(){
            var this_ = $(this)
            $('.ajaxForm').attr('action', "{{route('admin.role.add')}}")
            $('.ajaxForm #data-slug').attr('disabled', false)
            $(".add-new-data").addClass("show");
            $(".overlay-bg").addClass("show");
        });

        $(document).on('click' , '.action-edit', function(e){
            var this_ = $(this)

            e.stopPropagation();
            $('#data-name').val(this_.attr('name'));
            $('#data-slug').val(this_.attr('slug'));
            $('#data-code').val(this_.attr('code'));
            $('#data-details').val( $('.details-'+this_.attr('item_id')).text() );
            $('#data-active').prop('checked',this_.attr('active'));

            $('.ajaxForm').attr('action', this_.attr('action'))
            $('.ajaxForm #data-slug').attr('disabled', true)
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
        <form action="{{ route('admin.roles.update') }}" method="POST" id="form-datatable">
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
                            <th>عنوان</th>
                            <th>اسلاگ</th>
                            <th>کد</th>
                            <th>فعال / غیر فعال</th>
                            <th>تعداد کاربریان</th>
                            <th>تعداد دسترسی ها</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $key => $role)
                            <tr row="{{$role->id}}">
                                <td>{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td>{{$role->slug}}</td>
                                <td>{{$role->code}}</td>
                                <td>
                                    @if($role->deleted_at)
                                        <div class="chip chip-danger">
                                            <div class="chip-body">
                                                <div class="chip-text">حذف</div>
                                            </div>
                                        </div> 
                                    @elseif ($role->active)
                                        <div class="chip chip-success">
                                            <div class="chip-body">
                                                <div class="chip-text">قعال</div>
                                            </div>
                                        </div>   
                                    @else
                                        <div class="chip chip-warning">
                                            <div class="chip-body">
                                                <div class="chip-text">غیر فعال</div>
                                            </div>
                                        </div>  
                                    @endif
                                </td>
                                <td>{{$role->users_count}}</td>
                                <td>{{$role->permissions_count}}</td>
                                <td class="td-action">
                                    <span class="action-edit" item_id="{{$role->id}}" name="{{$role->name}}" slug="{{$role->slug}}" code="{{$role->code}}" active="{{($role->active) ? true : false}}" action="{{ route('admin.role.update', ['id'=> $role->id]) }}"><i class="feather icon-edit"></i></span>
                                    <span class="action-delete" onclick="deleteRow('{{ route('admin.role.delete', ['id'=>$role->id]) }}', '{{$role->id}}')"><i class="feather icon-trash"></i></span>
                                    <p class="hidden details-{{$role->id}}">{{$role->details}}</p>
                                </td>
                            </tr>
                            {{-- <tr>
                                <td></td>
                                <td colspan="7">
                                    <p class="detail-{{$role->id}}">{{$role->details}}</p>
                                </td>
                            </tr> --}}
                        @empty
                            
                        @endforelse
                        
                    </tbody>
                </table>
            </div>
            <!-- DataTable ends -->
        </form>

        <!-- add new sidebar starts -->
        <form action="" method="post" class="ajaxForm">
            @csrf
            <input type="hidden" name="id" id="item_id" value="">
            <div class="add-new-data-sidebar">
                <div class="overlay-bg"></div>
                <div class="add-new-data">
                    <div class="div mt-2 px-2 d-flex new-data-title justify-content-between">
                        <div>
                            <h4 class="text-uppercase">اضافه / ویرایش نقش</h4>
                        </div>
                        <div class="hide-data-sidebar">
                            <i class="feather icon-x"></i>
                        </div>
                    </div>
                    <div class="data-items pb-3">
                        <div class="data-fields px-2 mt-1">
                            <div class="row">
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-name">نام</label>
                                    <input type="text" class="form-control" name="name" id="data-name">
                                    <small class="help-block text-danger error-name"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-name">اسلاگ</label>
                                    <input type="text" class="form-control" name="slug" id="data-slug">
                                    <small class="help-block text-danger error-slug"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-name">کد</label>
                                    <input type="text" class="form-control" name="code" id="data-code">
                                    <small class="help-block text-danger error-code"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-name">جزئیات</label>
                                    <input type="text" class="form-control" name="details" id="data-details">
                                    <small class="help-block text-danger error-details"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-category"> دسترسی ها </label>
                                    <select class="form-control select2" multiple name="permissions[]" id="data-category">
                                        @forelse ($permissions as $permission)
                                            <option value="{{$permission->id}}">{{$permission->name}}</option>
                                        @empty
                                            
                                        @endforelse
                                    </select>
                                    <small class="help-block text-danger error-roles"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-status">وضعیت </label>
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox"  name="active" value="1" id="data-active">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">فعال</span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="add-data-footer d-flex justify-content-around px-3 mt-2">
                        <div class="add-data-btn">
                            <button class="btn btn-primary">اضافه / ویرایش</button>
                        </div>
                        <div class="cancel-data-btn">
                            <span class="btn btn-outline-danger">کنسل</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- add new sidebar ends -->
    </section>
    <!-- Data list view end -->
@endsection