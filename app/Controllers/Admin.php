<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Admin',
			'proses' => 'home'
		];
		return view('admin/admin_view', $data);
	}
	public function user()
	{
		$data = [
			'title' => 'Admin',
			'proses' => 'user'
		];
		return view('admin/admin_view', $data);
	}
}
