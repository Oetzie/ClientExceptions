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

	class ClientExceptionsExceptionsGetListProcessor extends modObjectGetListProcessor {
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
		public $defaultSortField = 'id';
		
		/**
		 * @acces public.
		 * @var String.
		 */
		public $defaultSortDirection = 'DESC';
		
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
				'dateFormat' => $this->modx->getOption('manager_date_format') .', '. $this->modx->getOption('manager_time_format')
			));
			
			return parent::initialize();
		}
		
		/**
		 * @acces public.
		 * @param Object $c.
		 * @return Object.
		 */
		public function prepareQueryBeforeCount(xPDOQuery $c) {
			$c->leftjoin('modContext', 'modContext', array('ClientExceptionsExceptions.context = modContext.key'));
			$c->select($this->modx->getSelectColumns('ClientExceptionsExceptions', 'ClientExceptionsExceptions'));
			$c->select($this->modx->getSelectColumns('modContext', 'modContext', 'context_', array('key', 'name')));
			
			$context = $this->getProperty('context');
			
			if (!empty($context)) {
				$c->where(array(
					'ClientExceptionsExceptions.context' => $context
				));
			}
			
			$query = $this->getProperty('query');
			
			if (!empty($query)) {
				$c->where(array(
					'ClientExceptionsExceptions.ip:LIKE' 		=> '%'.$query.'%',
					'OR:ClientExceptionsExceptions.name:LIKE' 	=> '%'.$query.'%'
				));
			}
			
			$type = $this->getProperty('type');
			
			if ('' != $type) {
				$c->where(array(
					'ClientExceptionsExceptions.type' => $type
				));
			}
			
			return $c;
		}
		
		/**
		 * @acces public.
		 * @param Object $query.
		 * @return Array.
		 */
		public function prepareRow(xPDOObject $object) {
			if (null !== $object->context_key) {
				$array = $object->toArray();
			} else {
				$array = array_merge($object->toArray(), array(
					'context_key' 	=> '-',
					'context_name'	=> $this->modx->lexicon('clientexceptions.context_independent')
				));
			}

			if (in_array($array['editedon'], array('-001-11-30 00:00:00', '-1-11-30 00:00:00', '0000-00-00 00:00:00', null))) {
				$array['editedon'] = '';
			} else {
				$array['editedon'] = date($this->getProperty('dateFormat'), strtotime($array['editedon']));
			}
			
			return $array;	
		}
	}

	return 'ClientExceptionsExceptionsGetListProcessor';
	
?>