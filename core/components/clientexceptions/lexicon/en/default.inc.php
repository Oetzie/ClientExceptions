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

	$_lang['clientexceptions'] 											= 'IP Exception';
	$_lang['clientexceptions.desc'] 									= 'Manage your IP exceptions.';
	
	$_lang['area_clientexceptions'] 									= 'IP Exception';
			
	$_lang['clientexceptions.exception']								= 'Exception';
	$_lang['clientexceptions.exceptions']								= 'Exceptions';
	$_lang['clientexceptions.exceptions_desc']							= 'Manage the IP exceptions for your website here! This Extra allows you to control which IP addresses do or do not have permission to visit your MODX website.';
	$_lang['clientexceptions.exception_create']							= 'Create new exception';
	$_lang['clientexceptions.exception_update']							= 'Update exception';
	$_lang['clientexceptions.exception_remove']							= 'Delete exception';
	$_lang['clientexceptions.exception_remove_confirm']					= 'Are you sure you want to delete this exception?';
	$_lang['clientexceptions.exceptions_import']						= 'Import exceptions';
	$_lang['clientexceptions.exceptions_import_desc']					= 'Select a CSV file to import the exceptions. Make sure it is a valid CSV format.';
	$_lang['clientexceptions.exceptions_export']						= 'Export exceptions';
	
	$_lang['clientexceptions.label_ipnumber']							= 'IP address';
	$_lang['clientexceptions.label_ipnumber_desc']						= 'Use ^ to start an IP range (ex. ^127.0.), use $ to end an IP range (ex. .0.1$) and use % to activate a wildcard.';
	$_lang['clientexceptions.label_own_ipnumber']						= 'My IP';
	$_lang['clientexceptions.label_name']								= 'Name exception';
	$_lang['clientexceptions.label_name_desc']							= 'Enter the name of the exception.';
	$_lang['clientexceptions.label_context']							= 'Context';
	$_lang['clientexceptions.label_context_desc']						= 'Select the context for which the exception should be active. If no context is selected, the exception will be active in all contexts!';
	$_lang['clientexceptions.label_type']								= 'Exception type';
	$_lang['clientexceptions.label_type_desc']							= 'Grant or deny access of this exception.';
	$_lang['clientexceptions.label_description']						= 'Description (optional)';
	$_lang['clientexceptions.label_description_desc']					= 'Add a description.';
	$_lang['clientexceptions.label_active']								= 'Active';
	$_lang['clientexceptions.label_active_desc']						= '';
	$_lang['clientexceptions.label_import_file']						= 'File';
	$_lang['clientexceptions.label_import_file_desc']					= 'Select a valid CSV file.';
	$_lang['clientexceptions.label_import_delimiter']					= 'Delimiter';
	$_lang['clientexceptions.label_import_delimiter_desc']				= 'The delimiter to separate columns. Default is ";".';
	$_lang['clientexceptions.label_import_headers']						= 'First row consists of columns.';
	$_lang['clientexceptions.label_import_headers_desc']				= '';
	$_lang['clientexceptions.label_import_reset']						= 'Delete all current exceptions.';
	$_lang['clientexceptions.label_import_reset_desc']					= '';

	$_lang['clientexceptions.filter_context']							= 'Filter on context...';
	$_lang['clientexceptions.filter_type']								= 'Filter on type...';
	$_lang['clientexceptions.context_independent']						= 'Independent';	
	$_lang['clientexceptions.type_deny']								= 'Deny access';
	$_lang['clientexceptions.type_grant']								= 'Grant access';
	$_lang['clientexceptions.import_dir_failed']						= 'An error occurred while importing the exceptions, the import directory could not be created.';
	$_lang['clientexceptions.import_valid_failed']						= 'Select a valid CSV file!';
	$_lang['clientexceptions.import_upload_failed']						= 'An error occurred while importing the exceptions, the CSV could not be uploaded.';
	$_lang['clientexceptions.import_read_failed']						= 'An error occurred while importing the exceptions, the CSV could not be not be read.';
	$_lang['clientexceptions.export_failed']							= 'An error occurred while exporting the exceptions. Try again, please.';
	$_lang['clientexceptions.export_dir_failed']						= 'An error occurred while exporting the exceptions, the export directory could not be created.';
	
	$_lang['clientexceptions.error_own_ip']								= 'It is not possible to deny your own access!';
?>