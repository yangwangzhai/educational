<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
// 作业
include_once 'content_model.php';
class teacher_model extends content_model
{
	function __construct()
	{
		parent::__construct ();
		$this->table = 'fly_teacher';
	}

	// 教师附表 使用统计字段 +1
	function stat($uid, $field)
	{
		$this->db->where ( 'id', $uid );
		$this->db->set ( $field, $field.'+1', false );
		$this->db->update ( 'fly_teacher' );
	}

    function get_all_message($schoolid,$term,$school_type)
    {
        $sql="select * from fly_member m,fly_teacher t where m.id=t.id AND m.schoolid=$schoolid AND m.term=$term AND m.school_type=$school_type";
        $query=$this->db->query($sql);
        return $query->result_array();
    }

    function excel_import_member($member)
    {
        foreach($member as $key=>$value){
            $query = $this->db->insert ('fly_member',$value );
            $insert_id[$key]['id']=$in_id=$this->db->insert_id ();
            //  生成登录名
            $username = make_username($in_id);
            $this->db->query("update fly_member set username='$username' where id=$in_id limit 1");
        }
        return $insert_id;
    }

    function excel_import_teacher($teacher)
    {
        foreach($teacher as $key=>$value){
            $this->db->insert($this->table, $value);
        }
    }

    function get_one_teacher($classname,$course)
    {
        $term=$this->session->userdata('term');
        $school_type=$this->session->userdata('school_type');
        $query = $this->db->query(
            "select m.id,truename from fly_member m,fly_teacher t where m.id=t.id and m.term=$term AND m.school_type=$school_type AND
                 m.schoolid='$this->schoolid'and (manage_class like '%$classname%' or teach_class like '%$classname%') AND
                 FIND_IN_SET('$course', course) limit 1000");
        return $query->row_array();
    }













	
}
