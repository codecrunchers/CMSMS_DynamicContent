<?php

#-------------------------------------------------------------------------
# Project [DynamicContent]
# Version: [DynamicContent 0.1]  Alan Ryan www.codecrunchers.ie
# 1:07:35 PM -  Oct 20, 2009

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

///fetch a random spiel

$path = dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME'])));
require_once $path . DIRECTORY_SEPARATOR . 'include.php';

//TODO: Check for intalled etc..
$module =& $gCms->modules['DynamicContent']['object'];
$module->update_content();



?>