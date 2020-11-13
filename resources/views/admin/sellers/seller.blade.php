@extends('layouts/master')

@section('head')
    
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}"> @endsection @section('footer')
<style>
    .accordion input, .accordion textarea:not([name='message-seller']), .accordion select{
        pointer-events: none !important;
        cursor: pointer !important;
        background-color: #F5F5F1 !important;
        border: none !important
    }
</style>
<!-- include summernote css/js -->
<link href="{{asset('assets/summernote/summernote.min.css')}}" rel="stylesheet">
<script src="{{asset('assets/summernote/summernote.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('textarea').summernote();
    });
    </script>
@endsection

@section('footer')
    
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script>
    $(".select2").select2({
        dir: "rtl",
        dropdownAutoWidth: true,
        width: '100%'
    });

$(() => {
})
    $(document).ready(function(){
        $("input").prop('disabled', true);

    })

</script>
@endsection

@section('content')
    

<!-- Accordion with margin start -->
<section id="accordion-with-margin">
    <div class="row">
        <div class="col-sm-12">
            <div class="card collapse-icon accordion-icon-rotate">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.seller.active', ['id'=>$seller->id]) }}" method="POST" class="ajaxForm">
                        @csrf
                        <input type="hidden" name="seller_id" value="{{$seller->id}}">
                        <div class="row border-warning p-2">
                            <p class="col-md-12">
                                لطفا اطلاعات 
                                <code>فروشنده</code> را کامل چک و پس از تایید نسبت به فعال سازی اقدام نمایید.
                            </p>
                            <br>
                            <p class="text-danger col-md-12">
                                <strong>*توجه:</strong>
                                در صورت لزوم با فروشنده تماس حاصل نمایید و اطلاعات را چک نمایید.
                            </p>
                            <div class="col-12">

                                <ul class="list-group">
                                    <li class="list-group-item"><strong> لینک اطلاعات کلی و لوگو: </strong><label class="float-right">{{ route('seller.data.get') }}</label></li>
                                    <li class="list-group-item"><strong> لینک تنظیمات فروش و ارتباط مشتری و هزینه و زمان پست: </strong><label class="float-right">{{ route('seller.setting.get') }}</label></li>
                                    <li class="list-group-item"><strong> لینک اضافه کردن شعبه: </strong><label class="float-right">{{ route('seller.brancehs.get') }}</label></li>
                                    <li class="list-group-item"><strong> لینک شبکه های اجتماعی: </strong><label class="float-right">{{ route('seller.socials.get') }}</label></li>
                                </ul>
                            </div>
                            <label class="p-1"> <strong>شماره تماس فروشنده: </strong> {{$seller->user->phone}}</label>
                            <div class="col-md-12 d-flex justify-content-start flex-wrap">
                                <div class="custom-control custom-switch  custom-switch-success mr-2 mb-1">
                                    <p class="mb-0">فروشنده فعال شود؟</p>
                                    <input type="checkbox" class="custom-control-input" name="admin_actived_at" id="active-seller" {{($seller->admin_actived_at) ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="active-seller">
                                        <span class="switch-text-left">بله</span>
                                        <span class="switch-text-right">خیر</span>
                                    </label>
                                </div>
                                <div class="custom-control custom-switch  custom-switch-success mr-2 mb-1">
                                    <p class="mb-0">با فرشنده تماس گرفته اید؟</p>
                                    <input type="checkbox" class="custom-control-input" name="call_admin_at" id="tell-seller" {{($seller->call_admin_at) ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="tell-seller">
                                        <span class="switch-text-left">بله</span>
                                        <span class="switch-text-right">خیر</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-label-group my-2">
                                    <textarea data-length="500" class="form-control char-textarea active" id="textarea-seller" rows="10" placeholder="توضیحات برای فروشنده" style="color: rgb(78, 81, 84);" name='message_seller'>
                                    فروشگاه شما تایید گردید، هم اکنون میتوانید نسبت به فعال سازی پلن فروشگاه اقدام نمایید.
                                    <br>
                                    دقت نمایید بعد از فعال سازی یکی از پلن های فروشگاهی امکان اضافه کردن محصول و دیگر امکانات را خواهید داشت.
                                    </textarea>
                                    <label for="textarea-seller">توضیحات برای فروشنده</label>
                                </fieldset>
                                <small class="counter-value float-right" style="background-color: rgb(115, 103, 240);"><span class="char-count">0</span> / 500 </small>
                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn bg-gradient-info mr-1 waves-effect waves-light action-add-new" data-toggle="modal" data-target="#exampleModalCenter">
                                    <i class="feather icon-plus"></i> ارسال پیام و تاییدیه ها
                                </button>
                            </div>
                            
                        </div>
                    </form>
                    <div class="accordion" id="accordionExample">
                        <div class="collapse-margin">
                            <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <span class="lead collapse-title">
                                    اطلاعات پایه
                                </span>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    
                                    @include('admin.sellers.sections.info', ['seller'=>$seller, 'countries'=>$countries])
                                </div>
                            </div>
                        </div>
                        <div class="collapse-margin">
                            <div class="card-header" id="headingTwo" data-toggle="collapse" role="button" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span class="lead collapse-title">
                                    شعب
                                </span>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if ($seller->branches)
                                        
                                    @include('admin.sellers.sections.branches', ['seller'=>$seller, 'countries'=>$countries])
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="collapse-margin">
                            <div class="card-header" id="headingThree" data-toggle="collapse" role="button" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <span class="lead collapse-title">
                                    تنظیمات فروشگاه و هزینه پستی
                                </span>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">
                                    
                                    @include('admin.sellers.sections.setting', [
                                        'seller'=>$seller, 
                                        'countries' => $countries,
                                        'setting' => $setting,
                                        'currencies' => $currencies,
                                        'payTypes' => $payTypes,
                                        'sellTypes' => $sellTypes,
                                        'states' => $states,
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="collapse-margin">
                            <div class="card-header" id="headingFour" data-toggle="collapse" role="button" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <span class="lead collapse-title">
                                    لیست شبکه های اجتماعی
                                </span>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <div class="card-body">
                                    @include('admin.sellers.sections.socials', [
                                        'seller'=>$seller, 
                                        'socials' => $socials,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Accordion with margin end -->


@endsection