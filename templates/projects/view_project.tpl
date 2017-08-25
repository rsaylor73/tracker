

    <div class="row">
        <div class="col-sm-2">
            <div class="thumbnail">
                <img src="/logo/{$logo}" alt="">
            </div>
        </div>
        <div class="col-sm-10">
            <h3>Projects : View</h3>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>DOT Project #</b></div>
        <div class="col-sm-3">
            <form name="myform1" style="display:inline">
            <input type="hidden" name="projectID" value="{$projectID}">
            <input type="hidden" name="label" value="Project #">
            <input type="text" name="dotproject" value="{$dotproject}" class="form-control"
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
            </form>
        </div>
        <div class="col-sm-3">
            <div id="ajax_results"></div>
        </div>
    </div>
    <div class="row top-buffer">
        <div class="col-sm-3"><b>Sub Account:</b></div>
        <div class="col-sm-3">
            <form name="myform2" style="display:inline">
            <input type="hidden" name="projectID" value="{$projectID}">
            <input type="hidden" name="label" value="Sub Account">
            <input type="text" name="subaccount" value="{$subaccount}" class="form-control"
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
            </form>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3">
            <b>Project Type:</b>
        </div>
        <div class="col-sm-3">
            <form name="myform3" style="display:inline">
            <input type="hidden" name="projectID" value="{$projectID}">
            <input type="hidden" name="label" value="projecttypeID">
            <select name="projecttypeID" class="form-control"            
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
            {$projecttype}</select>
            </form>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3">
            <b>Project Description:</b>
        </div>
        <div class="col-sm-3">
            <form name="myform4" style="display:inline">
            <input type="hidden" name="projectID" value="{$projectID}">
            <input type="hidden" name="label" value="description">
            <input type="text" name="description" value="{$description}" class="form-control"
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
            </form>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3">
            <b>Est. Cont. Cost:</b>
        </div>
        <div class="col-sm-3">
            <form name="myform5" style="display:inline">
            <input type="hidden" name="projectID" value="{$projectID}">
            <input type="hidden" name="label" value="est_const_cost">
            <input type="text" name="est_const_cost" value="{$est_const_cost}" class="form-control"
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
            </form>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Estimated Ad Date:</b></div>
        <div class="col-sm-3">
            <form name="myform5" style="display:inline">
            <input type="hidden" name="projectID" value="{$projectID}">
            <input type="hidden" name="label" value="est_ad_date">
            <input type="text" name="est_ad_date" value="{$est_ad_date}" class="form-control date"
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
            </form>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Region / District:</b></div>
        <div class="col-sm-3">
            <form name="myform6" style="display:inline">
            <input type="hidden" name="projectID" value="{$projectID}">
            <input type="hidden" name="label" value="regionID">
            <select name="regionID" required class="form-control"
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
            {$region}
            </select>
            </form>
        </div>
    </div>

    <form name="myform7" style="display:inline">
    <input type="hidden" name="dotID" value="{$dotID}">
    <input type="hidden" name="mode" value="view">
    <input type="hidden" name="projectID" value="{$projectID}">
    <input type="hidden" name="label" value="contactID">
    <div id="contacts">
    <div class="row top-buffer">
        <div class="col-sm-3"><b>Contact:</b></div>
        <div class="col-sm-3" id="contacts">
            <select name="contacts" class="form-control"
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
            {$contacts}</select>
        </div>
        <div class="col-sm-6"><input type="button" value="Add New" onclick="new_contact(this.form)" class="btn btn-primary"></div>
    </div>
    </div>
    </form>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Reviews:</b></div>
        <div class="col-sm-9">
            <div class="row">
                {foreach $review as $r}
                    <div class="col-sm-2">
                        <input type="button" onclick="document.location.href='/review/{$r.id}'"
                        value="{$r.Description}" class="btn btn-primary">
                    </div>
                {/foreach}
                {if $r_error eq "1"}
                    <div class="col-sm-12 alert alert-danger">No Reviews Available</div>
                {/if}
            </div>
        </div>
    </div>

<script>
function new_contact(myform) {
    $.get('/ajax/new_contact.php',
    $(myform).serialize(),
    function(php_msg) {
        $("#contacts").html(php_msg);
    });
}

function update_form(myform) {
    $.get('/ajax/update_form.php',
    $(myform).serialize(),
    function(php_msg) {
        $("#ajax_results").html(php_msg);
    });
}
</script>

