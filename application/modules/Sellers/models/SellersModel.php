<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SellersModel extends CI_Model
{
    public function GetAll()
    {
        $limit = $this->input->get('pageSize');
        $offset = $this->input->get('pageNumber');

        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('date_approved !=', null);
        $this->db->where('kode !=', null);
        $this->db->where('kode !=', '');
        $this->db->group_start();
        $this->db->where('aktif', '0');
        $this->db->or_where('aktif', '');
        $this->db->or_where('aktif', null);
        $this->db->group_end();
        $this->db->order_by('kode', 'asc');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function Get($seller_id)
    {
        return $this->db->get_where('member', array('kode' => $seller_id))->row();
    }
}

/* End of file SellersModel.php */
