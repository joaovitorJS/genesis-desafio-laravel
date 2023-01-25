<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAndUpdateScheduleRequest;
use App\Models\Schedule;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ScheduleController extends Controller
{   

    /*Home - Lista de agendamentos*/
    public function index() 
    {
        $schedules = Schedule::all();

        return view('home')->with('schedules', $schedules);
    }
    
    /*Formulário de cadastro*/
    public function create()
    {
        return view('schedules.create');
    }

    public function store(StoreAndUpdateScheduleRequest $request) 
    {   
        /* Validando dados de acordo com as regras estabelecidas em StoreAndUpdateScheduleRequest */
        $validated = $request->validated();
        

        $values = [
            'name' => $request->name,
            'cpf' => $request->cpf,
            'card_sus' => $request->card_sus,
            'reason' => $request->reason,
            'date_scheduling' => $request->date_scheduling,
            'urgency' => $request->urgency,
            'doctor_name' => $request->doctor_name,
            'professional_name' => $request->professional_name,
        ];

        $scheduling = Schedule::create($values);

        /* Se o agendamento foi criado */
        if ($scheduling) {
            $response['success'] = true;
            $response['message'] = "Agendamento criado com sucesso!";
            echo json_encode($response);
        }
    }

    public function edit($id) 
    {
        $scheduling = Schedule::find($id);

        if ($scheduling) {
            /* Chama a view que contém o formulário de atualizar o agendamento */
            return view('schedules.edit')->with('scheduling', $scheduling);
        } else {
            /*Se o agendamento não foi encontrado*/
            return redirect()->action([ScheduleController::class, 'index']);
        }
    }

    public function update(StoreAndUpdateScheduleRequest $request, $id)
    {
        $validated = $request->validated();
        if (empty($validated)) {
            $response['success'] = false;
            $response['message'] = "Houve um erro interno! Tente novamente depois!";
            echo json_encode($response);
            return;
        }
        
        $scheduling = Schedule::find($id);

        $scheduling->name = $request->name;
        $scheduling->cpf = $request->cpf;
        $scheduling->card_sus = $request->card_sus;
        $scheduling->reason = $request->reason;
        $scheduling->date_scheduling = $request->date_scheduling;
        $scheduling->urgency = $request->urgency;
        $scheduling->doctor_name = $request->doctor_name;
        $scheduling->professional_name = $request->professional_name;
     

        $scheduling->save();

        $response['success'] = true;
        $response['message'] = "Agendamento criado com sucesso!";
        echo json_encode($response);
    }
}
