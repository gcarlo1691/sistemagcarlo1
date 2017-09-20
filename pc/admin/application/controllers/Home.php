<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('HomeModel');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('table');
    }

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('home');

		
		/*$data['lista'] = $query;
		$data['item'] = 0;*/
		//$this->load->view('home');
	}
	
	public function lista()
	{
		$lista = $this->HomeModel->GetList();
		$data = array();
		$numero = $_POST['start'];
		foreach ($lista as $gl) {
			$numero++;
			$row = array();
			$row[] = $gl->REG_Cod;
			$row[] = $gl->REG_Nombre;
			$row[] = $gl->REG_Email;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="editar('."'".$gl->REG_Cod."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="eliminar('."'".$gl->REG_Cod."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}
		//SALIDA//
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->HomeModel->count_all(),
						"recordsFiltered" => $this->HomeModel->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ingresar()
	{
		$this->form_validation->set_rules('txtUsuario', 'Usuario', 'required');
		$this->form_validation->set_rules('txtPassword', 'Password', 'required',
											array('required'=>'DEBE DE INGRESAR CONTRASEÑA'));
		$this->form_validation->set_rules('passconf', 'REPETIR CONTRASEÑA', 'required');
		$this->form_validation->set_rules('txtEmail', 'CORREO', 'required');
		if ($this->form_validation->run() == FALSE)
        {        	
            $this->load->view('ingresar');
        }
        else
        {
        	$data = array(
			        'REG_Nombre' => $this->input->post('txtUsuario'),
			        'REG_Password' => $this->input->post('txtPassword'),
			        'REG_Email' => $this->input->post('txtEmail')
			);
			$this->db->insert('registro', $data);
            //$this->load->view('exito');
            $this->index();
        }
		//$this->load->view('ingresar');
	}
	
	public function editar($id){
		$data = $this->HomeModel->GetById($id);		
		echo json_encode($data);
	}
	public function modificar()
	{
        $this->_validate();
        $cod = $this->input->post('txtID');
        $data = array(
        	'REG_Nombre' 	=> $this->input->post('txtNombre'),
        	'REG_Email' 	=> $this->input->post('txtEmail'),
        );
        $this->HomeModel->ModifDat($data,$cod);
        echo json_encode(array("status" => TRUE));
	}

	public function eliminar($id)
	{
		$this->HomeModel->DeleteGetId($id);
		echo json_encode(array("status" => TRUE));
	}

	public function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('txtNombre') == '')
		{
			$data['inputerror'][] = 'txtNombre';
			$data['error_string'][] = 'REQUIRE INGRESAR DATOS NOMBRE';
			$data['status'] = FALSE;
		}

		if($this->input->post('txtEmail') == '')
		{
			$data['inputerror'][] = 'txtEmail';
			$data['error_string'][] = 'REQUIRE INGRESAR DATOS EMAIL';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
?>