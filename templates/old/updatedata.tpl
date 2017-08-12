    <header class="jumbotron hero-spacer">
    <h1>Update Record </h1>

    </header>
    <hr>

    <form action="/index.php" method="POST">
    <input type="hidden" name="section" value="saveupdatedata">
    <input type="hidden" name="projectID" value="{$projectID}">
    <input type="hidden" name="id" value="{$id}">

    <div class="row top-buffer">
    	<div class="col-sm-3">Page Label:</div>
    	<div class="col-sm-3"><input type="text" name="Page_Label" value="{$Page_Label}" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Page Index:</div>
    	<div class="col-sm-3"><input type="text" name="Page_Index" value="{$Page_Index}" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Author:</div>
    	<div class="col-sm-3"><input type="text" name="Author" value="{$Author}" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Date:</div>
    	<div class="col-sm-3"><input type="text" name="Date" value="{$Date}" required class="form-control date2"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Creation Date:</div>
    	<div class="col-sm-3"><input type="text" name="Creation_Date" value="{$Creation_Date}" required class="form-control date2"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Comments:</div>
    	<div class="col-sm-3"><input type="text" name="Comments" value="{$Comments}" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Category:</div>
    	<div class="col-sm-3"><input type="text" name="Category" value="{$Category}" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Comment Type:</div>
    	<div class="col-sm-3"><input type="text" name="Comment_Type" value="{$Comment_Type}" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Discipline:</div>
    	<div class="col-sm-3"><input type="text" name="Discipline" value="{$Discipline}" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Importance:</div>
    	<div class="col-sm-3"><input type="text" name="Importance" value="{$Importance}" required class="form-control"></div>
    </div>

    <div class="row top-buffer">
    	<div class="col-sm-3">Cost Reduction:</div>
    	<div class="col-sm-3"><input type="text" name="Cost_Reduction" value="{$Cost_Reduction}" required class="form-control" value="$"></div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-6">
    	<input type="submit" value="Update" class="btn btn-success">&nbsp;
    	<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/viewreview/{$projectID}'">
    	</div>
    </div>
    </form>



