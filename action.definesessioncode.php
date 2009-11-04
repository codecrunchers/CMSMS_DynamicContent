<?php

#-------------------------------------------------------------------------
# Project [activeproject]
# Version: [activeproject_activever]  Alan Ryan www.codecrunchers.ie
# 2:17:52 PM -  Oct 21, 2009

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

//@author alan Modification TO CMSMS Core Oct 21, 2009
//Add Ajax Call Back.
return;
global $gCms;
$ajax = $gCms->modules['AjaxMadeSimple']['object'];

if($ajax){
	$_smarty = &$gCms->GetSmarty();
	$_smarty->assign('callback_link',$ajax->GetRequestURL($this->GetName(),'update_page_info_session_var','',''));
	
	define('XAJAX_DEFAULT_CHAR_ENCODING', $config['admin_encoding']);
	require_once(dirname(dirname(dirname(__FILE__))) . '/lib/xajax/xajax.inc.php');
	$xajax = new xajax();
	$xajax->registerFunction('_set_page_info_var');

	$xajax->processRequests();
	$headtext = $xajax->getJavascript('../lib/xajax')."\n";
	echo $headtext;
}




?>