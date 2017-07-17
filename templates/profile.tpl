    <header class="jumbotron hero-spacer">
    <h1>Profile </h1>
    </header>
    <hr>
    <form action="/index.php" method="post">
    <input type="hidden" name="section" value="update_profile">
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
        <div class="col-sm-3">Username:</div>
        <div class="col-sm-3">{$uuname}</div>
    </div>
    <div class="row top-buffer">
        <div class="col-sm-3">Password:</div>
        <div class="col-sm-3"><input type="password" name="password" placeholder="Enter new if you wish to change" class="form-control"></div>
    </div>
    <div class="row top-buffer">
        <div class="col-sm-6">
            <input type="submit" value="Update" class="btn btn-success">&nbsp;
            <input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/'">
        </div>
    </div>
    </form>
