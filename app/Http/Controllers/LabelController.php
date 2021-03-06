<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::orderBy('id', 'asc')->paginate();
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $label = new Label();
        return view('labels.create', compact('label'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $labelInputData = $this->validate($request, [
            'name' => 'required|max:255|unique:labels',
            'description' => 'nullable|string'
        ], $messages = [
            'unique' => __('validation.The label name has already been taken'),
            'max' => __('validation.The name should be no more than :max characters'),
        ]);

        $label = new Label();
        $label->fill($labelInputData);
        $label->save();

        flash(__('labels.Label has been added successfully'))->success();
        return redirect()
            ->route('labels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $labelInputData = $this->validate($request, [
            'name' => 'required|max:255|unique:labels,name,' . $label->id,
            'description' => 'nullable|string'
        ], $messages = [
            'unique' => __('validation.The label name has already been taken'),
            'max' => __('validation.The name should be no more than :max characters'),
        ]);

        $label->fill($labelInputData);
        $label->save();

        flash(__('labels.Label has been updated successfully'))->success();
        return redirect()
            ->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash(__('labels.Failed to delete label'))->error();
            return back();
        }

        $label->delete();
        flash(__('labels.Label has been deleted successfully'))->success();
        return redirect()->route('labels.index');
    }
}
