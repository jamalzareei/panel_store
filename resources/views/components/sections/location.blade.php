<div class="row">
    <div class="col-4">
        <select name="country_id" id="" class="select2">
            <option value="">کشور</option>
            @if ($user->country)
                <option selected value="{{$user->country->id}}">{{$user->country->name}}</option>
            @endif
            @foreach($countries as $country)
                <option value="{{$country->id}}">{{$country->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-4">
        <select name="state_id" id="" class="select2">
            <option value="">استان</option>
            @if ($user->state)
                <option selected value="{{$user->state->id}}">{{$user->state->name}}</option>
            @endif
        </select>
    </div>
    <div class="col-4">
        <select name="city_id" id="" class="select2">
            <option value="">شهر</option>
            @if ($user->city)
                <option selected value="{{$user->city->id}}">{{$user->city->name}}</option>
            @endif
        </select>
    </div>
</div>

<script>
    $(() => {
        $('[name="country_id"]').change(function() {
            var country_id = $(this).find('option:selected').val();
            $.ajax({
                url: "{{route('get.states.location')}}?country_id="+country_id,
                method: 'get',
                data: { ajax: 'true' },
                success: function(response) {
                    console.log(response)
                    $('[name="state_id"]').html(response)
                },
                error: function(request, status, error) {
                    console.log(request);
                }
            })
        })
        $('[name="state_id"]').change(function() {
            var state_id = $(this).find('option:selected').val();
            $.ajax({
                url: "{{route('get.cities.location')}}?state_id="+state_id,
                method: 'get',
                data: { ajax: 'true' },
                success: function(response) {
                    console.log(response)
                    $('[name="city_id"]').html(response)
                },
                error: function(request, status, error) {
                    console.log(request);
                }
            })
        })
    })
</script>