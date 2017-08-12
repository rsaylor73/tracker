
<form name="myform" action="/save_project" method="POST">
<input type="hidden" name="dotID" value="{$dotID}">
<div class="modal-header">
    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">New Project</h4>
</div>
<div class="modal-body">
    <div class="te">

    <div class="row top-buffer">
 		<div class="col-sm-6">DOT Project #: <div id="dots"></div></div>
 		<div class="col-sm-6"><input type="text" name="dotproject" required class="form-control"
        onchange="check_dot(this.form)"
        onblur="check_dot(this.form)"
        ></div>
    </div>
    <div class="row top-buffer">
 		<div class="col-sm-6">Sub Account:</div>
 		<div class="col-sm-6"><input type="text" name="subaccount" class="form-control"></div>
 	</div>

    <div class="row top-buffer">
        <div class="col-sm-6">Project Description:</div>
        <div class="col-sm-6"><input type="text" name="description" class="form-control"></div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-6">Region / District:</div>
        <div class="col-sm-6"><select name="regionID" required class="form-control">
            <option selected value="">Select</option>
            {$region}
            </select>
        </div>
    </div>

 	<div class="row top-buffer">
 		<div class="col-sm-6">Project Type:</div>
 		<div class="col-sm-6"><select name="projecttypeID" required class="form-control">
 			<option selected value="">Select</option>
 			{$projecttype}
 			</select>
 		</div>
 	</div>

    <div class="row top-buffer">
        <div class="col-sm-6">Estimated Construction Cost:</div>
        <div class="col-sm-6"><input type="text" name="est_const_cost" class="form-control"></div>
    </div>

 	<div class="row top-buffer">
 		<div class="col-sm-6">Estimated Ad Date:</div>
 		<div class="col-sm-6">
 			<input type="text" name="est_ad_date" class="form-control date">
 		</div>
    </div>

    <div id="contacts">
 	<div class="row top-buffer">
 		<div class="col-sm-6">Contact:</div>
 		<div class="col-sm-4" id="contacts">
            <select name="contacts" class="form-control">{$contacts}</select>
        </div>
        <div class="col-sm-2"><input type="button" value="Add New" onclick="new_contact(this.form)" class="btn btn-primary"></div>
    </div>
    </div>


</div>
</div>

<div class="modal-footer">
    <button type="button" onclick="javascript:window.location.reload()" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success btn-lg">Save Project</button>
</div>
</form>



<script>
function new_contact(myform) {
	$.get('/ajax/new_contact.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#contacts").html(php_msg);
	});
}

function check_dot(myform) {
    $.get('/ajax/check_dot.php',
    $(myform).serialize(),
    function(php_msg) {
        $("#dots").html(php_msg);
    });
}
function release_button() {
    document.getElementById('s1').disabled = false;
}

$(function() {
    $( ".date" ).datepicker({ 
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: "-2Y", 
        maxDate: "+5Y"
    });
});

</script>

