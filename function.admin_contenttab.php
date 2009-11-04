<?php

$smarty->assign('formstart',$this->CreateFormStart($id,'defaultadmin'));


if (isset($params['submit_massdelete']) )
{
	if (!$this->CheckPermission('Delete Dynamic Content'))
	{
		echo $this->ShowErrors($this->Lang('needpermission', array('Manage Dynamic Content')));
	}
	else if( isset($params['sel']) && is_array($params['sel']) &&
	count($params['sel']) > 0 )
	{
		foreach( $params['sel'] as $dcid )
		{
			$this->delete_dynamiccontent( $dcid );
		}
	}
}
if( isset( $params['pagelimit'] ) )
{
	$this->SetPreference('dc_pagelimit',(int)$params['pagelimit']);
}
$pagelimit = $this->GetPreference('dc_pagelimit',25);
$pagenumber = 1;
if( isset( $params['pagenumber'] ) )
{
	$pagenumber = $params['pagenumber'];
}
$startelement = ($pagenumber-1) * $pagelimit;

//Load the current articles
$entryarray = array();

$dbresult = '';

$query1 = "SELECT * FROM ".cms_db_prefix()."module_dc_content";
$query2 = "SELECT count(id) AS count FROM ".cms_db_prefix()."module_dc_content";



$dbresult = $db->SelectLimit( $query1, $pagelimit, $startelement);
$row = $db->GetRow($query2);
$numrows = $row['count'];


$pagecount = (int)($numrows/$pagelimit);
if( ($numrows % $pagelimit) != 0 ) $pagecount++;
// some pagination variables to smarty.
if( $pagenumber == 1 )
{
	$smarty->assign('prevpage','<');
	$smarty->assign('firstpage','<<');
}
else
{
	$smarty->assign('prevpage',
	$this->CreateLink($id,'defaultadmin',
	$returnid,'<',
	array('pagenumber'=>$pagenumber-1,
					    'active_tab'=>'content')));
	$smarty->assign('firstpage',
	$this->CreateLink($id,'defaultadmin',
	$returnid,'<<',
	array('pagenumber'=>1,
					    'active_tab'=>'content')));
}
if( $pagenumber >= $pagecount )
{
	$smarty->assign('nextpage','>');
	$smarty->assign('lastpage','>>');
}
else
{
	$smarty->assign('nextpage',
	$this->CreateLink($id,'defaultadmin',
	$returnid,'>',
	array('pagenumber'=>$pagenumber+1,
					    'active_tab'=>'content')));
	$smarty->assign('lastpage',
	$this->CreateLink($id,'defaultadmin',
	$returnid,'>>',
	array('pagenumber'=>$pagecount,
					    'active_tab'=>'content')));
}
$smarty->assign('pagenumber',$pagenumber);
$smarty->assign('pagecount',$pagecount);
$smarty->assign('oftext',$this->Lang('prompt_of'));

$rowclass = 'row1';

$admintheme =& $gCms->variables['admintheme'];
$contentops =& $gCms->GetContentOperations();
while ($dbresult && $row = $dbresult->FetchRow())
{
	$onerow = new stdClass();

	$onerow->id = $row['id'];
	$onerow->title = $this->CreateLink($id, 'editcontent', $returnid, $row['title'], array('dcid'=>$row['id']));
	$onerow->expired = 0;
	if( ($row['end_time'] != '') &&
	($db->UnixTimeStamp($row['end_time']) < time()) )
	{
		$onerow->expired = 1;
	}
	$onerow->enddate = $row['end_time'];
	$onerow->status = $this->Lang($row['status']);
	if( $row['status'] == 1)
	{
		$onerow->approve_link = $this->CreateLink($id,'setactivecontent',
		$returnid,
		$admintheme->DisplayImage('icons/system/true.gif',$this->Lang('setinactive'),'','','systemicon'),array('approve'=>0,'dcid'=>$row['id']));
	}
	else
	{
		$onerow->approve_link = $this->CreateLink($id,'setactivecontent',
		$returnid,
		$admintheme->DisplayImage('icons/system/false.gif',$this->Lang('setactive'),'','','systemicon'),array('approve'=>1,'dcid'=>$row['id']));
	}

	$onerow->page_alias = $contentops->GetPageAliasFromID($row['page_id']);
	$onerow->select = $this->CreateInputCheckbox($id,'sel[]',$row['id']);
	$onerow->editlink = $this->CreateLink($id, 'editcontent', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif', $this->Lang('edit'),'','','systemicon'), array('dcid'=>$row['id']));
	$onerow->deletelink = $this->CreateLink($id, 'deletecontent', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'), array('dcid'=>$row['id']), $this->Lang('areyousure'));

	$entryarray[] = $onerow;
	
	$onerow->rowclass = $rowclass;

	($rowclass=="row1"?$rowclass="row2":$rowclass="row1");

}

$smarty->assign_by_ref('items', $entryarray);
$smarty->assign('itemcount', count($entryarray));

$smarty->assign('addlink', $this->CreateLink($id, 'editcontent', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', $this->Lang('addarticle'),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'editcontent', $returnid, $this->Lang('addcontent'), array(), '', false, false, 'class="pageoptions"'));

$smarty->assign('form2start',$this->CreateFormStart($id,'defaultadmin',$returnid));
$smarty->assign('form2end',$this->CreateFormEnd());

$smarty->assign('submit_massdelete',
$this->CreateInputSubmit($id,'submit_massdelete',$this->Lang('delete_selected'),
					     '','',$this->Lang('areyousure_deletemultiple')));


$smarty->assign('selecttext',$this->Lang('select'));
$smarty->assign('pagetext',$this->Lang('page'));
$smarty->assign('statustext',$this->Lang('status'));
$smarty->assign('expiredtext',$this->Lang('expiry'));
$smarty->assign('statetext',$this->Lang('state'));
$smarty->assign('titletext', $this->Lang('title'));

global $gCms;
$theme =& $gCms->variables['admintheme'];
$config =& $this->GetConfig();
$themedir = $config['root_url'].'/'.$config['admin_dir'].'/themes/'.$theme->themeName.'/images/icons/system';

$smarty->assign('iconurl',$themedir);

#Display template
echo $this->ProcessTemplate('contentlist.tpl');

// EOF
?>