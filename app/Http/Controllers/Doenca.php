<?php

namespace App\Http\Controllers;

use App\Models\Doenca as ModelsDoenca;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Doenca extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function listaDoencas(): array
    {
        return array(
            'Agenesia de Membros',
            'Deficiência Auditiva',
            'Deficiência Intelectual',
            'Deficiência Motora',
            'Deficiência Visual',
            'Paralisia Cerebral',
            'Síndrome de Angelman',
            'Síndrome de Down',
            'Síndrome de Edwards',
            'Síndrome de Jacobs',
            'Síndrome de Klinefelter',
            'Síndrome de Patau',
            'Síndrome de Turner',
            'Síndrome do Triplo X',
            'Síndromes Raras',
            'TEA - Transtorno do Espectro Autista'
        );
    }

    public static function doencasPorUsuario(int $user_id): array
    {
        $doencaUserList = ModelsDoenca::where('user_id', $user_id)->get(["doenca"]);
        $finalDoencaUserList = [];
        foreach ($doencaUserList as $doenca) {
            $finalDoencaUserList[$doenca->doenca] = $doenca->doenca;
        }

        return $finalDoencaUserList;
    }
}
