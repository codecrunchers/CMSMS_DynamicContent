<?php
$lang['addtemplate'] = 'Add Template';
$lang['areyousure'] = 'Are you sure you want to delete this?';
$lang['changelog'] = <<<EOF
	<ul>        
		<li>1.0 -- Initial Release</li>
	</ul> 
EOF;
$lang['dbtemplates'] = 'Database Templates';
$lang['friendlyname']='Dynamic Content';
$lang['help']='
<b>This is a BETA version...</b>This module is intended to allow for per page dynamic content to be displayed. For example, on your home page you would like a rotating banner of HTML content, you add a new <em>Dynamic Content</em> entry, and asssign it to a pag. Each entry consists of a <b>title</b> and some <b>content</b>. You can also add an expiry date so that this will only show for a certain time period - e.g. <strong>"Special Offer, Xmas Sale"</strong>. 	You can add multiple <em>Dynamic Content </em>entries for each page.
<P>Within your template for the page to which you would like the banner to work on add a div like so:</P><p><code>&lt;div id="updatediv">{*Ajax Driven Content*}
			{cms_module module="DynamicContent"}&lt;/div&gt;</code></p>
The entries will appear here in that DIV every 4 seconds at the moment.<br/>Lots of work to do, let me know if you want changes. See it working at <a target="_blank" href="http://www.codecrunchers.ie">Code Crunchers</a>';  
$lang['moddescription']='Ajax Enabled Page Associated Dynamic Content Module';
$lang['postinstall']='Woo Hoo';
$lang['postuninstall']='Boo hoo';
$lang['notitlegiven']='No Title Supplied';
$lang['nocontentgiven']='No Content Supplied';
$lang['error_invaliddates']='Expiry Date is Invalid';
$lang['content']='Dynamic Content';
$lang['title']='Title';
$lang['useexpiration']='Expires?';
$lang['enddate']='Expiry Date';
$lang['page_id']='Asscoiated Page';
$lang['prompt_of']='of';
$lang['addcontent']='Add New Content';
$lang['setinactive']='Inactive';
$lang['active']='Active';
$lang['inactive']='Inactive';
$lang['options']='Options';
$lang['noassociatedpage']="Please Associate Content with a Page";
$lang['contentadded']="Dynamic Content Added";
$lang['contentupdated']="Dynamic Content Updated";
$lang['contentdeleted']="Dynamic Content Deleted";
$lang['expiry']='Expires';
$lang['status']='Status';
$lang['select']='';
$lang['delete_selected']='Delete All Selected';
$lang['page']="Associated Page";
?>