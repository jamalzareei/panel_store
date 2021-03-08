
    <div class="chat_navbar">
        <header class="chat_header d-flex justify-content-between align-items-center p-1">
            <div class="vs-con-items d-flex align-items-center">
                <div class="sidebar-toggle d-block d-lg-none mr-1"><i class="feather icon-menu font-large-1"></i></div>
                <div class="avatar user-profile-toggle m-0 m-0 mr-1">

                    {{-- <img src="http://localhost/cdn.shixeh.local/images/3.jpg" alt="avatar" height="40" width="40"> --}}
                    @if ($contact && isset($contact->image) && $contact->image->path)
                        <img src="{{config('shixeh.cdn_domain_files')}}{{$contact->image->path}}" alt="avatar" height="40" width="40" />
                    @else
                        <img src="{{config('shixeh.x_logo')}}" alt="avatar" height="40" width="40" />
                    @endif
                    <span class="avatar-status-busy"></span>
                </div>
                <h6 class="mb-0">
                    {{$contact->full_name}}
                    <small class="font-small-1 " dir="ltr">({{$contact->phone_sub}})</small>
                </h6>
            </div>
            <span class="favorite"><i class="feather icon-star font-medium-5"></i></span>
        </header>
    </div>
    <div class="user-chats ps ps--active-y">

        <div class="chats">
            @forelse ($messages as $message)
            
                @if ($message->user_sender_id == auth()->id())
                <div class="chat chat-left">
                    <div class="chat-avatar">
                        <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
                            @if ($message && $message->sender && isset($message->sender->image) && $message->sender->image->path)
                                <img src="{{config('shixeh.cdn_domain_files')}}{{$message->sender->image->path}}" alt="avatar" height="40" width="40" />
                            @else
                                <img src="{{config('shixeh.x_logo')}}" alt="avatar" height="40" width="40" />
                            @endif
                        </a>
                    </div>
                    <div class="chat-body">
                        <div class="chat-content">
                            {!!$message->message!!}
                        </div>

                    </div>
                </div>
                @else
                <div class="chat">
                    
                    <div class="chat-avatar">
                        <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
                            @if ($message && $message->receiver && isset($message->receiver->image) && $message->receiver->image->path)
                                <img src="{{config('shixeh.cdn_domain_files')}}{{$message->receiver->image->path}}" alt="avatar" height="40" width="40" />
                            @else
                                <img src="{{config('shixeh.x_logo')}}" alt="avatar" height="40" width="40" />
                            @endif
                        </a>
                    </div>
                    <div class="chat-body">
                        <div class="chat-content">
                            {!!$message->message!!}
                        </div>
                    </div>
                </div>
                @endif
            @empty
        
            @endforelse

        </div>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; left: -7px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
        </div>
    </div>
    <div class="chat-app-form">
        <form class="chat-app-input d-flex" onsubmit="enter_chat();" action="javascript:void(0);">
            <input type="text" class="form-control message mr-1 ml-50" id="iconLeft4-1" placeholder="Type your message">
            <button type="button" class="btn btn-primary send waves-effect waves-light" onclick="enter_chat();"><i class="fa fa-paper-plane-o d-lg-none"></i> <span class="d-none d-lg-block">Send</span></button>
        </form>
    </div>
