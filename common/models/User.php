<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $company_id
 * @property int $updated_at
 * @property string|null $verification_token
 * @property string $token
 * @property string $fullname
 * @property string $department_id
 * @property string $position_id
 * @property string $phone_number
 * @property string $image
 * @property string $gender
 * @property string $by_user_id
 * @property float $rating
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public $currentPassword;
    public $newPassword;
    public $newPasswordConfirm;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public $imageFile;
    public $password;
    public $user_assignment;
    public $user_bid;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['password_reset_token', 'verification_token'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 10],
            [['username', 'auth_key', 'email', 'created_at', 'updated_at', 'token', 'fullname', 'department_id', 'position_id', 'phone_number', 'gender', 'by_user_id', 'rating', 'password'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['rating'], 'number'],
            [['username', 'password_hash', 'password', 'password_reset_token', 'email', 'verification_token', 'fullname', 'department_id', 'position_id', 'phone_number', 'image'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['token'], 'string', 'max' => 50],
            [['gender', 'by_user_id'], 'string', 'max' => 10],

            [['terminal_employee_no'], 'unique'],
            [['terminal_card'], 'unique'],

            [['user_bid'], 'number'],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['password'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            [['currentPassword', 'newPassword', 'newPasswordConfirm'], 'required'],
            [['currentPassword'], 'validateCurrentPassword'],

            [['newPassword', 'newPasswordConfirm'], 'string', 'min' => 6],
            [['newPassword', 'newPasswordConfirm'], 'filter', 'filter' => 'trim'],
            [['newPasswordConfirm'], 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Новый пароль несовпадает'],

        ];
    }

    public function validateCurrentPassword()
    {
        if (!$this->verifyPassword($this->currentPassword)) {
            $this->addError('currentPassword', 'Не совпадает с текущим паролем');
        }
        return true;
    }

    public function verifyPassword($password)
    {
        $dbpassword = \common\models\User::findOne(
            ['username' => Yii::$app->user->identity->username, 'status' => self::STATUS_ACTIVE]
        )->password_hash;
        return Yii::$app->security->validatePassword($password, $dbpassword);
    }

    public static function findByToken($token)
    {
        $user = self::findOne(['token' => $token]);
        if (!$user) return ['success' => false, 'status' => 404, 'message' => 'Пользователь не найден'];
        if ($user->status != 10) return ['success' => false, 'status' => 422, 'Пользователь неактивен'];

        return $user;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currentPassword' => 'Текущий пароль',
            'newPassword' => 'Новый пароль',
            'newPasswordConfirm' => 'Повторный новый пароль',

            'terminal_employee_no' => 'Terminal: Employee Number',
            'terminal_card' => 'Terminal: Card',


            'user_bid' => 'Ставка',
            'username' => 'Логин',
            'auth_key' => 'Auth Key',
            'password' => 'Пароль',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'verification_token' => 'Verification Token',
            'token' => 'Token',
            'fullname' => 'Ф.И.О',
            'department_id' => 'Отдел',
            'position_id' => 'Должность',
            'phone_number' => 'Номер телефона',
            'image' => 'Аватар',
            'imageFile' => 'Аватар',
            'gender' => 'Пол',
            'by_user_id' => 'Создавший сотрудник',
            'rating' => 'Рейтинг',
            'user_assignment' => 'Роли сотрудника в системе'
        ];
    }

    public function fields()
    {
        return [
            'id',
            'token',
            'username',
            'created_at' => function () {
                return date('d.m.Y H:i', $this->created_at);
            },
            'fullname',
            'position' => function () {
                return $this->position->name;
            },
            'department' => function () {
                return $this->position->department->name;
            },
        ];
    }

    public function checkCard()
    {
        $model = \common\models\Employees::find()->where(['user_id' => $this->id])->one();
        return ($model == true) ? $model->id : false;
    }

    public function getByUser()
    {
        return $this->hasOne(User::class, ['id' => 'by_user_id']);
    }

    public function getGender()
    {
        return $this->hasOne(DirectoryList::class, ['id' => 'gender']);
    }

    public function getPosition()
    {
        return $this->hasOne(Position::class, ['id' => 'position_id']);
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    public function getInfo()
    {
        return "{$this->fullname} | {$this->phone_number}";
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key'=>$token]);
        //throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
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
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
