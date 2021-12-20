<div 
        class="modal fade" 
        id="newMailerModal" 
        tabindex="-1" 
        aria-labelledby="newMailerModalLabel" 
        aria-hidden="true"
        
    >
        <div class="modal-dialog" style="width: 800px; max-width: 800px !important; padding:20px;">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="newMailerModalLabel">Add new Mailer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- <div class="d-flex">
                        <input type="edit" class="form-control" id="new-mailer-input" name="new-mailer-input">
                    </div> --}}
                    <div>
                        <div style="margin-top:10px" class="row">
                            <div class="col-6">
                                <span><b>First Name</b></span>
                                <input style="margin-top:5px" type="email" class="form-control" id="input-first-name" name="input-first-name">    
                            </div>
                            <div class="col-6">
                                <span><b>Last Name</b></span>
                            <input style="margin-top:5px" type="email" class="form-control" id="input-last-name" name="input-last-name">
                            </div>
                        </div>
                        <div style="margin-top:10px" class="row">
                            <div class="col-6">
                                <span><b>Mail</b></span>
                                <input style="margin-top:5px" type="email" class="form-control" id="input-email" name="input-email">
                            </div>
                            <div class="col-6">
                                <span><b>Telegram ID</b></span>
                                <input style="margin-top:5px" type="text" class="form-control" id="input-telegram" name="input-telegram">
                            </div>
                        </div>
                        <div style="margin-top:10px" class="row">
                            <div class="col-6">
                                <span><b>Discord ID</b></span>
                                <input style="margin-top:5px" type="text" class="form-control" id="input-discord" name="input-discord">
                            </div>
                            <div class="col-6">
                                <span><b>Twitter ID</b></span>
                                <input style="margin-top:5px" type="text" class="form-control" id="input-twitter" name="input-twitter">
                            </div>
                        </div>
                        <div style="margin-top:10px" class="row">
                            <div class="col-6">
                                <span><b>Slack ID</b></span>
                                <input style="margin-top:5px" type="text" class="form-control" id="input-slack" name="input-slack">
                            </div>
                            <div class="col-6">
                                <span><b>Mobile Number</b></span>
                                <input style="margin-top:5px" type="text" class="form-control" id="input-phone" name="input-phone">
                            </div>
                        </div>
                        <div style="margin-top:10px">
                            <span><b>Category</b></span>
                            <select id="select_mailer_category" name="select_mailer_category" class="form-select">
                                @foreach ($mailer_categories as $mailer_category)
                                    <option value="{{ $mailer_category->id }}">{{ $mailer_category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" style="width:100%" id="btnAddContact" name="btnAddContact" onclick="addNewMailerInfo()">Add</button>
                    {{-- onclick="addData()" --}}
                </div>
            </div>
        </div>
    </div>
