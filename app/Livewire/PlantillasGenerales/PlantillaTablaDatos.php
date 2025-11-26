<?php

namespace App\Livewire\PlantillasGenerales;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;

class PlantillaTablaDatos extends Component
{
    public $modelo;
    public $bucadorComlumnas = [];
    public $filas;
    public $columnas;

    #[Url(except: '')]
    public $buscador = '';

    protected function buildQuery(): Builder
    {
        $query = $this->modelo::query();

        if (!empty($this->buscador) && !empty($this->bucadorComlumnas)) {
            $terminoBuscador = '%' . $this->buscador . '%';

            $query->where(function (Builder $q) use ($terminoBuscador) {
                foreach ($this->bucadorComlumnas as $columna) {
                    $q->orWhere($columna, 'like', $terminoBuscador);
                }
            });
        }
        
        return $query;
    }

    public function render()
    {
        //Query
        $datos = $this->buildQuery()->get();

        return view('livewire.plantillas-generales.plantilla-tabla-datos',[
            'datos' => $datos
        ]);
    }
}
