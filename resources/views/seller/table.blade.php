@extends('layouts.master')

@section('head')

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
<style>
    .action-add, .action-filters, .dataTables_paginate.paging_simple_numbers{display: none;}
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



        var table = $('.data-list-view').DataTable();
        
        // Event listener to the two range filtering inputs to redraw on input
        $('select.filter').change( function() {
            table.draw();
        } );
        $('.filter').keyup( function() {
            table.draw();
        } );


    } );

    
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
                    <form method="GET" action="">
                        <div class="row">
                            <div class="col-12 col-sm-4 col-lg-4 form-group">
                                <label for="categories-list-department">نام محصول</label>
                                <fieldset class="form-group">
                                    <input type="text" name="name" value="" class="form-control filter" placeholder="نام محصول">
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-4 col-lg-4 form-group">
                                <label for="categories-list-department">کد محصول</label>
                                <fieldset class="form-group">
                                    <input type="text" name="code" value="" class="form-control filter" placeholder="کد محصول">
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-3 col-lg-3 form-group">
                                <label for="categories-list-status">وضعیت</label>
                                <fieldset class="form-group">
                                    <select class="form-control filter" name="status" id="categories-list-status">
                                        <option value="">همه</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-1 col-lg-1 form-group">
                                <label for="categories-list-status">&nbsp;</label>
                                <fieldset class="form-group">
                                    <button type="submit" class="btn btn-icon rounded-circle btn-outline-primary mr-1 mb-1 waves-effect waves-light"><i class="feather icon-search"></i></button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Data list view starts -->
    <section id="data-list-view-" class="data-list-view-header">
            
        <form action="{{ route('seller.products.update') }}" method="POST" id="form-datatable">
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
                            {{-- <button class="dropdown-item" name="type" value="delete"><i class="feather icon-trash"></i>حذف</button> --}}
                            {{-- <button class="dropdown-item" name="type" value="update"><i class="feather icon-save"></i>بروزرسانی <small>(موقعیت/فعال)</small></button> --}}
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
                            <th>کد محصول</th>
                            <th>نام</th>
                            <th>قیمت</th>
                            <th>وضعیت</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        
                    </tbody>
                </table>
            </div>
            <!-- DataTable ends -->
        </form>
        <div class="bottom">
            
        </div>

    </section>
    <!-- Data list view end -->
@endsection