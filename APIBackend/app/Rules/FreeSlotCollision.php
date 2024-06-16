<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Consultation_slot;
use App\Models\Free_slot;

class FreeSlotCollision implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $start_time;
    protected $end_time;
    protected $date;
    protected $lecturer_id;
    protected $free_slot_id;

    public function __construct($start_time, $end_time, $date, $lecturer_id, $free_slot_id = null)
    {
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->date = $date;
        $this->lecturer_id = $lecturer_id;
        $this->free_slot_id = $free_slot_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        // dd($attribute, $value, $fail);
        // dd($value, $attribute);
        $overlappingSlots = Consultation_slot::where('lecturer_id', $this->lecturer_id)
            ->where('date', $this->date)
            ->where('start_time', '<', $this->end_time)
            ->where('end_time', '>', $this->start_time)
            ->where('status', 'Approved')
            ->orWhere('lecturer_id', $this->lecturer_id)
            ->where('date', $this->date)
            ->where('start_time', '<', $this->start_time)
            ->where('end_time', '>', $this->end_time)
            ->where('status', 'Approved')
            ->orWhere('lecturer_id', $this->lecturer_id)
            ->where('date', $this->date)
            ->where('start_time', '>=', $this->start_time)
            ->where('end_time', '<', $this->end_time)
            ->where('status', 'Approved')
            ->get();

        if ($overlappingSlots->count() != 0) {
            $fail('The time slot is already taken');
        }

        $overlappingFreeSlots = Free_slot::where('lecturer_id', $this->lecturer_id)
            ->where('date', $this->date)
            ->where('start_time', '<', $this->end_time)
            ->where('end_time', '>', $this->start_time)
            ->where('id', '!=', $this->free_slot_id)
            ->orWhere('lecturer_id', $this->lecturer_id)
            ->where('date', $this->date)
            ->where('start_time', '<', $this->start_time)
            ->where('end_time', '>', $this->end_time)
            ->where('id', '!=', $this->free_slot_id)
            ->orWhere('lecturer_id', $this->lecturer_id)
            ->where('date', $this->date)
            ->where('start_time', '>=', $this->start_time)
            ->where('end_time', '<', $this->end_time)
            ->where('id', '!=', $this->free_slot_id)
            ->get();

            if($overlappingFreeSlots->count() != 0){
                $fail('The time slot is already taken');
            }
    }
}
