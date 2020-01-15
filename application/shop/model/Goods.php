<?php
/**
 * Created by PhpStorm.
 * User: 韩令恺
 * Date: 2018/5/23 0023
 * Time: 20:22
 */


namespace app\shop\model;
use think\model;

class Goods extends Model
{

    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = 'timestamp';
    // 定义时间戳字段名
    protected $createTime = 'ctime';
    protected $updateTime = 'updated_at';
    protected $type = [
        'money'     =>  'float',
    ];
    public function contact()
    {
        return $this->hasOne('UserContact','id','contact_id');
    }
    public function avater()
    {
        return $this->hasOne('File','id','avater_id');
    }
    public function wx()
    {
        return $this->hasOne('OauthWx','user_id','id');
    }
    public function applet()
    {
        return $this->hasOne('OauthApplet','user_id','id');
    }


    /**
     * 获取列表
     * @param bool $condition 条件
     * @param string $field 字段
     * @param string $order 排序
     * @param int $pagesize 每页条数
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function get_list($condition=null,$field='*',$page=1,$pagesize=10,$order=null)
    {
        $res = $this->where($condition)->field($field)->order($order)->page($page,$pagesize)->select();
        return $res;
    }


    /**
     * 获取数据 链表
     * @param array $table 指定操作数据表 多表
     * @param null $join_where 链表条件
     * @param null $condition 查询条件
     * @param int $page 页码
     * @param int $pagesize 每页数量
     * @param string $field 字段
     * @param null $order 排序
     * @param null $group 分组
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function get_join_list($table=array(),$join_where=null,$condition=null,$page=1,$pagesize=10,$field='*',$order=null,$group=null)
    {
        $res = $this->table($table)->where($join_where)->where($condition)->field($field)->order($order)->group($group)->page($page,$pagesize)->select();
        return $res;
    }


    /**
     * 获取数据 单条
     * @param null $condition 条件
     * @param string $field 字段
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function get_row($condition=null,$field='*')
    {
        $res = $this->where($condition)->field($field)->find();
        return $res;
    }


    /**
     * 获取数据 链表 单条
     * @param array $table 指定操作数据表 多表
     * @param null $join_where 链表条件
     * @param null $condition 查询条件
     * @param string $field 字段
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function get_row_join($table=array(),$join_where=null,$condition=null,$field='*')
    {
        $res = $this->table($table)->where($join_where)->where($condition)->field($field)->find();
        return $res;
    }


    /**
     * 新增数据
     * @param $data 新增数据
     * @return int|string
     */
    public function get_insert($data)
    {
        return $this->insert($data);
    }


    /**
     * 更改数据
     * @param null $condition 条件
     * @param array $data 更改数据
     * @return User
     */
    public function get_update($condition=null,$data=array())
    {
        return $this->where($condition)->update($data);
    }


    /**
     * 删除数据
     * @param null $condition 删除条件
     * @return int
     */
    public function get_delete($condition=null)
    {
        return $this->where($condition)->delete();
    }


    /**
     * 获取数据条数
     * @param null $condition 条件
     * @return int|string
     */
    public function get_count($condition=null)
    {
        return $this->where($condition)->count();
    }

}
