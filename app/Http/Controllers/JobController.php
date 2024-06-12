<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(){
        $statuses = ["Em Execução", "Concluída", "Cancelada"];

        function randomDate($start_date, $end_date) {
            $start_timestamp = strtotime($start_date);
            $end_timestamp = strtotime($end_date);
            $random_timestamp = mt_rand($start_timestamp, $end_timestamp);
            return date("Y-m-d", $random_timestamp);
        }
        
        function randomValue($min, $max) {
            return mt_rand($min * 100, $max * 100) / 100;
        }

        $analises = [];

        for ($i = 1; $i <= 10; $i++) {
            $analise = [
                "nome" => "Analise_Exemplo_$i",
                "data" => randomDate("2023-01-01", "2024-12-31"),
                "status" => $statuses[array_rand($statuses)],
                "valor_minimo" => randomValue(100, 500),
                "valor_maximo" => randomValue(500, 1000),
            ];

            if ($analise["valor_minimo"] > $analise["valor_maximo"]) {
                $temp = $analise["valor_minimo"];
                $analise["valor_minimo"] = $analise["valor_maximo"];
                $analise["valor_maximo"] = $temp;
            }

            $analises[] = $analise;
        }
        return view('job', compact('analises'));
    }
}
