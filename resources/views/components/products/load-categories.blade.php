
<ul class="list-group list-group-flush">
    @forelse ($categories as $category)
        <label class="list-group-item d-flex justify-content-between align-items-center">
            {{-- <span> {{$category->name}} </span> --}}
            <div class="vs-checkbox-con vs-checkbox-primary">
                <input type="radio" name="categories[{{$col}}]" value="{{$category->id}}" id="data-{{$category->id}}" onchange="LoadCategories('{{route('get.children.categories', ['parent_id' => $category->id, 'col' => $col])}}', {{$col}}, '{{$category->name}}', this)">
                <span class="vs-checkbox vs-checkbox-sm">
                    <span class="vs-checkbox--check">
                        <i class="vs-icon feather icon-check"></i>
                    </span>
                </span>
                <span class="">{{$category->name}} </span>
                <small class="help-block text-danger error-pay"></small>
            </div>
            @if ($category->children_count)
                <i class="fas fa-chevron-left font-small-2"></i>
            @endif
        </label>
    @empty
        
    @endforelse
</ul>