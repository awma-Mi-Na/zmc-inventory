<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\TestKitReport
 *
 * @property int $id
 * @property string $entry_date
 * @property int $item_id
 * @property int $balance
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TestKitReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestKitReport newQuery()
 * @method static \Illuminate\Database\Query\Builder|TestKitReport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TestKitReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|TestKitReport whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestKitReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestKitReport whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestKitReport whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestKitReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestKitReport whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestKitReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TestKitReport withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TestKitReport withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Item|null $item
 * @method static \Database\Factories\TestKitReportFactory factory(...$parameters)
 */
class TestKitReport extends \Eloquent implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
