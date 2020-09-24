<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Model\CEO;
use App\Http\Resources\CEOResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CEOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ceos  = CEO::all();

        return response([
            'message'   => 'Retrieved Successfully',
            'ceos'      => CEOResource::collection($ceos)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data       = $request->all();

        $validator  = Validator::make($data, [
            'name'                  => 'required|max:255',
            'year'                  => 'required|max:255',
            'company_headquarters'  => 'required|max:255',
            'what_company_does'     => 'required'
        ]);

        if($validator->fails()) {
            return response([
                'error'  => $validator->errors(),
                'Validation Error'
            ]);
        }

        $ceo    = CEO::create($data);

        return response([
            'message'   => 'Created CEO successfully',
            'ceo'       => new CEOResource($ceo),
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\CEO  $cEO
     * @return \Illuminate\Http\Response
     */
    public function show(CEO $ceo)
    {
        return response([
            'message'   => 'Retrieved Successfully',
            'ceo'   => new CEOResource($ceo),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\CEO  $cEO
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CEO $ceo)
    {
        $data       = $request->all();

        $validator  = Validator::make($data, [
            'name'                  => 'required|max:255',
            'year'                  => 'required|max:255',
            'company_headquarters'  => 'required|max:255',
            'what_company_does'     => 'required'
        ]);

        if($validator->fails()) {
            return response([
                'error'  => $validator->errors(),
                'Validation Error'
            ]);
        }

        $ceo->update($data);

        return response([
            'message'   => 'Updated Successfully',
            'ceo'   => new CEOResource($ceo),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\CEO  $cEO
     * @return \Illuminate\Http\Response
     */
    public function destroy(CEO $ceo)
    {
        $ceo->delete();

        return response([
            'message' => 'Delete Successfully'
        ]);
    }
}
