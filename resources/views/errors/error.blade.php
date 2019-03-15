<div class="form-group">
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul style="color:red;">
            @foreach ($errors->all() as $error)
                <li style="color:white;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    </div>