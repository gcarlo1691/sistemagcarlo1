<?php
class HomeModel extends CI_Model
{
	var $table = 'registro';
	var $column_search = array('REG_Nombre','REG_Email');
	var $column_order = array('REG_Cod','REG_Nombre','REG_Email');
	var $order = array('REG_Cod' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function GetList()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function GetById($id)
	{
		$this->db->from($this->table);
		$this->db->where('REG_Cod',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function ModifDat($data,$id)
	{
		$this->db->set($data);
		$this->db->where('REG_Cod',$id);
		$this->db->update('registro');
	}

	public function DeleteGetId($id)
	{
		$this->db->where('REG_Cod', $id);
		$this->db->delete($this->table);
	}
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
}
?>