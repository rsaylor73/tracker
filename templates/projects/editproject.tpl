    <header class="jumbotron hero-spacer">
    <h1>Edit Project</h1>
    <input type="button" value="Project" class="btn btn-primary btn-lg"
    onclick="document.location.href='/editproject/{$id}'">&nbsp;
    <input type="button" value="Review" class="btn btn-primary btn-lg"
    onclick="document.location.href='/viewreview/{$id}'">&nbsp;
    <input type="button" value="Reports" class="btn btn-primary btn-lg"
    onclick="document.location.href='/viewreport/{$id}'">
    </header>
    <hr>
    <form name="myform" enctype="multipart/form-data" action="/index.php" method="post">
    <input type="hidden" name="section" value="update_project">
    <input type="hidden" name="id" value="{$id}">
    <div class="row top-buffer">
 		<div class="col-sm-3">DOT Project #:</div>
 		<div class="col-sm-3"><input type="text" name="dotproject" value="{$dotproject}" required class="form-control"></div>
 		<div class="col-sm-3">Sub Account #:</div>
 		<div class="col-sm-3"><input type="text" name="subaccount" value="{$subaccount}" required class="form-control"></div>
 	</div>

 	<div class="row top-buffer">
 		<div class="col-sm-3">Browse PDF File:</div>
 		<div class="col-sm-3"><input type="file" name="pdf_file" class="btn btn-info form-control"
        {if $pdf_filename ne ""}
        onclick="alert('You only need to upload a PDF file if you need to replace the current file or it was not uploaded prior. To continue select a PDF file or click cancel when prompted for a file.')"
        {/if}
        ></div>
        <div class="col-sm-6">
            {if $pdf_filename ne ""}
                <a href="/view_pdf.php?pdf_file={$pdf_filename}" target="_blank" 
                class="btn btn-info">Download PDF File</a>
            {else}
                <div class="alert alert-danger">The PDF file is missing</div>
            {/if}
        </div>
 	</div>

 	<div class="row top-buffer">
 		<div class="col-sm-3">Submittal Type:</div>
 		<div class="col-sm-3"><select name="submittalID" required class="form-control">
 			<option selected value="">Select</option>
 			{$SubmittalTypes}
 			</select>
 		</div>
 		<div class="col-sm-3">Project Type:</div>
 		<div class="col-sm-3"><select name="projecttypeID" required class="form-control">
 			<option selected value="">Select</option>
 			{$projecttype}
 			</select>
 		</div>
 	</div>

 	<div class="row top-buffer">
 		<div class="col-sm-3">Route:</div>
 		<div class="col-sm-3"><input type="text" name="route" value="{$route}" required class="form-control"></div>
 		<div class="col-sm-3">Estimated Construction Cost:</div>
 		<div class="col-sm-3"><input type="text" name="est_const_cost" value="{$est_const_cost}" class="form-control"></div>
 	</div>

 	<div class="row top-buffer">
 		<div class="col-sm-3">Estimated Ad Date:</div>
 		<div class="col-sm-3">
 			<input type="text" name="est_ad_date" value="{$est_ad_date}" class="form-control date">
 		</div>
 		<div class="col-sm-3">Date Received:</div>
 		<div class="col-sm-3">
 			<input type="text" name="date_received" value="{$date_received}" class="form-control date">
 		</div>
 	</div>

 	<div class="row top-buffer">
 		<div class="col-sm-3">Date Completed:</div>
 		<div class="col-sm-3">
 			<input type="text" name="date_completed" value="{$date_completed}" class="form-control date">
 		</div>
 		<div class="col-sm-3">Region/District:</div>
 		<div class="col-sm-3"><select name="regionID" class="form-control">
 			<option selected value="">Select</option>
 			{$region}
 			</select>
 		</div>
 	</div>

 	<div id="new_agency">
 	<div class="row top-buffer">
 		<div class="col-sm-3">Agency:</div>
 		<div class="col-sm-2">
 			<select name="agencyID" class="form-control" required onchange="get_contacts(this.form)">
 			<option selected value="">Select</option>
 			{$agency}
 			</select>
 		</div>
 		<div class="col-sm-1">
 			<input type="button" value="Add" class="btn btn-primary" onclick="new_agency(this.form)">
 		</div>
        <div class="col-sm-3">Contact:</div>
        <div class="col-sm-3" id="contacts">
            <select name="contactID" class="form-control">
                {$contacts}
            </select>
        </div>
 	</div>
 	</div>

 	<div class="row top-buffer">
 		<div class="col-sm-12">
 			<input type="submit" value="Update Project" id="s1" class="btn btn-success">&nbsp;
 			<input type="button" value="Cancel" class="btn btn-warning" 
 				onclick="document.location.href='/projects'">
 		</div>
 	</div>


 	</form>

<script>
function new_agency(myform) {
	$.get('/ajax/new_agency.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#new_agency").html(php_msg);
	});
}
function get_contacts(myform) {
    $.get('/ajax/get_contacts.php',
    $(myform).serialize(),
    function(php_msg) {
        $("#contacts").html(php_msg);
    });
}
function release_button() {
    document.getElementById('s1').disabled = false;
}
</script>

