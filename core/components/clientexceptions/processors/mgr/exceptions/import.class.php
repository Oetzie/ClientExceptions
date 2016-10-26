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

	class ClientExceptionsExeptionsImportProcessor extends modObjectImportProcessor {
		/**
		 * @acces public.
		 * @var String.
		 */
		public $classKey = 'ClientExceptionsExceptions';
		
		/**
		 * @acces public.
		 * @var Array.
		 */
		public $languageTopics = array('clientexceptions:default');
		
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
		 * @return Mixed.
		 */
		public function process() {
			if (!is_dir($this->getProperty('directory'))) {
				if (!mkdir($this->getProperty('directory'), 0777, true)) {
					return $this->failure($this->modx->getLexion('clientexceptions.import_dir_failed'));
				}
			}
			
			if (!empty($_FILES['file'])) {
				$filename 		= $_FILES['file']['name'];
				$newFilename 	= substr($filename, 0, strrpos($filename, '.')).'.'.time().'.csv';
				$extension 		= substr($filename, strrpos($filename, '.') + 1, strlen($filename));

				if ('csv' == strtolower($extension)) {
					if (move_uploaded_file($_FILES['file']['tmp_name'], $this->getProperty('directory').$newFilename)) {
						if (false !== ($fopen = fopen($this->getProperty('directory').$newFilename, 'r'))) {
							$current = 0;
							$columns = array('name', 'ip', 'type', 'description', 'active', 'context');
							
							while (($row = fgetcsv($fopen, 1000, $this->getProperty('delimiter')))) {
								if (0 == $current && !empty($this->getProperty('headers'))) {
									$columns = $row;
								} else {
									$data = array(
										'name'			=> '',
										'ip'			=> '',
										'type'			=> 0,
										'description'	=> '',
										'active'		=> 1,
										'context' 		=> $this->modx->getOption('default_context')
									);
									
									foreach ($columns as $key => $value) {
										if (isset($row[$key])) {
											$data[$value] = $row[$key];
										}
									}
									
									if (!empty($data['ip'])) {
										$criterea = array(
											'context' 	=> $data['context'],
											'ip'		=> $data['ip']
										);
									
										if (null === ($exception = $this->modx->getObject($this->classKey, $criterea))) {
											$exception = $this->modx->newObject($this->classKey);
										}
										
										$exception->fromArray($data);
										
										$exception->save();	
									}
								}
								
								$current++;
							}
							
							return $this->success($this->modx->lexicon('failed'));
						}
						
						return $this->failure($this->modx->lexicon('clientexceptions.import_read_failed'));
					}
					
					return $this->failure($this->modx->lexicon('clientexceptions.import_upload_failed'));
				}
				
				return $this->failure($this->modx->lexicon('clientexceptions.import_valid_failed'));
			}
			
			return $this->failure($this->modx->lexicon('clientexceptions.import_valid_failed'));
		}
	}

	return 'ClientExceptionsExeptionsImportProcessor';
	
?>