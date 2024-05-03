<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Cv;
use App\Models\Jobseeker;
use App\Models\Skill;

class CvController extends Controller
{
    // Get all cv for jobseeker
    public function getCvJobseeker($id)
    {
        try {
            $register =  Jobseeker::findOrFail($id);
            $cvs = $register->cvs()->get() ?? collect();
            return response()->json(['listCvs' => $cvs], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al obtener los registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Save cv for jobseeker
    public function store(Request $request)
    {
        try {
            Cv::create($request->all());
            return response()->json(['message' => 'CV creada correctamente'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al crear el registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Updater register CV
    public function update(Request $request, $id)
    {
        try {
            $cv = Cv::findOrFail($id);
            $cv->update($request->all());
            return response()->json(['message' => 'El reistro fue actualizado correctamente.'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al actualizar el registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
     // Delete jobseeker
     public function destroy($id)
     {
         try {
             $cv = Cv::findOrFail($id);
             Skill::where('cv_id',$id)->delete();
             $cv->delete();
             return response()->json(['message' => 'Registro eliminado correctamente'], Response::HTTP_OK);
         } catch (\Throwable $th) {
             return response()->json(['message' => 'Error al eliminar el registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }
     // Get cv
     public function getCv($id){
        try {
            $cv = Cv::findOrFail($id);
            $jobseeker = Jobseeker::findOrFail($cv->jobseeker_id);
            $skills = $cv->skills()->get();
            return response()->json(['cv' => $cv, 'jobseeker' => $jobseeker, 'skills' => $skills], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al eliminar el registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
     }
}
