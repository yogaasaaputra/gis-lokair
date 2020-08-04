<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kecamatan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();

		$this->load->model('KecamatanModel', 'Model');
	}

	public function index()
	{
		$datacontent['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();

		$datacontent['url'] = 'kecamatan';
		$datacontent['title'] = 'Data Kecamatan';
		$datacontent['datatable'] = $this->Model->get();
		$data['content'] = $this->load->view('kecamatan/tableView', $datacontent, TRUE);
		$data['title'] = 'Halaman Data Kecamatan | GIS &ndash; LOKAIR';
		$this->load->view('layouts/admin/html', $data);
	}
	public function form($parameter = '', $id = '')
	{
		$datacontent['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();

		$datacontent['url'] = 'kecamatan';
		$datacontent['parameter'] = $parameter;
		$datacontent['id'] = $id;
		$datacontent['title'] = 'Form Kecamatan';
		$data['content'] = $this->load->view('kecamatan/formView', $datacontent, TRUE);
		$data['title'] = 'Halaman Form Kecamatan | GIS &ndash; LOKAIR';
		$this->load->view('layouts/admin/html', $data);
	}
	public function simpan()
	{
		if ($this->input->post()) {
			$data = [
				'kd_kecamatan' => $this->input->post('kd_kecamatan'),
				'nm_kecamatan' => $this->input->post('nm_kecamatan'),
				'warna_kecamatan' => $this->input->post('warna_kecamatan'),
			];
			// upload
			if ($_FILES['geojson_kecamatan']['name'] != '') {
				$upload = upload('geojson_kecamatan', 'geojson', 'geojson');
				if ($upload['info'] == true) {
					$data['geojson_kecamatan'] = $upload['upload_data']['file_name'];
				} elseif ($upload['info'] == false) {
					$info = '<div class="alert alert-danger alert-dismissible">
	            		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            		<h4><i class="icon fa fa-ban"></i> Error!</h4> ' . $upload['message'] . ' </div>';
					$this->session->set_flashdata('info', $info);
					redirect('kecamatan');
					exit();
				}
			}
			// upload
			if ($_POST['parameter'] == "tambah") {
				$this->Model->insert($data);
			} else {
				$this->Model->update($data, ['id_kecamatan' => $this->input->post('id_kecamatan')]);
			}
		}
		redirect('kecamatan');
	}

	public function hapus($id = '')
	{
		// hapus file di dalam folder
		$this->db->where('id_kecamatan', $id);
		$get = $this->Model->get()->row();
		$geojson_kecamatan = $get->geojson_kecamatan;
		unlink('assets/unggah/geojson/' . $geojson_kecamatan);
		// end hapus file di dalam folder
		$this->Model->delete(["id_kecamatan" => $id]);
		redirect('kecamatan');
	}
}
