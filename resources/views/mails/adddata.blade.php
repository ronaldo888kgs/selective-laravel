@extends('dashboard')

@section('content')

<div style="position: absolute; width:100%; margin-top:20px; display: flex; justify-content: end;">
    <div style="margin-right:20px;">
        <div class="alert alert-success" id="success-alert" style="width:fit-content">
            <strong>Success! </strong> 
            <span id="success-alert-label" name="success-alert-label" style="margin-left:20px;" ></span>
        </div>
        <div class="alert alert-danger" id="danger-alert" style="width:fit-content">
            <strong>Failed! </strong> 
            <span id="danger-alert-label" name="danger-alert-label" style="margin-left:20px;">
                
            </span>
        </div>
    </div>
</div>

<div style="width:100%; height:100%;  position: relative;">
    <div class="header_menu d-flex" style="border-bottom:1px solid #2578b5; padding:10px;">
        <button 
            class="btn btn-primary" 
            style="margin-left:10px; width:100px; font-size:18px;"
            data-bs-toggle="modal" 
            data-bs-target="#mailCategoryAdd" 
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
            </svg>
        </button>
        <select 
            id="select_categories" 
            name="select_categories" 
            class="form-select" 
            style="width:200px; margin-left:10px; font-size:18px;"
            onchange="changeCategory()"
        >
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"  {{ $current_category == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option> 
            @endforeach
        </select>
        @foreach ($categories as $category)
            <input type="hidden" value="{{ $category->name }}" id="category_{{ $category->id }}" name="category_{{ $category->id }}">
        @endforeach
        <button  
            class="btn btn-primary" 
            style="margin-left:10px; width:100px; font-size:18px;"
            data-toggle="tooltip" 
            title="Mail Edit" 
            style="cursor: pointer;" 
            data-bs-toggle="modal" 
            data-bs-target="#mailCategoryEdit" 
            onclick="showEditCategory()"
        >Edit</button>
        <button  
            class="btn btn-primary" 
            style="margin-left:10px; width:150px; font-size:18px;"
            data-bs-toggle="modal" 
            data-bs-target="#newMailerModal" 
            onclick="showNewMailerModal()"
        >New Mailer</button>
        <button  
            class="btn btn-primary" 
            style="margin-left:10px; width:150px; font-size:18px;"
            data-bs-toggle="modal" 
            data-bs-target="#importBulkMailerModal" 
            onclick="showImportBulkEmailModal()"
        >Import Bulk</button>

        <button  
            class="btn btn-primary" 
            style="margin-left:10px; width:150px; font-size:18px; white-space: nowrap;"
            data-bs-toggle="collapse" 
            data-bs-target="#collapseShowAllMails" 
            aria-expanded="false" 
            aria-controls="collapseShowAllMails"
        >Show Sent Mails</button>
        
    </div>
    <div class="collapse " id="collapseShowAllMails" style="margin-top:10px">
        <div class="row" style="width:100%; margin:0px; padding:0px;">
            <div class="send-email-container" style="margin:0px; padding:10px;">
                <div class="d-flex justify-content-between">
                    <span><h5>All Sent Mails</h5></span>
                    <button 
                        class="btn btn-danger" 
                        style="font-size:14px;" 
                        data-bs-toggle="modal" 
                        data-bs-target="#contactDeleteModal"
                        onclick="showMultiSentMailDeleteModal()">Delete</button>
                </div>
                <div class="sent-email-table" style="margin-top:10px; overflow: auto;">
                    <table 
                        class="table table-bordered table-row-dashed table-striped table-row-gray-300 align-middle gs-0 gy-4" 
                        style=" font-size:14px; ">
                        <thead class="table-light" >
                            <th style="width:30px; background-color:#484848 !important">
                                <input type="checkbox" name="selectAllSentMail" id="selectAllSentMail" onchange="checkAllMails(1)"/>
                            </th>
                            <th style="width:150px; background-color:#484848 !important; color:white; min-width:120px;">Sent Date</th>
                            <th style="width:150px; background-color:#484848 !important; color:white">Title</th>
                            <th style="background-color:#484848 !important; color:white">To</th>
                            <th style="background-color:#484848 !important; color:white">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($sent_mail as $mail)
                            <tr >
                                <td><input type="checkbox" name="selectSentMail" id="selectSentMail" value="{{ $mail->id }}"/></td>
                                <td>{{ $mail->created_at }}</td>
                                <td>{{ $mail->title }}</td>
                                <td>{{ $mail->receivers }}</td>
                                <td class="d-flex justify-content-center">
                                    <a 
                                        data-toggle="tooltip" 
                                        title="Delete record" 
                                        style="cursor: pointer;" 
                                        
                                        >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>    
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th style="width:30px; background-color:#484848 !important">
                                <input type="checkbox" name="selectAllSentMail2" id="selectAllSentMail2" onchange="checkAllMails(2)" />
                            </th>
                            <th style="width:150px; background-color:#484848 !important; color:white; min-width:120px;">Sent Date</th>
                            <th style="width:150px; background-color:#484848 !important; color:white">Title</th>
                            <th style="background-color:#484848 !important; color:white">To</th>
                            <th style="background-color:#484848 !important; color:white">Action</th>
                        </tfoot>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
    <div class="row" style="margin:0px; padding:0px;">
        <div class="send-email-container" style="margin:0px; padding:10px;">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="d-flex" style="height:fit-content; align-items:end">
                        <h4 style=" margin:0px;">All Mailer Infos : </h4>
                        <h5 style="color:gray; margin:0px; margin-left:10px; ">show {{ $contacts->count() }} of {{ $count_contacts }}</h5>
                    </div>
                    
                </div>
                <div class="d-flex">
                    <select id="select_type" class="form-select" aria-label="Default select" style="width:fit-content; margin-right:10px;">
                        <option value="0" {{ $search_field == '0' ? 'selected' : '' }}>Email</option>
                        <option value="1" {{ $search_field == '1' ? 'selected' : '' }}>Telegram ID</option>
                        <option value="2" {{ $search_field == '2' ? 'selected' : '' }}>Discord ID</option>
                        <option value="3" {{ $search_field == '3' ? 'selected' : '' }}>Twitter ID</option>
                        <option value="4" {{ $search_field == '4' ? 'selected' : '' }}>Slack ID</option>
                        <option value="5" {{ $search_field == '5' ? 'selected' : '' }}>Mobile Number</option>
                    </select>
                    <input type="text" class="form-control" id="searchInputByType" name="searchInputByType" value="{{ $search_value }}">
                    <button  class="btn btn-success" style="margin-left:10px; width:150px; font-size:18px; white-space: nowrap;" onclick="changeSearchInput()">Search</button>
                    <button class="btn btn-success" type="button" style="margin-left:10px" onclick="resetSearchInput()" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="color:white">
                            <path style="fill:currentColor" d="M20.944 12.979c-.489 4.509-4.306 8.021-8.944 8.021-2.698 0-5.112-1.194-6.763-3.075l1.245-1.633c1.283 1.645 3.276 2.708 5.518 2.708 3.526 0 6.444-2.624 6.923-6.021h-2.923l4-5.25 4 5.25h-3.056zm-15.864-1.979c.487-3.387 3.4-6 6.92-6 2.237 0 4.228 1.059 5.51 2.698l1.244-1.632c-1.65-1.876-4.061-3.066-6.754-3.066-4.632 0-8.443 3.501-8.941 8h-3.059l4 5.25 4-5.25h-2.92z"/>
                        </svg>
                    </button>
                    <button  class="btn btn-success" style="margin-left:10px; width:150px; font-size:18px; white-space: nowrap;" onclick="goSendMessagePage()">Send Message</button>
                </div>
                <div>
                    <button  
                        class="btn btn-danger" 
                        style="font-size:14px;"
                        data-bs-toggle="modal" 
                        data-bs-target="#contactDeleteModal"
                        onclick="showMultiDeleteModal()" 
                    >Delete</button>
                </div>
                
            </div>
            <div id="contact-table"class="sent-email-table" style="margin-top:10px; overflow: auto;">
                @include('mails.contact-table')
            </div>
        </div>
    </div>
   
    @include('mails.modals.new-mailer')
    @include('mails.modals.add-category')
    @include('mails.modals.edit-category')
    @include('mails.modals.import-bulk-mailers')

    <div class="modal fade" id="contactDeleteModal" tabindex="-1" aria-labelledby="contactDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="contactDeleteModalLabel">Delete Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <h3 id="selected_cnt"></h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="hidden-selected-contacts" name="hidden-selected-contacts" />
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btnMultiDelete" >Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $("#success-alert").hide();
    $("#danger-alert").hide();

    function checkAllMails(varWhich)
    {
        if(varWhich == 1)
            document.getElementById('selectAllSentMail2').checked = document.getElementById('selectAllSentMail').checked;
        if(varWhich == 2)
        {
            document.getElementById('selectAllSentMail').checked = document.getElementById('selectAllSentMail2').checked;
        }
            
        var i = 0;
        var elements = document.getElementsByName('selectSentMail');
        for(i = 0 ; i < elements.length ; i++)
        {
            elements[i].checked = varWhich == 1 ? document.getElementById('selectAllSentMail').checked : document.getElementById('selectAllSentMail2').checked;
        }
    }

    function resetSearchInput()
    {
        $('#searchInputByType').val('');
        window.location.href = "/adddata?category=" + $('#select_categories').val();
    }
    function changeSearchInput()
    {
        var searchVal = $('#searchInputByType').val();
        var search_field = $('#select_type').val();
        if(searchVal == '')
            window.location.href = "/adddata?category=" + $('#select_categories').val();
        else
            window.location.href = "/adddata?category=" + $('#select_categories').val() + '&search_field=' + search_field + '&search_value=' + searchVal;
            

    }
    function goSendMessagePage()
    {
        //view_send_mail;
        var type = $('#select_type').val();
        var strMailers = "all";
        var listMailers = document.getElementsByClassName("checkMailer");
        var listHiddenEmails = document.getElementsByClassName("hidden_emails");
        for(var i = 0 ; i < listMailers.length ; i++)
        {
            if(listMailers[i].checked)
            {
                if(type == 0 && listHiddenEmails[i].value != "")
                {
                    strMailers += listHiddenEmails[i].value + ",";
                }
            }
        }

        window.location.href = "/send_mail/" + $('#select_categories').val() + "/" + strMailers;
    }
    
    function showNewMailerModal()
    {
        $('#newMailerModalLabel').html("Add new mailer contact");
        $('#input-first-name').removeAttr('disabled');
        $('#input-last-name').removeAttr('disabled');        
        $('#input-email').removeAttr('disabled');
        $('#input-discord').removeAttr('disabled');
        $('#input-twitter').removeAttr('disabled');
        $('#input-telegram').removeAttr('disabled');
        $('#input-slack').removeAttr('disabled');
        $('#input-phone').removeAttr('disabled');
        var categoryName = document.getElementById('category_' + $('#select_categories').val()).value;
        $('#new-mailer-category').val(categoryName);

        $('#btnAddContact').html('Add');
        $('#btnAddContact').attr('class', 'btn btn-success');
        $('#btnAddContact').off('click');
        $('#btnAddContact').on('click', function(){addData()} );
    }

    function editCategory()
    {
        if($('#select_categories').val() == null)
        {
            $('#mailCategoryEdit').modal('hide');
            return;
        }
        $.ajax({
            url: "{{ route('add_edit_category') }}",
            method: 'post',
            dataType: "json",
            data: {
                new_category: $("#edit-category-name").val(),
                old_category: $("#select_categories").val(),
            },
            success: function(data) {
                if(data.status == true)
                {
                    showSuccessMessage(data.message);       
                }
                if(data.status == false)
                {
                    showFailedMessage(data.message)
                }
            }
        });
    }

    function showFailedMessage(message)
    {
        $('#danger-alert-label').html(message);
        $("#danger-alert").show();
        $("#danger-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#danger-alert").slideUp(500);
        });
        $('#mailCategoryEdit').modal('hide');
    }

    function showSuccessMessage(message)
    {
        $('#success-alert-label').html(message);
        $("#success-alert").show();
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
        $('#mailCategoryEdit').modal('hide');
    }

    function addNewCategory()
    {
        $('#mailCategoryAdd').modal('hide');

        $.ajax({
            url: "{{ route('add_new_category') }}",
            method: 'post',
            dataType: "json",
            data: {
                category: $("#new-category").val(),
            },
            success: function(data) {
                if(data.status == true)
                {
                    showSuccessMessage(data.message);
                }
                if(data.status == false)
                {
                    showFailedMessage(data.message);
                }
            }
        });
    }
    function showEditCategory()
    {
        var categoryName = document.getElementById('category_' + $('#select_categories').val()).value;
        $('#edit-category-name').val(categoryName);
    }
    function sendMail()
    {
        //CKEDITOR.instances["element_id"].getData()
    }
    function showMultiSentMailDeleteModal()
    {
        var nCnt = 0;
        var strData = '';
        var objChecks = document.getElementsByName('selectSentMail');
        objChecks.forEach(function(obj){
            if(obj.checked)
                {
                    nCnt++;
                    strData += obj.value + ',';
                }
        });
        $('#contactDeleteModalLabel').html("Delete Mails");
        $('#selected_cnt').html("Are you sure to delete " + nCnt + " mails?");
        $('#hidden-selected-contacts').val(strData);
        $('#btnMultiDelete').off('click');
        $('#btnMultiDelete').on('click', function(){deleteSentMail(strData)} );
    }
    function deleteSentMail(selectedMails)
    {
        $.ajax({
            url: "{{ route('delete_mail') }}",
            method: 'post',
            dataType: "json",
            data: {
                delete_mail: selectedMails
            },
            success: function(data) {
                if(data.status == true)
                {
                    window.location.reload();
                }
            }
        });
    }
    function showMultiDeleteModal()
    {   
        var nCnt = 0;
        var strData = '';
        var objChecks = document.getElementsByName('checkMailer');
        objChecks.forEach(function(obj){
            if(obj.checked)
                {
                    nCnt++;
                    strData += obj.value + ',';
                }
        });
        $('#contactDeleteModalLabel').html("Delete Contacts");
        $('#selected_cnt').html("Are you sure to delete " + nCnt + " mails?");
        $('#hidden-selected-contacts').val(strData);
        $('#btnMultiDelete').off('click');
        $('#btnMultiDelete').on('click', function(){deleteContacts(strData)} );
    }

    function showDeleteModal(objContract)
    //function showDeleteModal(address_id, group_id)
    {
        var objData = JSON.parse(objContract);
        $('#newMailerModalLabel').html("Are you sure delete Contact?");
        $('#input-first-name').attr('disabled', 'disabled');
        $('#input-first-name').val(objData.first_name);

        $('#input-last-name').attr('disabled', 'disabled');
        $('#input-last-name').val(objData.last_name);
        
        $('#input-email').attr('disabled', 'disabled');
        $('#input-email').val(objData.email);

        $('#input-discord').attr('disabled', 'disabled');
        $('#input-discord').val(objData.discord_id);

        $('#input-twitter').attr('disabled', 'disabled');
        $('#input-twitter').val(objData.twitter_id);

        $('#input-telegram').attr('disabled', 'disabled');
        $('#input-telegram').val(objData.telegram_id);

        $('#input-slack').attr('disabled', 'disabled');
        $('#input-slack').val(objData.slack_id);

        $('#input-phone').attr('disabled', 'disabled');
        $('#input-phone').val(objData.phone);

        var categoryName = document.getElementById('category_' + $('#select_categories').val()).value;
        $('#new-mailer-category').val(categoryName);

        $('#btnAddContact').html('Delete');
        $('#btnAddContact').attr('class', 'btn btn-danger');
        $('#btnAddContact').off('click');
        $('#btnAddContact').on('click', function(){deleteContacts(objData.id)} );
    }
    function deleteMultiContacts()
    {
        if($('#hidden-selected-contacts').val() != '')
            deleteContacts($('#hidden-selected-contacts').val());
    }
    function deleteContacts(contactID)
    {
        $.ajax({
            url: "{{ route('delete_contact') }}",
            method: 'post',
            dataType: "json",
            data: {
                contact_id: contactID
            },
            success: function(data) {
                if(data.status == true)
                {
                    // $('#contactDeleteModal').modal('hide');
                    window.location.reload();
                }
            }
        });
    }
    function checkAllAddress()
    {
        var i = 0;
        var elements = document.getElementsByName('checkMailer');
        for(i = 0 ; i < elements.length ; i++)
        {
            elements[i].checked = document.getElementById('sendAllCheck').checked;
        }
    }

    function validationEmail(email)
    {
        if(!email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/))
            return false;        
        return true;
    }
    
    function addData()
    {
        var contactType = document.getElementById('select_type').value;
        var first_name = document.getElementById('input-first-name').value;
        var last_name = document.getElementById('input-last-name').value;
        var email = document.getElementById('input-email').value;
        var telegram_id = document.getElementById('input-telegram').value;
        var discord_id = document.getElementById('input-discord').value;
        var twitter_id = document.getElementById('input-twitter').value;
        var slack_id = document.getElementById('input-slack').value;
        var mobile_number = document.getElementById('input-phone').value;
        var groud_id = document.getElementById('select_categories').value;
        if(email != '' && validationEmail(email) == false)
        {
            showFailedMessage("email is invalidate.");
            return;
        }

        $.ajax({
                url: "{{ route('add_contact') }}",
                method: 'post',
                dataType: "json",
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    telegram_id: telegram_id,
                    discord_id: discord_id,
                    twitter_id:twitter_id,
                    slack_id: slack_id,
                    phone: mobile_number,
                    type: contactType,
                    group_id:groud_id
                },
                success: function(data) {
                    if(data.status == true)
                    {

                        showSuccessMessage("Success add new mailer");
                        $('#newMailerModal').modal('hide');
                        window.location.reload();
                    }
                    if(data.status == false)
                    {
                        showFailedMessage("Failed add new mailer");
                    }
                }
            });
    }
    function changeCategory()
    {
        window.location.href = "/adddata?category=" + $('#select_categories').val();
    }
    function showImportBulkEmailModal()
    {
        document.getElementById('contact_type').value = $('#select_categories').val();
    }
</script>
@endsection