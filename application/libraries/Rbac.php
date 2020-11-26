<?php
class RBAC 
{	
	private $module_access;
	function __construct()
	{
		$this->obj =& get_instance();
		$this->obj->module_access = $this->obj->session->userdata('module_access');
	}

	//----------------------------------------------------------------
	function set_access_in_session()
	{
		$this->obj->db->from('module_access');
		$this->obj->db->where('level',$this->obj->session->userdata('level'));
		$query=$this->obj->db->get();
		$data=array();
		foreach($query->result_array() as $v)
		{
			$data[strtolower($v['module'])][strtolower($v['operation'])] = '';
		}
		$this->obj->session->set_userdata('module_access',$data);
	} 	

	//--------------------------------------------------------------	
	function check_module_permission($module)
	{
		if(isset($this->obj->module_access[$module])) 
			return 1;
		else 
		 	return 0;
	}

	//--------------------------------------------------------------	
	function Check_operation_permission($operation)
	{
		if(isset($this->obj->module_access[strtolower($this->obj->uri->segment(1))][$operation])) 
			return 1;
		else 
		 	return 0;
	}

	//--------------------------------------------------------------	
	function check_module_access()
	{
		if(!$this->check_module_permission(strtolower($this->obj->uri->segment(1))))
		{
			if ( ($this->obj->uri->segment(1) !='login' OR $this->obj->uri->segment(1) !='Login') && $this->obj->session->userdata('level') == '') {
				redirect('login','refresh');
			}
			$back_to = $_SERVER['REQUEST_URI'];
			$back_to = $this->obj->functions->encode($back_to);
			redirect('access_denied/index/'.$back_to);
		}
	}

	//--------------------------------------------------------------	
	function check_operation_access()
	{
		$uri2 = ($this->obj->uri->segment(2) == '') ? 'index' : $this->obj->uri->segment(2);
		if(!$this->check_operation_permission(strtolower($uri2)))
		{
			$back_to =$_SERVER['REQUEST_URI'];
			$back_to = $this->obj->functions->encode($back_to);
			redirect('access_denied/index/'.$back_to);
		}
	}

}
?>