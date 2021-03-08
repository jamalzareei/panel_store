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