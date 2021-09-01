<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
 
use App\Models\Company;
 
use Datatables;

use App\Exports\CompaniesExport;
use Maatwebsite\Excel\Facades\Excel;
 
class DataTableAjaxCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Company::select('*'))
            ->addColumn('action', 'company-actions')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('companies');
    }
      
      
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {  
        $r->validate([
        "name" => "required",
        "email" => "required|email",
        "address" => "required",
        ]);
 
        $companyId = $r->id;
 
        $company   =   Company::updateOrCreate(
                    [
                     'id' => $companyId
                    ],
                    [
                    'name' => $r->name, 
                    'email' => $r->email,
                    'address' => $r->address
                    ]);    
                         
        return Response()->json($company);
 
    }
      
      
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $company  = Company::where($where)->first();
      
        return Response()->json($company);
    }
      
      
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $company = Company::where('id',$request->id)->delete();

          // check data deleted or not
        if ($company == 1) {
            $success = true;
            $message = "User deleted successfully";
        } else {
            $success = true;
            $message = "User not found";
        }
      
        return Response()->json([
            'success' => $success,
            'message' => $message,
            // 'company' => $company,
        ]);
    }

    public function export() 
    {
        return Excel::download(new CompaniesExport, 'companies.xlsx');
    }
}