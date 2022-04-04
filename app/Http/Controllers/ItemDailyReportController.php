<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemDailyReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ItemDailyReportController extends Controller
{
    /**
     * Fetch the specified resource
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $date
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $date)
    {
        if (date('Y-m-d', strtotime($date)) != $date)
            return response(['message' => 'Incorrect date format']);
        try {
            $return_data = ItemDailyReport::with(
                [
                    'item:id,name,type'
                ]
            )
                ->whereDate('entry_date', $date)
                ->orderBy('item_id')
                ->get();

            if (!$return_data->count())
                return response(['message' => ["No record found on $date"]], 404);

            if ($request->download == 'pdf') {
                return Pdf::loadView(
                    'item-pdf',
                    [
                        'datas' => $return_data,
                        'date' => Carbon::parse($date)->format('jS F, Y'),
                        'title' => 'DAILY STOCK REPORT',
                        'columns' => ['ITEMS', 'CUMULATIVE STOCK', 'BALANCE', 'RECEIVED', 'TOTAL', 'ISSUED', 'STOCK BALANCE']
                    ]
                )
                    ->setPaper('a1', 'landscape')
                    ->stream("DAILY STOCK REPORT ({$date}).pdf");
            }

            return response(
                [
                    'data' => $return_data
                ],

            );
        } catch (\Exception $e) {
            return response(
                [
                    'message' => $e->getMessage()
                ],
                400
            );
        }
    }

    /**
     * Create a new resource for first entry
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function first_entry(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'entry_date' => 'required|date_format:Y-m-d',
                'name' => ['required', Rule::unique('items', 'name')->where('type', 'item')],
                'received' => 'required|numeric',
                'issued' => 'required|numeric',
                'total' => 'required|numeric',
                'opening_balance' => 'required|numeric',
                'closing_balance' => 'required|numeric',
                'cumulative_stock' => 'required|numeric',
            ],
            [
                'name.unique' => 'The item name already exists.'
            ]
        );
        if ($validator->fails()) {
            return response(
                ['message' => array_values($validator->getMessageBag()->getMessages())],
                422
            );
        }

        try {
            $new_item = Item::firstOrCreate([
                'name' => $request->name,
                'type' => 'item'
            ]);
            $new_item_report = ItemDailyReport::create(
                array_merge(
                    $request->only(
                        ['entry_date', 'opening_balance', 'received', 'total', 'issued', 'closing_balance', 'cumulative_stock']
                    ),
                    [
                        'item_id' => $new_item->id
                    ]
                )
            );
            return response(
                [
                    'new_item' => $new_item,
                    'new_item_report' => $new_item_report,
                    'message' => 'Item and report has been added.'
                ],
                201
            );
        } catch (\Exception $e) {
            return response(
                [
                    'message' => $e->getMessage()
                ],
                400
            );
        }
    }

    /**
     * Create a new resource for second entry onwards
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            foreach ($request->items as $item) {
                if (!$item || Item::where('id', $item['id'])->firstOrFail('type')->type != 'item')
                    return response(['message' => ["Item {$item['name']} does not belong to the category 'item'"]], 400);
                $new_entry = [];
                $opening_balance = null;

                // get previous entry; if it does not exist get today's entry
                // use previous entry details if exists, otherwise update the same entry
                $opening = null;
                $opening = ItemDailyReport::where('item_id', $item['id'])
                    ->orderBy('entry_date', 'desc')
                    ->whereDate('entry_date', '<', $request->entry_date)
                    ->first();
                $cumulative_stock = 0;

                // update the same entry
                if (!$opening) {
                    $opening = ItemDailyReport::where('item_id', $item['id'])
                        ->orderBy('entry_date', 'desc')
                        ->whereDate('entry_date', '=', $request->entry_date)
                        ->first();
                    $opening_balance = $opening->opening_balance;
                    $cumulative_stock = $opening->cumulative_stock - $opening->received + check_exists_or_null('received', $item);
                } else {
                    $opening_balance = $opening->closing_balance;
                    $cumulative_stock = $opening->cumulative_stock + check_exists_or_null('received', $item);
                }
                // check and store received and issued values
                $received = check_exists_or_null('received', $item);
                $issued = check_exists_or_null('issued', $item);

                // store request attributes
                $new_entry['item_id'] = $item['id'];
                $new_entry['received'] = $received;
                $new_entry['issued'] = $issued;
                $new_entry['opening_balance'] = $opening_balance;
                $new_entry['total'] = $new_entry['opening_balance'] + $received;
                $new_entry['closing_balance'] = $new_entry['total'] - $issued;
                $new_entry['entry_date'] = $request->entry_date;
                // cumulative stock calculation unsure(add total, or add the received stock)
                $new_entry['cumulative_stock'] = $cumulative_stock;

                ItemDailyReport::updateOrCreate(['entry_date' => $request->entry_date, 'item_id' => $item['id']], $new_entry);
            }

            return response(
                [
                    'message' => 'Report added successfully'
                ],
                201
            );
        } catch (\Exception $e) {
            return response(
                [
                    'message' => $e->getMessage()
                ],
                400
            );
        }
    }
}
