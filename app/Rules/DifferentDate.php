<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DifferentDate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id=null)
    {   
        $this->id = $id;       
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $dateFormatted = date('Y-m-d H:i:s', strtotime($value));

        if (!$this->id) { /*Caso de Create*/
            $datesSchedules = DB::table('schedules')
            ->select($attribute)
            ->get()
            ->toArray();     
        } else { /*Caso de Update*/
            $datesSchedules = DB::table('schedules')
            ->select($attribute)
            ->where('id', '!=', $this->id)
            ->get()
            ->toArray();   
        }

        $dates = array_map(function ($item) {
            return $item->date_scheduling;
        }, $datesSchedules);

        /*Se existe uma data igual na mesma coluna*/
        if (in_array($dateFormatted, $dates)) {
            return false; 
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Data e hora já estão agendados!';
    }
}
