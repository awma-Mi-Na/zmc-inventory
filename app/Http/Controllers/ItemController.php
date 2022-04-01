<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::when(request('type'), function ($query, $type) {
            $query->where('type', $type);
        })->get(['id', 'name', 'type']);
        return $items;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'type' => 'required|in:item,test_kit,oxygen_tank,ward'
            ]
        );
        if ($validator->fails()) {
            return response(
                ['message' => array_values($validator->getMessageBag()->getMessages())],
                422
            );
        }

        try {
            $new_item = Item::create($validator->validated());
            return response(
                [
                    'new_item' => $new_item,
                    'message' => 'Item has been added'
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
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'max:255',
                'type' => 'in:item,test_kit,oxygen_tank,ward'
            ],
            [
                'type.in' => 'Type must be one of: item, test_kit, oxygen_tank,ward'
            ]
        );
        if ($validator->fails()) {
            return response(
                ['message' => array_values($validator->getMessageBag()->getMessages())],
                422
            );
        }

        try {
            $item->update($validator->validated());
            return response(
                [
                    'message' => 'Item has been updated.'
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return response(['message' => 'Item has been deleted']);
    }
}
