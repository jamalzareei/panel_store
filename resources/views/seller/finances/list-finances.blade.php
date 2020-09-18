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
            $('.ajaxForm').attr('action', "{{route('seller.finance.add.post')}}")
            $('.ajaxForm #data-slug').attr('disabled', false)
            $(".add-new-data").addClass("show");
            $(".overlay-bg").addClass("show");
        });

        $(document).on('click' , '.action-edit', function(e){
            var this_ = $(this)

            e.stopPropagation();
            $('#data-name').val(this_.attr('name'));
            $('#data-bank').val(this_.attr('bank'));
            $('#data-bank_cart_number').val(this_.attr('bank_cart_number'));
            $('#data-bank_sheba_number').val(this_.attr('bank_sheba_number'));
            $('#data-bank_account_number').val(this_.attr('bank_account_number'));
            $('#data-actived_at').prop('checked',this_.attr('actived_at'));

            $('.ajaxForm').attr('action', this_.attr('action'))
            // $('.ajaxForm #data-slug').attr('disabled', true)
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
        <form action="{{ route('admin.finances.update') }}" method="POST" id="form-datatable">
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
                            <th>نام صاحب حساب</th>
                            <th>بانک</th>
                            <th>شماره شبا</th>
                            <th>فعال / غیر فعال</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($finances as $key => $finance)
                            <tr row="{{$finance->id}}">
                                <td>{{$finance->id}}</td>
                                <td>{{$finance->name}}</td>
                                <td>{{$finance->bank}}</td>
                                <td>{{$finance->bank_sheba_number}}</td>
                                <td>
                                    @if($finance->deleted_at)
                                        <div class="chip chip-danger">
                                            <div class="chip-body">
                                                <div class="chip-text">حذف</div>
                                            </div>
                                        </div> 
                                    @elseif ($finance->actived_at)
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
                                <td class="td-action">
                                    <span class="action-edit" 
                                    item_id="{{$finance->id}}" 
                                    name="{{$finance->name}}" 
                                    bank="{{$finance->bank}}" 
                                    bank_cart_number="{{$finance->bank_cart_number}}" 
                                    bank_sheba_number="{{$finance->bank_sheba_number}}" 
                                    bank_account_number="{{$finance->bank_account_number}}" 
                                    actived_at="{{($finance->actived_at) ? true : false}}" 
                                    action="{{ route('seller.finance.update.post', ['id'=> $finance->id]) }}">
                                    <i class="feather icon-edit"></i></span>
                                    <span class="action-delete" onclick="deleteRow('{{ route('seller.finance.delete', ['id'=>$finance->id]) }}', '{{$finance->id}}')"><i class="feather icon-trash"></i></span>
                                    
                                </td>
                            </tr>
                            {{-- <tr>
                                <td></td>
                                <td colspan="7">
                                    <p class="detail-{{$finance->id}}">{{$finance->details}}</p>
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
                                    <label for="data-name">نام صاحب حساب</label>
                                    <input type="text" class="form-control" placeholder="نام صاحب حساب" name="name" id="data-name">
                                    <small class="help-block text-danger error-name"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-bank">بانک</label>
                                    <input type="text" class="form-control" placeholder="بانک" name="bank" id="data-bank">
                                    <small class="help-block text-danger error-bank"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-bank_cart_number">شماره کارت بانکی</label>
                                    <input type="text" class="form-control" name="bank_cart_number" placeholder="شماره کارت بانکی" id="data-bank_cart_number">
                                    <small class="help-block text-danger error-bank_cart_number"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-bank_sheba_number">شماره شبا</label>
                                    <input type="text" class="form-control" name="bank_sheba_number" placeholder="شماره شبا" id="data-bank_sheba_number">
                                    <small class="help-block text-danger error-bank_sheba_number"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-bank_account_number">شماره حساب</label>
                                    <input type="text" class="form-control" name="bank_account_number" placeholder="شماره حساب" id="data-bank_account_number">
                                    <small class="help-block text-danger error-bank_account_number"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-status">وضعیت </label>
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox"  name="actived_at" value="1" id="data-actived_at">
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