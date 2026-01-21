<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\User;  
use Illuminate\Http\Request;

class NgoBrowseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $area   = $request->query('area');

        // organization role user from user table
        $query = User::where('role', 'organization');

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        if (!empty($area)) {
            $query->where('address', 'like', "%{$area}%");
        }

        $ngos = $query->orderBy('name')->paginate(9);

        return view('pages.donor.ngos.index', compact('ngos', 'search', 'area'));
    }
}
