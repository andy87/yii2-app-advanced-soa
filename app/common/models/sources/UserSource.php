<?php declare(strict_types=1);

namespace app\common\models\sources;

use app\common\components\core\BaseModel;

/**
 * < Common > `UserSource`
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @package app\common\models\sources
 */
abstract class UserSource extends BaseModel
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['username', 'email'], 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'email'],
            ['password', 'string']
        ];
    }
}