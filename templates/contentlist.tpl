{literal}
<script type="text/javascript">
//<![CDATA[
function selectAll()
{
  checkboxes = document.getElementsByTagName("input");
  for (i=0; i<checkboxes.length ; i++)
    {
      if (checkboxes[i].type == "checkbox") checkboxes[i].checked=!checkboxes[i].checked;
    }
}
//]]>
</script>
{/literal} {if $itemcount > 0}
<div class="pageoptions">
<p class="pageoptions">{$addlink}</p>
</div>

{if $pagecount > 1}
<p>{if $pagenumber > 1} {$firstpage}&nbsp;{$prevpage}&nbsp; {/if}
{$pagenumber}&nbsp;{$oftext}&nbsp;{$pagecount} {if $pagenumber <
$pagecount} &nbsp;{$nextpage}&nbsp;{$lastpage} {/if}</p>
{/if} {$form2start}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th>{$titletext}</th>
			<th>{$pagetext}</th>
			<th>{$expiredtext}</th>
			<th class="pageicon">{$statustext}</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon"><a href="javascript:selectAll();">{$selecttext}</a></th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$items item=entry}
		<tr class="{$entry->rowclass}"
			onmouseover="this.className='{$entry->rowclass}hover';"
			onmouseout="this.className='{$entry->rowclass}';">
			<td>{$entry->title}</td>
			<td>{$entry->page_alias}</td>
			<td>{if $entry->expired == 1}
			<div class="important">{$entry->enddate|cms_date_format}</div>
			{else} {$entry->enddate|cms_date_format} {/if}</td>			
			<td>{$entry->approve_link}</td>
			<td>{$entry->editlink}</td>
			<td>{$entry->deletelink}</td>
			<td>{$entry->select}</td>
		</tr>
		{/foreach}
	</tbody>
</table>
{/if}

<div style="width: 97%;">
<div class="pageoptions" style="float: left;">
<p class="pageoptions">{$addlink}</p>
</div>
{if $itemcount > 0}
<div class="pageoptions" style="float: right;">
{$submit_massdelete}</div>
{/if}
<div class="clearb"></div>
</div>
{$form2end}
