@if(count($errors->all()) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li> {{ $error }} </li>

            @endforeach
        </ul>
    </div>

@endif
@if(session()->has('success'))
<div class="alert alert-success">
    <h3> {{ session('success') }} </h3>
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger">
    <h3> {{ session('error') }} </h3>
</div>
@endif
