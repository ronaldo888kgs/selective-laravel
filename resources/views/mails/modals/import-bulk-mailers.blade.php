
<div 
        class="modal fade" 
        id="importBulkMailerModal" 
        tabindex="-1" 
        aria-labelledby="importBulkMailerModalLabel" 
        aria-hidden="true"
        
    >
        <div class="modal-dialog" style="width: 800px; max-width: 800px !important; padding:20px;">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="importBulkMailerModalLabel">Import Bulk Emails</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('add_bulk_contacts') }}" enctype="multipart/form-data" class="d-flex align-items-center">
                    @csrf
                    <div class="modal-body">    
                        <input type="hidden" id="contact_type" name="contact_type" value='0'>
                        <input type="file" name="file" class="custom-file-input" id="customFile">        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Import data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>