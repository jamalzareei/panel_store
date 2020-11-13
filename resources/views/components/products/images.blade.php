@forelse ($images as $image)

    <div class="col-md-3" id="item-row-{{$image->id}}">

                                        
        <div class="row  border-light rounded pt-1" style="margin: 5px">
            <img src="{{config('shixeh.cdn_domain'). $image['path']}}" alt="" class=" user-circle m-auto">
            <div class="col-6 mt-2">
                <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                    <input type="checkbox" class="custom-control-input" name="actived_at[{{$image->id}}]" id="customSwitch-image-{{$image->id}}" {{($image->default_use == 'MAIN') ? 'checked' : ''}} onclick="changeStatus('{{ route('seller.image.update.status', ['id'=> $image->id]) }}',this)">
                    <label class="custom-control-label" for="customSwitch-image-{{$image->id}}">
                        <span class="switch-text-left">اصلی</span>
                        <span class="switch-text-right">گالری</span>
                    </label>
                </div>
            </div>
            <div class="col-6 mt-2">
                <span class="action-delete" onclick="deleteRow('{{ route('seller.image.product.delete', ['id'=>$image->id]) }}', '{{$image->id}}')">
                    <i class="feather icon-trash"></i>
                </span>
            </div>
        </div>
        
        
    </div>
@empty
    
@endforelse