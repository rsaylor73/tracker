<form name="myform">
<div class="modal-header">
    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Select Project</h4>
</div>
<div class="modal-body">
    <div class="te">

    <div class="row top-buffer">
    	<div class="col-sm-6">Project #</div>
    	<div class="col-sm-6">
    		<select name="dotproject" id="dotproject" class="form-control" onchange="check_dropdown(this.form)">
            <option selected value="">Select</option>
            {$options}
            </select>
        </div>
    </div>

    <div id="ajax_results"></div>


    </div>
</div>

<div class="modal-footer">
    <button type="button" onclick="javascript:window.location.reload()" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
    
</div>
</form>


<script>

function check_dropdown() {

    var project = $('#dotproject :selected').val();
    var url = '/client_view_project/' + project;
    window.location.href=url;
    
}

</script>