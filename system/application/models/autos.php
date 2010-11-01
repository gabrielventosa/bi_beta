<?php

class Autos extends Model 
{


	function Autos()
	{
		parent::Model();

		// Other stuff
		$this->autos_table = 'auto';
	}
	
	// General function
	
	function get_all($offset = 0, $row_count = 0)
	{

		$query = NULL;
		
		if ($offset >= 0 AND $row_count > 0)
		{
			if($this->dx_auth->get_permission_value('auto_access') == 'all' || $this->dx_auth->is_admin()){	
				$query = $this->db->get($this->autos_table, $row_count, $offset);
			}
			else{
				$role_id = $this->dx_auth->get_role_id();
				$authorized_vehicles = unserialize($this->dx_auth->get_permission_value($role_id,'authorized_vehicles'));
				foreach ($authorized_vehicles as $vehicle){
					$this->db->or_where('id', $vehicle);
				}
				$query = $this->db->get($this->autos_table, $row_count, $offset);
			}
		}
		else
		{
			if($this->dx_auth->get_permission_value('auto_access') == 'all' || $this->dx_auth->is_admin()){	
				$query = $this->db->get($this->autos_table);
			}
			else{
				$role_id = $this->dx_auth->get_role_id();
				$authorized_vehicles = unserialize($this->dx_auth->get_permission_value('authorized_vehicles'));
				foreach ($authorized_vehicles as $vehicle){
					$this->db->or_where('id', $vehicle);
				}
				$query = $this->db->get($this->autos_table);
			}
		}
		
		return $query;
	}

	function get_vehicle_data($id)
	{

		$query = NULL;
		
		$query =  $this->db->where('id',$id);
		$query = $this->db->get($this->autos_table);
		
		return $query;
	}	
	
	function get_vehicle_gpspos($id){
		
		$ubicar_db = $this->load->database('ubicar',TRUE);
		$vehicle = $this->get_vehicle_data($id)->row();
		$ubicar_db->select("IMEI,latitud,longitud,speed,course,iodata,analog,dyn,DATE_FORMAT(CONVERT_TZ(timestamp,'MST','MST'),'%d %b %Y %T') as timestamp", FALSE);
		$ubicar_db->where('IMEI',$vehicle->imei);
		$lastpos = $ubicar_db->get('lastpos');
		return $lastpos;
	
	}

	function get_vehicle_actual_route($id){
	
		$ubicar_db = $this->load->database('ubicar',TRUE);
		$vehicle = $this->get_vehicle_data($id)->row();
		$ubicar_db->select('regist');
		$ubicar_db->where('IMEI',$vehicle->imei);
		$ubicar_db->where('dyn','0');
		$ubicar_db->order_by('regist','desc');
		$lastpos = $ubicar_db->get('gpsdata',1);
		$last_static_point = $lastpos->row()->regist;
		$ubicar_db->select("IMEI,latitud,longitud,speed,course,iodata,analog,dyn,DATE_FORMAT(CONVERT_TZ(timestamp,'MST','MST'),'%d %b %Y %T') as timestamp", FALSE);
		$ubicar_db->where('IMEI',$vehicle->imei);
		$ubicar_db->where('regist >',$last_static_point);
		$ubicar_db->where('dyn','1');
		$ubicar_db->where('latitud !=', '0');
		$ubicar_db->where('gpssats >', '03');
		$ubicar_db->order_by('regist','asc');
		$last_route = $ubicar_db->get('gpsdata');
		return $last_route;

	}


	
}

?>
