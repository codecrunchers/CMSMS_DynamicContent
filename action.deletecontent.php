<?php

#-------------------------------------------------------------------------
# Project [activeproject]
# Version: [activeproject_activever]  Alan Ryan www.codecrunchers.ie
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

if (!$this->CheckPermission('Delete Dynamic Content'))
{
	echo $this->ShowErrors($this->Lang('needpermission', array('Delete Dynamic Content')));
	return;
}

$dcid= '';
if (isset($params['dcid']))
{
	$dcid = $params['dcid'];
}

$this->delete_dynamiccontent($dcid);

$params = array('tab_message'=> 'contentdeleted', 'active_tab' => 'content');
$this->Redirect($id, 'defaultadmin', $returnid, $params);
?>