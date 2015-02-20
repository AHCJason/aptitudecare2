<?php

class HealthcareFacility extends AppData {

	protected $table = 'healthcare_facility';

	protected $belongsTo = array(
		'LocationType' => array(
			'table' => 'ac_location_type',
			'join_type' => 'INNER',
			'inner_key' => 'location_type_id',
			'foreign_key' => 'id',
			'join_field' => array(
				'column' => 'description',
				'name' => 'ac_location_type'
			)
		)
	);

	protected $_manage_fields = array(
		'public_id',
		'name',
		'city',
		'state',
		'zip',
		'phone',
		'location_type'
	);

	protected $_add_fields = array(
		'name',
		'address',
		'city',
		'state',
		'zip',
		'phone',
		'fax'
	); 

}