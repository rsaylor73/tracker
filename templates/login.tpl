
        <!-- Jumbotron Header -->
        <form action="/index.php" method="post">
        <input type="hidden" name="section" value="login">
        <header class="jumbotron hero-spacer">
            <div class="row top-buffer">
                <div class="col-sm-12">
                    <h2>Login</h2>
                </div>
            </div>
            <div class="row top-buffer">
            	<div class="col-sm-4">Username:</div>
            	<div class="col-sm-4"><input type="text" name="uuname" class="form-control"></div>
            </div>
            <div class="row top-buffer">
            	<div class="col-sm-4">Password:</div>
            	<div class="col-sm-4"><input type="password" name="password" class="form-control"></div>
            </div>
            <div class="row top-buffer">
            	<div class="col-sm-8">
            		<input type="submit" value="Login" class="btn btn-success">&nbsp;
            		<input type="button" value="Forgot Password" class="btn btn-warning">
            	</div>
            </div>

            </p>
        </header>
        </form>
