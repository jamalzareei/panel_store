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
            $('#data-social').val(this_.attr('social'));
            $('#data-details').val(this_.attr('details'));

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

<div class="row">
    <div class="alert alert-info">
        برای جستجوی اطلاعات اینستاگرام از لینک زیر استفاتده نمایید
        <a href="https://www.instagram.com/web/search/topsearch/?query=shixehcom" target="_blank">
        https://www.instagram.com/web/search/topsearch/?query=shixehcom
        </a>
    </div>
</div>
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
                            <th>فروشنده</th>
                            <th>نوع</th>
                            <th>نام کاربری</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($socials as $key => $social)
                            <tr row="{{$social->id}}">
                                <td>{{$social->id}}</td>
                                <td><a href="{{ route('admin.seller.show', ['slug'=>$social->seller->slug]) }}" target="_blank">{{ $social->seller->name }}</a></td>
                                <td>{!! $social->social->icon !!} {{$social->social->name}}</td>
                                <td dir="ltr"> <a href="https://www.instagram.com/web/search/topsearch/?query={{ $social->username }}" target="_blank">{{'@'.$social->username}}</a> </td>
                            
                                <td class="td-action">
                                    <span class="action-edit" item_id="{{$social->id}}" name="{{$social->seller->name}}" social="{{$social->social->name}}" details="{{$social->details}}" action="{{ route('admin.social.seller.update', ['id'=> $social->id]) }}"><i class="feather icon-edit"></i></span>
                                    <p class="hidden details-{{$social->id}}">{{$social->details}}</p>
                                </td>
                            </tr>
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
                            <h4 class="text-uppercase">ویرایش جزئیات</h4>
                        </div>
                        <div class="hide-data-sidebar">
                            <i class="feather icon-x"></i>
                        </div>
                    </div>
                    <div class="data-items pb-3">
                        <div class="data-fields px-2 mt-1">
                            <div class="row">
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-name">نام فروشنده</label>
                                    <input type="text" class="form-control" name="name" id="data-name" disabled>
                                    <small class="help-block text-danger error-name"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-social">نام کاربری</label>
                                    <input type="text" class="form-control" name="social" id="data-social" disabled>
                                    <small class="help-block text-danger error-social"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-details">جزئیات</label>
                                    <input type="text" class="form-control" name="details" id="data-details">
                                    <small class="help-block text-danger error-details"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="add-data-footer d-flex justify-content-around px-3 mt-2">
                        <div class="add-data-btn">
                            <button class="btn btn-primary"> ویرایش</button>
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