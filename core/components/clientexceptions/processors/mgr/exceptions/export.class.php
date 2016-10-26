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

	class ClientExceptionsExeptionsExportProcessor extends modObjectGetListProcessor {
		/**
		 * @acces public.
		 * @var String.
		 */
		public $classKey = 'ClientExceptionsExeptions';
		
		/**
		 * @acces public.
		 * @var Array.
		 */
		public $languageTopics = array('clientexceptions:default');
		
		/**
		 * @acces public.
		 * @var String.
		 */
		public $defaultSortField = 'id';
		
		/**
		 * @acces public.
		 * @var String.
		 */
		public $defaultSortDirection = 'ASC';
		
		/**
		 * @acces public.
		 * @var String.
		 */
		public $objectType = 'clientexceptions.exceptions';
		
		/**
		 * @acces public.
		 * @var Object.
		 */
		public $clientexceptions;
		
		/**
		 * @acces public.
		 * @return Mixed.
		 */
		public function initialize() {
			$this->clientexceptions = $this->modx->getService('clientexceptions', 'ClientExceptions', $this->modx->getOption('clientexceptions.core_path', null, $this->modx->getOption('core_path').'components/clientexceptions/').'model/clientexceptions/');

			$this->setDefaultProperties(array(
				'filename'	=> $this->objectType.'.csv',
				'directory'	=> $this->modx->getOption('core_path').'cache/export/clientexceptions/',
				'delimiter'	=> ';'
			));
			
			return parent::initialize();
		}
		
		/**
		 * @acces public.
		 * @return mixed.
		 */
		public function process() {
			if (!is_dir($this->getProperty('directory'))) {
				if (!mkdir($this->getProperty('directory'), 0777, true)) {
					return $this->failure($this->modx->getLexion('clientexceptions.export_dir_failed'));
				}
			}

			$file = $this->getProperty('download');

			if (empty($file)) {
				return $this->setFile();
			}
			
			return $this->getFile();
		}
		
		/**
		 * @acces public.
		 * @return mixed.
		 */
		public function setFile() {
			if (false !== ($fopen = fopen($this->getProperty('directory').$this->getProperty('filename'), 'w'))) {
				$columns = array('name', 'ip', 'type', 'description', 'active', 'context');
				
				$rows = array($columns);
				
				foreach ($this->modx->getCollection($this->classKey) as $exception) {
					$rows[$exception->id] = $exception->toArray();
				}

				foreach ($rows as $key => $value) {
					if (0 == $key) {
						fputcsv($fopen, $value, $this->getProperty('delimiter'));
					} else {
						$data = array();
						
						foreach ($columns as $column) {
							$data[] = $value[$column];
						}
						
						fputcsv($fopen, $data, $this->getProperty('delimiter'));
					}
				}
				
				fclose($fopen);
			
				return $this->success($this->modx->lexicon('success'));
			}
			
			return $this->failure($this->modx->lexicon('clientexceptions.export_failed'));
		}
		
		/**
		 * @acces public.
		 * @return mixed.
		 */
		public function getFile() {
			$file = $this->getProperty('directory').$this->getProperty('filename');

			if (is_file($file)) {
				$fileContents = file_get_contents($file);
				
				header('Content-Type: application/force-download');
				header('Content-Disposition: attachment; filename="'.$this->getProperty('filename').'"');
			
				return $fileContents;
			}
			
			return $this->failure($this->modx->lexicon('clientexceptions.export_failed'));
		}
	}

	return 'ClientExceptionsExeptionsExportProcessor';
	
?>