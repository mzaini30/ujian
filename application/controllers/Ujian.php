<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends MY_Controller {
	public function index(){
		if (!$_POST){
			$data = $this->db->get('soal')->result()[0];
			$this->twig->display('ujian/beranda', compact('data'));
		} else {
			$data = (array) $this->input->post();
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
		$data = $this->db->get('jawaban')->result();
		$this->twig->display('tampil/beranda', compact('data'));
	}
}
