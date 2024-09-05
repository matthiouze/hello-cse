<?php

namespace App\Enum;

enum Status: string
{
    case UNACTIVE = 'unactive';
    case ACTIVE = 'active';
    case PENDING = 'pending';

    public static function getValues(): array
    {
        return [
            self::UNACTIVE,
            self::ACTIVE,
            self::PENDING,
        ];
    }

    /**
     * @return string
     * @author Arthur Remond <arthur.remond@akawam.com>
     */
    public function traduction(): string
    {
        return match ($this) {
            self::UNACTIVE => 'Inactif',
            self::ACTIVE => 'Actif',
            self::PENDING => 'En attente',
        };
    }
}
