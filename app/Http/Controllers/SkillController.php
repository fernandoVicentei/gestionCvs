<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Cv;
use App\Models\Jobseeker;
use App\Models\Skill;

class SkillController extends Controller
{
    // Get all skills for cvs
    public function getSkillCvs($id)
    {
        try {
            $register =  Cv::findOrFail($id);
            $skills = $register->skills()->get() ?? collect();
            return response()->json(['listSkills' => $skills], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al obtener los registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Save cv for jobseeker
    public function store(Request $request)
    {
        try {
            Skill::create($request->all());
            return response()->json(['message' => 'Skill creada correctamente'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al crear el registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
     // Updater register skill
     public function update(Request $request, $id)
     {
         try {
             $cv = Skill::findOrFail($id);
             $cv->update($request->all());
             return response()->json(['message' => 'El reistro fue actualizado correctamente.'], Response::HTTP_OK);
         } catch (\Throwable $th) {
             return response()->json(['message' => 'Error al actualizar el registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }
      // Delete skill
      public function destroy($id)
      {
          try {
              $skill = Skill::findOrFail($id);
              $skill->delete();
              return response()->json(['message' => 'Registro eliminado correctamente'], Response::HTTP_OK);
          } catch (\Throwable $th) {
              return response()->json(['message' => 'Error al eliminar el registro: ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
          }
      }
}
