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

	class ClientExceptions {
		/**
		 * @access public.
		 * @var Object.
		 */
		public $modx;
		
		/**
		 * @access public.
		 * @var Array.
		 */
		public $config = array();
		
		/**
		 * @access public.
		 * @param Object $modx.
		 * @param Array $config.
		 */
		public function __construct(modX &$modx, array $config = array()) {
			$this->modx =& $modx;
		
			$corePath 		= $this->modx->getOption('clientexceptions.core_path', $config, $this->modx->getOption('core_path').'components/clientexceptions/');
			$assetsUrl 		= $this->modx->getOption('clientexceptions.assets_url', $config, $this->modx->getOption('assets_url').'components/clientexceptions/');
			$assetsPath 	= $this->modx->getOption('clientexceptions.assets_path', $config, $this->modx->getOption('assets_path').'components/clientexceptions/');
		
			$this->config = array_merge(array(
				'namespace'				=> $this->modx->getOption('namespace', $config, 'clientexceptions'),
				'helpurl'				=> $this->modx->getOption('namespace', $config, 'clientexceptions'),
				'lexicons'				=> array('clientexceptions:default'),
				'base_path'				=> $corePath,
				'core_path' 			=> $corePath,
				'model_path' 			=> $corePath.'model/',
				'processors_path' 		=> $corePath.'processors/',
				'elements_path' 		=> $corePath.'elements/',
				'chunks_path' 			=> $corePath.'elements/chunks/',
				'cronjobs_path' 		=> $corePath.'elements/cronjobs/',
				'plugins_path' 			=> $corePath.'elements/plugins/',
				'snippets_path' 		=> $corePath.'elements/snippets/',
				'templates_path' 		=> $corePath.'templates/',
				'assets_path' 			=> $assetsPath,
				'js_url' 				=> $assetsUrl.'js/',
				'css_url' 				=> $assetsUrl.'css/',
				'assets_url' 			=> $assetsUrl,
				'connector_url'			=> $assetsUrl.'connector.php',
				'version'				=> '1.1.0',
				'branding'				=> (boolean) $this->modx->getOption('clientexceptions.branding', null, true),
				'branding_url'			=> 'http://www.oetzie.nl',
				'branding_help_url'		=> 'http://www.werkvanoetzie.nl/extras/clientexceptions',
				'context'				=> $this->getContexts()
			), $config);
		
			$this->modx->addPackage('clientexceptions', $this->config['model_path']);
			
			if (is_array($this->config['lexicons'])) {
				foreach ($this->config['lexicons'] as $lexicon) {
					$this->modx->lexicon->load($lexicon);
				}
			} else {
				$this->modx->lexicon->load($this->config['lexicons']);
			}
		}
		
		/**
		 * @access public.
		 * @return String.
		 */
		public function getHelpUrl() {
			return $this->config['branding_help_url'].'?v='.$this->config['version'];
		}
		
		/**
		 * @access private.
		 * @return Boolean.
		 */
		private function getContexts() {
			return 1 == $this->modx->getCount('modContext', array(
				'key:!=' => 'mgr'
			));
		}
		
		/**
		 * @access public.
		 * @param Array $context.
		 * @return Array.
		 */
		public function getExceptions($context = array()) {
			$exceptions = array();
			
			if (is_string($context)) {
				$context = explode(',', $context);
			}
			
			$criteria = array(
				'context:IN' 	=> $context + array($this->modx->context->key, ''),
				'active' 		=> 1
			);
			
			foreach ($this->modx->getCollection('ClientExceptionsExceptions', $criteria) as $exception) {
				$exceptions[] = $exception;
			}
			
			return $exceptions;
		}
		
		/**
		 * @access public.
		 */
		public function run() {
			foreach ($this->getExceptions() as $exception) {
				$regex = preg_quote($exception->ip);
				$regex = str_replace(array('%', '\?', '\^', '\$'), array('\d+', '?', '^', '$'), $regex);
				
				if (!preg_match('/\^/si', $regex) && !preg_match('/\$/si', $regex)) {
					$regex = sprintf('/^%s$/si', $regex);
				} else {
					$regex = sprintf('/%s/si', $regex);
				}

				if (preg_match($regex, $_SERVER['REMOTE_ADDR'])) {
					$this->modx->setOption('site_status', $exception->type);
					$this->modx->setOption('site_unavailable_message', $exception->description);

					break;
				}
			}
		}
	}
	
?>