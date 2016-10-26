<?php
	
	/**
	 * ClientExceptions
	 *
	 * Copyright 2016 by Oene Tjeerd de Bruin <info@oetzie.nl>
	 *
	 * This file is part of ClientExceptions, a real estate property listings component
	 * for MODX Revolution.
	 *
	 * ClientExceptions is free software; you can redistribute it and/or modify it under
	 * the terms of the GNU General Public License as published by the Free Software
	 * Foundation; either version 2 of the License, or (at your option) any later
	 * version.
	 *
	 * ClientExceptions is distributed in the hope that it will be useful, but WITHOUT ANY
	 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
	 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License along with
	 * ClientExceptions; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
	 * Suite 330, Boston, MA 02111-1307 USA
	 */

	switch($modx->event->name) {
		case 'OnHandleRequest':
			if ('mgr' != $modx->context->key) {
				if ($modx->loadClass('ClientExceptions', $modx->getOption('clientexceptions.core_path', null, $modx->getOption('core_path').'components/clientexceptions/').'model/clientexceptions/', true, true)) {
			        $clientexceptions = new ClientExceptions($modx);
			        
				    if ($clientexceptions instanceOf ClientExceptions) {
						foreach ($clientexceptions->getExceptions() as $exception) {
							$regex = preg_quote($exception['ip']);
							$regex = str_replace(array('%', '\?', '\^', '\$'), array('\d+', '?', '^', '$'), $regex);
							$regex = !preg_match('/\^/si', $regex) && !preg_match('/\$/si', $regex) ? sprintf('/^%s$/si', $regex) : sprintf('/%s/si', $regex);
		
							if (preg_match($regex, $_SERVER['REMOTE_ADDR'])) {
								$modx->setOption('site_status', $exception['type']);
								$modx->setOption('site_unavailable_message', $exception['description']);
		
								break;
							}
						}
					}
				}
			}

			break;
	}

	return;
	
?>