<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\OxygenTankReport
 *
 * @property int $id
 * @property string $entry_date
 * @property int $item_id
 * @property int $full
 * @property int $empty
 * @property int $in_use
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport newQuery()
 * @method static \Illuminate\Database\Query\Builder|OxygenTankReport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport whereEmpty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport whereFull($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport whereInUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OxygenTankReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OxygenTankReport withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OxygenTankReport withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Item|null $item
 * @method static \Database\Factories\OxygenTankReportFactory factory(...$parameters)
 */
class OxygenTankReport extends \Eloquent implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
