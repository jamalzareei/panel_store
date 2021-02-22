<style>
    .show-form-reply{
        bottom: 4%;
        position: fixed;
        width: 62%;
    }
</style>
<section class="chat-app-window">
        
    <div class="active-chat">


        <div class="chat_navbar" id="load-header">
            <header class="chat_header d-flex justify-content-between align-items-center p-1">
                <div class="vs-con-items d-flex align-items-center">
                    <div class="sidebar-toggle d-block d-lg-none mr-1"><i class="feather icon-menu font-large-1"></i>
                    </div>
                    <div class="avatar user-profile-toggle m-0 m-0 mr-1">
                        <img src="{{ config('shixeh.x_logo') }}" alt="avatar" height="40" width="40">
                    </div>
                    <h6 class="mb-0">

                        <small class="font-small-1 " dir="ltr">{{ $ticket->title }}</small>
                    </h6>
                </div>
                <span class="favorite">
                    <button class="btn btn-warning" onclick="showFromReply()">
                        پاسخ به تیکت
                    </button>
                </span>
            </header>
        </div>
        
        <div class="user-chats ps" style="height: calc(var(--vh, 1vh) * 100 - 17.5rem) !important;" id="load-chat">
            <div class="chats">
                @if ($ticket->ticket_messages->count())
                @forelse ($ticket->ticket_messages as $message)
                    
                    <div class="chat  {{ $message->user_id == auth()->id() ? 'chat-left' : '' }}">
                        {{-- <div class="chat-avatar">
                            <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right" title=""
                                data-original-title="">
                                <img src="{{ config('shixeh.x_logo') }}" alt="avatar" height="40" width="40">
                            </a>
                        </div> --}}
                        <div class="chat-body">
                            <div class="chat-content- bg-gradient-white p-2 w-100 {{ $message->user_id == auth()->id() ? 'text-left' : 'text-right' }} ">
                                <h6>{{ $message->user->full_name ?? '' }}</h6>
                                <div class="text-dark">
                                    @if ($message->paths)
                                        <br>
                                    <img src="{{ config('shixeh.cdn_domain_files') . $message->paths }}" alt="" class="img-thumbnail" height="200" width="500">
                                    @endif

                                </div>
                                
                                <div class="row text-dark m-1">

                                    {{ $message->message }}
                                </div>
                                <div class="small border-top w-100 text-muted text-left p-1">
                                    {{verta($message->created_at)->formatDifference()}}
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    
                @endforelse

    
                @else
            
                <div class="start-chat-area">
                    <span class="mb-1 start-chat-icon feather icon-message-square"></span>
                    <button class="btn btn-warning" onclick="showFromReply()">
                        اضافه کردن متن و سوال تیکت
                    </button>
                </div>
            
                @endif
            </div>
        </div>
        
        <div class="chat-app-form card bg-gradient-secondary" style="    background-color: #17d3d8;" id="load-form">
            
            <form class="chat-app-input row ajaxUpload" method="POST" action="{{ route('admin.ticket.add.reply', ['ticket_id'=>$ticket->id]) }}"  enctype="multipart/form-data">
                <h3 class="text-center w-100 mb-1">افزودن پاسخ جدید به تیکت</h3>
                <div class="col-sm-12 data-field-col">
                    <input type="hidden" class="form-control message mr-1 ml-50" id="txt-ticket_id" name="ticket_id" value="{{ $ticket->id }}">
                    <textarea name="message" id="message" cols="30" rows="5" placeholder="متن تیکت" class="form-control"></textarea>
                </div>
                
                <div class="col-sm-12 data-field-col">
                    <fieldset class="form-group">
                        <label for="basicInputFile">فایل ها</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input file-upload" id="data-imageUrl" name="imageUrl" >
                            <label class="custom-file-label" for="data-imageUrl">انتخاب فایل ها</label>
                        </div>
                    </fieldset>
                    <small class="help-block text-danger error-imageUrl"></small>
                </div>
                
                <div class="col-sm-12 data-field-col">
                    <button type="submit" id="btn-send" class="btn btn-primary float-left send waves-effect waves-light">
                        <i class="fa fa-paper-plane-o d-lg-none"></i> <span class="d-none d-lg-block">ارسال</span>
                    </button>
                    <button type="javascript:void()" onclick="showFromReply()" id="btn-send" class="btn btn-danger float-right send waves-effect waves-light">
                        <i class="fa fa-paper-plane-o d-lg-none"></i> <span class="d-none d-lg-block">بستن</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
</section>

<script>
    function showFromReply(){
        $(".chat-app-form").toggleClass('show-form-reply');
    }
    //     bottom: 0;
    // position: fixed;
    // width: 62%;
</script>