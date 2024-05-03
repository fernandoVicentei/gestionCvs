<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobseeker;
use Illuminate\Http\Response;
use App\Models\Cv;
use App\Models\Skill;

class JobseekerController extends Controller
{
    //GET list Jobseekers
    public function getListJobSeekers() {
        try {
            $registers = Jobseeker::orderBy('id', 'desc')->get();
            return response()->json(['registers' => $registers],Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al obtener los registros'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Create Jobseeker
    public function store(Request $request)
    {
        try {
            Jobseeker::create($request->all());
            return response()->json(['message' => 'Candidato creado correctamente'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al crear el registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Get jobseeker for visualization information
    public function show($id)
    {
        try {
            $jobseeker =  Jobseeker::findOrFail($id);
            return response()->json(['register' => $jobseeker], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al obtener el registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Updater register
    public function update(Request $request, $id)
    {
        try {
            $jobseeker = Jobseeker::findOrFail($id);
            $jobseeker->update($request->all());
            return response()->json(['message' => 'El reistro fue actualizado correctamente.'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al actualizar el registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Delete jobseeker
    public function destroy($id)
    {
        try {
            $jobseeker = Jobseeker::findOrFail($id);
            $cvs = $jobseeker->cvs()->get();
            foreach ($cvs as $cv) {
                Skill::where('cv_id',$cv->id)->delete();
                $cv->delete();
            }
            $jobseeker->delete();
            return response()->json(['message' => 'Registro eliminado correctamente'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al eliminar el registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Filter jobseeker
    public function filterJobseekers(Request $request)
    {
        try {
            $searchable = $request->filter;
            $results = Jobseeker::where('first_name', 'LIKE', "%$searchable%")
                            ->orWhere('last_name', 'LIKE', "%$searchable%")
                            ->orWhere('phone_number', 'LIKE', "%$searchable%")
                            ->orWhere('email', 'LIKE', "%$searchable%")
                            ->get();
            return response()->json(['registers' => $results ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al obtener los registros: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
