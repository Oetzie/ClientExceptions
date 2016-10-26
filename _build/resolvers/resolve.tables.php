<?php

	if ($object->xpdo) {
	    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
	        case xPDOTransport::ACTION_INSTALL:
	            $modx =& $object->xpdo;
	            $modx->addPackage('clientexceptions', $modx->getOption('clientexceptions.core_path', null, $modx->getOption('core_path').'components/clientexceptions/').'model/');
	
	            $manager = $modx->getManager();
	
	            $manager->createObjectContainer('ClientExceptionsExceptions');
	
	            break;
	        case xPDOTransport::ACTION_UPGRADE:
	            break;
	    }
	}
	
	return true;