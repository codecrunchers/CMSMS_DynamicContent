<?php

#-------------------------------------------------------------------------
# Project [DynamicContent]
# Version: [DynamicContent 0.1]  Alan Ryan www.codecrunchers.ie
# 10:45:22 AM -  Oct 20, 2009

#-------------------------------------------------------------------------#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL#
#-------------------------------------------------------------------------

if (!isset($gCms)) exit;


if (!$this->CheckPermission('Manage Dynamic Content'))
{
	echo $this->ShowErrors($this->Lang('needpermission', array('Manage Dynamic Content')));
	return;
}

$edit= -1;
if (isset($params['dcid']) && $params['dcid'] > -1)
{
	$edit =  $params['dcid'];
}


if (isset($params['cancel']))
{
	$this->Redirect($id, 'defaultadmin', $returnid);
}


$content = '';
if (isset($params['content']))
{
	$content = $params['content'];
}

$status=0;
if (isset($params['status']))
{
	$status = $params['status'];
}

$page_id  = -1;
if (isset($params['page_id']))
{
	$page_id = $params['page_id'];
}


/*$postdate = time();
 if (isset($params['postdate_Month']))
 {
 $postdate = mktime($params['postdate_Hour'], $params['postdate_Minute'], $params['postdate_Second'], $params['postdate_Month'], $params['postdate_Day'], $params['postdate_Year']);
 }*/

$useexp = 0;
if (isset($params['useexp']))
{
	$useexp = 1;
}

$userid = get_userid();

$startdate = time();
if (isset($params['startdate_Month']))
{
	$startdate = mktime($params['startdate_Hour'], $params['startdate_Minute'], $params['startdate_Second'], $params['startdate_Month'], $params['startdate_Day'], $params['startdate_Year']);
}
$ndays = (int)$this->GetPreference('expiry_interval',180);
if( $ndays == 0 ) $ndays = 180;
$enddate = strtotime(sprintf("+%d days",$ndays), time());
if (isset($params['enddate_Month']))
{
	$enddate = mktime($params['enddate_Hour'], $params['enddate_Minute'], $params['enddate_Second'], $params['enddate_Month'], $params['enddate_Day'], $params['enddate_Year']);
}

$title = '';
if (isset($params['title']))
{
	$title = $params['title'];
}

if( isset($params['submit']) )
{
	$error = FALSE;
	if( empty($title) )
	{
		$error = $this->ShowErrors($this->Lang('notitlegiven'));
	}
	else if( empty($content) )
	{
		$error = $this->ShowErrors($this->Lang('nocontentgiven'));
	}
	else if( $page_id == -1 )
	{
		$error = $this->ShowErrors($this->Lang('noassociatedpage'));
	}
	else if( $useexp == 1 )
	{
		if( $startdate >= $enddate )
		{
			$error = $this->ShowErrors($this->Lang('error_invaliddates'));
		}
	}

	if( $error !== FAlSE )
	{
		echo $error;
	}
	else
	{
		if($edit == -1){//INSERT

			$dcid = $db->GenID(cms_db_prefix()."module_dc_content_seq");
			$query = 'INSERT INTO '.cms_db_prefix().'module_dc_content (id, page_id, title, content, end_time, status,author_id) VALUES (?,?,?,?,?,?,?)';
			if ($useexp == 1)
			{
				$dbr = $db->Execute($query, array($dcid, $page_id , $title, $content, trim($db->DBTimeStamp($enddate), "'"), $status, $userid));
			}
			else
			{
				$dbr = $db->Execute($query, array($dcid, $page_id , $title, $content, NULL, $status, $userid));
			}

			$msg='contentadded';
		}else{//update
				
			$query = 'UPDATE '.cms_db_prefix().'module_dc_content SET title=?, content=?, end_time=?, status=? WHERE id =? and page_id = ?';
				
			if ($useexp == 1)
			{
				$dbr = $db->Execute($query, array($title, $content, trim($db->DBTimeStamp($enddate), "'"), $status,$edit,$page_id));
			}
			else
			{
				$dbr = $db->Execute($query, array($title, $content, NULL, $status,$edit,$page_id));
			}
			$msg='contentupdated';

		}

		if( !$dbr )
		{
			trigger_error("Insert Failed: " . $db->sql . " " . $db->ErrorMsg(),E_USER_ERROR);
			$error = TRUE;
		}


		if( !$error )
		{
			//Update search index
			$module =& $this->GetModuleInstance('Search');
			if ($module != FALSE)
			{

				$text = $content.' '.$title.' '.$title;
				$module->AddWords($this->GetName(), $dcid, 'Info', $text, $useexp == 1 ? $enddate : NULL);
			}


			$params = array('tab_message'=> $msg, 'active_tab' => 'content');
			$this->Redirect($id, 'defaultadmin', $returnid, $params);
		} // if !$error

	} // outer if !$error
} // submit




//are we editing

if($edit > -1 ){

	$query = 'SELECT * FROM '.cms_db_prefix().'module_dc_content WHERE id = ?';
	$row = $db->GetRow($query, array($edit));

	if ($row)
	{
		$title = $row['title'];
		$content = $row['content'];
		$status = $row['status'];
		$author_id = $row['author_id'];
		$page_id = $row['page_id'];
		if (isset($row['end_time']))
		{
			$useexp = 1;
			$enddate = $db->UnixTimeStamp($row['end_time']);
		}
		else
		{
			$useexp = 0;
		}
	}
}


// build the form
//
$statusdropdown = array();
$statusdropdown[$this->Lang('active')] = '1';
$statusdropdown[$this->Lang('inactive')] = '0';


$contentops =& $gCms->GetContentOperations();
$page_dd = $contentops->CreateHierarchyDropdown('','',$id.'page_id');


$smarty->assign('authortext', '');
$smarty->assign('inputauthor', '');
$smarty->assign('hidden', $this->CreateInputHidden($id, 'dcid', $edit));;



$smarty->assign('startform', $this->CreateFormStart($id, 'editcontent', $returnid,'post','multipart/form-data'));
$smarty->assign('endform', $this->CreateFormEnd());


$smarty->assign('inputtitle', $this->CreateInputText($id, 'title', $title, 30, 255));
$smarty->assign('inputcontent', $this->CreateTextArea(true, $id, $content, 'content'));

$smarty->assign('inputexp', $this->CreateInputCheckbox($id, 'useexp', '1', $useexp, 'class="pagecheckbox"'));
$smarty->assign_by_ref('enddate', $enddate);
$smarty->assign('enddateprefix', $id.'enddate_');

if($edit>-1)
{
	$smarty->assign('inputpage_id', $this->CreateInputTextWithLabel($id, 'page_id', $page_id, 10,255,' READONLY', "Page Title"));
}
else
$smarty->assign('inputpage_id', $page_dd);


$smarty->assign('statustext', lang('status'));
$smarty->assign('status', $this->CreateInputDropdown($id, 'status', $statusdropdown, -1, $status));

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

$smarty->assign('titletext', $this->Lang('title'));
$smarty->assign('page_idtext', $this->Lang('page_id'));
$smarty->assign('contenttext', $this->Lang('content'));
$smarty->assign('useexpirationtext', $this->Lang('useexpiration'));
$smarty->assign('enddatetext', $this->Lang('enddate'));

echo $this->ProcessTemplate('editcontent.tpl');


?>