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

	$_lang['clientexceptions'] 											= 'IP exception';
	$_lang['clientexceptions.desc'] 									= 'Change or create IP exceptions.';
	
	$_lang['area_clientexceptions'] 									= 'IP exception';
			
	$_lang['clientexceptions.exception']								= 'Exception';
	$_lang['clientexceptions.exceptions']								= 'Exceptions';
	$_lang['clientexceptions.exceptions_desc']							= 'Here you can set IP exceptions for the MODX site. An IP exception is meant to give some one with use of his or her IP number grant or deny to the website. For a wildcard in the IP number use %, use ^ to start an IP range (ex. ^127.0.) or use $ to end an IP range (ex. .0.1$).';
	$_lang['clientexceptions.exception_create']							= 'Create new exception';
	$_lang['clientexceptions.exception_update']							= 'Update exception.';
	$_lang['clientexceptions.exception_remove']							= 'Delete exception';
	$_lang['clientexceptions.exception_remove_confirm']					= 'Are you sure you want to delete this exception?';
	$_lang['clientexceptions.exceptions_remove_selected']				= 'Delete selected exceptions';
	$_lang['clientexceptions.exceptions_remove_selected_confirm']		= 'Are you sure you want to delete the selected exceptions?';
	$_lang['clientexceptions.exceptions_activate_selected']				= 'Activate selected exceptions';
	$_lang['clientexceptions.exceptions_activate_selected_confirm']		= 'Are you sure you want to activate the selected exceptions?';
	$_lang['clientexceptions.exceptions_deactivate_selected']			= 'Deactivate selected exceptions';
	$_lang['clientexceptions.exceptions_deactivate_selected_confirm']	= 'Are you sure you want to deactivate the selected exceptions?';
	$_lang['clientexceptions.exceptions_import']						= 'Import exceptions';
	$_lang['clientexceptions.exceptions_import_desc']					= 'Select a CSV file to import the exceptions. It must be a valid CSV format.';
	$_lang['clientexceptions.exceptions_export']						= 'Export exceptions';
	
	$_lang['clientexceptions.label_ipnumber']							= 'IP number';
	$_lang['clientexceptions.label_ipnumber_desc']						= 'The IP number of the exception.';
	$_lang['clientexceptions.label_own_ipnumber']						= 'My IP';
	$_lang['clientexceptions.label_name']								= 'Name';
	$_lang['clientexceptions.label_name_desc']							= 'The name of the exception.';
	$_lang['clientexceptions.label_context']							= 'Context';
	$_lang['clientexceptions.label_context_desc']						= 'The context of the exception.';
	$_lang['clientexceptions.label_type']								= 'Exceptions type';
	$_lang['clientexceptions.label_type_desc']							= 'The type of the exception, this can be "grant" or "deny".';
	$_lang['clientexceptions.label_description']						= 'Description/reason';
	$_lang['clientexceptions.label_description_desc']					= 'The description/reason of the exception.';
	$_lang['clientexceptions.label_active']								= 'Active';
	$_lang['clientexceptions.label_active_desc']						= '';
	$_lang['clientexceptions.label_import_file']						= 'File';
	$_lang['clientexceptions.label_import_file_desc']					= 'Select a valid CSV file.';
	$_lang['clientexceptions.label_delimiter']							= 'Delimiter';
	$_lang['clientexceptions.label_delimiter_desc']						= 'The delimiter to separate the columns. Default is ";".';
	$_lang['clientexceptions.label_headers']							= 'First row column titles.';
	$_lang['clientexceptions.label_headers_desc']						= '';

	$_lang['clientexceptions.filter_context']							= 'Filter on context...';
	$_lang['clientexceptions.filter_type']								= 'Filter on type...';
	$_lang['clientexceptions.type_deny']								= 'Deny';
	$_lang['clientexceptions.type_grant']								= 'Grant';
	$_lang['clientexceptions.import_dir_failed']						= 'An error occurred while importing the exceptions, the import directory could not be created.';
	$_lang['clientexceptions.import_valid_failed']						= 'Select a valid CSV file..';
	$_lang['clientexceptions.import_upload_failed']						= 'An error occurred while importing the exceptions, the CSV could not be uploaded.';
	$_lang['clientexceptions.import_read_failed']						= 'An error occurred while importing the exceptions, the CSV could not be not be read.';
	$_lang['clientexceptions.export_failed']							= 'An error occurred while exporting the exceptions, try again.';
	$_lang['clientexceptions.export_dir_failed']						= 'An error occurred while exporting the exceptions, the import directory could not be created.';
	
?>