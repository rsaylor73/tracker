    <header class="jumbotron hero-spacer">
    <h1>Reports</h1>
    <h3>Project {$dotproject} :: {$subaccount}</h3>
    <input type="button" value="Project" class="btn btn-primary btn-lg"
	onclick="document.location.href='/editproject/{$id}'">&nbsp;
    <input type="button" value="Review" class="btn btn-primary btn-lg"
    onclick="document.location.href='/viewreview/{$id}'">&nbsp;
    <input type="button" value="Reports" class="btn btn-primary btn-lg"
    onclick="document.location.href='/viewreport/{$id}'">
    </h1>
    </header>
    <hr>


<div id="{$chart1_id}" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>