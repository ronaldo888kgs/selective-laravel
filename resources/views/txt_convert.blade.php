@extends('dashboard')

@section('content')
<div class="d-flex justify-content-center" style="width:100%">
    <div style="margin-top:100px;">
        <form action="{{ route('txt_convert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="txt-file" class="custom-file-input" id="customFile">
            <button class="btn btn-primary">Covert File</button>
        </form>
    </div>
    
</div>
@endsection