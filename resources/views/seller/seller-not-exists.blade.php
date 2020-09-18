
@extends('layouts/master')

@section('head')
    
@endsection

@section('footer')
    
@endsection

@section('content')

    <div class="modal fade text-left show" id="info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel130" aria-modal="true" 
    style="padding-right: 17px; display: block;background-color: rgba(255, 255, 255, .15);  
    backdrop-filter: blur(2px);"
    >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info white">
                    <h5 class="modal-title" id="myModalLabel130">تکمیل اطلاعات فروشگاه</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}
                        {{-- <span aria-hidden="true">×</span> --}}
                    </button>
                </div>
                <div class="modal-body">
                    <br>
                    شما اجازه دسترسی به این بخش را ندارید.
                    <br>
                    <br>
                    لطفا ابتدا نسبت به تکمیل اطلاعات فروشگاه خود اقدام نمایید.
                </div>
                <div class="modal-footer">
                    <a href="{{ route('seller.data.get') }}" class="btn btn-info waves-effect waves-light" data-dismiss="modal">تکمیل اطلاعات فروشنده</a>
                </div>
            </div>
        </div>
    </div>
@endsection