
    <div class="row">
        <div class="col-sm-2">
            <div class="thumbnail">
                <img src="/logo/{$logo}" alt="">
            </div>
        </div>
        <div class="col-sm-10">
            <h3>Review</h3>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Project #</b></div>
        <div class="col-sm-3">
            <form name="myform1" style="display:inline">
            <input type="hidden" name="projectID" value="{$projectID}">
            <input type="hidden" name="label" value="Project #">
            <input type="text" name="dotproject" value="{$dotproject}" class="form-control" disabled readonly>
            </form>
        </div>
        <div class="col-sm-3"><b>Sub Account:</b></div>
        <div class="col-sm-3">
            <form name="myform2" style="display:inline">
            <input type="hidden" name="projectID" value="{$projectID}">
            <input type="hidden" name="label" value="Sub Account">
            <input type="text" name="subaccount" value="{$subaccount}" class="form-control" disabled readonly>
            </form>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Project Phase:</b></div>
        <div class="col-sm-3">
            <form name="myform3" style="display:inline">
            <input type="hidden" name="reviewID" value="{$reviewID}">
            <input type="hidden" name="label" value="Project Phase">
            <select name="project_phase" class="form-control"
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
            {$SubmittalTypes}</select>
            </form>
        </div>
        <div class="col-sm-6" id="ajax_results"></div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Review Type:</b></div>
        <div class="col-sm-3">
            <form name="myform4" style="display:inline">
            <input type="hidden" name="reviewID" value="{$reviewID}">
            <input type="hidden" name="label" value="Review Type">
            <select name="review_type" class="form-control"
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
                <option selected>{$review_type}</option>
                <option>Plans</option>
                <option>Specifications</option>
                <option>Cost Estimate</option>
                <option>Design Calculations</option>
            </select>
            </form>
        </div>
        <div class="col-sm-3">
        {if $found_xml eq "1"}
            <div class="alert alert-success">XML file loaded</div>
        {else}
            <div class="alert alert-danger">XML file not loaded</div>
        {/if}
        </div>
        <div class="col-sm-3">
        {if $pdf eq "1"}
            <div class="alert alert-success">PDF file loaded</div>
        {else}
            <div class="alert alert-danger">PDF file not loaded</div>
        {/if}        
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Date Received:</b></div>
        <div class="col-sm-3">
            <form name="myform5" style="display:inline">
            <input type="hidden" name="reviewID" value="{$reviewID}">
            <input type="hidden" name="label" value="Date Received">
            <input type="text" name="date_received" value="{$date_received}" class="form-control date"
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
            </form>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Date Completed:</b></div>
        <div class="col-sm-3">
            <form name="myform6" style="display:inline">
            <input type="hidden" name="reviewID" value="{$reviewID}">
            <input type="hidden" name="label" value="Date Completed">
            <input type="text" name="date_completed" value="{$date_completed}" class="form-control date"
            onblur="update_form(this.form)"
            onchange="update_form(this.form)">
            </form>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3">
            <a data-toggle="modal" 
            style="text-decoration:none; color:#FFFFFF;"
            href="/upload_xml/{$reviewID}" 
            data-target="#myModal" data-backdrop="static" data-keyboard="false" 
            class="btn btn-primary btn-lg btn-block" 
            >Upload XML</a>
        </div>
        <div class="col-sm-3">
            <a data-toggle="modal" 
            style="text-decoration:none; color:#FFFFFF;"
            href="/upload_pdf/{$reviewID}" 
            data-target="#myModal" data-backdrop="static" data-keyboard="false" 
            class="btn btn-info btn-lg btn-block" 
            >Upload PDF</a>
        </div>
        <div class="col-sm-3">
            <a data-toggle="modal" 
            style="text-decoration:none; color:#FFFFFF;"
            href="/upload_cost/{$reviewID}" 
            data-target="#myModal" data-backdrop="static" data-keyboard="false" 
            class="btn btn-success btn-lg btn-block" 
            >Upload Cost Reduction</a>
        </div>

        <div class="col-sm-3">
            <input type="button" value="Delete Review" class="btn btn-danger btn-lg btn-block"
            onclick="if(confirm('You are about to delete this review. Click OK to continue.')) {
                document.location.href='/deletereview/{$reviewID}'
            }">
    </div>

    <div class="row top-buffer">
        <div class="col-sm-12">&nbsp;</div>
    </div>

    <div class="jumbotron">
        {if $no_charts ne "1"}
        <div class="row top-buffer">
            <div class="col-sm-6">
                <div id="container1" style="min-width: 200px; height: 400px; margin: 0 auto"></div>
            </div>
            <div class="col-sm-6">
                <div id="container2" style="min-width: 200px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>
        <br>
        <div class="row top-buffer">
            <div class="col-sm-6">
                <div id="container3" style="min-width: 200px; height: 400px; margin: 0 auto"></div>
            </div>
            <div class="col-sm-6">
                <div id="container4" style="min-width: 200px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>
        {else}
        <div class="row top-buffer">
            <div class="col-sm-12 alert alert-info">
                Upload an XML file to generate charts 
            </div>
        </div>
        {/if}

    </div>

    <div class="jumbotron table-responsive">
        <table class="table table-responsive table-striped table-hover" id="myTable">
        <thead>
            <tr>
            <th>Label</th>
            <th>Author</th>
            <th>Comments</th>
            <th>Category</th>
            <th>Type</th>
            <th>Discipline</th>
            <th>Importance</th>
            <th>Cost Reduction</th>
            </tr>
        </thead>
        <tbody>
        {foreach $dataview as $data}
            <tr>
                <td>{$data.Page_Label}</td>
                <td>{$data.Author}</td>
                <td>{$data.Comments}</td>
                <td>{$data.Category}</td>
                <td>{$data.Comment_Type}</td>
                <td>{$data.Discipline}</td>
                <td>{$data.Importance}</td>
                <td>{$data.Cost_Reduction}</td>
            </tr>
        {/foreach}
        </tbody>
        </table>
    </div>

   <!-- Modal -->
   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Loading please wait...</h4>

               </div>
               <div class="modal-body"><div class="te"></div></div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <button type="button" class="btn btn-primary">Save changes</button>
               </div>
           </div>
           <!-- /.modal-content -->
       </div>
       <!-- /.modal-dialog -->
   </div>
   <!-- /.modal -->

<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});

function update_form(myform) {
    $.get('/ajax/update_form.php',
    $(myform).serialize(),
    function(php_msg) {
        $("#ajax_results").html(php_msg);
    });
}
</script>
