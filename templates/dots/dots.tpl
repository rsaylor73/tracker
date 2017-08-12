
{if $error eq "1"}
<div class="alert alert-danger">Sorry but you do not have access to any DOT</div>
{/if}

<div class="row text-center">
{assign var=counter value=0}
{foreach $dots as $d}
    {if $counter eq 4}
        </div>
        <div class="row text-center">
        {assign var=counter value=0}
    {/if}

    <div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <a href="/dots/{$d.id}"><img src="/logo/{$d.logo}" alt=""></a>
        </div>
    </div>
    {counter print=false}
{/foreach}
</div>