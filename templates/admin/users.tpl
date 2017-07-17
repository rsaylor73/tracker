    <header class="jumbotron hero-spacer">
    <h1>Users <input type="button" value="Add New User" class="btn btn-success btn-lg" onclick="document.location.href='/newuser'"></h1>
    </header>
    <hr>
    <div class="row top-buffer">
        <div class="col-sm-3"><b>Name</b></div>
        <div class="col-sm-3"><b>Access</b></div>
        <div class="col-sm-3"><b>Email</b></div>
        <div class="col-sm-3">&nbsp;</div>
    </div>
    {foreach $users as $user}
    <div class="row top-buffer">
        <div class="col-sm-3">{$user.first} {$user.last}</div>
        <div class="col-sm-3">{$user.group_name}</div>
        <div class="col-sm-3">{$user.email}</div>
        <div class="col-sm-3">
            <input type="button" value="Edit" class="btn btn-primary" onclick="
                document.location.href='/edituser/{$user.id}'
            ">&nbsp;
            <input type="button" value="Delete" class="btn btn-danger" onclick="
            if(confirm('You are about to delete {$user.first} {$user.last}. Click OK to continue.')) {
                document.location.href='/deleteuser/{$user.id}';
            }">
        </div>
    </div>
    {/foreach}