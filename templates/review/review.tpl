
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
            <input type="text" name="dotproject" value="{$dotproject}" class="form-control">
        </div>
        <div class="col-sm-3"><b>Sub Account:</b></div>
        <div class="col-sm-3">
            <input type="text" name="subaccount" value="{$subaccount}" class="form-control">
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Project Phase:</b></div>
        <div class="col-sm-3">
            <select name="project_phase" class="form-control">{$SubmittalTypes}</select>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Review Type:</b></div>
        <div class="col-sm-3">
            <select name="review_type" class="form-control">
                <option selected>{$review_type}</option>
                <option>Plans</option>
                <option>Specifications</option>
                <option>Cost Estimate</option>
                <option>Design Calculations</option>
            </select>
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Date Received:</b></div>
        <div class="col-sm-3">
            <input type="text" name="date_received" value="{$date_received}" class="form-control date">
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-3"><b>Date Completed:</b></div>
        <div class="col-sm-3">
            <input type="text" name="date_completed" value="{$date_completed}" class="form-control date">
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-4">
            <a data-toggle="modal" 
            style="text-decoration:none; color:#FFFFFF;"
            href="/upload_xml/{$reviewID}" 
            data-target="#myModal" data-backdrop="static" data-keyboard="false" 
            class="btn btn-primary btn-lg btn-block" 
            >Upload XML</a>
        </div>
        <div class="col-sm-4">
            <input type="button" value="Upload PDF" class="btn btn-info btn-lg btn-block">
        </div>
        <div class="col-sm-4">
            <input type="button" value="Upload Cost Reduction" class="btn btn-success btn-lg btn-block">
        </div>
    </div>

    <div class="row top-buffer">
        <div class="col-sm-12">&nbsp;</div>
    </div>

    <div class="jumbotron">
        <div class="row">
            <div class="col-sm-12"><h4>Graphs</h4></div>
        </div>

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
                    <h4 class="modal-title"></h4>

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
</script>
