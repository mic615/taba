<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'amount' => $this->amount,
          'category' => $this->category,
          'name' => $this->name,
          'transaction_type' => $this->transaction_type,
          'date' => $this->date,
          'location' => $this->location,
          'trip_id' => $this->trip_id
        ];
    }
}
