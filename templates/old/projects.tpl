    <header class="jumbotron hero-spacer">
    <h1>Projects <input type="button" value="Add New Project" class="btn btn-success btn-lg" onclick="document.location.href='/newproject'"></h1>
    </header>
    <hr>
    <div class="row top-buffer">
        <div class="col-sm-3"><b>DOT Project</b></div>
        <div class="col-sm-3"><b>Sub Account</b></div>
        <div class="col-sm-3"><b>Submittal Type</b></div>
        <div class="col-sm-3">&nbsp;</div>
    </div>
    {foreach $project as $project_data}
    <div class="row top-buffer">
        <div class="col-sm-3">{$project_data.dotproject}</div>
        <div class="col-sm-3">{$project_data.subaccount}</div>
        <div class="col-sm-3">{$project_data.Description}</div>
        <div class="col-sm-3">
            <input type="button" value="Edit" class="btn btn-primary" onclick="
                document.location.href='/editproject/{$project_data.id}'
            ">&nbsp;
            <input type="button" value="Delete" class="btn btn-danger" onclick="
            if(confirm('You are about to delete {$project_data.dotproject}. Click OK to continue.')) {
                document.location.href='/deleteproject/{$project_data.id}';
            }">
        </div>
    </div>
    {/foreach}
