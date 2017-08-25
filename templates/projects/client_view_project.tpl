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
            <input type="text" value="{$dotproject}" class="form-control" readonly>
        </div>
    </div>
    <div class="row top-buffer">
        <div class="col-sm-3"><b>Sub Account:</b></div>
        <div class="col-sm-3">
            <input type="text" value="{$subaccount}" class="form-control" readonly>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3">
            <b>Project Type:</b>
        </div>
        <div class="col-sm-3">
            <input type="text" value="{$project_type}" class="form-control" readonly>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3">
            <b>Project Description:</b>
        </div>
        <div class="col-sm-3">
            <input type="text" value="{$description}" class="form-control" readonly>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3">
            <b>Est. Cont. Cost:</b>
        </div>
        <div class="col-sm-3">
            <input type="text" value="{$est_const_cost}" class="form-control" readonly>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Estimated Ad Date:</b></div>
        <div class="col-sm-3">
            <input type="text" value="{$est_ad_date}" class="form-control" readonly>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Region / District:</b></div>
        <div class="col-sm-3">
            <input type="text" value="{$regionName}" class="form-control" readonly>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Contact:</b></div>
        <div class="col-sm-3">
            <input type="text" value="{$first} {$last}" class="form-control" readonly>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Reviews:</b></div>
        <div class="col-sm-9">
            <div class="row">
                {foreach $review as $r}
                    <div class="col-sm-2">
                        <input type="button" onclick="window.open('/pdf/{$r.id}')"
                        value="{$r.Description}" class="btn btn-primary">
                    </div>
                {/foreach}
                {if $r_error eq "1"}
                    <div class="col-sm-12 alert alert-danger">No Reviews Available</div>
                {/if}
            </div>
        </div>
    </div>

