<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    { 
      $auth = Yii::$app->authManager;
      if (!$this->validate()) {
          return null;
      }

      $user = new User();
      $user->username = $this->username;
      $user->email = $this->email;
      $user->setPassword($this->password);
      $user->generateAuthKey();

      $transaction = User::getDb()->beginTransaction();
      try {
        $saveOk = $user->save();
        if ($saveOk) {
          $authorRole = $auth->getRole('author');
          $auth->assign($authorRole, $user->id);
          $transaction->commit();
        } else {
          throw \Exception;
        }
      } catch (\Exception $e) {
          $transaction->rollBack();
          return null;
      } catch (\Throwable $e) {
          $transaction->rollBack();
          return null;
      }
      
      return $saveOk ? $user : null;
    }
}
