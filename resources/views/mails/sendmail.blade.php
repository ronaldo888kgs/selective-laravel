@extends('dashboard')

@section('content')

<div id="loader-container" style="position: absolute; width:100%; height:100%; background-color:rgba(85, 95, 95, 0.5); z-index:10000;" class="d-flex justify-content-center align-items-center">
    <div class="loader" style="position: relative;"></div>
</div>

<div class="d-flex justify-content-center" style="width:100%; margin:0px; padding:20px">
    <div style="width:80%">
        <div style="margin-bottom:10px; padding-bottom:10px;">
            <h4>
                Category name is <b>{{ $current_category->name }}</b>
                <input type="hidden" id="category_id" name="category_id" value="{{ $current_category->id }}">
            </h4>
        </div>
            <input type="hidden" id="" name="", value="">
            <div class="d-flex" style="margin:0px; margin-top:20px; padding:10px; width:100%; border: 1px solid #d1d1d1;">
                <div class="col-lg-6 col-12" style="padding-right:20px;">
                    <div style="margin-right:20px;">
                        <h5>Subject :</h5>
                    </div>
                    <div style="width:100%;">
                        <input type="text" class="form-control" name="input_title" id="input_title" style="width:100%;">
                    </div>
                </div>
                <div class="col-lg-6 col-12" style="padding-left:20px;">
                    <div class="d-flex align-items-center" style="margin-right:20px;">
                        <div><h5>To :</h5></div>
                    </div>
                    <div style="width:100%;">
                        <select id='select-emails' name="select-emails" class="form-control" style="width:100% !important" multiple>
                            @foreach ($contacts as $contact)
                            <option value='{{ $contact->email }}'>{{ $contact->email }}</option>
                            @endforeach    
                        </select>
                    </div>
                </div>
            </div>
            <div id="mail-edit-form" style="margin-top:20px;">
                <textarea cols="80" rows="10" id="mail-editor" name="mail-editor"></textarea>
            </div>
            <div id="attached-files-form" style="margin-top:20px;">
    
            </div>
            <div style="margin-top:20px;">
                <button class="btn btn-success" style="width:100%" onclick="sendEmail()"><b>Send Mail</b></button>
            </div>
        
    </div>
    
</div>

<script src="/ckeditor/ckeditor.js"></script>
<script src="/js/multiple-select.js"></script>
<link rel="stylesheet" href="/css/multiple-select.css" />
<link rel="stylesheet" href="/assets/css/mailform.css" ">

<script type="text/javascript">

    $( document ).ready(function() {
        CKEDITOR.replace( 'mail-editor' );
        hideAndShowLoader(true);
    });

    document.multiselect('#select-emails')
		.setCheckBoxClick("checkboxAll", function(target, args) {
			console.log("Checkbox 'Select All' was clicked and got value ", args.checked);
		})
		.setCheckBoxClick("1", function(target, args) {
			console.log("Checkbox for item with value '1' was clicked and got value ", args.checked);
		});

    function hideAndShowLoader(hide)
    {
        if(hide)
            $('#loader-container').css('left', '-100%');
        else
            $('#loader-container').css('left', '0');
    }
    function sendEmail()
    {
        hideAndShowLoader(false);
        $.ajax({
            url: "{{ route('send_email') }}",
            method: 'post',
            dataType: "json",
            data: {
                title: $("#input_title").val(),
                content: CKEDITOR.instances['mail-editor'].getData(),
                address: $('#select-emails').val(),
                category: $('#category_id').val()
            },
            success: function(data) {
                hideAndShowLoader(true);
                window.location.href = "/adddata";
            }
        });
    }
</script>


@endsection