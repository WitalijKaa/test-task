<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Shared\App\Models\AdSite\AdSiteBannerPosition
 *
 * @property int $id
 * @property int $foreign_id
 * @property int $status
 * @property string $status_label
 * @property string|null $url
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @mixin \Eloquent */
class ImagesRegister extends Model
{
    const TABLE_NAME = 'images_register';
    protected $table = self::TABLE_NAME;

    const STATUS_APPROVED = 1;
    const STATUS_DECLINED = 2;
    const STATUS_AWAIT = 3;
    const STATUS_RESET = 4;

    const STATUSES_FORBIDDEN = [self::STATUS_APPROVED, self::STATUS_DECLINED];

    const STATUSES_LABELS = [
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_DECLINED => 'Declined',
        self::STATUS_AWAIT => 'Undefined',
        self::STATUS_RESET => 'Undefined',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    public function getStatusLabelAttribute() {
        return static::STATUSES_LABELS[$this->status] ?? 'Unknown';
    }

}
