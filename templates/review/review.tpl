    <header class="jumbotron hero-spacer">
    <h1>Review </h1>
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
            <input type="button" value="Review" class="btn btn-primary" onclick="
                document.location.href='/viewreview/{$project_data.id}'
            ">&nbsp;

        </div>
    </div>
    {/foreach}