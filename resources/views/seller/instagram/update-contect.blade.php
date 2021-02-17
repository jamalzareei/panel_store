@extends('layouts.master')

@section('head')

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
<style>
    .action-add, .action-filters, .dataTables_paginate.paging_simple_numbers{display: none;}
    .div-action-btns{transform: translate(0, 64px);}
    .dt-checkboxes-cell {
        display: none;
    }
    .form-disabled input{

    }
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
        @if (isset($infoUserInstagram))
            
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 profile-card-2">
                <div class="bg-white row">
                    <div class="col-md-6 align-items-center d-flex justify-content-around">
                        <div class="avatar avatar-xl">
                            <img class="img-fluid m-auto" src="{{ $infoUserInstagram['users'][0]['user']['profile_pic_url'] ?? '' }}" alt="img placeholder">
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        
                        <div class="card-header mx-auto pb-0">
                            <div class="row m-0">
                                <div class="col-sm-12 text-center">
                                    <h4>{{ $infoUserInstagram['users'][0]['user']['username'] ?? '' }}</h4>
                                </div>
                                <div class="col-sm-12 text-center">
                                    <p class="">{{ $infoUserInstagram['users'][0]['user']['full_name'] ?? '' }}</p>
                                </div>
                                
                                <div class="col-sm-12 text-center">
                                    <p class="">{{ $posts['count_post'] ?? '0' }} پست اینستاگرام</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if (isset($posts['end_cursor']))
            
        <div class="row">
            <a href="{{ url()->current().'?after='.$posts['end_cursor'] }}" class="btn btn-danger btn-block"> پست های بعد</a>
        </div>
        @endif
        @forelse ($posts as $key => $post)
                @if (isset($post['shortcode']))
                    <form action="{{ route('seller.post.instragram.save') }}" method="post" class="card p-1 ajaxForm">
                        <fieldset  class="row " {{ (in_array($post['shortcode'], $productArrayShortCodes)) ? 'disabled' : '' }}>
                            <div class="col-md-2">
                                <img src="{{ $post['image'] }}" alt="" height="80" width="80">
                                <input type="hidden" name="shortcode" value="{{ $post['shortcode'] }}">
                                <input type="hidden" name="description" value="{{ $post['caption'] }}">

                                <input type="hidden" name="image[]" value="{{ $post['image'] }}">
                                @if (isset($post['edge_sidecar_to_children']))
                                        
                                    @forelse ($post['edge_sidecar_to_children'] as $imageItem)
                                        
                                    <input type="hidden" name="image[]" value="{{ $imageItem }}">
                                    @empty
                                        
                                    @endforelse
                                @endif
                            </div>
                            
                            <div class="col-md-3">
                                <label for="">نام محصول</label>
                                <input type="text" class="form-control" name="name" value="{{ explode("\n",$post['caption'])[0] ?? null }}">
                            </div>
                            <div class="col-md-2">
                                <label for="">قیمت محصول (ريال)</label>
                                <input type="text" class="form-control" name="price" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="">دسته بندی محصول</label>
                                <select name="category" id="" class="select2" >
                                    <option value="">انتخاب پراپرتی های دسته انتخابی</option>
                                    @forelse ($categories as $item)
                                        <option value="{{$item->id}}">
                                            {{$item->name}}
                                                @if ($item->parent && $item->parent->name)
                                                    @if ($item->parent->parent && $item->parent->parent->name)
                                                        @if ($item->parent->parent->parent && $item->parent->parent->parent->name)
                                                            {{ $item->parent->parent->parent->name }} >
                                                        @endif
                                                        {{ $item->parent->parent->name }} >
                                                    @endif
                                                    {{ $item->parent->name }} >
                                                @endif
                                                {{$item->name}}
                                        </option>
                                    @empty
                
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="">فعال شود؟</label>
                                <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                    <input type="checkbox" class="custom-control-input" name="sendadmin" id="customSwitchCategory{{$post['shortcode']}}">
                                    <label class="custom-control-label" for="customSwitchCategory{{$post['shortcode']}}">
                                        <span class="switch-text-left">فعال</span>
                                        <span class="switch-text-right">غیر فعال</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="">&nbsp;</label>
                                @if (in_array($post['shortcode'], $productArrayShortCodes))
                                    <div class="text-danger">ثبت شده</div>
                                @else
                                    
                                <button type="submit" class="btn btn-icon btn-icon btn-primary waves-effect waves-light">
                                    <i class="fas fa-save mx-1"></i> ذخیره
                                </button>
                                @endif

                            </div>
                        </fieldset >
                    </form>
                @endif
                @empty
                    
                @endforelse
        <div class="bottom">
            
        @if (isset($posts['end_cursor']))
        <div class="row">
            <a href="{{ url()->current().'?after='.$posts['end_cursor'] }}" class="btn btn-danger btn-block"> پست های بعد</a>
        </div>
        @endif
        {{-- {{ $posts->appends($_GET)->links() }} --}}
        </div>

    </section>
    <!-- Data list view end -->
@endsection