@extends('layouts/master') 
@section('head')

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/core/colors/palette-gradient.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/app-chat.css') }}"> 
@endsection 
@section('footer')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/app-chat.css') }}">
<!-- BEGIN: Page JS-->
<script src="{{ asset('app-assets/js/scripts/pages/app-chat.js') }}"></script>
<!-- END: Page JS-->
@endsection 
@section('content')


<div class="vertical-layout vertical-menu-modern content-left-sidebar chat-application navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar">
    <div class="content-area-wrapper m-0">
        <div class="sidebar-left">
            <div class="sidebar">
                <!-- User Chat profile area -->
                <div class="chat-profile-sidebar">
                    <header class="chat-profile-header">
                        <span class="close-icon">
                            <i class="feather icon-x"></i>
                        </span>
                        <div class="header-profile-sidebar">
                            <div class="avatar">
                                <img src="{{asset('app-assets/images/portrait/small/avatar-s-11.jpg')}}" alt="user_avatar" height="70" width="70">
                                <span class="avatar-status-online avatar-status-lg"></span>
                            </div>
                            <h4 class="chat-user-name">John Doe</h4>
                        </div>
                    </header>
                    <div class="profile-sidebar-area">
                        <div class="scroll-area">
                            <h6>About</h6>
                            <div class="about-user">
                                <fieldset class="mb-0">
                                    <textarea data-length="120" class="form-control char-textarea" id="textarea-counter" rows="5" placeholder="About User">Dessert chocolate cake lemon drops jujubes. Biscuit cupcake ice cream bear claw brownie brownie marshmallow.</textarea>
                                </fieldset>
                                <small class="counter-value float-right"><span class="char-count">108</span> / 120 </small>
                            </div>
                            <h6 class="mt-3">Status</h6>
                            <ul class="list-unstyled user-status mb-0">
                                <li class="pb-50">
                                    <fieldset>
                                        <div class="vs-radio-con vs-radio-success">
                                            <input type="radio" name="userStatus" value="online" checked="checked">
                                            <span class="vs-radio">
                                                <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                            </span>
                                            <span class="">Active</span>
                                        </div>
                                    </fieldset>
                                </li>
                                <li class="pb-50">
                                    <fieldset>
                                        <div class="vs-radio-con vs-radio-danger">
                                            <input type="radio" name="userStatus" value="busy">
                                            <span class="vs-radio">
                                                <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                            </span>
                                            <span class="">Do Not Disturb</span>
                                        </div>
                                    </fieldset>
                                </li>
                                <li class="pb-50">
                                    <fieldset>
                                        <div class="vs-radio-con vs-radio-warning">
                                            <input type="radio" name="userStatus" value="away">
                                            <span class="vs-radio">
                                                <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                            </span>
                                            <span class="">Away</span>
                                        </div>
                                    </fieldset>
                                </li>
                                <li class="pb-50">
                                    <fieldset>
                                        <div class="vs-radio-con vs-radio-secondary">
                                            <input type="radio" name="userStatus" value="offline">
                                            <span class="vs-radio">
                                                <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                            </span>
                                            <span class="">Offline</span>
                                        </div>
                                    </fieldset>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ User Chat profile area -->
                <!-- Chat Sidebar area -->
                <div class="sidebar-content card">
                    <span class="sidebar-close-icon">
                        <i class="feather icon-x"></i>
                    </span>
                    <div class="chat-fixed-search">
                        <div class="d-flex align-items-center">
                            <div class="sidebar-profile-toggle position-relative d-inline-flex">
                                <div class="avatar">
                                    <img src="{{asset('app-assets/images/portrait/small/avatar-s-11.jpg')}}" alt="user_avatar" height="40" width="40">
                                    <span class="avatar-status-online"></span>
                                </div>
                                <div class="bullet-success bullet-sm position-absolute"></div>
                            </div>
                            <fieldset class="form-group position-relative has-icon-left mx-1 my-0 w-100">
                                <input type="text" class="form-control round" id="chat-search" placeholder="Search or start a new chat">
                                <div class="form-control-position">
                                    <i class="feather icon-search"></i>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div id="users-list" class="chat-user-list list-group position-relative">
                        {{-- <h3 class="primary p-1 mb-0">پیام های مدیریت</h3> --}}
                        <ul class="chat-users-list-wrapper media-list">
                            @forelse ($messages as $key => $user)
                            <li class="{{ ($user->status_id == 0) ? '' : 'bg-rgba-dark'}}" user_id="{{($user->user_sender_id == auth()->id()) ? $user->user_receiver_id : $user->user_sender_id}}" url="{{ route('user.load.chat', ['user_id'=>($user->user_sender_id == auth()->id()) ? $user->user_receiver_id : $user->user_sender_id]) }}">
                                <div class="pr-1">
                                    <span class="avatar m-0 avatar-md">
                                        @if ($user && $user->sender && isset($user->sender->image) && $user->sender->image->path)
                                            <img class="media-object rounded-circle" src="{{config('shixeh.cdn_domain')}}{{$user->sender->image->path}}" height="42" width="42" alt="Generic placeholder image">
                                            @else
                                            <img class="media-object rounded-circle" src="{{config('shixeh.path_logo')}}" height="42" width="42" alt="Generic placeholder image">
                                        @endif
                                        <i></i>
                                    </span>
                                </div>
                                <div class="user-chat-info">
                                    <div class="contact-info">
                                        <h5 class="font-weight-bold mb-0" dir="ltr">
                                            @if ($user->user_sender_id == auth()->id())
                                                {{$user->receiver->full_name}}
                                                <small class="font-small-1">({{$user->receiver->phone_sub}})</small>
                                            @else
                                                {{$user->sender->full_name}}
                                                <small class="font-small-1">({{$user->sender->phone_sub}})</small>
                                            @endif
                                        </h5>
                                        <p class="truncate">
                                            {!!$user->title!!}
                                        </p>
                                    </div>
                                    <div class="contact-meta">
                                        <span class="float-right mb-25 small">{{verta($user->created_at)->formatDifference()}}</span>
                                        {{-- @if ($user->read->isEmpty() || $user->read->count() == 0)
                                            <span class="badge badge-primary badge-pill float-right">1</span>
                                        @endif --}}
                                    </div>
                                </div>
                            </li>
                            @empty
                                
                            @endforelse
                        </ul>
                    </div>
                </div>
                <!--/ Chat Sidebar area -->

            </div>
        </div>
        <div class="content-right">
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="chat-overlay"></div>
                    <section class="chat-app-window">
                        <div class="start-chat-area">
                            <span class="mb-1 start-chat-icon feather icon-message-square"></span>
                            <h4 class="py-50 px-1 sidebar-toggle start-chat-text">شروع گفتگو</h4>
                        </div>
                        <div class="active-chat d-none">
                            
                            {{-- @include('user.messages.load-messages') --}}
                            <div class="chat_navbar"  id="load-header">
                                {!!$load_header!!}
                            </div>
                            <div class="user-chats ps ps--active-y" id="load-chat">
                                {!!$load_chats!!}  
                            </div>
                            <div class="chat-app-form" id="load-form">
                                {!!$load_form!!} 
                            </div>
                        </div>
                    </section>
                    <!-- User Chat profile right area -->
                    <div class="user-profile-sidebar">
                        <header class="user-profile-header">
                            <span class="close-icon">
                                <i class="feather icon-x"></i>
                            </span>
                            <div class="header-profile-sidebar">
                                <div class="avatar">
                                    <img src="{{asset('app-assets/images/portrait/small/avatar-s-11.jpg')}}" alt="user_avatar" height="70" width="70">
                                    <span class="avatar-status-busy avatar-status-lg"></span>
                                </div>
                                <h4 class="chat-user-name">Felecia Rower</h4>
                            </div>
                        </header>
                        <div class="user-profile-sidebar-area p-2">
                            <h6>About</h6>
                            <p>Toffee caramels jelly-o tart gummi bears cake I love ice cream lollipop. Sweet liquorice croissant candy danish dessert icing. Cake macaroon gingerbread toffee sweet.</p>
                        </div>
                    </div>
                    <!--/ User Chat profile right area -->

                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN: Content-->
    {{-- <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        
    </div> --}}
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

</div>
@endsection