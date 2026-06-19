<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use App\Models\Lang;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    protected $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
        view()->share('langs', $this->langs);
    }

    public function index()
    {
        return view('admin.pages.pricing-plan.index');
    }

    public function create()
    {
        $item = new PricingPlan();
        return view('admin.pages.pricing-plan.create', compact('item'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'price_monthly' => 'nullable|numeric',
            'price_yearly' => 'nullable|numeric',
            'cta_link' => 'nullable|string',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        foreach ($this->langs as $lang) {
            $transData = $request->validate([
                $lang->code . '.name' => 'required|string',
                $lang->code . '.features' => 'nullable|string',
                $lang->code . '.cta_text' => 'nullable|string',
            ])[$lang->code];

            // Process features from textarea (newline separated) to array
            if (isset($transData['features'])) {
                $transData['features'] = array_filter(array_map('trim', explode("\n", $transData['features'])));
            }

            $data[$lang->code] = $transData;
        }

        PricingPlan::create($data);

        return redirect()->route('admin.pricing-plan.index')->with('success', 'Pricing Plan created successfully');
    }

    public function edit($id)
    {
        $item = PricingPlan::findOrFail($id);
        return view('admin.pages.pricing-plan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = PricingPlan::findOrFail($id);

        $data = $request->validate([
            'price_monthly' => 'nullable|numeric',
            'price_yearly' => 'nullable|numeric',
            'cta_link' => 'nullable|string',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        foreach ($this->langs as $lang) {
            $transData = $request->validate([
                $lang->code . '.name' => 'required|string',
                $lang->code . '.features' => 'nullable|string',
                $lang->code . '.cta_text' => 'nullable|string',
            ])[$lang->code];

            // Process features from textarea (newline separated) to array
            if (isset($transData['features'])) {
                $transData['features'] = array_filter(array_map('trim', explode("\n", $transData['features'])));
            }

            $data[$lang->code] = $transData;
        }

        $item->update($data);

        return redirect()->route('admin.pricing-plan.index')->with('success', 'Pricing Plan updated successfully');
    }

    public function destroy($id)
    {
        PricingPlan::findOrFail($id)->delete();
        return redirect()->route('admin.pricing-plan.index')->with('success', 'Pricing Plan deleted successfully');
    }

    public function is_active(Request $request)
    {
        $item = PricingPlan::find($request->id);
        $item->is_active = !$item->is_active;
        $item->save();
    }
}
