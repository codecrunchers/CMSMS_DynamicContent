{$startform}
{if $inputauthor}
	<div class="pageoverflow">
		<p class="pagetext">*{$authortext}:</p>
		<p class="pageinput">{$inputauthor}</p>
	</div>
{/if}
	<div class="pageoverflow">
		<p class="pagetext">*{$titletext}:</p>
		<p class="pageinput">{$inputtitle}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">*{$contenttext}:</p>
		<p class="pageinput">{$inputcontent}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">*{$page_idtext}:</p>
		<p class="pageinput">{$inputpage_id}</p>
	</div>	
{if isset($statustext)}
	<div class="pageoverflow">
		<p class="pagetext">*{$statustext}:</p>
		<p class="pageinput">{$status}</p>
	</div>
{else}
	{$status}
{/if}
	<div class="pageoverflow">
		<p class="pagetext">{$useexpirationtext}:</p>
		<p class="pageinput">{$inputexp}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$enddatetext}:</p>
		<p class="pageinput">{html_select_date prefix=$enddateprefix time=$enddate start_year="-10" end_year="+15"} {html_select_time prefix=$enddateprefix time=$enddate}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$hidden}{$submit}{$cancel}{if isset($apply)}{$apply}{/if}</p>
	</div>
{$endform}
