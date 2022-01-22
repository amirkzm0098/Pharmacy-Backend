<?php

namespace App\Http\Controllers;

use App\Models\Presc;
use Illuminate\Http\Request;

class PrescController extends Controller
{
    public function index()
    {
        $presc = Presc::all();
        return response()->json([
            'status' => true,
            'message' => [],
            'result' => $presc
        ]);
    }

    public function store(Request $request)
    {
        $val = validator($request->all(), [
            'date' => 'required|date',
            'doctor' => 'required',
            'patient_id' => 'required',
        ]);
        if (!$val->fails()) {
            $totalPrice = null;
            if ($request['total_price'] != null) $totalPrice = $request['total_price'];
            $paid = false;
            if ($request['paid'] != null) $paid = $request['paid'];

            $presc = new Presc();
            $presc->fill([
                'date' => $request['date'],
                'doctor' => $request['doctor'],
                'patient_id' => $request['patient_id'],
                'total_price' => $totalPrice,
                'paid' => $paid
            ]);
            $presc->save();
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $presc
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }
    }

    public function show($id)
    {
        $val = validator(['id' => $id], [
            'id' => 'required|integer',
        ]);
        if (!$val->fails()) {
            $presc = Presc::find($id);
            if ($presc == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['Prescription not found'],
                    'result' => []
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $presc
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $val = validator(array_merge($request->all(), ['id' => $id]), [
            'id' => 'required|integer',
            'date' => 'required|date',
            'doctor' => 'required',
            'patient_id' => 'required',
        ]);
        if (!$val->fails()) {
            $presc = Presc::find($id);
            if ($presc == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['Prescription not found'],
                    'result' => []
                ]);
            }
            $totalPrice = null;
            if ($request['total_price'] != null) $totalPrice = $request['total_price'];
            $paid = false;
            if ($request['paid'] != null) $paid = $request['paid'];
            $presc->update([
                'date' => $request['date'],
                'doctor' => $request['doctor'],
                'patient_id' => $request['patient_id'],
                'total_price' => $totalPrice,
                'paid' => $paid
            ]);

            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $presc
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }
    }

    public function destroy($id)
    {
        $val = validator(['id' => $id], [
            'id' => 'required|integer',
        ]);
        if(!$val->fails()) {
            $res = Presc::destroy($id);
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $res
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }
    }
}