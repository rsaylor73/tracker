    <form name="myform" action="/index.php" method="post">
    <input type="hidden" name="section" value="save_review">
    <input type="hidden" name="id" value="{$id}">
    <div class="row top-buffer">
    	<div class="col-sm-6 panel panel-info">
    		<h3>New Review</h3>
    	</div>
    </div>
    <div class="row top-buffer">
 		<div class="col-sm-3">Project #:</div>
 		<div class="col-sm-3">{$dotproject}</div>
 	</div>
 	<div class="row top-buffer">
 		<div class="col-sm-3">Sub Account #:</div>
 		<div class="col-sm-3">{$subaccount}</div>
 	</div>
 	<div class="row top-buffer">
 		<div class="col-sm-3">Project Description:</div>
 		<div class="col-sm-3">{$description}</div>
 	</div>
 	<div class="row top-buffer">
 		<div class="col-sm-3">Region/District:</div>
 		<div class="col-sm-3">{$region}</div>
 	</div>
 	<div class="row top-buffer">
 		<div class="col-sm-3">Project Type:</div>
 		<div class="col-sm-3">{$project_type}</div>
 	</div>

 	<div class="row top-buffer">
 		<div class="col-sm-3">Review Type:</div>
 		<div class="col-sm-3"><select name="review_type" required class="form-control">
 			<option selected value="">Select</option>
 			<option>Plans</option>
 			<option>Specifications</option>
 			<option>Cost Estimate</option>
 			<option>Design Calculations</option>
 		</select></div>
 	</div>
 	<div class="row top-buffer">
 		<div class="col-sm-3">Project Phase:</div>
 		<div class="col-sm-3">
 			<select name="project_phase" required class="form-control">
 				<option selected value="">Select</option>
 				{$SubmittalTypes}
 			</select>
 		</div>
 	</div>
 	<div class="row top-buffer">
 		<div class="col-sm-3">
 			Date Received:
 		</div>
 		<div class="col-sm-3">
 			<input type="text" name="date_received" class="form-control date">
 		</div>
 	</div>
 	<div class="row top-buffer">
 		<div class="col-sm-6">
 			<input type="submit" value="Save" class="btn btn-success btn-block">
 		</div>
 	</div>
 	</form>

