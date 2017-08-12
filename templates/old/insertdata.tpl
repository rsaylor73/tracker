    <header class="jumbotron hero-spacer">
    <h1>Add Record </h1>

    </header>
    <hr>

    <form action="/index.php" method="POST">
    <input type="hidden" name="section" value="savedata">
    <input type="hidden" name="projectID" value="{$projectID}">

    <div class="row top-buffer">
    	<div class="col-sm-3">Page Label:</div>
    	<div class="col-sm-3"><input type="text" name="Page_Label" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Page Index:</div>
    	<div class="col-sm-3"><input type="text" name="Page_Index" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Author:</div>
    	<div class="col-sm-3"><input type="text" name="Author" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Date:</div>
    	<div class="col-sm-3"><input type="text" name="Date" required class="form-control date2"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Creation Date:</div>
    	<div class="col-sm-3"><input type="text" name="Creation_Date" required class="form-control date2"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Comments:</div>
    	<div class="col-sm-3"><input type="text" name="Comments" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Category:</div>
    	<div class="col-sm-3"><input type="text" name="Category" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Comment Type:</div>
    	<div class="col-sm-3"><input type="text" name="Comment_Type" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Discipline:</div>
    	<div class="col-sm-3"><input type="text" name="Discipline" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Importance:</div>
    	<div class="col-sm-3"><input type="text" name="Importance" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Cost Reduction:</div>
    	<div class="col-sm-3"><input type="text" name="Cost_Reduction" required class="form-control" value="$"></div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-6">
    	<input type="submit" value="Save" class="btn btn-success">&nbsp;
    	<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/viewreview/{$projectID}'">
    	</div>
    </div>
    </form>



