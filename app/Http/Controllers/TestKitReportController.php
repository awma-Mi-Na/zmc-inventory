<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\TestKitReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class TestKitReportController extends Controller
{
    /**
     * Create item and report for first entry
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function first_entry(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', Rule::unique('items', 'name')->where('type', 'test_kit')],
                'balance' => 'required|numeric',
                'entry_date' => 'required|date_format:Y-m-d',
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
            $new_item = Item::firstOrCreate([
                'name' => $request->name,
                'type' => 'test_kit'
            ]);

            $new_testKit_report = TestKitReport::create(
                array_merge(
                    $request->only(['balance', 'entry_date'],),
                    ['item_id' => $new_item->id],
                )
            );
            DB::commit();
            return response(
                [
                    'new_item' => $new_item,
                    'new_report' => $new_testKit_report,
                    'message' => 'Item (test kit) and report has been added'
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->test_kits as $test_kit) {
                $new_entry = [];

                // store the request attributes
                $new_entry['entry_date'] = $request->entry_date;
                $new_entry['item_id'] = $test_kit['id'];
                $new_entry['balance'] = check_exists_or_null('balance', $test_kit);

                // update if report exists on the request's entry date; otherwise create new report
                TestKitReport::updateOrCreate(
                    ['entry_date' => $request->entry_date, 'item_id' => $test_kit['id']],
                    $new_entry
                );
            }
            DB::commit();
            return response(
                [
                    'message' => 'Report has been added'
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
     * Display the specified resource.
     *
     * @param  string $date
     * @return \Illuminate\Http\Response
     */
    public function show(string $date)
    {
        if (date('Y-m-d', strtotime($date)) != $date)
            return response(['message' => 'Date must be in the format: yyyy-mm-dd']);

        try {
            $report = TestKitReport::with('item:id,name,type')
                ->whereDate('entry_date', $date)
                ->orderBy('id')
                ->get();

            if (!$report->count())
                return response(['message' => "No record found on $date"], 404);

            if (request('download') == 'pdf') {
                return Pdf::loadView(
                    'kit-pdf',
                    [
                        'datas' => $report,
                        'date' => Carbon::parse($date)->format('jS F, Y'),
                        'title' => 'TEST KITS (COVID LAB) REPORT',
                        'columns' => ['NAME OF ITEM', 'BALANCE'],
                    ]
                )->setPaper('a4')->stream("TEST KITS (COVID LAB) REPORT ({$date}).pdf");
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
}
