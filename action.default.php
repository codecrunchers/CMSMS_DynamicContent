<?php

#-------------------------------------------------------------------------
# Project [activeproject]
# Version: [activeproject_activever]  Alan Ryan www.codecrunchers.ie
# 1:05:58 PM -  Oct 20, 2009

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

$page_id = $gCms->variables['content_id'];



//TODO: allow for multiple sections per page
$ajax=$this->GetModuleInstance("AjaxMadeSimple");
$ajax->RegisterAjaxRequester($this->GetName(),"update","updatediv","","ajax.update.php",array('page_id'=>$page_id),array(),5000);

$ajax->RegisterAjaxRequester($this->GetName(),"set_page_info","updatediv","set_page_info","",array(),array("form_page_id"=>-1));
//$ajax->RegisterAjaxRequester($this->GetName(),"poll_".$pollid,"pollcontent_".$pollid,"ExecuteVote","",array("pollid"=>$pollid),array("pollvotingchoice_".$pollid=>"radio","vote"=>""));
$this->smarty->assign('dc_form_action','<form  id="g_page_id_form" action="#" '.$ajax->GetFormOnSubmit($this->GetName(),"set_page_info","this.form_page_id.value = get_active_menu_item();").'>');











?>