<?php

class MainPageController extends MainController {
	
		
	public function index() {
		// Check if user is logged in, if not redirect to login page
		if (!auth()->isLoggedIn()) {
			$this->redirect(array('page' => 'Login', 'action' => 'index'));
		}
		
	}
	

	public function searchReferralSources() {
		$this->template = 'blank';

		$term = input()->query;
		if ($term != '') {
			$tokens = explode(' ', $term);
			$params = array();
			$classes = array(
				'ac_case_manager' => 'CaseManager',
				'ac_physician' => 'Physician',
				'ac_healthcare_facility' => 'HealthcareFacility'
			);

			//	Get the location to which the patient will be admitted 
			$location = $this->loadModel('Location', input()->location);
			$additionalStates = $this->loadModel('LocationLinkState')->getAdditionalStates($location->id);
			$params[":state"] = $location->state;
			foreach ($additionalStates as $key => $addState) {
				$params[":add_state{$key}"] = $addState->state;
			}

			$sql = null;

			foreach ($tokens as $idx => $token) {
				$token = trim($token);
				$params[":term{$idx}"] = "%{$token}%";
				foreach ($classes as $k => $t) {
					if ($k != 'ac_healthcare_facility') {
						$sql .= "(SELECT `{$k}`.`id`, `{$k}`.`public_id`, CONCAT(`{$k}`.`first_name`, ' ', `{$k}`.`last_name`) AS name, @type:=\"{$t}\" AS type FROM `{$k}`";
						if ($k == 'case_manager') {
							$sql .= " INNER JOIN `ac_healthcare_facility` ON `ac_healthcare_facility`.`id`=`case_manager`.`healthcare_facility_id`";
						}

						$sql .= " WHERE `{$k}`.`first_name` LIKE :term{$idx} OR `{$k}`.`last_name` LIKE :term{$idx}";
						if ($k == 'home_health_case_manager') {
							$sql .= " AND (`ac_healthcare_facility`.`state` = :state";
							foreach ($additionalStates as $key => $addState) {
								$sql .= " OR `ac_healthcare_facility`.`state` = :add_state{$key}";
								
							}
						} else {
							$sql .= " AND (`physician`.`state` = :state";
							foreach ($additionalStates as $key => $addState) {
								$sql .= " OR `ac_physician`.`state` = :add_state{$key}";
							}
						}
						$sql .= ")) UNION";
					} else {
						$sql .= "(SELECT `{$k}`.`id`, `{$k}`.`public_id`, `{$k}`.`name`, @type:=\"{$t}\" AS type FROM `{$k}` WHERE name LIKE :term{$idx} AND (`{$k}`.`state` = :state";
						foreach ($additionalStates as $key => $addState) {
							$sql .= " OR `{$k}`.`state` = :add_state{$key}";
						}
						$sql .= ")";
						$sql .= ") UNION";
					} 	
				}
				

			}

			$sql = trim($sql, ' UNION');

			foreach ($classes as $k => $c) {
				$class = new $c;
				$results[$k] = db()->fetchRows($sql, $params, $class);
			}

		} else {
			$results = array();
		}


		$resultArray = array();
		foreach ($results as $key => $r) {
			foreach ($r as $k => $i) {
				$resultArray['suggestions'][$k]['value'] = $i->name;
				$resultArray['suggestions'][$k]['data'] = array('id' => $i->id, 'type' => $i->type);
			}			
		}

		json_return($resultArray);
	}


	public function search_results() {
		$this->helper = 'PatientMenu';
		$term = input()->term;
		$search_results = $this->loadModel('Patient')->fetchPatientSearch($term);
		smarty()->assignByRef('search_results', $search_results);
	}


	protected function dateDiff($start, $end) {
			$start_ts = strtotime($start);
			$end_ts = strtotime($end);
			$diff = $end_ts - $start_ts;
			return round($diff / 86400);

	}



}