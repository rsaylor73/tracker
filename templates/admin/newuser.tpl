    <header class="jumbotron hero-spacer">
    <h1>New User</h1>
    </header>
    <hr>

    <form action="index.php" method="post">
    <input type="hidden" name="section" value="saveuser">
    <div class="row top-buffer">
    	<div class="col-sm-3">First Name:</div>
    	<div class="col-sm-3"><input type="text" name="first" class="form-control"></div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-3">Last Name:</div>
    	<div class="col-sm-3"><input type="text" name="last" class="form-control"></div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-3">Email:</div>
    	<div class="col-sm-3"><input type="text" name="email" class="form-control"></div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-3">User Name:</div>
    	<div class="col-sm-3"><input type="text" name="uuname" class="form-control"></div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-3">Password:</div>
    	<div class="col-sm-3"><input type="text" name="password" class="form-control"></div>
    </div>
    <div class="row top-buffer">
        <div class="col-sm-3">User Type:</div>
        <div class="col-sm-3">
            <select name="userType" class="form-control" required>
                <option value="">Select</option>
                <option>staff</option>
                <option>client</option>
            </select>
        </div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-6 alert alert-info"><b>Staff Only</b> : Each group inherits each other. Projects would include Reviews and Reports. Reviews would include Reports, etc. Admin includes all and Reports include only Reports.</div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-3">Group Access:</div>
    	<div class="col-sm-3">
    		<select name="groupID" class="form-control">
    			<option value="2">Projects</option>
    			<option value="3">Reviews</option>
    			<option value="4">Reports</option>
    			<option value="1">Admin</option>
                <option value="5">N/A</option>
    		</select>
    	</div>
    </div>
    <div class="row top-buffer">
    	<div class="col-sm-6">
    		<input type="submit" value="Save" class="btn btn-success">&nbsp;
    		<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/users'">
    	</div>
    </div>
    </form>