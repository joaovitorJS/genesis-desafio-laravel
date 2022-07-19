<?php

namespace App\Http\Controllers;

use App\Services\ReplicadorService;
use Illuminate\Http\Request;

class ReplicadorController extends Controller
{
    protected $service;

    public function __construct(ReplicadorService $service)
    {
        $this->service = $service;
    }

    public function replicar(Request $request)
    {
        try {
            return $this->service->replicar($request->getContent());
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
