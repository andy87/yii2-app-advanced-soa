<?php declare(strict_types=1);

namespace yii2\common\models\audit;

use yii\db\ActiveRecord;

/**
 * Базовая ActiveRecord-модель audit-домена с нормализацией JSON-атрибутов.
 *
 * @package yii2\common\models\audit
 */
abstract class BaseAuditModel extends ActiveRecord
{
    /**
     * Возвращает список JSON-атрибутов модели.
     *
     * @return string[] Имена JSON-атрибутов.
     */
    protected function jsonAttributes(): array
    {
        return [];
    }

    /**
     * Подготавливает JSON-атрибуты перед сохранением.
     *
     * @param bool $insert Признак вставки новой записи.
     * @return bool Можно ли продолжать сохранение.
     */
    public function beforeSave($insert): bool
    {
        foreach ($this->jsonAttributes() as $attribute) {
            $value = $this->getAttribute($attribute);
            if (is_array($value)) {
                $this->setAttribute($attribute, json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * Возвращает JSON-атрибут как массив.
     *
     * @param string $attribute Имя атрибута.
     * @param array $default Значение по умолчанию.
     * @return array Декодированное JSON-значение.
     */
    public function getJsonArray(string $attribute, array $default = []): array
    {
        $value = $this->getAttribute($attribute);

        if (is_array($value)) {
            return $value;
        }

        if (!is_string($value) || $value === '') {
            return $default;
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : $default;
    }

    /**
     * Обновляет timestamp-поле `updated_at`, если оно есть в модели.
     *
     * @return void
     */
    public function touchUpdatedAt(): void
    {
        if ($this->hasAttribute('updated_at')) {
            $this->setAttribute('updated_at', date('Y-m-d H:i:s'));
        }
    }
}
