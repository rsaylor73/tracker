<form name="myform" action="/save_client_file" method="POST" enctype="multipart/form-data">
<input type="hidden" name="dotID" value="{$dotID}">

<div class="modal-header">
    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Upload Files For Review</h4>
</div>
<div class="modal-body">
    <div class="te">

    <div class="row top-buffer">
        <div class="col-sm-6">Project:</div>
        <div class="col-sm-6">
            <select name="projectID" class="form-control" required>
                <option selected value="">Select</option>
                {$options}
            </select>
        </div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-6">PDF File:</div>
    	<div class="col-sm-6"><input type="file" name="pdf_file" class="form-control"></div>
    </div>

</div>
</div>

<div class="modal-footer">
    <button type="button" onclick="javascript:window.location.reload()" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success btn-lg">Upload</button>
</div>
</form>