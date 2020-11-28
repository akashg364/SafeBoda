<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function index()
	{
		echo "Safe Boda Case study";
	}

	public function generatePromoCode_get()
	{
		$event_id = $this->input->get('event_id');

		$promo_code = random_string('alnum', 8);

		$expiryDate = date('Y-m-d', strtotime('+30 days'));
		
		//check event is exists or not
		$event_res = $this->db->where('id', $event_id)->where('status', 1)->get('event')->row_array();
		
		if(!empty($event_res)){

			$data = array('eventId' => $event_id, 'code' => $promo_code, 'expiryDate' => $expiryDate, 'status' => 1, 'createdOn' => date("Y-m-d H:i:s"));

			$this->db->insert($table="promocode", $data);

			$last_insert_id = $this->db->insert_id();

			if($last_insert_id > 0){
				$this->response([
	                'status' => TRUE,
	                'message' => "Promo code for the Event : ".$promo_code,
	                'data' => $promo_code
	            ], REST_Controller::HTTP_OK);
			}
		}else{
				$this->response([
                'status' => TRUE,
                'message' => "Invalid event",
                'data' => array()
            ], REST_Controller::HTTP_OK);
		}
	}

	public function updatePromoCodeAmount_put()
	{
		$promo_code = $this->input->get('promo_code');
		$amount = $this->input->get('amount');

		//check promocode is exists or not
		$promocode_res = $this->db->where('code', $promo_code)->where('status', 1)->where('expiryDate >', date("y-m-d"))->get('promocode')->row_array();
		
		if(!empty($promocode_res)){

			$data = array('amount' => $amount, 'updatedOn' => date('Y-m-d H:i:s'));

			$res = $this->db->update($table="promocode", $data, $where=array('code' => $promo_code));

			if($res == 1){
				$this->response([
	                'status' => TRUE,
	                'message' => "Promo code amount updated successfully.",
	                'data' => ''
	            ], REST_Controller::HTTP_OK);
			}
		}else{
				$this->response([
                'status' => TRUE,
                'message' => "Invalid promo code",
                'data' => array()
            ], REST_Controller::HTTP_OK);
		}
	}

	public function deactivatePromoCode_put()
	{
		$promo_code = $this->input->get('promo_code');

		//check promocode is exists or not
		$promocode_res = $this->db->where('code', $promo_code)->where('status', 1)->where('expiryDate >', date("y-m-d"))->get('promocode')->row_array();
		
		if(!empty($promocode_res)){

			$data = array('status' => 2, 'updatedOn' => date('Y-m-d H:i:s'));

			$res = $this->db->update($table="promocode", $data, $where=array('code' => $promo_code));

			if($res == 1){
				$this->response([
	                'status' => TRUE,
	                'message' => "Promo code deactivated successfully.",
	                'data' => ''
	            ], REST_Controller::HTTP_OK);
			}
		}else{
				$this->response([
                'status' => TRUE,
                'message' => "Invalid promo code",
                'data' => array()
            ], REST_Controller::HTTP_OK);
		}
	}

	public function activePromoCodes_get()
	{
		//get all active promo code
		$promocode_res = $this->db->where('expiryDate >', date('Y-m-d'))->where('status', 1)->select('code')->get('promocode')->result_array();
		
		if(!empty($promocode_res)){

			$this->response([
                'status' => TRUE,
                'message' => "Active Promo codes",
                'data' => $promocode_res
            ], REST_Controller::HTTP_OK);

		}else{
				$this->response([
                'status' => TRUE,
                'message' => "Active Promo codes are not found.",
                'data' => array()
            ], REST_Controller::HTTP_OK);
		}
	}

	public function allPromoCodes_get()
	{
		//get all active promo code
		$promocode_res = $this->db->select('code')->get('promocode')->result_array();
		
		if(!empty($promocode_res)){

			$this->response([
                'status' => TRUE,
                'message' => "All Promo codes",
                'data' => $promocode_res
            ], REST_Controller::HTTP_OK);

		}else{
				$this->response([
                'status' => TRUE,
                'message' => "Promo code is not found.",
                'data' => array()
            ], REST_Controller::HTTP_OK);
		}
	}

	public function updatePromoCodeConfiguration_put()
	{
		$promo_code = $this->input->get('promo_code');
		$radius = $this->input->get('radius');

		//check promocode is exists or not
		$promocode_res = $this->db->where('code', $promo_code)->where('status', 1)->where('expiryDate >', date("y-m-d"))->get('promocode')->row_array();
		
		if(!empty($promocode_res)){

			$data = array('radius' => $radius, 'updatedOn' => date('Y-m-d H:i:s'));

			$res = $this->db->update($table="promocode", $data, $where=array('code' => $promo_code));

			if($res == 1){
				$this->response([
	                'status' => TRUE,
	                'message' => "Promo code configuration updated successfully.",
	                'data' => ''
	            ], REST_Controller::HTTP_OK);
			}
		}else{
				$this->response([
                'status' => TRUE,
                'message' => "Invalid promo code",
                'data' => array()
            ], REST_Controller::HTTP_OK);
		}
	}

	public function validatePromoCodeAgainstlocation_get()
	{
		
		$source_lat = $this->input->get('source_lat');
		$source_long = $this->input->get('source_long');
		$destination_lat = $this->input->get('destination_lat');
		$destination_long = $this->input->get('destination_long');
		$promo_code = $this->input->get('promo_code');

		if(!empty($source_lat) && !empty($source_long) && !empty($destination_lat) && !empty($destination_long)){
			$dis = $this->distance($source_lat, $source_long, $destination_lat, $destination_long);
			
			if($dis > 0){

				//check promo code is valid or not

				$event_res = $this->db->where('code', $promo_code)->where('radius >= ', $dis)->select(['code', 'amount', 'expiryDate', 'radius'])->get('promocode')->row_array();

				if(!empty($event_res)){
					$this->response([
		                'status' => TRUE,
		                'message' => "Promo code is valid.",
		                'data' => $event_res
		            ], REST_Controller::HTTP_OK);
				}else{
					$this->response([
		                'status' => TRUE,
		                'message' => "Promo code is invalid.",
		                'data' => array()
		            ], REST_Controller::HTTP_OK);
				}
			}else{
				$this->response([
	                'status' => TRUE,
	                'message' => "Provided details are not valid.",
	                'data' => array()
	            ], REST_Controller::HTTP_OK);
			}
			
		}
	}

	public function distance($lat1, $lon1, $lat2, $lon2) { 
		$pi80 = M_PI / 180; 
		$lat1 *= $pi80; 
		$lon1 *= $pi80; 
		$lat2 *= $pi80; 
		$lon2 *= $pi80; 
		$r = 6372.797; // mean radius of Earth in km 
		$dlat = $lat2 - $lat1; 
		$dlon = $lon2 - $lon1; 
		$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2); 
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a)); 
		$km = $r * $c; 
		//echo ' '.$km; 
		return $km; 
	}
}
