<?php
/**
 * Created by User: wene<china_wangyu@aliyun.com> Date: 2019/5/17 Time: 10:00
 */

namespace WangYu\lib;

use think\Validate;
use WangYu\exception\ValidateException;
class Param
{
    public $rule;
    public $field;
    public $request;

    public function __construct($rule,\think\Request $request,array $field = [])
    {
        $this->request = $request;
        $this->rule = $rule;
        $this->field = $field;
    }

    public function check(){
        if (is_string($this->rule)) {
            $validate = new $this->rule();
        }else{
            $validate = (new Validate())->make($this->rule,[],$this->field);
        }
        $res = $validate->batch()->check($this->request->param());
        if(!$res){
            throw new ValidateException([
                'message' => join(',',$validate->getError()),
            ]);
        }
        return true;
    }
}