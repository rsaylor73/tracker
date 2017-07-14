    <header class="jumbotron hero-spacer">
    <h1>Review </h1>
    <input type="button" value="Edit Project" class="btn btn-primary btn-lg"
    onclick="document.location.href='/editproject/{$projectID}'">&nbsp;
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" 
    data-target="#myModal">Search</button>&nbsp;
    <input type="button" value="Add Record" onclick="document.location.href='/insertdata/{$projectID}'" class="btn btn-success btn-lg">

    </header>
    <hr>

    {assign var="up" value='<i class="fa fa-arrow-up" aria-hidden="true"></i>'}
    {assign var="down" value='<i class="fa fa-arrow-down" aria-hidden="true"></i>'}

    {$page_numbers}
    <div class="table-responsive">
    	<table class="table table-responsive table-striped table-hover">
    		<thead>
    			<th>
                    <b>
                    <a href="/viewreview/{$projectID}/Page_Label/DESC">{$up}</a>
                    <br>Label<br>
                    <a href="/viewreview/{$projectID}/Page_Label/ASC">{$down}</a>
                    </b>
                </th>
    			<th>
                    <b>
                    <a href="/viewreview/{$projectID}/Page_Index/DESC">{$up}</a>
                    <br>Index<br>
                    <a href="/viewreview/{$projectID}/Page_Index/ASC">{$down}</a>
                    </b>
                </th>
    			<th>
                    <b>
                    <a href="/viewreview/{$projectID}/Author/DESC">{$up}</a>
                    <br>Author<br>
                    <a href="/viewreview/{$projectID}/Author/ASC">{$down}</a>
                    </b>
                </th>
    			<th>
                    <b>
                    <a href="/viewreview/{$projectID}/Date/DESC">{$up}</a>
                    <br>Date<br>
                    <a href="/viewreview/{$projectID}/Date/ASC">{$down}</a>
                    </b>
                </th>
    			<th>
                    <b>
                    <a href="/viewreview/{$projectID}/Creation_Date/DESC">{$up}</a>
                    <br>Creation<br>
                    <a href="/viewreview/{$projectID}/Creation_Date/ASC">{$down}</a>
                    </b>
                </th>
    			<th>
                    <b>
                    <a href="/viewreview/{$projectID}/Comments/DESC">{$up}</a>
                    <br>Comments<br>
                    <a href="/viewreview/{$projectID}/Comments/ASC">{$down}</a>
                    </b>
                </th>
    			<th>
                    <b>
                    <a href="/viewreview/{$projectID}/Category/DESC">{$up}</a>
                    <br>Category<br>
                    <a href="/viewreview/{$projectID}/Category/ASC">{$down}</a>
                    </b>
                </th>
    			<th>
                    <b>
                    <a href="/viewreview/{$projectID}/Comment_Type/DESC">{$up}</a>
                    <br>Type<br>
                    <a href="/viewreview/{$projectID}/Comment_Type/ASC">{$down}</a>
                    </b>
                </th>
    			<th>
                    <b>
                    <a href="/viewreview/{$projectID}/Discipline/DESC">{$up}</a>
                    <br>Discipline<br>
                    <a href="/viewreview/{$projectID}/Discipline/ASC">{$down}</a>
                    </b>
                </th>
    			<th>
                    <b>
                    <a href="/viewreview/{$projectID}/Importance/DESC">{$up}</a>
                    <br>Importance<br>
                    <a href="/viewreview/{$projectID}/Importance/ASC">{$down}</a>
                    </b>
                </th>
    			<th>
                    <b>
                    <a href="/viewreview/{$projectID}/Cost_Reduction/DESC">{$up}</a>
                    <br>Reduction<br>
                    <a href="/viewreview/{$projectID}/Cost_Reduction/ASC">{$down}</a>
                    </b>
                </th>
                <th>&nbsp;</th>
    		</thead>
    		<tbody>
    		{foreach $review_data as $data}
    		<tr>
    			<td>{$data.Page_Label}</td>
    			<td>{$data.Page_Index}</td>
    			<td>{$data.Author}</td>
    			<td>{$data.Date}</td>
    			<td>{$data.Creation_Date}</td>
    			<td>{$data.Comments}</td>
    			<td>{$data.Category}</td>
    			<td>{$data.Comment_Type}</td>
    			<td>{$data.Discipline}</td>
    			<td>{$data.Importance}</td>
    			<td>{$data.Cost_Reduction}</td>
                <td><a href="/updatedata/{$data.projectID}/{$data.id}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
    		</tr>
    		{/foreach}
    		</tbody>
    	</table>
    </div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Search</h4>
      </div>
      <div class="modal-body">

        <form action="/index.php" method="POST" style="display:inline">
        <input type="hidden" name="section" value="viewreview">
        <input type="hidden" name="projectID" value="{$projectID}">

        <table class="table table-responsive table-striped">
        <tr>
                <td width="200">Page Label:</td>
                <td><input type="text" name="Page_Label" class="form-control"></td>
        </tr>

        <tr>
                <td width="200">Page Index:</td>
                <td><input type="text" name="Page_Index" class="form-control"></td>
        </tr>

        <tr>
                <td width="200">Author:</td>
                <td><input type="text" name="Author" class="form-control"></td>
        </tr>

        <tr>
                <td width="200">Date:</td>
                <td><input type="text" name="Date" class="form-control date2"></td>
        </tr>

        <tr>
                <td width="200">Creation Date:</td>
                <td><input type="text" name="Creation_Date" class="form-control date2"></td>
        </tr>

        <tr>
                <td width="200">Comments:</td>
                <td><input type="text" name="Comments" class="form-control"></td>
        </tr>

        <tr>
                <td width="200">Category:</td>
                <td><input type="text" name="Category" class="form-control"></td>
        </tr>

        <tr>
                <td width="200">Comment_Type:</td>
                <td><input type="text" name="Comment_Type" class="form-control"></td>
        </tr>

        <tr>
                <td width="200">Discipline:</td>
                <td><input type="text" name="Discipline" class="form-control"></td>
        </tr>

        <tr>
                <td width="200">Importance:</td>
                <td><input type="text" name="Importance" class="form-control"></td>
        </tr>

        <tr>
                <td width="200">Cost_Reduction:</td>
                <td><input type="text" name="Cost_Reduction" placeholder="$1,000" class="form-control"></td>
        </tr>

        <tr>
            <td colspan="2">
                <input type="submit" value="Search" class="btn btn-info">&nbsp;
                <input type="button" value="Reset Search" class="btn btn-warning"
                    onclick="document.location.href='/viewreview/{$projectID}'">
            </td>
        </tr>
        </table>
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
