<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Users extends BaseController
{
	public $user_model;

	public $output = [
		'success'   => false,
		'message'   => '',
		'data'      => []
	];

	public function __construct()
	{
		$this->user_model = new \App\Models\UsersModel;
	}
	public function index()
	{
		return view('errors/html/error_404');
	}

	public function user_ajax_list()
	{
		$user_model = $this->user_model;
		$where = ['id' != 0];
		$column_order = array('', '', 'username',  'type', 'status');
		$column_search = array('username',  'type');
		$order = array('username' => 'ASC');
		$list = $user_model->get_datatables('users', $column_order, $column_search, $order, $where);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lists) {
			$no++;
			$row    = array();


			$password = '<a href="#" onclick="ganti_password(' . $lists->id . ') "title="Change Password"><span style="font-size: 1em; color: Mediumslateblue;"><i class="fa fa-key" aria-hidden="true"></i></span></a>';

			$edit = '<a href="#" onclick="form_edit_user(' . $lists->id . ') "title="Edit"><span style="font-size: 1em; color: Dodgerblue;"><i class="fa fa-edit"></i></span></a>';

			$delete = '<a href="#" onclick="delete_record(' . $lists->id . ') "title="Delete"><span style="font-size: 1em; color: Tomato;"><i class="fa fa-trash" ></i></span></a>';


			$row[]  = $password . '&nbsp;&nbsp;' . $edit .  '&nbsp;&nbsp;' . $delete;
			$row[]  = $no;
			$row[]  = $lists->username;
			$row[]  = $lists->type;
			$row[]  = $lists->status;
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $user_model->count_all('users', $where),
			"recordsFiltered" => $user_model->count_filtered('users', $column_order, $column_search, $order, $where),
			"data" => $data,
		);
		echo json_encode($output);
	}


	public function simpan_user_baru()
	{
		$user_model = $this->user_model;
		if ($this->request->isAJAX()) {
			$validation =  \Config\Services::validation();

			if (!$this->validate([
				'username' => 'required|is_unique[users.username]',
				'password' => 'required',
				'usertype' => 'required'
			])) {
				$this->output['errors'] = $validation->getErrors();
				echo json_encode($this->output);
			} else {
				$username = $this->request->getVar('username');
				$password = md5($this->request->getVar('password'));
				$type = $this->request->getVar('usertype');
				$status = '1';
				$user = [
					'username' => $username,
					'password' => $password,
					'type' => $type,
					'status' => $status
				];
				$simpan = $this->user_model->save($user);
				if ($simpan) {
					$this->output['success'] = true;
					$this->output['message']  = 'Record has been added successfully';
					echo json_encode($this->output);
				}
			}
		}
	}

	public function get_user()
	{
		$user_model = $this->user_model;
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('id_password');
			$result = $user_model->find($id);
			if ($result) {
				$this->output['success'] = true;
				$this->output['message']  = 'Data ditemukan';
				$this->output['data']   = $result;
				echo json_encode($this->output);
			}
		}
	}

	public function update_password_user()
	{
		$user_model = $this->user_model;
		if ($this->request->isAJAX()) {
			$validation =  \Config\Services::validation();

			if (!$this->validate([
				'password1' => 'required',
				'password2' => 'required'
			])) {
				$this->output['errors'] = $validation->getErrors();
				echo json_encode($this->output);
			} else {
				$password1 = $this->request->getVar('password1');
				$password2 = $this->request->getVar('password2');
				$id = $this->request->getVar('id_update');

				if ($password1 != $password2) {
					$this->output['errors'] = ['password2' => 'Password1 and Password2 not matches'];
					echo json_encode($this->output);
				} else {
					$data = [
						'password' => $password1
					];
					$update = $user_model->update($id, $data);
					if ($update) {
						$this->output['success'] = true;
						$this->output['message']  = 'Record has been updated successfully';
						echo json_encode($this->output);
					}
				}
			}
		}
	}
}
