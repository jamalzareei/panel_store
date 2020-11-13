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

    
</script>
@endsection

@section('content')

    <!-- Data list view starts -->
    <section id="data-list-view" class="data-list-view-header">
        <form action="{{ route('seller.branches.update') }}" method="POST" id="form-datatable">
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
                            <th>نام فروشگاه</th>
                            <th>مدیریت</th>
                            <th>شماره تماس</th>
                            <th>شهر</th>
                            <th>وضعیت</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sellers as $key => $seller)
                            <tr row="{{$seller->id}}">
                                <td col="id">{{$seller->id}}</td>
                                <td col="title" class=""><a href="{{ route('admin.seller.show', ['slug'=>$seller->slug]) }}">{{$seller->name}}</a></td>
                                <td col="manager" class=""><a href="{{ route('admin.seller.show', ['slug'=>$seller->slug]) }}">{{$seller->manager}}</a></td>
                                <td col="phone" class=""><a href="{{ route('admin.seller.show', ['slug'=>$seller->slug]) }}">{{$seller->user->phone ?? ''}}</a></td>
                                <td col="city" class=""><a href="{{ route('admin.seller.show', ['slug'=>$seller->slug]) }}">{{$seller->city->name ?? ''}}</a></td>
                                <td col="verify">
                                    @if($seller->deleted_at)
                                        <div class="chip chip-warning">
                                            <div class="chip-body">
                                                <div class="chip-text">حذف شده</div>
                                            </div>
                                        </div>
                                    @elseif (!$seller->actived_at && !$seller->admin_actived_id)
                                        <div class="chip chip-warning">
                                            <div class="chip-body">
                                                <div class="chip-text">در حال تکمیل اطلاعات</div>
                                            </div>
                                        </div>
                                    @elseif ($seller->actived_at && $seller->admin_actived_id)
                                        <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                        <input type="checkbox" class="custom-control-input" name="actived_at[{{$seller->id}}]" id="customSwitch{{$seller->id}}" checked onclick="changeStatus('{{ route('admin.seller.update.status', ['id'=> $seller->id]) }}',this)">
                                            <label class="custom-control-label" for="customSwitch{{$seller->id}}">
                                                <span class="switch-text-left">فعال</span>
                                                <span class="switch-text-right">غیر فعال</span>
                                            </label>
                                        </div>
                                        <div class="hidden">فعال شده</div>
                                    @elseif ($seller->actived_at && !$seller->admin_actived_id)
                                        <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                        <input type="checkbox" class="custom-control-input" name="actived_at[{{$seller->id}}]" id="customSwitch{{$seller->id}}" onclick="changeStatus('{{ route('admin.seller.update.status', ['id'=> $seller->id]) }}',this)">
                                            <label class="custom-control-label" for="customSwitch{{$seller->id}}">
                                                <span class="switch-text-left">فعال</span>
                                                <span class="switch-text-right">غیر فعال</span>
                                            </label>
                                        </div>
                                        <div class="hidden">غیر فعال شده</div>
                                    @else
                                        <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                            <input type="checkbox" class="custom-control-input" name="actived_at[{{$seller->id}}]" id="customSwitch{{$seller->id}}" onclick="changeStatus('{{ route('admin.seller.update.status', ['id'=> $seller->id]) }}',this)">
                                            <label class="custom-control-label" for="customSwitch{{$seller->id}}">
                                                <span class="switch-text-left">فعال</span>
                                                <span class="switch-text-right">غیر فعال</span>
                                            </label>
                                        </div>
                                        <div class="hidden">غیر فعال شده</div>
                                    @endif
                                    
                                </td>
                                <td col="action" class="td-action">
                                    <a href="{{ route('admin.seller.show', ['slug'=>$seller->slug]) }}">
                                        <i class="feather icon-eye"></i>
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