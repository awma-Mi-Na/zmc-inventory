<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Item
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ItemDailyReport[] $item_daily_reports
 * @property-read int|null $item_daily_reports_count
 * @method static \Database\Factories\ItemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Query\Builder|Item onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Item withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Item withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BedOccupancyReport[] $bed_occupancy_reports
 * @property-read int|null $bed_occupancy_reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OxygenTankReport[] $oxygen_tank_reports
 * @property-read int|null $oxygen_tank_reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TestKitReport[] $test_kit_reports
 * @property-read int|null $test_kit_reports_count
 */
class Item extends \Eloquent implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function item_daily_reports()
    {
        return $this->hasMany(ItemDailyReport::class);
    }

    public function oxygen_tank_reports()
    {
        return $this->hasMany(OxygenTankReport::class);
    }

    public function test_kit_reports()
    {
        return $this->hasMany(TestKitReport::class);
    }

    public function bed_occupancy_reports()
    {
        return $this->hasMany(BedOccupancyReport::class);
    }
}
