<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends MY_Controller {
	public function index(){
		if (!$_POST){
			$data = $this->db->get('soal')->result()[0];
			$this->twig->display('ujian/beranda', compact('data'));
		} else {
			$data = (object) $this->input->post();
			$data->nilai1 = '0';
			$data->nilai2 = '0';
			$data->nilai3 = '0';
			$data->nilai4 = '0';
			$data->nilai5 = '0';
			$this->db->insert('jawaban', $data);
			$this->twig->display('ujian/selesai');
		}
	}

	public function edit(){
		if (!$_POST){
			$data = $this->db->get('soal')->result()[0];
			$this->twig->display('admin/edit', compact('data'));
		} else {
			$data = (array) $this->input->post();
			$id = 1;
			$this->db->update('soal', $data, compact('id'));
			$this->twig->display('admin/selesai');
		}
	}

	public function tampil(){
		$data = $this->db->order_by('nama')->get('jawaban')->result();
		$soal = $this->db->get('soal')->result()[0];
		$this->twig->display('tampil/beranda', compact('data', 'soal'));
	}

	public function tampil_selesai(){
		$data = $this->db->order_by('nama')->get('jawaban')->result();
		$this->twig->display('tampil/selesai', compact('data'));
	}

	public function nilai($data, $nama){
		$list_data = explode('_', $data);
		$list_nama = explode('_', $nama);
		array_pop($list_data);
		array_pop($list_nama);
		foreach ($list_nama as $n => $x) {
			$list_nama[$n] = str_replace('%20', ' ', $x);
		}
		$list_data_1 = array();
		$list_data_2 = array();
		$list_data_3 = array();
		$list_data_4 = array();
		$list_data_5 = array();
		$dibagi_5 = count($list_data) / 5;
		for ($n = 0; $n < $dibagi_5; $n++){
			array_push($list_data_1, $list_data[$n]);
		}
		for ($n = $dibagi_5; $n < $dibagi_5 * 2; $n++){
			array_push($list_data_2, $list_data[$n]);
		}
		for ($n = $dibagi_5 * 2; $n < $dibagi_5 * 3; $n++){
			array_push($list_data_3, $list_data[$n]);
		}
		for ($n = $dibagi_5 * 3; $n < $dibagi_5 * 4; $n++){
			array_push($list_data_4, $list_data[$n]);
		}
		for ($n = $dibagi_5 * 4; $n < $dibagi_5 * 5; $n++){
			array_push($list_data_5, $list_data[$n]);
		}
		foreach ($list_data_1 as $n => $x) {
			$this->db->update('jawaban', array(
				'nilai1' => $x
			), array(
				'nama' => $list_nama[$n]
			));
		}
		foreach ($list_data_2 as $n => $x) {
			$this->db->update('jawaban', array(
				'nilai2' => $x
			), array(
				'nama' => $list_nama[$n]
			));
		}
		foreach ($list_data_3 as $n => $x) {
			$this->db->update('jawaban', array(
				'nilai3' => $x
			), array(
				'nama' => $list_nama[$n]
			));
		}
		foreach ($list_data_4 as $n => $x) {
			$this->db->update('jawaban', array(
				'nilai4' => $x
			), array(
				'nama' => $list_nama[$n]
			));
		}
		foreach ($list_data_5 as $n => $x) {
			$this->db->update('jawaban', array(
				'nilai5' => $x
			), array(
				'nama' => $list_nama[$n]
			));
		}
		redirect(base_url() . 'tampil-selesai');
	}
}
