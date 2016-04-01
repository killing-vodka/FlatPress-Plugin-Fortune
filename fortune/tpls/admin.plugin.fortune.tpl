<h2>{$plang.head}</h2>

{include file=shared:errorlist.tpl}

{html_form}


<p>{$plang.desc1}</p>
<p>
	<textarea id="rqform" name="rqform" rows="40" cols="70">{$rqcfg.rqform}</textarea>
</p>


<div class="buttonbar">
	<input type="submit" value="{$plang.submit}"/>
</div>

{*<h3>{$plang.options}</h3>
<p>{$plang.desc2}</p>*}
{/html_form}
