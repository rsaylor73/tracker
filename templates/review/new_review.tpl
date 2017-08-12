<form name="myform" action="/save_project" method="POST">
<input type="hidden" name="dotID" id="dotID" value="{$dotID}">
<div class="modal-header">
    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">New Review</h4>
</div>
<div class="modal-body">
    <div class="te">

    <div class="row top-buffer">
    	<div class="col-sm-6">Project #</div>
    	<div class="col-sm-6"><select name="dotproject" id="dotproject" class="form-control"
        onchange="check_dropdown()">
            <option selected value="">Select</option>{$options}</select></div>
    </div>



	</div>
</div>

<div class="modal-footer">
    <button type="button" onclick="javascript:window.location.reload()" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
    
</div>
</form>

<script>
function check_dropdown() {
    var dotproject = $('#dotproject :selected').val();
    var dotID = $('#dotID').val();
    var url = '/projects/' + dotID + '/' + dotproject;
    window.location.href=url;
    //window.location.href='/projects/<?=$_GET['dotID']?>/'+dotproject;
}

//function load_project() {
    //var dotproject = $('#dotproject :selected').text();

    //window.location.href='/projects/<?=$_GET['dotID']?>/'+dotproject;

//}
</script>