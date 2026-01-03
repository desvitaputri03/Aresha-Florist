<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    public function getProvinces(): JsonResponse
    {
        $provinces = Province::all(['id', 'name']);
        return response()->json($provinces);
    }

    public function getRegencies(string $provinceId): JsonResponse
    {
        $regencies = Regency::where('province_id', $provinceId)->get(['id', 'name']);
        return response()->json($regencies);
    }

    public function getDistricts(string $regencyId): JsonResponse
    {
        $districts = District::where('regency_id', $regencyId)->get(['id', 'name', 'postal_code']);
        return response()->json($districts);
    }

    public function getPostalCode(string $districtId): JsonResponse
    {
        $district = District::find($districtId, ['postal_code']);
        return response()->json(['postal_code' => $district ? $district->postal_code : null]);
    }
}
