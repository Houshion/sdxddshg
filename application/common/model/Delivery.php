<?php
namespace app\common\model;

use think\Model;

class Delivery extends Model
{
	protected $resultSetType = 'collection';
	protected $autoWriteTimestamp = 'timestamp';
	// 定义时间戳字段名
    protected $createTime = 'ctime';
    protected $updateTime = 'updated_at';
	protected $auto = ['status'];


}