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

	$_lang['clientexceptions'] 											= 'IP uitzonderingen';
	$_lang['clientexceptions.desc'] 									= 'Wijzig of maak IP uitzonderingen.';
	
	$_lang['area_clientexceptions']										= 'IP uitzonderingen';

	$_lang['clientexceptions.exception']								= 'Uitzondering';
	$_lang['clientexceptions.exceptions']								= 'Uitzonderingen';
	$_lang['clientexceptions.exceptions_desc']							= 'Hier kun je alle IP uitzonderingen beheren voor jouw website. Een IP uitzondering is bedoelt om iemand aan de hand van zijn of haar IP nummer toegang tot de website te verlenen of weigeren. Voor een wildcard in het IP nummer gebruik %, gebruik een ^ om een IP reeks te starten (bv ^172.0.) of gebruik $ om een IP reeks te eindigen (bv .0.1$).';
	$_lang['clientexceptions.exception_create']							= 'Nieuwe uitzondering';
	$_lang['clientexceptions.exception_update']							= 'Uitzondering wijzigen';
	$_lang['clientexceptions.exception_remove']							= 'Uitzondering verwijderen';
	$_lang['clientexceptions.exception_remove_confirm']					= 'Weet je zeker dat je deze uitzondering wilt verwijderen?';
	$_lang['clientexceptions.exceptions_remove_selected']				= 'Geselecteerde uitzonderingen verwijderen';
	$_lang['clientexceptions.exceptions_remove_selected_confirm']		= 'Weet je zeker dat je de geselecteerde uitzonderingen wilt verwijderen?';
	$_lang['clientexceptions.exceptions_activate_selected']				= 'Geselecteerde uitzonderingen activeren';
	$_lang['clientexceptions.exceptions_activate_selected_confirm']		= 'Weet je zeker dat je de geselecteerde uitzonderingen wilt activeren?';
	$_lang['clientexceptions.exceptions_deactivate_selected']			= 'Geselecteerde uitzonderingen deactiveren';
	$_lang['clientexceptions.exceptions_deactivate_selected_confirm']	= 'Weet je zeker dat je de geselecteerde uitzonderingen wilt deactiveren?';
	$_lang['clientexceptions.exceptions_import']						= 'Uitzonderingen importeren';
	$_lang['clientexceptions.exceptions_import_desc']					= 'Selecteer een CSV bestand om uitzonderingen te importeren. Het moet een geldig CSV formaat zijn.';
	$_lang['clientexceptions.exceptions_export']						= 'Uitzonderingen exporteren';
	
	$_lang['clientexceptions.label_ipnumber']							= 'IP nummer';
	$_lang['clientexceptions.label_ipnumber_desc']						= 'Het IP nummer van de uitzondering.';
	$_lang['clientexceptions.label_own_ipnumber']						= 'Mijn IP';
	$_lang['clientexceptions.label_name']								= 'Naam';
	$_lang['clientexceptions.label_name_desc']							= 'De naam van de uitzondering.';
	$_lang['clientexceptions.label_context']							= 'Context';
	$_lang['clientexceptions.label_context_desc']						= 'De context van de uitzondering. Als er geen context geselecteerd word geldt deze uitzondering voor alle contexten.';
	$_lang['clientexceptions.label_type']								= 'Uitzonderingstype';
	$_lang['clientexceptions.label_type_desc']							= 'De type van de uitzondering, dit kan "weigeren" of "verlenen" zijn.';
	$_lang['clientexceptions.label_description']						= 'Omschrijving/reden';
	$_lang['clientexceptions.label_description_desc']					= 'De omschrijving/reden van de uitzondering.';
	$_lang['clientexceptions.label_active']								= 'Actief';
	$_lang['clientexceptions.label_active_desc']						= '';
	$_lang['clientexceptions.label_import_file']						= 'Bestand';
	$_lang['clientexceptions.label_import_file_desc']					= 'Selecteer een geldig CSV bestand.';
	$_lang['clientexceptions.label_import_delimiter']					= 'Scheidingsteken';
	$_lang['clientexceptions.label_import_delimiter_desc']				= 'Het scheidingsteken waarmee kolommen gescheiden worden. Standaard is ";".';
	$_lang['clientexceptions.label_import_headers']						= 'Eerste rij zijn kolommen.';
	$_lang['clientexceptions.label_import_headers_desc']				= '';
	$_lang['clientexceptions.label_import_reset']						= 'Verwijder alle huidige uitzonderingen.';
	$_lang['clientexceptions.label_import_reset_desc']					= '';
	
	$_lang['clientexceptions.filter_context']							= 'Filter op context...';
	$_lang['clientexceptions.filter_type']								= 'Filter op type...';
	$_lang['clientexceptions.context_independent']						= 'Onafhankelijk';			
	$_lang['clientexceptions.type_deny']								= 'Weigeren';
	$_lang['clientexceptions.type_grant']								= 'Verlenen';
	$_lang['clientexceptions.import_dir_failed']						= 'Er is een fout opgetreden tijdens het importeren van de uitzonderingen, de import folder kon niet aangemaakt worden.';
	$_lang['clientexceptions.import_valid_failed']						= 'Selecteer een geldig CSV bestand.';
	$_lang['clientexceptions.import_upload_failed']						= 'Er is een fout opgetreden tijdens het importeren van de uitzonderingen, het CSV bestand kon niet geüpload worden.';
	$_lang['clientexceptions.import_read_failed']						= 'Er is een fout opgetreden tijdens het importeren van de uitzonderingen, het CSV bestand kon niet gelezen worden.';
	$_lang['clientexceptions.export_failed']							= 'Het exporteren van de uitzonderingen is mislukt, probeer het nog eens.';
	$_lang['clientexceptions.export_dir_failed']						= 'Er is een fout opgetreden tijdens het exporteren van de uitzonderingen, de export folder kon niet aangemaakt worden.';
	
	$_lang['clientexceptions.error_own_ip']								= 'Het is niet mogelijk om jezelf de toegang te weigeren.';
	
?>