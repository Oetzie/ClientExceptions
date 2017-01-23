<?php

    /**
	 * Client Exceptions
	 *
	 * Copyright 2016 by Oene Tjeerd de Bruin <info@oetzie.nl>
	 *
	 * This file is part of Client Exceptions, a real estate property listings component
	 * for MODX Revolution.
	 *
	 * Client Exceptions is free software; you can redistribute it and/or modify it under
	 * the terms of the GNU General Public License as published by the Free Software
	 * Foundation; either version 2 of the License, or (at your option) any later
	 * version.
	 *
	 * Client Exceptions is distributed in the hope that it will be useful, but WITHOUT ANY
	 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
	 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License along with
	 * Client Exceptions; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
	 * Suite 330, Boston, MA 02111-1307 USA
	 */

	switch($modx->event->name) {
		case 'OnHandleRequest':
			if ($modx->loadClass('ClientExceptions', $modx->getOption('clientexceptions.core_path', null, $modx->getOption('core_path').'components/clientexceptions/').'model/clientexceptions/', true, true)) {
		        $clientexceptions = new ClientExceptions($modx);
		        
			    if ($clientexceptions instanceOf ClientExceptions) {
					return $clientexceptions->run();
				}
			}

			break;
	}

	return;
	
?>