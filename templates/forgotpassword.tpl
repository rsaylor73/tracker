        <!-- Jumbotron Header -->
        <form action="/index.php" method="post">
        <input type="hidden" name="section" value="resetpw">
        <input type="hidden" name="go" value="">
        <header class="jumbotron hero-spacer">
            <div class="row top-buffer">
                <div class="col-sm-12">
                    <h2>Login</h2>
                </div>
            </div>
            <div class="row top-buffer">
                <div class="col-sm-8 alert alert-info">You are requesting your password to be reset. To continue please enter in your email.</div>
            </div>
            <div class="row top-buffer">
            	<div class="col-sm-4">Email:</div>
            	<div class="col-sm-4"><input type="text" name="email" class="form-control"></div>
            </div>
            <div class="row top-buffer">
            	<div class="col-sm-8">
            		<input type="submit" value="Send Password" class="btn btn-success">&nbsp;

            	</div>
            </div>

            </p>
        </header>
        </form>