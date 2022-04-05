<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\OxygenTankReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class OxygenTankReportController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  string $date the date to fetch the report
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $date)
    {
        if (date('Y-m-d', strtotime($date)) != $date)
            return response(['message' => 'The date must be in the format: yyyy-mm-dd']);

        try {
            $report = OxygenTankReport::whereDate('entry_date', $date)
                ->orderBy('item_id')
                ->with('item:id,name,type')
                ->get();

            if (!$report->count())
                return response(['message' => ["No record found on $date"]], 404);

            if (request('download') == 'pdf') {
                return Pdf::loadView(
                    'oxygen-pdf',
                    [
                        'datas' => $report,
                        'date' => Carbon::parse($date)->format('jS F, Y'),
                        'title' => 'OXYGEN REPORT',
                        'columns' => ['NAME OF ITEM', 'FULL CYLINDER', 'EMPTY CYLINDER', 'IN USE'],
                    ]
                )->setPaper('a4')->stream("OXYGEN REPORT ({$date}).pdf");
            }

            return response(['data' => $report]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->oxygen_tanks as $oxygen_tank) {
                $new_entry = [];

                // store request attributes
                $new_entry['item_id'] = $oxygen_tank['id'];
                $new_entry['full'] = check_exists_or_null('full', $oxygen_tank);
                $new_entry['empty'] = check_exists_or_null('empty', $oxygen_tank);
                $new_entry['in_use'] = check_exists_or_null('in_use', $oxygen_tank);
                $new_entry['entry_date'] = $request->entry_date;

                // create or update new report entry
                OxygenTankReport::updateOrCreate(
                    ['entry_date' => $request->entry_date, 'item_id' => $oxygen_tank['id']],
                    $new_entry
                );
            }
            DB::commit();
            return response(
                [
                    'message' => 'Report has been added.'
                ],
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response(
                [
                    'message' => $e->getMessage()
                ],
                400
            );
        }
    }



    /**
     * Create resource for first entry
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function first_entry(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', Rule::unique('items', 'name')->where('type', 'oxygen_tank')],
                'entry_date' => 'required|date_format:Y-m-d',
                'full' => 'required|numeric',
                'in_use' => 'required|numeric',
                'empty' => 'required|numeric',
            ],
            [
                'name.unique' => 'The item name already exists.'
            ]
        );
        if ($validator->fails()) {
            return response(
                [
                    'message' => array_values($validator->getMessageBag()->getMessages())
                ],
                422
            );
        }

        try {
            DB::beginTransaction();
            $new_item = Item::create([
                'name' => $request->name,
                'type' => 'oxygen_tank'
            ]);

            $new_oxygen_report = OxygenTankReport::create(
                array_merge(
                    $request->only(
                        ['full', 'in_use', 'empty', 'entry_date'],
                    ),
                    ['item_id' => $new_item->id],
                )
            );
            DB::commit();
            return response(
                [
                    'new_item' => $new_item,
                    'new_report' => $new_oxygen_report,
                    'message' => 'Item (oxygen tank) and report has been added'
                ],
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response(
                [
                    'message' => $e->getMessage()
                ],
                400
            );
        }
    }
}
