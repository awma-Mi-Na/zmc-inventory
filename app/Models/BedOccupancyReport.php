<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\BedOccupancyReport
 *
 * @property int $id
 * @property string $entry_date
 * @property int $total
 * @property int $patients
 * @property int $attendants
 * @property int $positive_attendants
 * @property int $empty
 * @property int $on_oxygen
 * @property int $on_ventilator_invasive
 * @property int $on_ventilator_niv
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport newQuery()
 * @method static \Illuminate\Database\Query\Builder|BedOccupancyReport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereAttendants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereEmpty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereOnOxygen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereOnVentilatorInvasive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereOnVentilatorNiv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport wherePatients($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport wherePositiveAttendants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|BedOccupancyReport withTrashed()
 * @method static \Illuminate\Database\Query\Builder|BedOccupancyReport withoutTrashed()
 * @mixin \Eloquent
 * @property int $item_id
 * @property-read \App\Models\Item|null $item
 * @method static \Database\Factories\BedOccupancyReportFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BedOccupancyReport whereItemId($value)
 */
class BedOccupancyReport extends \Eloquent implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
