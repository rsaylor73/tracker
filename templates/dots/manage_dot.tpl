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


{if $error eq "1"}
<div class="alert alert-danger">Sorry but you do not have access to this DOT</div>
{/if}

<div class="row">
	<div class="col-sm-2">
		<div class="thumbnail">
			<img src="/logo/{$logo}" alt="">
		</div>
	</div>
	<div class="col-sm-10">
		<h3>Dashboard</h3>
	</div>
</div>

<div class="row text-center">
	<div class="col-sm-3">

    <a data-toggle="modal" 
    style="text-decoration:none; color:#FFFFFF;"
    href="/list_project/{$id}" 
    data-target="#myModal" data-backdrop="static" data-keyboard="false" 
    class="btn btn-primary btn-lg btn-block" 
    >List Projects</a>

	</div>
	<div class="col-sm-3">

    <a data-toggle="modal" 
    style="text-decoration:none; color:#FFFFFF;"
    href="/open_review/{$id}" 
    data-target="#myModal" data-backdrop="static" data-keyboard="false" 
    class="btn btn-info btn-lg btn-block" 
    >Upload Review Files</a>

	</div>
	<div class="col-sm-3">

    <a data-toggle="modal" 
    style="text-decoration:none; color:#FFFFFF;"
    href="/new_project/{$id}" 
    data-target="#myModal" data-backdrop="static" data-keyboard="false" 
    class="btn btn-success btn-lg btn-block" 
    >Add New Project</a>

	</div>
	<div class="col-sm-3">

    <a data-toggle="modal" 
    style="text-decoration:none; color:#FFFFFF;"
    href="/new_review/{$id}" 
    data-target="#myModal" data-backdrop="static" data-keyboard="false" 
    class="btn btn-warning btn-lg btn-block" 
    >Add New Review</a>

	</div>
</div>
