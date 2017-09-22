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

    <div class="table-responsive">
        <table class="table table-striped table-hover sortable">
            <thead>
                <tr>
                    <th>
                    <span class="btn btn-warning">
                    <input type="checkbox" id="checkAll" class="checkAll" checked > Toggle
                    </span>
                    </th>
                    <th><b>DOT Project #</b></th>
                    <th><b>Sub Account</b></th>
                    <th><b>Region/District</b></th>
                    <th width="250"><b>Project Description</b></th>
                    <th><b>Project Type</b></th>
                    <th><input type="submit" value="Report" class="btn btn-success btn-block"></th>
                </tr>
            </thead>
            <tbody>
            {foreach $results as $r}
            <tr>
                <td>
                    <input type="checkbox" name="p{$r.id}" value="checked" class="checkItem" id="p{$r.id}" checked>
                </td>
                <td>
                    <a href="/view_project/{$r.id}">{$r.dotproject}</a>
                </td>
                <td>
                    {$r.subaccount}
                </td>
                <td>
                    {$r.region_name}
                </td>
                <td>
                    {$r.description}
                </td>
                <td>
                    {$r.project_type}
                </td>
                <td>
                    <input type="button" value="Delete" class="btn btn-danger" onclick="
                    if(confirm('You are about to delete this project and all the reviews it is part of. Click OK to continue.')) {
                            document.location.href='/deleteproject/{$r.id}'
                    }
                    ">
                </td>
            </tr>
            {/foreach}
            </tbody>
        </table>
    </div>


</form>

<script>
$('#mybutton').click(function(e) {
    $(':checkbox').each(function(i,item){
        $(item).attr('checked', !$(item).is(':checked'));
    });
});

$('.checkAll').click(function () {    
    $(':checkbox.checkItem').prop('checked', this.checked);    
 });
</script>
