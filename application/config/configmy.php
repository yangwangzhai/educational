<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    // 自定义 全局变量 by tangjian    

// 南宁 城区划分




// client type
$config['client'] = array(0=>'全部',1=>'家长端',2=>'教师端');
$config['os'] = array(0=>'web',1=>'android',2=>'ios');

// 会员类型
$config['member_type'] = array(0=>'全部',1=>'家长',2=>'教师',3=>'学生');

// 星期
$config['week'] =array(
    0 =>array(
        1 => '星期一',
        2 => '星期二',
        3 => '星期三',
        4 => '星期四',
        5 => '星期五',
    ),
    1 =>array(
        1 => '星期一',
        2 => '星期二',
        3 => '星期三',
        4 => '星期四',
        5 => '星期五',
        6 => '星期六',
    ),
    2 =>array(
        1 => '星期一',
        2 => '星期二',
        3 => '星期三',
        4 => '星期四',
        5 => '星期五',
        6 => '星期六',
        7 => '星期天',
    ),
);

$config['week2'] =array(
    0 =>array(
        1,
        2,
        3,
        4,
        5,
    ),
    1 =>array(
        1,
        2,
        3,
        4,
        5,
        6,
    ),
    2 =>array(
        1,
        2,
        3,
        4,
        5,
        6,
        7,
    ),
);


$config['section']=array(
    0 =>array(
        1 => '第一节',
        2 => '第二节',
        3 => '第三节',
        4 => '第四节',
        5 => '第五节',
        6 => '第六节',
    ),
    1 =>array(
        1 => '第一节',
        2 => '第二节',
        3 => '第三节',
        4 => '第四节',
        5 => '第五节',
        6 => '第六节',
        7 => '第七节',
    ),
    2 =>array(
        1 => '第一节',
        2 => '第二节',
        3 => '第三节',
        4 => '第四节',
        5 => '第五节',
        6 => '第六节',
        7 => '第七节',
        8 => '第八节',
    ),
    3 =>array(
        1 => '第一节',
        2 => '第二节',
        3 => '第三节',
        4 => '第四节',
        5 => '第五节',
        6 => '第六节',
        7 => '第七节',
        8 => '第八节',
        9 => '第九节',
    ),
    4 =>array(
        1 => '第一节',
        2 => '第二节',
        3 => '第三节',
        4 => '第四节',
        5 => '第五节',
        6 => '第六节',
        7 => '第七节',
        8 => '第八节',
        9 => '第九节',
        10 => '第十节',
    ),
    5 =>array(
        1 => '第一节',
        2 => '第二节',
        3 => '第三节',
        4 => '第四节',
        5 => '第五节',
        6 => '第六节',
        7 => '第七节',
        8 => '第八节',
        9 => '第九节',
        10 => '第十节',
        11 => '第十一节',
    ),
    6 =>array(
        1 => '第一节',
        2 => '第二节',
        3 => '第三节',
        4 => '第四节',
        5 => '第五节',
        6 => '第六节',
        7 => '第七节',
        8 => '第八节',
        9 => '第九节',
        10 => '第十节',
        11 => '第十一节',
        12 => '第十二节',
    ),
);

$config['section2']=array(
    0 =>array(
        1,
        2,
        3,
        4,
        5,
        6,
    ),
    1 =>array(
        1,
        2,
        3,
        4,
        5,
        6,
        7,
    ),
    2 =>array(
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
    ),
    3 =>array(
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
    ),
    4 =>array(
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
        10,
    ),
    5 =>array(
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
        10,
        11,
    ),
    6 =>array(
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
        10,
        11,
        12,
    ),
);


// 管理员组
$config['user_category'] = array(
        1 => '超级管理',
        2 => '普通管理员'
        );
		
// 新闻分类
$config['news_type'] = array(
		1 => '新闻资讯',
		2 => '通知公告',
		3 => '工作动态'
);

// 性别
$config['gender'] = array(0 => '女',1 => '男');
// 数据表的 状态
$config['status'] = array(1 => '已审', 0 => '未审');

//幼儿园班级类型
$config['grade']=array(
    1=>'2009',
    2=>'2010',
    3=>'2011',
    4=>'2012',
    5=>'2013',
    6=>'2014',
    7=>'2015',
    8=>'2016',
);
$config['reason']=array(
    1=>'--',
    2=>'就近入园',
    3=>'办学特色',
    4=>'教学质量',
    5=>'朋友介绍',
    6=>'校园声誉',
    7=>'师资力量',
    8=>'基础建设好',
    9=>'饮食卫生好',
    10=>'管理模式专业',
    11=>'其他原因'
);
$config['leaving']=array(
    1=>'--',
    2=>'毕业离校',
    3=>'转学离校',
    4=>'搬迁异地',
    5=>'资费原因',
    6=>'资料有误要删除（彻底删除）',
    7=>'师资力量不足',
    8=>'基础建设不足',
    9=>'饮食卫生不足',
    10=>'管理方式不足',
    11=>'教学内容不足',
    12=>'其他'
);

$config['account']=array(
    1=>'--',
    2=>'农业户口',
    3=>'非农业户口',
);
$config['disabled_type']=array(
    1=>'--',
    2=>'视力残疾',
    3=>'听力残疾',
    4=>'言语残疾',
    5=>'肢体残疾',
    6=>'智力残疾',
    7=>'精神残疾',
    8=>'多重残疾',
    9=>'其他残疾'
);
$config['leave_type']=array(
    1=>'事假',
    2=>'病假'
);
$config['subject'] = array(
    1 => '音乐',
    2 => '语言',
    3 => '健康',
    4 => '社会',
    5 => '科学',
    6 => '美术'
);
// 新闻分类
$config['news_type'] = array(
    1 => '新闻资讯',
    2 => '通知公告',
    3 => '工作动态'
);
$config['relatives']=array(
    1=>'爸爸',
    2=>'妈妈',
    3=>'爷爷',
    4=>'奶奶',
    5=>'外公',
    6=>'外婆'
);
$config['transport']=array(
    1=>'步行',
    2=>'自行车',
    3=>'电车',
    4=>'汽车'
);
$config['environment']=array(
    1=>'工薪阶层',
    2=>'小康',
    3=>'富裕',
);
// 学期
$config['semester'] = array(
    1 => '2015-秋学期',
    2 => '2016-春学期',
    3 => '2016-秋学期',
    4 => '2017-春学期',
    5 => '2017-秋学期',
    6 => '2018-春学期',
    7 => '2018-秋学期'
);
$config['resource_type']=array(
    '1'=>'PPT课件',
    '2'=>'Flash课件',
    '3'=>'音频课件',
    '4'=>'视频资源'
);
$config['fit']=array(
    '1'=>'配合度高',
    '2'=>'配合度一般',
    '3'=>'配合度差'
);
$config['experience']=array(
    '1'=>'经验丰富',
    '2'=>'经验一般'
);
// 餐点
$config['mealtime'] = array(
    1 => '早餐',
    2 => '午餐',
    3 => '午点',
    4 => '晚餐',
);
$config['leave_type']=array(
    1=>'事假',
    2=>'病假',
    3=>'公假',
    4=>'婚假',
    5=>'怀孕、产假、哺乳假、流产假',
    6=>'丧假',
    7=>'工伤假',
    8=>'年休假',
    9=>'补休'
);

$config['student_leave_type']=array(
    1=>'事假',
    2=>'病假'
);
// 第几节课
$config['leave_section'] = array(
    1 => '一节',
    2 => '二节',
    3 => '三节',
    4 => '四节',
    5 => '五节',
    6 => '六节',
    7 => '七节',
    8 => '八节',
);
// 成绩分级
$config['score'] = array(
    1=>'A',
    2=>'B',
    3=>'C',
    4=>'D'
);
// 合同类型
$config['contract_type'] = array(
    1=>'劳动合同',
    2=>'保密协议'
);
$config['contract_status'] = array(
    1=>'有效',
    2=>'终止',
    3=>'解除	',
    4=>'未签约',
    5=>'未续签'
);
$config['hopetitle'] = array(
    1=>'幼儿教师',
    2=>'保育员',
    3=>'财务出纳',
    4=>'管理人员',
    5=>'门卫保安',
    6=>'清洁员'
);
$config['dept'] = array(
    1=>'后勤部',
    2=>'教务部',
    3=>'校务部',
    4=>'财务部'
);
$config['staffstatus']=array(
    1=>'在职',
    2=>'实习生',
    3=>'兼职',
    4=>'其它',
    5=>'离职'
);
$config['workyear'] = array(
    1=>'应届毕业生',
    2=>'一年以上',
    3=>'二年以上',
    4=>'三年以上',
    5=>'五年以上',
    6=>'十年以上'
);
$config['resume_status'] = array(
    1=>'待安排',
    2=>'第一轮面试',
    3=>'第二轮面试',
    4=>'第三轮面试',
    5=>'录用',
    6=>'淘汰'
);
$config['degrees'] = array(
    1=>'本科',
    2=>'大专',
    3=>'高中',
    4=>'初中',
    5=>'技校',
    6=>'硕士',
    6=>'博士'
);
$config['marry'] = array(1 => '已婚',2 => '未婚');
$config['YEAR']=array(
    '2011'=>'2011',
    '2012'=>'2012',
    '2013'=>'2013',
    '2014'=>'2014',
    '2015'=>'2015',
    '2016'=>'2016',
    '2017'=>'2017'
);
$config['MONTH'] = array(
    '01'=>'1月',
    '02'=>'2月',
    '03'=>'3月',
    '04'=>'4月',
    '05'=>'5月',
    '06'=>'6月',
    '07'=>'7月',
    '08'=>'8月',
    '09'=>'9月',
    '10'=>'10月',
    '11'=>'11月',
    '12'=>'12月'
);
$config['MONTH1'] = array(
    '1'=>'一月',
    '2'=>'二月',
    '3'=>'三月',
    '4'=>'四月',
    '5'=>'五月',
    '6'=>'六月',
    '7'=>'七月',
    '8'=>'八月',
    '9'=>'九月',
    '10'=>'十月',
    '11'=>'十一月',
    '12'=>'十二月'
);
$config['train_type'] = array(
    1=>'时间管理',
    2=>'沟通技巧',
    3=>'效率工作',
    4=>'安全生产'
);
$config['idcardtype']=array(
    1=>'身份证',
    2=>'护照',
    3=>'港澳通行证',
    4=>'军人证',
    5=>'其它'
);
$config['shebaotype']=array(
    1=>'城保',
    2=>'镇保',
    3=>'农保',
    4=>'综保'
);
$config['politics']=array(
    1=>'无党派人士',
    2=>'民族党派',
    3=>'党员',
    4=>'团员',
    5=>'政协委员',
    6=>'人大代表'
);
$config['attendance_type']=array(
    1=>'正常',
    2=>'迟到',
    3=>'早退',
    4=>'未打卡'
);
//班次
$config['set_title'] = array(
    1 => '上午',
    2 => '下午'
);
$config['enrolled']=array(
    1=>'未入学',
    2=>'已入学'
);
$config['payment']=array(
    1=>'未缴费',
    2=>'已缴费'
);
$config['volunteer_type']=array(
    1=>'后勤类',
    2=>'文娱类',
    3=>'资源类'
);
$config['question_type']=array(
    1=>'家长问题',
    2=>'幼儿问题',
    3=>'教学问题'
);
$config['feedback_type']=array(
    1=>'批评',
    2=>'建议',
    3=>'赞扬'
);
$config['submit_type']=array(
    1=>'APP客户端',
    2=>'手机短信',
    3=>'来电反馈（固话、手机)',
    4=>'当面反馈',
    5=>'书信/意见薄'
);
$config['feedback_active']=array(
    1=>'新反馈',
    2=>'待核实',
    3=>'待整改',
    4=>'待审核',
    5=>'待审阅',
    6=>'已完成',
);
$config['feedback_score']=array(
    1=>'满意',
    2=>'合格',
    3=>'不合格'
);
//奖励处罚类型
$config['reward_type']=array(
    1=>'奖励',
    2=>'处罚',
);
$config['exam_type']=array(
    1=>'日常考试一',
    2=>'日常考试二',
    3=>'日常考试三',
    4=>'日常考试四',
    5=>'期中',
    6=>'升学考',
    7=>'期末',
    8=>'摸底考',
    9=>'毕业会考',
);
$config['subject']=array(
    1=>'语文',
    2=>'数学',
    3=>'外语',
    4=>'物理',
    5=>'化学',
    6=>'政治',
    7=>'历史',
    8=>'地理',
    9=>'生物',
    10=>'音乐',
    11=>'体育',
    12=>'美术',
);
/*
 * 素材类型分类缓存
 */
$config['resource_type_cache']=APPPATH.'/cache';
/*
| 是否在后台登录的时候有验证码
| 默认是true
*/
$config['yzm_open'] = true;//true ;
/* End of file config.php */
/* Location: ./application/config/config.php */