    <header class="jumbotron hero-spacer">
    <h1>Edit User</h1>
    </header>
    <hr>

    <form action="/index.php" method="post">
    <input type="hidden" name="section" value="updateuser">
    <input type="hidden" name="id" value="{$id}">
    <div class="row top-buffer">
    	<div class="col-sm-3">First Name:</div>
    	<div class="col-sm-3"><input type="text" name="first" value="{$first}" class="form-control"></div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-3">Last Name:</div>
    	<div class="col-sm-3"><input type="text" name="last" value="{$last}" class="form-control"></div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-3">Email:</div>
    	<div class="col-sm-3"><input type="text" name="email" value="{$email}" class="form-control"></div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-3">User Name:</div>
    	<div class="col-sm-3">{$uuname}</div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-3">Password:</div>
    	<div class="col-sm-3"><input type="text" name="password" placeholder="Only if you wish to change" class="form-control"></div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-6 alert alert-info">Each group inherits each other. Projects would include Reviews and Reports. Reviews would include Reports, etc. Admin includes all and Reports include only Reports.</div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-3">Group Access:</div>
    	<div class="col-sm-3">
    		<select name="groupID" class="form-control">
                {if $groupID eq "1"}<option selected value="1">Admin (Default)</option>{/if}
                {if $groupID eq "2"}<option selected value="2">Projects (Default)</option>{/if}
                {if $groupID eq "3"}<option selected value="3">Reviews (Default)</option>{/if}
                {if $groupID eq "4"}<option selected value="4">Reports (Default)</option>{/if}

    			<option value="2">Projects</option>
    			<option value="3">Reviews</option>
    			<option value="4">Reports</option>
    			<option value="1">Admin</option>
    		</select>
    	</div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-6">
    		<input type="submit" value="Update" class="btn btn-success">&nbsp;
    		<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/users'">
    	</div>
    </div>
    </form>