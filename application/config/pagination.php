<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 分页属性
 * @author      lensic [mhy]
 * @link        http://www.lensic.cn/
 * @copyright   Copyright (c) 2013 - , lensic [mhy].
 */
$config['per_page']             = 10;
$config['total_rows'] = 20;
$config['uri_segment']          = 3;
$config['num_links']            = 10;
$config['first_link']           = '首页';
$config['last_link']            = '尾页';
$config['prev_link']            = '&lt;上一页';
$config['next_link']            = '下一页&gt;';
$config['page_query_string']    = TRUE;
$config['query_string_segment'] = 'pn';
$config['full_tag_open']        = '<div class="page_container"><div class="page_style">';
$config['full_tag_close']       = '</div><div class="cls"></div></div>';
$config['first_tag_open']       = '';
$config['first_tag_close']      = '';
$config['prev_tag_open']        = '';
$config['prev_tag_close']       = '';
$config['next_tag_open']        = '';
$config['next_tag_close']       = '';
$config['last_tag_open']        = '';
$config['last_tag_close']       = '';
$config['num_tag_open']         = '';
$config['num_tag_close']        = '';
$config['cur_tag_open']         = '<a class="page_in">';
$config['cur_tag_close']        = '</a>';

// $this->config->load('pagination', TRUE);
// $pagination = $this->config->item('pagination');
// $pagination['base_url'] = $this->baseurl;
// $pagination['total_rows'] = $count['num'];
// $this->load->library('pagination');
// $this->pagination->initialize($pagination);
// $data['pages'] = $this->pagination->create_links();


/* End of file pagination.php */
/* Location: ./application/config/pagination.php */