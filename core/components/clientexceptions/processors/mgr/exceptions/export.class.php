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

	class ClientExceptionsExeptionsExportProcessor extends modObjectGetListProcessor {
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
		public $defaultSortField = 'id';
		
		/**
		 * @access public.
		 * @var String.
		 */
		public $defaultSortDirection = 'ASC';
		
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

			$this->setDefaultProperties(array(
				'filename'	=> $this->objectType.'.csv',
				'directory'	=> $this->modx->getOption('core_path').'cache/export/clientexceptions/',
				'delimiter'	=> ';'
			));
			
			if (null === $this->getProperty('download')) {
				$this->setProperty('download', 0);
			}
			
			if (null === $this->getProperty('headers')) {
				$this->setProperty('headers', 0);
			}
			
			return parent::initialize();
		}
		
		/**
		 * @access public.
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
		 * @access public.
		 * @return mixed.
		 */
		public function setFile() {
			if (false !== ($fopen = fopen($this->getProperty('directory').$this->getProperty('filename'), 'w'))) {
				$columns = array('name', 'ip', 'type', 'description', 'active', 'context');
								
				$headers = $this->getProperty('headers');
				
				if (!empty($headers)) {
					$rows = array($columns);
				} else {
					$rows = array();
				}
				
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
		 * @access public.
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