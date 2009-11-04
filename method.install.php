<?php 
#-------------------------------------------------------------------------
# Project [DynamicContent]
# Version: [DynamicContent 0.1]  Alan Ryan www.codecrunchers.ie
# 8:26:28 PM -  Oct 19, 2009

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
if (!isset($gCms)) exit;

$db =& $this->GetDb();

$db_prefix = cms_db_prefix();
$dict = NewDataDictionary($db);
$flds= "
		id I KEY,
		page_id I,
		title C(255),
		content X,
		end_time " . CMS_ADODB_DT . ",
		status I,
		author_id I
		";
						

$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_dc_content', $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$db->CreateSequence(cms_db_prefix()."module_dc_content_seq");

// create a permission
$this->CreatePermission('Manage Dynamic Content', 'Manage Dynamic Content');
$this->CreatePermission('Delete Dynamic Content', 'Delete Dynamic Content');
$this->SetPreference('dc_pagelimit',25);

?>