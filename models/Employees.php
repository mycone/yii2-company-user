<?php

namespace mycone\users\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use mycone\users\libraries\Idcard;
use yii\base\Event;

/**
 * This is the model class for table "{{%employees}}".
 *
 * @property string $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $depts_id
 * @property string $fullname
 * @property string $telphone
 * @property string $email
 * @property string $idcard
 * @property string $jobs
 * @property string $last_at
 * @property string $last_ip
 * @property integer $status
 * @property string $status_cn
 * @property string $avatar
 * @property string $remark
 * @property string $created_at
 * @property array $statusArray
 */
class Employees extends \yii\db\ActiveRecord
{
    /**
     * Event beforeCreate
     * @var string
     */
    const EVENT_BEFORE_CREATE   = 'beforeCreate';
    
    /**
     * Event afterCreate
     * @var string
     */
    const EVENT_AFTER_CREATE    = 'afterCreate';
    
    /**
     * Employees status
     * @var int
     */
    const STATUS_CLOSE = 0;
    
    /**
     * Employees Default status
     * @var int
     */
    const STATUS_ACTIVE = 1;
    
    /**
     * Default username regexp
     * @var string
     */
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';
    
    /**
     * Used for model validation.
     * @var string Plain password.
     */
    public $password;
    
    /**
     * status cn remark
     * @var string
     */
    public $status_cn;
    
    /**
     * status array
     * @var array
     */
    private $_status;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employees}}';
    }
    
    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->_status = [
            static::STATUS_ACTIVE => '正常',
            static::STATUS_CLOSE => '关闭',
        ];
        $this->on(static::EVENT_AFTER_FIND, [$this,'onAfterFind']);
    }
    
    /**
     * afterFind Handler
     * @param Event $event
     */
    public function onAfterFind($event) {
        $this->status_cn = $this->getStatusArray($this->status);
    }
    
    /**
     * 获取状态数组
     * @param string $value
     * @return array|string
     */
    public function getStatusArray($value='') {
        return $value!=='' ? $this->_status[$value] : $this->_status;
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    static::EVENT_BEFORE_INSERT => 'created_at',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['username', 'password', 'auth_key', 'depts_id', 'created_at'], 'required'],
            [['username','depts_id'],'required','on'=>['create','update']],
            ['username', 'match', 'pattern' => static::$usernameRegexp],
            ['username', 'string', 'max' => 30],
            ['username', 'unique'],
            
            [['depts_id', 'last_at', 'status', 'created_at'], 'integer'],
            [['remark'], 'string'],
            ['status','default','value'=>static::STATUS_ACTIVE],
            
            ['password','required','on'=>['create']],
            ['password','string','min' => 6],
            [['password', 'auth_key'], 'string', 'max' => 32],
            
            [['fullname', 'last_ip'], 'string', 'max' => 15],
            ['idcard', 'string', 'max' => 18],
            ['idcard',function($attribute) {
                if(!Idcard::validateCard($this->idcard)) {
                    $this->addError($attribute,"身份证号码格式有误");
                }
            }],
            [['telphone', 'email', 'jobs'], 'string', 'max' => 50],
            [['email'],'email'],
            [['avatar'], 'string', 'max' => 250],
            
            [['auth_key'], 'unique'],
        ];
    }
    
    /**
     * 定义场景
     * @see \yii\base\Model::scenarios()
     */
    public function scenarios() {
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios, [
            'create' => ['username','password','depts_id'],
            'update' => ['username','depts_id'],
        ]);
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '账号',
            'password_hash' => '密码HASH',
            'password' => '密码',
            'auth_key' => 'Token值',
            'depts_id' => '所属的部门',
            'fullname' => '姓名',
            'telphone' => '联系电话',
            'email' => '邮箱',
            'idcard' => '身份证号码',
            'jobs' => '职务',
            'last_at' => '最后登录时间',
            'last_ip' => '最后登录IP',
            'status' => '状态',//：1，正常；0，停用
            'status_cn' => '状态',
            'avatar' => '头像URL',
            'remark' => '备注',
            'created_at' => '创建时间',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
        if($this->validate(['auth_key'])) {
            return $this->auth_key;
        }
        while (!$this->validate(['auth_key'])) {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }
        return $this->auth_key;
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    
    /**
     * Generates user-friendly random password containing at least one lower case letter, one uppercase letter and one
     * digit. The remaining characters in the password are chosen at random from those three sets.
     *
     * @see https://gist.github.com/tylerhall/521810
     *
     * @param $length
     *
     * @return string
     */
    public static function generatePassword($length)
    {
        $sets = [
            'abcdefghjkmnpqrstuvwxyz',
            'ABCDEFGHJKMNPQRSTUVWXYZ',
            '23456789',
        ];
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
    
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $password .= $all[array_rand($all)];
        }
    
        $password = str_shuffle($password);
    
        return $password;
    }
    
    /**
     * Event beforeSave
     * @see \yii\db\BaseActiveRecord::beforeSave($insert)
     */
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            if(!empty($this->password)) 
                $this->setPassword($this->password);
            return true;
        }
        else {
            return false;
        }
    }
    
    /**
     * 添加帐号
     * @throws \RuntimeException
     */
    public function create() {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }
        //$this->password = $this->password == null ? static::generatePassword(8) : $this->password;
        $this->auth_key = $this->generateAuthKey();
        
        $this->trigger(static::EVENT_BEFORE_CREATE);
        
        if(!$this->save()) {
            return false;
        }
        
        $this->trigger(static::EVENT_AFTER_CREATE);
        
        return true;
    }
    
    /**
     * 关联获取所属部门
     * @return ActiveQuery
     */
    public function getDepts() {
        return $this->hasOne(Depts::className(), ['id'=>'depts_id']);
    }
    
    /**
     * 过滤敏感字段
     * @see \yii\db\BaseActiveRecord::fields()
     */
    public function fields() {
        $fields = parent::fields();
        unset($fields['password_hash']);
        return $fields;
    }
}
