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

    <!-- Data list view starts -->
    <section id="data-list-view-" class="data-list-view-header">
        <form action="" method="POST" id="form-datatable">
            @csrf
            <!-- DataTable starts -->
            <div class="table-responsive">
                <table class="table data-list-view">
                    <thead>
                        <tr>
                            <th></th>
                            <th>عکس محصول</th>
                            <th>نام</th>
                            <th>قیمت</th>
                            <th>دسته بندی</th>
                            <th>ارسال مدیریت</th>
                            <th>ثبت محصول</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $key => $post)
                        <form action="" method="shortcode-{{ $post['shortcode'] }}">
                            <tr row="{{$post['shortcode']}}">
                                <td col="id"> <input type="checkbox" class="form-control" name="category" value="{{$post['shortcode']}}"> </td>
                                <td col="code" class="">
                                    <img src="{{ $post['image'] }}" alt="" height="80" width="80">
                                    <input type="hidden" name="description" value="{{ $post['caption'] }}">

                                    <input type="hidden" name="image[]" value="{{ $post['image'] }}">
                                    @if (isset($post['edge_sidecar_to_children']))
                                            
                                        @forelse ($post['edge_sidecar_to_children'] as $imageItem)
                                            
                                        <input type="hidden" name="image[]" value="{{ $imageItem }}">
                                        @empty
                                            
                                        @endforelse
                                    @endif
                                </td>
                                <td col="name" class="">
                                    <input type="text" class="form-control" name="name" value="{{ substr($post['caption'], 0, 100) }}">
                                </td>
                                <td col="price" class="">
                                    <input type="text" class="form-control" name="price" value="">
                                </td>
                                <td col="verify">
                                    <input type="text" class="form-control" name="category" value="">
                                </td>
                                <td col="verify">
                                    <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                        <input type="checkbox" class="custom-control-input" name="sendadmin" id="customSwitchCategory{{$post['shortcode']}}">
                                        <label class="custom-control-label" for="customSwitchCategory{{$post['shortcode']}}">
                                            <span class="switch-text-left">فعال</span>
                                            <span class="switch-text-right">غیر فعال</span>
                                        </label>
                                    </div>
                                </td>
                                <td col="action" class="td-action form-inline">
                                
                                    <button type="submit" class="btn btn-icon btn-icon rounded-circle btn-primary mr-1 mb-1 waves-effect waves-light"><i class="fas fa-save"></i></button>

                                </td>
                            </tr>
                        </form>
                        @empty
                            
                        @endforelse
                        
                    </tbody>
                </table>
            </div>
            <!-- DataTable ends -->
        </form>
        <div class="bottom">
            
        {{-- {{ $posts->appends($_GET)->links() }} --}}
        </div>

    </section>
    <!-- Data list view end -->
@endsection