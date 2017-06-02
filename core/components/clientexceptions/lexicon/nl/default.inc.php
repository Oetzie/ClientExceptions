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
	$_lang['clientexceptions.desc'] 									= 'Beheer je IP uitzonderingen!';
	
	$_lang['area_clientexceptions']										= 'IP Exception';

	$_lang['clientexceptions.exception']								= 'Uitzondering';
	$_lang['clientexceptions.exceptions']								= 'Uitzonderingen';
	$_lang['clientexceptions.exceptions_desc']							= 'Beheer de IP uitzonderingen van jouw website hier! Deze Extra stelt jou in staat om te beheren welke IP adressen wel of geen toegang krijgen om jouw website te bezoeken.';
	$_lang['clientexceptions.exception_create']							= 'Nieuwe uitzondering';
	$_lang['clientexceptions.exception_update']							= 'Uitzondering wijzigen';
	$_lang['clientexceptions.exception_remove']							= 'Uitzondering verwijderen';
	$_lang['clientexceptions.exception_remove_confirm']					= 'Weet je zeker dat je deze uitzondering wilt verwijderen?';
	$_lang['clientexceptions.exceptions_import']						= 'Uitzonderingen importeren';
	$_lang['clientexceptions.exceptions_import_desc']					= 'Selecteer een CSV bestand om uitzonderingen te importeren. Dit moet een geldig CSV formaat zijn.';
	$_lang['clientexceptions.exceptions_export']						= 'Uitzonderingen exporteren';
	
	$_lang['clientexceptions.label_ipnumber']							= 'IP adres';
	$_lang['clientexceptions.label_ipnumber_desc']						= 'Gebruik ^ om een IP reeks te starten (vb. ^127.0.), gebruik $ om een IP reeks te eindigen (vb. .0.1$) en gebruik % om een wildcard te activeren.';
	$_lang['clientexceptions.label_own_ipnumber']						= 'Mijn IP';
	$_lang['clientexceptions.label_name']								= 'Naam uitzondering';
	$_lang['clientexceptions.label_name_desc']							= 'Voer naam van de uitzondering in.';
	$_lang['clientexceptions.label_context']							= 'Context';
	$_lang['clientexceptions.label_context_desc']						= 'Selecteer de context waarbinnen de uitzondering actief moet zijn. Als er geen context wordt geselecteerd, zal de uitzondering actief zijn in alle contexten!';
	$_lang['clientexceptions.label_type']								= 'Uitzondering type';
	$_lang['clientexceptions.label_type_desc']							= 'Weiger of verleen de toegang aan deze uitzondering.';
	$_lang['clientexceptions.label_description']						= 'Omschrijving (optioneel)';
	$_lang['clientexceptions.label_description_desc']					= 'Voeg een omschrijving toe.';
	$_lang['clientexceptions.label_active']								= 'Actief';
	$_lang['clientexceptions.label_active_desc']						= '';
	$_lang['clientexceptions.label_import_file']						= 'Bestand';
	$_lang['clientexceptions.label_import_file_desc']					= 'Selecteer een geldig CSV bestand.';
	$_lang['clientexceptions.label_import_delimiter']					= 'Scheidingsteken';
	$_lang['clientexceptions.label_import_delimiter_desc']				= 'Het scheidingsteken om kolommen te scheiden. Standaard is ";".';
	$_lang['clientexceptions.label_import_headers']						= 'Eerste rij bestaat uit kolommen.';
	$_lang['clientexceptions.label_import_headers_desc']				= '';
	$_lang['clientexceptions.label_import_reset']						= 'Verwijder alle huidige uitzonderingen.';
	$_lang['clientexceptions.label_import_reset_desc']					= '';
	
	$_lang['clientexceptions.filter_context']							= 'Filter op context...';
	$_lang['clientexceptions.filter_type']								= 'Filter op type...';
	$_lang['clientexceptions.context_independent']						= 'Onafhankelijk';			
	$_lang['clientexceptions.type_deny']								= 'Toegang weigeren';
	$_lang['clientexceptions.type_grant']								= 'Toegang verlenen';
	$_lang['clientexceptions.import_dir_failed']						= 'Er is een fout opgetreden tijdens het importeren van de uitzonderingen, de import map kon niet worden aangemaakt.';
	$_lang['clientexceptions.import_valid_failed']						= 'Selecteer een geldig CSV bestand!';
	$_lang['clientexceptions.import_upload_failed']						= 'Er is een fout opgetreden tijdens het importeren van de uitzonderingen, het CSV bestand kon niet worden geüpload.';
	$_lang['clientexceptions.import_read_failed']						= 'Er is een fout opgetreden tijdens het importeren van de uitzonderingen, het CSV bestand kon niet worden gelezen.';
	$_lang['clientexceptions.export_failed']							= 'Het exporteren van de uitzonderingen is mislukt. Probeer het a.u.b. opnieuw.';
	$_lang['clientexceptions.export_dir_failed']						= 'Er is een fout opgetreden tijdens het exporteren van de uitzonderingen, de export map kon niet worden aangemaakt.';
	
	$_lang['clientexceptions.error_own_ip']								= 'Het is niet mogelijk om je eigen toegang te weigeren!';
?>