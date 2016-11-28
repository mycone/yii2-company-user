<?php

namespace mycone\users\models;

use Yii;
use yii\base\Model;
use mycone\users\models\Employees;

class EmployeesData extends Model
{
    public $username;
    public $password;
    private $_employees;
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }
    
    /**
     * 验证密码是否正确
     * @param string $attribute
     * @param array $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $employees = $this->getEmployees();
            if (!$employees || !$employees->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误。');
            }
        }
    }
    
    public function getData() {
        if($this->validate()) {
            return $this->getEmployees();
        }
        else {
            return false;
        }
    }
    
    /**
     * 获取验证模型
     * @return Employees
     */
    protected function getEmployees()
    {
        if ($this->_employees === null) {
            $this->_employees = Employees::findByUsername($this->username);
        }
        return $this->_employees;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
        ];
    }
    
}