@if($errors->any())
    <div class="alert alert-danger mt-4">
        <ul>
            @foreach($errors->all() as $errors)
                <li>{{$errors}}</li>
            @endforeach
        </ul>

    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger mt-4">
        {{Session::get('error')}}
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-success mt-4">
        {{Session::get('success')}}
    </div>
@endif
