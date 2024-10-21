<?php

namespace App\Http\Controllers\Admin;

use App\Utils\helper;
use App\Models\Fields;
use App\Models\Program;
use App\Models\PeroidGlobel;
use App\Models\ProgramTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\FieldsUpdateRequest;
use App\Http\Requests\ProgramContractStoreRequest;
use App\Http\Requests\ProgramPeriodStoreRequest;
use App\Http\Requests\ProgramPeriodUpdateRequest;
use App\Http\Requests\ProgramStoreRequest;
use App\Http\Requests\ProgramUpdateRequest;
use App\Http\Requests\ProgramsTypesStoreRequest;
use App\Http\Requests\ProgramsTypesUpdateRequest;
use App\Models\ContractProgram;
use App\Models\Program_period;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProgramsController extends Controller
{

    ///start types
    public function types_index()
    {

        return view('admin.programs.types.list');
    }
    public function types_getData()
    {
        $data = ProgramTypes::all();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function types_store(ProgramsTypesStoreRequest $request)
    {
        try {
            $requestData = $request->all();


            ProgramTypes::create($requestData);


            Toastr::success(__('Program Types Created Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function types_update(ProgramsTypesUpdateRequest $request)
    {
        try {
            // Find the category by ID
            $Peroid = ProgramTypes::findOrFail($request->input('id'));

            // Get the validated data, excluding 'id'
            $requestData = $request->except('id');

            // Update the Peroid with the validated data
            $Peroid->update($requestData);

            // Display success message and redirect to index
            Toastr::success(__('Program Types Updated Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            // Display error message and redirect back
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }


    public function types_delete(ProgramTypes $ProgramTypes)
    {
        try {
            $ProgramTypes->delete(); // Soft delete the Category

            Toastr::success(__('Program Types Deleted Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Program Types Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }
    ///end types





    ///start fields
    public function fields_index()
    {

        return view('admin.programs.fields.list');
    }
    public function fields_getData()
    {
        $data = Fields::all();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function fields_store(ProgramsTypesStoreRequest $request)
    {
        try {
            $requestData = $request->all();


            Fields::create($requestData);


            Toastr::success(__('Field Created Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function fields_update(FieldsUpdateRequest $request)
    {
        try {
            // Find the category by ID
            $Peroid = Fields::findOrFail($request->input('id'));

            // Get the validated data, excluding 'id'
            $requestData = $request->except('id');

            // Update the Peroid with the validated data
            $Peroid->update($requestData);

            // Display success message and redirect to index
            Toastr::success(__('Field Updated Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            // Display error message and redirect back
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }


    public function fields_delete(Fields $Fields)
    {
        try {
            $Fields->delete(); // Soft delete the Category

            Toastr::success(__('Fields Deleted Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Fields Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }
    ///end fields


    /////start  programs

    public function index()
    {
        // $data = Program::with('program_type')
        // ->select('id', 'program_type_id', 'value', 'calender_ar', 'calender_en', 'interest_ar', 'interest_en', 'created_at','updated_at')
        // ->get();
        // dd($data);
        return view('admin.programs.program.index');
    }

    public function getData()
    {
        $data = Program::with('program_type')
            ->select('id', 'program_type_id', 'value', 'calender_ar', 'calender_en', 'interest_ar', 'interest_en', 'created_at', 'updated_at')
            ->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function create()
    {
        $data = ProgramTypes::get();
        $types = helper::transformDataByLanguage($data->toArray());

        return view('admin.programs.program.create', compact('types'));
    }

    public function store(ProgramStoreRequest $ProgramStoreRequest)
    {

        try {
            $requestData = $ProgramStoreRequest->all();


            Program::create($requestData);


            Toastr::success(__('Program Created Successfully'), __('Success'));

            return redirect()->route('programs.index');
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function edit(Program $program)
    {
        $data = ProgramTypes::get();
        $types = helper::transformDataByLanguage($data->toArray());

        return view('admin.programs.program.edit', compact('types', 'program'));
    }

    public function update(ProgramUpdateRequest $request)
    {
        try {
            // Find the category by ID
            $Peroid = Program::findOrFail($request->input('id'));

            // Get the validated data, excluding 'id'
            $requestData = $request->except('id');

            // Update the Peroid with the validated data
            $Peroid->update($requestData);

            // Display success message and redirect to index
            Toastr::success(__('program Updated Successfully'), __('Success'));
            return redirect()->route('programs.index');
        } catch (\Throwable $th) {
            // Display error message and redirect back
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }


    public function archive(Program $program)
    {
        try {
            $program->delete(); // Soft delete the Category

            Toastr::success(__('Program Archived Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Program Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function archiveList()
    {

        return view('admin.programs.program.archive');
    }
    public function getArchived()
    {

        $data = Program::onlyTrashed()->with('program_type')
            ->select('id', 'program_type_id', 'value', 'calender_ar', 'calender_en', 'interest_ar', 'interest_en', 'created_at', 'updated_at')
            ->get();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function restore($id)
    {
        try {
            Program::withTrashed()
                ->where('id', $id)
                ->restore();
            Toastr::success(__('program Restored Successfully'), __('Success'));

            return redirect()->route('programs.index');
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('program Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    ////end programs
    ////start period for programs

    public function period_list(Program $program)
    {

        $Period = PeroidGlobel::get();
        $Periods = helper::transformDataByLanguage($Period->toArray());

        return view('admin.programs.program.period', compact('program', 'Periods'));
    }
    public function period_getData($id)
    {
        $program_period = Program_period::with('period')->where('program_id', $id)->get();
        $data = helper::transformDataByLanguage($program_period->toArray());

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }
    public function period_store(ProgramPeriodStoreRequest $request)
    {
        try {
            $requestData = $request->all();


            Program_period::create($requestData);


            Toastr::success(__('Program period Created Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function period_update(ProgramPeriodUpdateRequest $request)
    {
        try {
            // Find the category by ID
            $Peroid = Program_period::findOrFail($request->input('id'));

            // Get the validated data, excluding 'id'
            $requestData = $request->except('id');

            // Update the Peroid with the validated data
            $Peroid->update($requestData);

            // Display success message and redirect to index
            Toastr::success(__('Program period Updated Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            // Display error message and redirect back
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }
    public function period_delete(Program_period $Program_period)
    {
        try {
            $Program_period->delete(); // Soft delete the Category

            Toastr::success(__('Program period Deleted Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Program period Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    //////end period program

    /// start contract

    public function contract_list(Program $program)
    {
        return view('admin.programs.program.contract', compact('program'));
    }
    public function contract_getData($id)
    {
        $program_contract = ContractProgram::where('program_id', $id)->get();

        return response()->json([
            'data' => $program_contract,
            'message' => 'found data'
        ]);
    }
    public function contract_store(ProgramContractStoreRequest $request)
    {
        try {
            $requestData = $request->all();

            // Handle file upload if PDF is present and valid
            if ($request->hasFile('pdf') && $request->file('pdf')->isValid()) {
                $imageName = time() . '.' . $request->pdf->getClientOriginalExtension();
                $directory = 'uploads/' . $request->name; // Adjust directory as needed
                $request->pdf->move(public_path($directory), $imageName);
                $imagePath = $directory . '/' . $imageName;
                $requestData['pdf'] = $imagePath; // Add the file path to requestData
            }

            // Create the ContractProgram record
            ContractProgram::create($requestData);

            // Show success message
            Toastr::success(__('Contract Program Created Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            // Handle errors
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }



    public function contract_delete(ContractProgram $ContractProgram)
    {
        try {
            $ContractProgram->delete(); // Soft delete the Category

            Toastr::success(__('Contract Program Deleted Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Contract Program Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }
}
