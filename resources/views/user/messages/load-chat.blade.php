
<div class="chats" >
    @forelse ($messages as $message)
            
        @if ($message->user_sender_id == auth()->id())
        <div class="chat">
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
        <div class="chat chat-left">
            
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

