<?php

class PatientBeverage extends Dietary {

  protected $table = "patient_beverage";

  public function fetchPatientBeverage($patient_id) {
    $order = $this->loadTable("Beverage");
    $sql = "SELECT * FROM {$this->tableName()} po right JOIN {$order->tableName()} AS d ON d.id = po.beverage_id and po.patient_id = :patient_id";
    $params[":patient_id"] = $patient_id;
    $result = $this->fetchAll($sql, $params);

    if (!empty ($result)) {
      return $result;
    }

    return false;

  }

  public function fetchByPatientAndBeverageId($patient_id, $beverage_id) {
    $sql = "SELECT * FROM {$this->tableName()} where patient_id = :patient_id AND beverage_id = :beverage_id";
    $params = array(":patient_id" => $patient_id, ":beverage_id" => $beverage_id);
    $result = $this->fetchOne($sql, $params);
    //pr($result); exit;

    if (!empty ($result)) {
      return $result;
    } else {
      return $this->fetchColumnNames();
    }
  }
}