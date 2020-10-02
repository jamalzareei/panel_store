<form class="chat-app-input d-flex" onsubmit="enter_chat('{{route('user.send.message', ['user_id'=> $sender_id])}}');" action="javascript:void(0);">
    <input type="hidden" class="form-control message mr-1 ml-50" id="txt-sender_id" name="sender_id" value="{{$sender_id}}">
    <input type="text" class="form-control message mr-1 ml-50" id="txt-message" placeholder="Type your message">
    <button type="submit" id="btn-send" class="btn btn-primary send waves-effect waves-light" >
        <i class="fa fa-paper-plane-o d-lg-none"></i> <span class="d-none d-lg-block">ارسال</span>
    </button>
</form>