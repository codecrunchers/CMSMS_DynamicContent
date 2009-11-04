<?php
#-------------------------------------------------------------------------
# Project [DynamicContent]
# Version: [DynamicContent]  Alan Ryan www.codecrunchers.ie
# 5:56:04 PM -  Oct 19, 2009

#
#-------------------------------------------------------------------------
#-------------------------------------------------------------------------
#
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
#-------------------------------------------------------------------------
class DynamicContent extends CMSModule
{


	/*---------------------------------------------------------
	 GetName()
	 ---------------------------------------------------------*/
	function GetName()
	{
		return 'DynamicContent';
	}


	/*---------------------------------------------------------
	 GetFriendlyName()
	 ---------------------------------------------------------*/
	function GetFriendlyName()
	{
		return $this->Lang('friendlyname');
	}


	/*---------------------------------------------------------
	 GetVersion()
	 ---------------------------------------------------------*/
	function GetVersion()
	{
		return '0.1';
	}


	/*---------------------------------------------------------
	 GetHelp()
	 ---------------------------------------------------------*/
	function GetHelp()
	{
		return $this->Lang('help');
	}


	/*---------------------------------------------------------
	 GetAuthor()
	 ---------------------------------------------------------*/
	function GetAuthor()
	{
		return 'Alan';
	}


	/*---------------------------------------------------------
	 GetAuthorEmail()
	 ---------------------------------------------------------*/
	function GetAuthorEmail()
	{
		return 'alan@codecrunchers.ie';
	}


	/*---------------------------------------------------------
	 GetChangeLog()
	 ---------------------------------------------------------*/
	function GetChangeLog()
	{
		return $this->Lang('changelog');
	}


	/*---------------------------------------------------------
	 IsPluginModule()
	 ---------------------------------------------------------*/
	function IsPluginModule()
	{
		return true;
	}


	/*---------------------------------------------------------
	 HasAdmin()
	 ---------------------------------------------------------*/
	function HasAdmin()
	{
		return true;
	}


	/*---------------------------------------------------------
	 GetAdminSection()
	 ---------------------------------------------------------*/
	function GetAdminSection()
	{
		return 'content';
	}


	/*---------------------------------------------------------
	 GetAdminDescription()
	 ---------------------------------------------------------*/
	function GetAdminDescription()
	{
		return $this->Lang('moddescription');
	}


	/*---------------------------------------------------------
	 VisibleToAdminUser()
	 ---------------------------------------------------------*/
	function VisibleToAdminUser()
	{
		return $this->CheckPermission('Manage Dynamic Content' );
	}

	/*---------------------------------------------------------
	 GetDependencies()
	 ---------------------------------------------------------*/
	function GetDependencies()
	{
		return array('AjaxMadeSimple'=>"0.1.6");
	}

	/*---------------------------------------------------------
	 InstallPostMessage()
	 ---------------------------------------------------------*/
	function InstallPostMessage()
	{
		return $this->Lang('postinstall');
	}


	/*---------------------------------------------------------
	 UninstallPostMessage()
	 ---------------------------------------------------------*/
	function UninstallPostMessage()
	{
		return $this->Lang('postuninstall');
	}


	/*---------------------------------------------------------
	 Upgrade()
	 ---------------------------------------------------------*/
	function Upgrade($oldversion, $newversion)
	{
		// nothing here
	}


	//API

	function delete_dynamiccontent($dcid)
	{
		$db =& $this->GetDb();

		//Now remove the article
		$query = "DELETE FROM ".cms_db_prefix()."module_dc_content WHERE id = ?";
		$db->Execute($query, array($dcid));

		//Update search index
		$module =& $this->GetModuleInstance('Search');
		if ($module != FALSE)
		{
			$module->DeleteWords($this->GetName(), $dcid, 'Info');
		}
	}

	//callback from mouseover
	function set_page_info($var){

		$page_id = $var['form_page_id'];


		if (session_id()=="") session_start();
		/*global $_SESSION*/
		$_SESSION['dc_active_page']=$page_id;
		
		$this->update_content();

		/*@ob_start();
		include("ajax.update.php");
		$content =	@ob_get_contents();
		@ob_end_clean();

		return $content;*/
			
	}

	/**
	 * Update the roating banner div
	 * @return unknown_type
	 */
	/*static*/ function update_content(){
	
		global /*$_SESSION,*/$gCms;
		$active_page = isset($_SESSION['dc_active_page'])?$_SESSION['dc_active_page']:-1;
		$db=$GLOBALS["gCms"]->db;

		if(!isset($gCms))
			$gCms = $GLOBALS["gCms"];
								
		$page_id = isset($_REQUEST['page_id'])?$_REQUEST['page_id']:isset($gCms->variables) && isset($gCms->variables['content_id'])?$gCms->variables['content_id']:-1;
		//get from mouseover, else active page
		if($active_page != -1)
			$page_id =  $active_page;


		$query = 'SELECT * FROM cms_module_dc_content WHERE page_id = ?';
		$dbresult = $db->Execute($query, array($page_id));
		$count = $dbresult->NumRows();
		$sel=$count;

		if($count>1){
			$sel  = rand(1,$count);
		}

		$count = 0;

		$title=$content=$status=$author_id='';
		$useexp=$useexp=FALSE;

		while($dbresult && $row = $dbresult->FetchRow())
		{
			$count++;

			$title = $row['title'];
			$content = $row['content'];
			$status = $row['status'];
			$author_id = $row['author_id'];

			if (isset($row['end_time']))
			{
				$useexp = 1;
				$useexp = $db->UnixTimeStamp($row['end_time']);
			}
			else
			{
				$useexp = 0;
			}

			if($sel == $count) break;
		}
		//TODO: Template-ise
		if($status){
			echo '<h2 class="rotating">'. $title  . '</h2><p style="color:red">'. $content.'</p>';
			/*$smarty->assign('title',$title);
			 $smarty->assign('content',$content);*/
		}


	}

} // class CMSMailer



?>