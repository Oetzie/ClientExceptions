<?php

	/**
	 * Client Exceptions
	 *
	 * Copyright 2017 by Oene Tjeerd de Bruin <modx@oetzie.nl>
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

	class ClientExceptionsHomeManagerController extends ClientExceptionsManagerController {
		/**
		 * @access public.
		 */
		public function loadCustomCssJs() {
			$this->addCss($this->clientexceptions->config['css_url'].'mgr/clientexceptions.css');
			
			$this->addJavascript($this->clientexceptions->config['js_url'].'mgr/widgets/home.panel.js');
			
			$this->addJavascript($this->clientexceptions->config['js_url'].'mgr/widgets/exceptions.grid.js');
			
			$this->addLastJavascript($this->clientexceptions->config['js_url'].'mgr/sections/home.js');
		}
		
		/**
		 * @access public.
		 * @return String.
		 */
		public function getPageTitle() {
			return $this->modx->lexicon('clientexceptions');
		}
		
		/**
		 * @access public.
		 * @return String.
		 */
		public function getTemplateFile() {
			return $this->clientexceptions->config['templates_path'].'home.tpl';
		}
	}

?>