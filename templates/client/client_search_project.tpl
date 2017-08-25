<style>
.row-striped:nth-of-type(odd){
  background-color: #efefef;
}

.row-striped:nth-of-type(even){
  background-color: #ffffff;
}
</style>
<form action="/" method="POST">
<input type="hidden" name="section" value="client_view_report">
<input type="hidden" name="dotID" value="{$dotID}">

    <div class="row">
        <div class="col-sm-2">
            <div class="thumbnail">
                <img src="/logo/{$logo}" alt="">
            </div>
        </div>
        <div class="col-sm-10">
            <h3>Projects : Results</h3>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-1">
            <input type="button" value="Toggle" class="btn btn-warning" id="mybutton">
        </div>
        <div class="col-sm-2"><b>DOT Project #</b></div>
        <div class="col-sm-2"><b>Sub Account</b></div>
        <div class="col-sm-2"><b>Region/District</b></div>
        <div class="col-sm-2"><b>Project Description</b></div>
        <div class="col-sm-2"><b>Project Type</b></div>
        <div class="col-sm-1"><input type="submit" value="Report" class="btn btn-success btn-block"></div>
    </div>


    {foreach $results as $r}
    <div class="row top-buffer row-striped">
        <div class="col-sm-1">
            <input type="checkbox" name="p{$r.id}" value="checked" id="p{$r.id}" checked>
        </div>
        <div class="col-sm-2">
            <a href="/client_view_project/{$r.id}">{$r.dotproject}</a>
        </div>
        <div class="col-sm-2">
            {$r.subaccount}
        </div>
        <div class="col-sm-2">
            {$r.region_name}
        </div>
        <div class="col-sm-2">
            {$r.description}
        </div>
        <div class="col-sm-3">
            {$r.project_type}
        </div>
    </div>
    {/foreach}
</form>

<script>
$('#mybutton').click(function(e) {
    $(':checkbox').each(function(i,item){
        $(item).attr('checked', !$(item).is(':checked'));
    });
});
</script>
