
        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>Dashboard</h1>
            
            </p>
        </header>

        <hr>

        {if $alert eq "1"}
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger">You do not have a default state set. Please visit your profile to set the default state.</div>
                </div>
            </div>
        {/if}

        {if $default_state ne ""}
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-info">
                        Your current default state selected is <b>{$default_state}</b>
                    </div>
                </div>
            </div>
        {/if}

        <!-- Page Features -->
        <div class="row text-center">

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="/img/new_project.png" alt="">
                    <div class="caption">
                        <h3>Projects</h3>
                        <p>Browse, edit and add a project.</p>
                        <p>
                            <a href="/projects" class="btn btn-primary">Continue</a> 
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="/img/review.png" alt="">
                    <div class="caption">
                        <h3>Review</h3>
                        <p>Browse projects ready for review.</p>
                        <p>
                            <a href="/review" class="btn btn-primary">Continue</a> 
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="/img/reports.png" alt="">
                    <div class="caption">
                        <h3>Reports</h3>
                        <p>View project reports</p>
                        <p>
                            <a href="/reports" class="btn btn-primary">Continue</a> 
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="/img/users.png" alt="">
                    <div class="caption">
                        <h3>Users</h3>
                        <p>View, edit, add users</p>
                        <p>
                            <a href="/users" class="btn btn-primary">Continue</a> 
                        </p>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->

        <hr>