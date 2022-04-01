<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\ItemDailyReport
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $entry_date
 * @property int $item_id
 * @property int $opening_balance
 * @property int $received
 * @property int $issued
 * @property int $total
 * @property int $closing_balance
 * @property int $cumulative_stock
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Item|null $item
 * @method static \Database\Factories\ItemDailyReportFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport newQuery()
 * @method static \Illuminate\Database\Query\Builder|ItemDailyReport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereClosingBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereCumulativeStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereIssued($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereOpeningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemDailyReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ItemDailyReport withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ItemDailyReport withoutTrashed()
 * @mixin \Eloquent
 */
class ItemDailyReport extends \Eloquent implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $casts = [
        'entry_date' => 'date:jS M, Y'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
