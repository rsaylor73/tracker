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


<div class="row top-buffer">
	<div class="col-sm-2">
		<div class="thumbnail">
			<img src="/logo/{$logo}"><br>
		</div>
	</div>

	<div class="col-sm-5">
		<div id="container1" style="min-width: 400px; max-width: 600px; height: 400px; margin: 0 auto"></div>
	</div>
	<div class="col-sm-5">
		<div id="container2" style="min-width: 400px; max-width: 600px; height: 400px; margin: 0 auto"></div>
	</div>
</div>

<div class="row top-buffer">
	<div class="col-sm-4">
		<div class="row">
			<div class="col-sm-12">
				<div id="container4" style="min-width: 200px; height: 300px; margin: 0 auto"></div>
			</div>
		</div>
		<div class="row top-buffer">
			<div class="col-sm-6">Total number of comments</div>
			<div class="col-sm-6">
				<div id="odometer" class="odometer">{$total_comments}</div>
			</div>
		</div>
		<div class="row top-buffer">
			<div class="col-sm-6">Average Comments per Review</div>
			<div class="col-sm-6">
				<div id="odometer" class="odometer">{$total_comments_avg}</div>
			</div>
		</div>
		<div class="row top-buffer">
			<div class="col-sm-6">Cost Reduction:</div>
			<div class="col-sm-6">${$total_cost_reduction|number_format:0:".":","}</div>
		</div>
		<div class="row top-buffer">
			<div class="col-sm-6">Potential Cost Savings:</div>
			<div class="col-sm-6">$243,121</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div id="container3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	</div>
</div>


<div class="row top-buffer">
	<div class="col-sm-4">&nbsp;</div>
	<div class="col-sm-4">
	    <a data-toggle="modal" 
	    style="text-decoration:none; color:#FFFFFF;"
	    href="/client_list_project/{$id}" 
	    data-target="#myModal" data-backdrop="static" data-keyboard="false" 
	    class="btn btn-primary btn-lg btn-block" 
	    >Customized Reports</a>
	</div>
	<div class="col-sm-4">
	    <a data-toggle="modal" 
	    style="text-decoration:none; color:#FFFFFF;"
	    href="/client_load_project/{$id}" 
	    data-target="#myModal" data-backdrop="static" data-keyboard="false" 
	    class="btn btn-success btn-lg btn-block" 
	    >Reviews</a>
	</div>
	<!--
	<div class="col-sm-3">
		
	    <a data-toggle="modal" 
	    style="text-decoration:none; color:#FFFFFF;"
	    href="/client_upload_file/{$id}" 
	    data-target="#myModal" data-backdrop="static" data-keyboard="false" 
	    class="btn btn-info btn-lg btn-block" 
	    >Upload Files For Review</a>
	</div>
	-->

</div>