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

	class ClientExceptionsExceptionsCreateProcessor extends modObjectCreateProcessor {
		/**
		 * @access public.
		 * @var String.
		 */
		public $classKey = 'ClientExceptionsExceptions';
		
		/**
		 * @access public.
		 * @var Array.
		 */
		public $languageTopics = array('clientexceptions:default');
		
		/**
		 * @access public.
		 * @var String.
		 */
		public $objectType = 'clientexceptions.exceptions';
		
		/**
		 * @access public.
		 * @var Object.
		 */
		public $clientexceptions;
		
		/**
		 * @access public.
		 * @return Mixed.
		 */
		public function initialize() {
			$this->clientexceptions = $this->modx->getService('clientexceptions', 'ClientExceptions', $this->modx->getOption('clientexceptions.core_path', null, $this->modx->getOption('core_path').'components/clientexceptions/').'model/clientexceptions/');
		
			if (null === $this->getProperty('active')) {
				$this->setProperty('active', 0);
			}

			return parent::initialize();
		}
		
		/**
		 * @access public.
		 * @return Mixed.
		 */
		public function beforeSave() {
			if ($_SERVER['REMOTE_ADDR'] == $this->getProperty('ip')) {
				if ('0' == $this->getProperty('type')) {
					$this->addFieldError('ip', $this->modx->lexicon('clientexceptions.error_own_ip'));
				}
			}

			return parent::beforeSave();
		}
	}
	
	return 'ClientExceptionsExceptionsCreateProcessor';
	
?>