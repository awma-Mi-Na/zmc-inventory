<?php

namespace App\Http\Controllers;

use App\Models\BedOccupancyReport;
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;
use Validator;

class BedOccupancyReportController extends Controller
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
                'name' => ['required', Rule::unique('items', 'name')->where('type', 'ward')],
                'total' => 'required|numeric',
                'patients' => 'required|numeric',
                'attendants' => 'required|numeric',
                'positive_attendants' => 'required|numeric',
                'empty' => 'required|numeric',
                'on_oxygen' => 'required|numeric',
                'on_ventilator_invasive' => 'required|numeric',
                'on_ventilator_niv' => 'required|numeric',
                'entry_date' => 'required|date_format:Y-m-d',
            ],
            [
                'name.required' => 'Ward field is required',
                'name.unique' => 'The item name already exists.',
                'total.required' => 'Total beds field is required',
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
                'type' => 'ward'
            ]);

            $new_bedOccupancy_report = BedOccupancyReport::create(
                array_merge(
                    $request->only([
                        'on_ventilator_invasive',
                        'on_ventilator_niv',
                        'on_oxygen',
                        'empty',
                        'positive_attendants',
                        'attendants',
                        'patients',
                        'total',
                        'entry_date'
                    ]),
                    ['item_id' => $new_item->id],
                )
            );
            DB::commit();


            return response(
                [
                    'new_item' => $new_item,
                    'new_report' => $new_bedOccupancy_report,
                    'message' => 'Item (ward) and report has been added'
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
            foreach ($request->bed_occupancies as $bed_occupancy) {
                $new_entry = [];

                // store the request attributes
                $new_entry['entry_date'] = $request->entry_date;
                $new_entry['item_id'] = $bed_occupancy['id'];
                $new_entry['total'] = check_exists_or_null('total', $bed_occupancy);
                $new_entry['patients'] = check_exists_or_null('patients', $bed_occupancy);
                $new_entry['attendants'] = check_exists_or_null('attendants', $bed_occupancy);
                $new_entry['positive_attendants'] = check_exists_or_null('positive_attendants', $bed_occupancy);
                $new_entry['empty'] = check_exists_or_null('empty', $bed_occupancy);
                $new_entry['on_oxygen'] = check_exists_or_null('on_oxygen', $bed_occupancy);
                $new_entry['on_ventilator_invasive'] = check_exists_or_null('on_ventilator_invasive', $bed_occupancy);
                $new_entry['on_ventilator_niv'] = check_exists_or_null('on_ventilator_niv', $bed_occupancy);

                // update if report exists on the request's entry date; otherwise create new report
                BedOccupancyReport::updateOrCreate(
                    ['entry_date' => $request->entry_date, 'item_id' => $bed_occupancy['id']],
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $date)
    {
        if (date('Y-m-d', strtotime($date)) != $date)
            return response(['message' => "Date must be in the format: yyyy-mm-dd"], 422);


        try {
            $report = BedOccupancyReport::with('item:id,name,type')
                ->whereDate('entry_date', $date)
                ->orderBy('id')
                ->get();
            if (!$report->count())
                return response(['message' => ["No record found on $date"]], 404);

            if (request('download') == 'pdf') {
                $sums = BedOccupancyReport::select([
                    DB::raw('sum(total) as total'),
                    DB::raw('sum(patients) as patients'),
                    DB::raw('sum(attendants) as attendants'),
                    DB::raw('sum(positive_attendants) as positive_attendants'),
                    DB::raw("sum(`empty`) as `empty`"),
                    DB::raw('sum(on_oxygen) as on_oxygen'),
                    DB::raw('sum(on_ventilator_invasive) as on_ventilator_invasive'),
                    DB::raw('sum(on_ventilator_niv) as on_ventilator_niv'),
                ])
                    ->whereDate('entry_date', $date)
                    ->get();
                return Pdf::loadView(
                    'bed-pdf',
                    [
                        'datas' => $report,
                        'date' => Carbon::parse($date)->format('jS F, Y'),
                        'title' => 'BED OCCUPANCY REPORT',
                        'columns' => ['NAME OF WARD', 'TOTAL BEDS', 'TOTAL PATIENTS', 'ATTENDANTS', 'POSITIVE ATTENDANTS', 'EMPTY BEDS', 'ON_OXYGEN'],
                        'sums' => $sums[0]->getAttributes(),
                    ]
                )->setPaper('a4', 'landscape')->stream("BED OCCUPANCY REPORT ({$date}).pdf");
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
