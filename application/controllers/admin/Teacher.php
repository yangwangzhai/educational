<?php

include 'content.php';

/**
 * 教师控制器
 * @author qcl 2016/01/06
 *
 */
class Teacher extends Content {
    /**
     * 构造器
     */
    function __construct ()
    {
        $class_name = 'teacher';
        $this->name = "教师";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=teacher'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('teacher_base_model');
        $this->load->model('classroom_model');
        $this->load->model('history_model');
        $this->load->model('train_model');
        $this->load->model('train_num_model');
    }

    /**
     *主页面
     */
    function index()
    {
        $grade = $this->input->post('grade')?$this->input->post('grade'):2015;

        //$course=array("语文","数学","英语","物理","化学","政治","历史","生物","地理","体育","信息","健教","音乐");
        //按照科目，分布取出所有老师
        $list=array();
        $where="grade_group=$grade";
        $list=$this->teacher_base_model->get_column("*","fly_teacher_base",$where);


        /*foreach($list as &$item)
        {
            $item['addtime']=times($item['addtime']);
            $item['gender']=config_item('gender')[$item['gender']];
            if($item['thumb'])
            {
                $thumb=small_name($item['thumb']);
                $item['thumb']="<img src='$thumb' width='40'>";
            }
            $item['teach_class']=$this->classroom_model->get_classname_by_ids($item['teach_class']);
            $item['manage_class']=$this->classroom_model->get_classname_by_ids($item['manage_class']);
        }*/
        $data['list'] = $list;
        $data['grade']=$grade;

        $this->load->view('admin/' . $this->list_view, $data);
    }

    //同步教师数据（根据fly_course_plan fly_teacher 更新fly_teacher_base）
    public function synchronize(){
        //先清空fly_teacher_base表
        $sql="truncate table fly_teacher_base";
        $this->db->query($sql);
        //获取fly_teacher最新的数据
        $sql="select id from fly_task ORDER by id desc limit 0,1";
        $query=$this->db->query($sql);
        $term=$query->row_array();
        $list=$this->teacher_base_model->get_column("teacher,teach_course","fly_teacher","term=$term[id]");
        $insert_teacher_base=array();

        foreach($list as $list_key=>$list_value){
            $result=$this->teacher_base_model->get_column("grade,classname","fly_course_plan","term=$term[id] and teacher='$list_value[teacher]'");
            $insert_teacher_base['truename']=$list_value['teacher'];
            $insert_teacher_base['course']=$list_value['teach_course'];
            $insert_teacher_base['grade_group']=getMinAndMaxInArray($result);
            $str='';
            foreach($result as $r_key=>$r_value){
                $str.=$r_value['grade'].$r_value['classname'].',';
            }
            $insert_teacher_base['teach_class']=substr($str, 0, -1);
            $this->teacher_base_model->db_insert_table("fly_teacher_base",$insert_teacher_base);
        }
        //同步班级信息
        //先清空fly_teacher_base表
        $sql="truncate table fly_classroom";
        $this->db->query($sql);
        //获取fly_course_plan年级总数
        $sql="SELECT DISTINCT grade FROM fly_course_plan ";
        $query=$this->db->query($sql);
        $grade=$query->result_array();

        //获取fly_course_plan各个年级对应的班级数
        foreach($grade as $grade_key=>$grade_value){
            $sql="SELECT DISTINCT classname FROM fly_course_plan where grade='$grade_value[grade]'";
            $query=$this->db->query($sql);
            $classname=$query->result_array();
            foreach ($classname as $item) {
                $insert_classroom['schoolid']=1;
                $insert_classroom['grade']=$grade_value['grade'];
                $insert_classroom['classname']=$grade_value['grade'].$item['classname'];
                $this->teacher_base_model->db_insert_table("fly_classroom",$insert_classroom);
            }
        }

        $_SESSION['url_forward'] = $this->baseurl . "&m=index";
        show_msg ( '同步更新成功！' ,$_SESSION['url_forward']);
    }

    function history()
    {
        $searchsql = "1 AND schoolid=$this->schoolid";
        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND truename like '%{$keywords}%' ";
        }

        $data['list'] = array();
        $count = $this->teacher_base_model->counts($searchsql);
        $data['count'] = $count;


        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $this->baseurl;
        $pagination['total_rows'] = $count;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();


        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->teacher_base_model->get_list('*',$searchsql,$offset,20);

        $data['list'] = $list;

        $teacherid = $this->input->get('teacherid')?$this->input->get('teacherid'):'0';
        $value=$this->history_model->get_history_by_teacherid($teacherid);
        $data['teacherid']=$value['teacherid'];
        if(empty($value))
        {
            $value=array(
                'schoolid'=>$this->schoolid,
                'addtime'=>time(),
                'updatetime'=>time(),
                'edu'=>'',
                'works'=>'',
                'spec'=>'',
                'lang'=>'',
                'it'=>'',
                'jc'=>'',
                'selfcomm'=>'',
                'teacherid'=>$teacherid
            );
            $insert_id=$this->history_model->insert($value);
            $data['id']=$insert_id;
        }
        $train=$this->train_num_model->get_list('train_id',"teacherid=$teacherid");
        $data['train']=$this->train_model->append_list($train);

        $data['id']=$value['id'];
        $data['value']=$value;

        $_SESSION['url_forward'] = $this->baseurl . "&m=history&teacherid=$teacherid&per_page=$offset";
        $this->load->view ( 'admin/history_edit',$data );
    }
    // 保存 添加和修改都是在这里
    public function history_save() {
        $data = trims ( $_POST ['value'] );
        $id = $this->input->post('id');
        $data['updatetime']=time();
        // 修改 ===========
        $this->history_model->update($id,$data);
        show_msg ( '保存成功！' ,$_SESSION['url_forward']);

    }
    /**
     * 添加
     *
     */
    public function add() {
        $data['classid_array'] = array();
        $data['manageid_array'] = array();
        $data['value']['birthday'] = '1986-01-01';
        $data['value']['joinin'] = date('Y-m-d',time());
        $data['value']['expireto'] =date('Y-m-d', strtotime('+1 year', time()));
        $arr=$this->classroom_model->get_field($this->schoolid);
        $data['class_list']=$arr;
        $this->load->view('admin/' . $this->add_view, $data);
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $teacher=$this->teacher_base_model->get_one($id);
        $arr=$this->classroom_model->get_field($this->schoolid);
        $data['manageid_array'] = explode(',', $teacher['manage_class']);
        $data['classid_array'] = explode(',', $teacher['teach_class']);
        $data['class_list']=$arr;
        $data['value'] = $teacher;
        $data['id'] = $id;

        $this->load->view('admin/' . $this->edit_view, $data);
    }

    /**
     *保存
     */
    public function save()
    {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );

        $data['schoolid'] = $this->schoolid;

        if ($data ['truename'] == "") {
            show_msg ( '姓名不能为空' );
        }
        // 检查手机号码
        if (empty($data ['tel'])) {
            show_msg ( '办公电话不能为空' );
        }

        if($this->teacher_base_model->is_tel_exist($data['tel'], $id)){
            show_msg ( '手机号码已经存在，请更换' );
        }
        if($data['joinin']==''){
            unset($data['joinin']);
        }
        if($data['expireto']==''){
            unset($data['expireto']);
        }
        if($data['birthday']==''){
            unset($data['birthday']);
        }
        if ($data ['thumb']) {
            thumb ( $data ['thumb'] );
        }

        // 附表
        $data['teach_class'] = $data['manage_class'] = '';
        $manage = $this->input->post ('manage');
        if(!empty($manage)) $data['manage_class'] = join(',', ($manage));
        $class = $this->input->post ('class');
        if(!empty($class)) $data['teach_class'] = join(',', ($class));

        if ($id) { // 修改 ===========
            $data['status2'] = 1;
            $this->teacher_base_model->update($id,$data);

            show_msg ( '修改成功！', $_SESSION ['url_forward'] );

        } else { // ===========添加 ===========
            $data['password'] = get_password('123456');
            $data ['addtime'] = time ();
            $insert_id = $this->teacher_base_model->insert ($data);


            //  生成登录名
            $username = make_username($insert_id);
            $this->teacher_base_model->update($insert_id,array('username'=>$username));

            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }
    // 删除
    public function delete ()
    {
        $ids = $this->input->get('id')?$this->input->get('id'):$this->input->post('delete[]');
        if (is_array($ids))
        {
            $this->teacher_base_model->delete($ids);

            show_msg('删除成功！', $_SESSION['url_forward']);
        }
        else
        {
            $this->teacher_base_model->delete($ids);

            show_msg('删除成功！', $_SESSION['url_forward']);
        }
    }

    /**
     *教师详细信息
     */
    function detail()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value=$this->teacher_base_model->get_one($id);
        $value['teach_class']=$this->classroom_model->get_classname_by_ids($value['teach_class']);
        $value['manage_class']=$this->classroom_model->get_classname_by_ids($value['manage_class']);
        $data['value']=$value;
        $data['id'] = $id;
        $history=$this->history_model->get_history_by_teacherid($id);
        if(empty($history))
        {
            $history=array(
                'schoolid'=>$this->schoolid,
                'addtime'=>time(),
                'updatetime'=>time(),
                'edu'=>'',
                'works'=>'',
                'spec'=>'',
                'lang'=>'',
                'it'=>'',
                'jc'=>'',
                'selfcomm'=>'',
                'teacherid'=>$id
            );
            $this->history_model->insert($history);
        }
        $data['history']=$history;
        $train=$this->train_num_model->get_list('train_id',"teacherid=$id");
        $data['train']=$this->train_model->append_list($train);
        $this->load->view('admin/teacher_detail', $data);
    }
    /**
     *教师信息
     */
    function info()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value=$this->teacher_base_model->get_one($id);
        $value['teach_class']=$this->classroom_model->get_classname_by_ids($value['teach_class']);
        $value['manage_class']=$this->classroom_model->get_classname_by_ids($value['manage_class']);
        $data['value']=$value;

        $data['id'] = $id;
        $data['prepage']=$this->teacher_base_model->getPrePage($id);
        $data['nextpage']=$this->teacher_base_model->getNextPage($id);
        $this->load->view('admin/teacher_info', $data);
    }
    /**
     *图表分析
     */
    function statistic()
    {
        $this->load->view('admin/teacher_statistic');
    }
    function ajax_statistic()
    {
        $types=$this->input->post('types');
            switch ($types) {
                case 'joinin':
                    $re= $this->teacher_base_model->statistic_joinin($this->schoolid);

                    foreach ($re as $key=>$item) {
                        $list[$key]['name']=$item['age'];
                        $list[$key]['group']='';
                        $list[$key]['value']=$item['num'];
                    }
                    break;
                case 'degrees':

                    $re = $this->teacher_base_model->statistic_degrees($this->schoolid);
                    $degrees = $this->config->item('degrees');
                    foreach ($re as $key=>$item) {
                        $list[$key]['name']=$degrees[$item['degrees']];
                        $list[$key]['value']=$item['num'];
                    }
                    break;
                case 'gender':

                    $re = $this->teacher_base_model->statistic_gender($this->schoolid);
                    $gender = $this->config->item('gender');
                    foreach ($re as $key=>$item) {
                        $list[$key]['name']=$gender[$item['gender']];
                        $list[$key]['value']=$item['num'];
                    }
                    break;
                case 'marry':

                    $re = $this->teacher_base_model->statistic_marry($this->schoolid);
                    $marry = $this->config->item('marry');
                    foreach ($re as $key=>$item) {
                        $list[$key]['name']=$marry[$item['marry']];
                        $list[$key]['value']=$item['num'];
                    }
                    break;
                case 'dept':
                    //data:数据格式：Result2=[{name:XXX,group:XXX,value:XXX},{name:XXX,group:XXX,value:XXX]
                    $re = $this->teacher_base_model->statistic_dept($this->schoolid);
                    $dept = $this->config->item('dept');
                    foreach ($re as $key=>$item) {
                        $list[$key]['name']=$dept[$item['dept']];
                        $list[$key]['group']='';
                        $list[$key]['value']=$item['num'];
                    }
                    break;
                case 'birthday':

                    $re = $this->teacher_base_model->statistic_birthday($this->schoolid);
                    $MONTH= $this->config->item('MONTH');

                    foreach ($re as $key=>$item) {
                        $list[$key]['name']=$MONTH[$item['months']];
                        $list[$key]['group']='';
                        $list[$key]['value']=$item['num'];
                    }
                    break;
            }
        echo json_encode($list);exit;

    }
    function teacher_leave_count()
    {
        $this->load->view('admin/teacher_leave_count');
    }

    function ajax_teacher_leave_count(){




    }



    function teacher_test_count_1()
    {
        $this->load->view('admin/teacher_test_count_1');
    }
    function teacher_test_count_2()
    {
        $this->load->view('admin/teacher_test_count_2');
    }
    function teacher_attendance_count()
    {
        $this->load->view('admin/teacher_attendance_count');
    }


    // 弹出框
    function dialog ()
    {
        $where="schoolid=$this->schoolid";

        $data['list'] = $this->teacher_base_model->get_list('id,truename',$where,0,50);

        $this->load->view('admin/teacher_dialog', $data);
    }
    /**
     * 更新 访问量
     *
     * @param int $id
     * @param int $status
     * @return array 二维数组
     */
    function update_status() {
        $id=$this->input->get('id');
        $status=$this->input->get('status');
        if ($id == 0)
            return false;
          $this->teacher_base_model->update ($id,array('status'=>$status));
    }
    // 修改密码页
    public function password() {
        $id = $this->input->get('id');

        // 这条信息
        $value = $this->teacher_base_model->get_one ($id);

        $data ['id'] = $id;
        $data ['value'] = $value;
        $this->load->view ( 'admin/teacher_password' , $data );
    }

    // 保存密码
    public function password_save() {
        $id = $this->input->post('id');
        $data = trims ( $_POST ['value'] );

        if ($data ['password'] == "") {
            show_msg ( '密码不能为空' );
        }
        if ($data ['password'] != $data ['password2']) {
            show_msg ( '两次密码不相同' );
        }
        if (strlen($data ['password'])<6) {
            show_msg ( '密码不能少于6位' );
        }

        $data ['password'] = get_password ( $data ['password'] );
        unset($data ['password2']);

        $this->teacher_base_model->update($id,$data);

        show_msg ( '修改成功！', $_SESSION ['url_forward'] );
    }
    // 导出Excel
    public function excelOut ()
    {
        $searchsql = "schoolid='$this->schoolid'";
        $list = $this->teacher_base_model->get_list('truename,username,password',$searchsql,0,200);
        $table_data = '<table border="1"><tr>
      			<th>姓名</th>
				<th>登录账号</th>
				<th>登录密码</th>
    			</tr>';

        header('Content-Type: text/xls');
        header("Content-type:application/vnd.ms-excel;charset=utf-8");
        // $str = mb_convert_encoding($file_name, 'gbk', 'utf-8');
        header('Content-Disposition: attachment;filename="幼儿园-教师登录账号.xls"');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        foreach ($list as $line) {
            $table_data .= '<tr>';

            foreach ($line as $key => &$item) {
                // $item = mb_convert_encoding($item, 'gbk', 'utf-8');
                $table_data .= '<td>' . $item . '</td>';
            }
            $table_data .= '</tr>';
        }
        $table_data .= '</table>';
        echo $table_data;
    }

    //教研组信息
    public function teach_manage(){
       //先自定义教研数组
       $teach_manage_arr=array('语文','数学','英语','物理','化学','生地','政治','历史','体健','音艺','电教');
       foreach($teach_manage_arr as $key=>$value){
           if($value=='生地'){
               $where="course='生物' OR course='地理'";
               $where_supervisor="(teach_supervisor=1 AND course='生物') OR (teach_supervisor=1 AND course='地理')";
           }elseif($value=='体健'){
               $where="course='体育' OR course='健教'";
               $where_supervisor="(teach_supervisor=1 AND course='体育') OR (teach_supervisor=1 AND course='健教')";
           }elseif($value=='音艺'){
               $where="course='音乐'";
               $where_supervisor="teach_supervisor=1 AND course='音乐'";
           }elseif($value=='电教'){
               $where="course='信息'";
               $where_supervisor="teach_supervisor=1 AND course='信息'";
           }else{
               $where="course='$value'";
               $where_supervisor="teach_supervisor=1 AND course='$value'";
           }
           $num=$this->teacher_base_model->db_counts('fly_teacher_base',$where);
           $supervisor=$this->teacher_base_model->get_column2('truename','fly_teacher_base',$where_supervisor);
           $group=$this->teacher_base_model->get_column('truename','fly_teacher_base',$where);
           $data[$key]['num']=$num;
           $data[$key]['teach_supervisor']=$supervisor['truename'];
           $data[$key]['group']=$value;
           $data[$key]['group_detail']=$group;
       }
            $mess['list']=$data;

        $this->load->view ( 'admin/teach_manage_group' , $mess );
    }

    public function teach_group_detail(){
        $group=$this->input->get('group');
        if($group=='生地'){
            $where="course='生物' OR course='地理'";
            $where_supervisor="(teach_supervisor=1 AND course='生物') OR (teach_supervisor=1 AND course='地理')";
        }elseif($group=='体健'){
            $where="course='体育' OR course='健教'";
            $where_supervisor="(teach_supervisor=1 AND course='体育') OR (teach_supervisor=1 AND course='健教')";
        }elseif($group=='音艺'){
            $where="course='音乐'";
            $where_supervisor="teach_supervisor=1 AND course='音乐'";
        }elseif($group=='电教'){
            $where="course='信息'";
            $where_supervisor="teach_supervisor=1 AND course='信息'";
        }else{
            $where="course='$group'";
            $where_supervisor="teach_supervisor=1 AND course='$group'";
        }
        $res1=$this->teacher_base_model->get_column('truename','fly_teacher_base',$where);
        $value['group']=$res1;
        $res2=$this->teacher_base_model->get_column2('truename','fly_teacher_base',$where_supervisor);
        $value['supervisor']=$res2['truename'];
        $data['list']=$value;

        $this->load->view("admin/teach_group_detail",$data);
    }

    public function teach_activity_index(){
        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $total_rows=$this->teacher_base_model->rows_query('fly_teach_activity');

        $pagination['total_rows'] =$total_rows;
        $pagination['base_url'] = $this->baseurl."&m=teach_activity_index";
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('pn') ? intval($this->input->get('pn')) : 0;
        $data['list'] = $this->teacher_base_model->get_list2('*',"",'fly_teach_activity',$offset,10);

        $this->load->view('admin/teach_activity_index',$data);
    }

    public function teach_activity_add(){
        $this->load->view('admin/teach_activity_add');
    }

    public function group_dialog(){
        //先自定义教研数组
        $teach_manage_arr=array('语文','数学','英语','物理','化学','生地','政治','历史','体健','音艺','电教');
        $data['list']=$teach_manage_arr;
        $this->load->view('admin/group_dialog', $data);
    }

    public function manager_dialog(){
        $group=$this->input->get("group");
        if($group=='生地'){
            $where="(course='生物' AND teach_supervisor=0) OR (course='地理' AND teach_supervisor=0)";
            $where_supervisor="(teach_supervisor=1 AND course='生物') OR (teach_supervisor=1 AND course='地理')";
        }elseif($group=='体健'){
            $where="(course='体育' AND teach_supervisor=0) OR (course='健教' AND teach_supervisor=0)";
            $where_supervisor="(teach_supervisor=1 AND course='体育') OR (teach_supervisor=1 AND course='健教')";
        }elseif($group=='音艺'){
            $where="course='音乐' AND teach_supervisor=0";
            $where_supervisor="teach_supervisor=1 AND course='音乐'";
        }elseif($group=='电教'){
            $where="course='信息' AND teach_supervisor=0";
            $where_supervisor="teach_supervisor=1 AND course='信息'";
        }else{
            $where="course='$group' AND teach_supervisor=0";
            $where_supervisor="teach_supervisor=1 AND course='$group'";
        }
        $res1=$this->teacher_base_model->get_column('truename','fly_teacher_base',$where);
        $value['group']=$res1;
        $res2=$this->teacher_base_model->get_column2('truename','fly_teacher_base',$where_supervisor);
        $value['supervisor']=$res2['truename'];
        $data['list']=$value;

        $this->load->view('admin/manager_dialog', $data);
    }

    public function member_dialog(){
        $group=$this->input->get("group");
        if($group=='生地'){
            $where="course='生物' OR course='地理'";
        }elseif($group=='体健'){
            $where="course='体育' OR course='健教'";
        }elseif($group=='音艺'){
            $where="course='音乐'";
        }elseif($group=='电教'){
            $where="course='信息'";
        }else{
            $where="course='$group'";
        }
        $data['list']=$this->teacher_base_model->get_column('truename','fly_teacher_base',$where);

        $this->load->view('admin/member_dialog', $data);
    }

    public function save_teach_activity(){
        $id=$this->input->post('id');
        $value=$this->input->post('value');
        $_SESSION ['url_forward']=$this->baseurl."&m=teach_activity_index";
        if($id){    //修改
            $this->teacher_base_model->db_update_table("fly_teach_activity",$value,"id=$id");
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        }else{
            $this->teacher_base_model->db_insert_table("fly_teach_activity",$value);
            show_msg ( '保存成功！', $_SESSION ['url_forward'] );
        }

    }

    public function teach_activity_edit(){
        $id=$this->input->get("id");
        $data['value']=$this->teacher_base_model->get_one_db("fly_teach_activity",$id);

        $this->load->view('admin/teach_activity_add',$data);
    }

    public function teach_activity_delete(){
        $delete['id']=$this->input->get("id");
        $this->teacher_base_model->db_delete2("fly_teach_activity",$delete);
        $_SESSION ['url_forward']=$this->baseurl."&m=teach_activity_index";
        show_msg ( '删除成功！', $_SESSION ['url_forward'] );
    }

    public function teach_activity_resource_index(){
        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $total_rows=$this->teacher_base_model->rows_query("fly_activity_resource");

        $pagination['total_rows'] =$total_rows;
        $pagination['base_url'] = $this->baseurl."&m=teach_activity_resource_index";
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('pn') ? intval($this->input->get('pn')) : 0;
        $data['list']=$list= $this->teacher_base_model->get_list2('*',"",'fly_activity_resource',$offset,10);
        //获取对应的附件
        foreach($list as $key=>$value){
            $resource_list[$key]=$this->teacher_base_model->get_column("filename,savename","fly_activity_resource_path","resourceid=$value[id]");
        }
        $data['resource_list']=$resource_list;

        $this->load->view('admin/teach_activity_resource_list',$data);
    }

    public function teach_activity_resource_add(){
        $token=md5(time().rand(0,9999));
        $data['token']=$token;
        $this->load->view('admin/teach_activity_resource_add',$data);
    }

    public function teach_activity_resource_save(){
        $token=$this->input->post('token')?$this->input->post('token'):0;
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        $_SESSION ['url_forward']=$this->baseurl."&m=teach_activity_resource_index";


        if ($id) { // 修改 ===========
            $this->teacher_base_model->update2($id,"fly_activity_resource",$data);
            $where_update['token']=$token;
            $this->teacher_base_model->db_update_table("fly_activity_resource_path",array('resourceid'=>$id),$where_update);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $insert_id=$this->teacher_base_model->db_insert_table("fly_activity_resource",$data);
            if($insert_id>=1)
            {
                $where_update['token']=$token;
                $this->teacher_base_model->db_update_table("fly_activity_resource_path",array('resourceid'=>$insert_id),$where_update);
            }
            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }

    /**
     *附件上传
     */
    public function upload()
    {
        $this->load->library('upload');
        if($this->input->post('token'))
        {
            $token=$this->input->post('token')?$this->input->post('token'):0;
            $uploadconfig['upload_path']='uploads/docs/'.date('Ym').'/';
            if(!file_exists($uploadconfig['upload_path']))
            {
                mkdir($uploadconfig['upload_path']);
            }
            $uploadconfig['allowed_types'] = '*';
            $uploadconfig['file_name']=time().'_'.rand(10000,99999);
            $uploadconfig['max_size'] = '1048576';//2G
            $uploadconfig['remove_spaces']  = TRUE;

            $this->upload->initialize($uploadconfig);
            if (!$this->upload->do_upload('Filedata')) {
                echo $this->upload->display_errors();exit;
            }
            else{
                $data = $this->upload->data();
                $insertdata = array(
                    'token'=>$token,
                    'filename'=>$_FILES["Filedata"]["name"],
                    'filetype'=>$data['file_ext'],
                    'savename'=>$uploadconfig['upload_path'].$data['file_name'],
                    'addtime'=>time()
                );
                $insert_id=$this->teacher_base_model->db_insert_table("fly_activity_resource_path",$insertdata);

                if ($insert_id >= 1) {
                    $insertdata['id']=$insert_id;
                }
                echo json_encode($insertdata,JSON_UNESCAPED_UNICODE);exit;
            }
        }
    }

    public function teach_activity_resource_edit(){
        $token=md5(time().rand(0,9999));
        $data['token']=$token;
        $data['id']=$id= $this->input->get('id')?$this->input->get('id'):'';

        $data['value']=$this->teacher_base_model->get_column2("teacher,title","fly_activity_resource","id=$id");
        $data['resource_list']=$this->teacher_base_model->get_column("id,filename,savename","fly_activity_resource_path","resourceid=$id");

        $this->load->view ( 'admin/teach_activity_resource_edit', $data );
    }

    public function deletefileup()
    {
        $id=$this->input->post('id');
        $msg='error';
        if(is_numeric($id))
        {
            $delete['id']=$id;
            $flag=$this->teacher_base_model->db_delete2("fly_activity_resource_path",$delete);
            if($flag)
            {
                $file_path=$this->input->post('file_path');
                if(file_exists($file_path))
                {
                    @unlink($file_path);
                }
                $msg='success';
            }
        }
        echo $msg;exit;
    }






}