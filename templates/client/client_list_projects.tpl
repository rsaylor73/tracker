<form name="myform" action="/client_search_project" method="POST">
<input type="hidden" name="dotID" id="dotID" value="{$dotID}">
<div class="modal-header">
    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Customized Reports</h4>
</div>
<div class="modal-body">
    <div class="te">

    <div class="row top-buffer">
    	<div class="col-sm-6">Region/District:</div>
    	<div class="col-sm-6">
    		<select name="region" class="form-control">
    		<option selected value="">Select</option>
    		{$region}
    		</select>
    	</div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-6">DOT Project #</div>
    	<div class="col-sm-6">
    		<select name="dotproject" class="form-control">
    			<option selected value="">Select</option>
    			{$dotproject}
    		</select>
    	</div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-6">Start Date:</div>
    	<div class="col-sm-6"><input type="text" name="start_date" class="form-control date"></div>
    </div>

     <div class="row top-buffer">
    	<div class="col-sm-6">End Date:</div>
    	<div class="col-sm-6"><input type="text" name="end_date" class="form-control date"></div>
    </div>  

    <div class="row top-buffer">
    	<div class="col-sm-6">Or Year:</div>
    	<div class="col-sm-6">
    		<select name="year" class="form-control">
    		<option value="">Select</option>
    		{$year_select}
    		</select>
    	</div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-6">Or Quarter</div>
    	<div class="col-sm-6">
    		<select name="quarter" class="form-control">
    			<option selected value="">Select</option>
    			<option value="1">Q1 (Jan - Mar)</option>
    			<option value="2">Q2 (Apr - Jun)</option>
    			<option value="3">Q3 (Jul - Sep)</option>
    			<option value="4">Q4 (Oct - Dec)</option>
    		</select>
    	</div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-6">Project Type:</div>
    	<div class="col-sm-6">
    		<select name="project_type" class="form-control">
    		<option value="">Select</option>
    		{$projecttype}
    		</select>
    	</div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-6">Contact:</div>
    	<div class="col-sm-6">
    		<select name="contactID" class="form-control">
    		<option value="">Select</option>
    		{$contacts}
    		</select>
    	</div>
    </div>

	</div>
</div>

<div class="modal-footer">
	<input type="submit" value="Search" class="btn btn-success btn-lg">&nbsp;
    <button type="button" onclick="javascript:window.location.reload()" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
    
</div>
</form>

<script>
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
