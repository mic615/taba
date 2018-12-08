<?php

namespace App\Http\Resources;
use App\Http\Resources\Transaction as TransactionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Trip extends JsonResource
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
          'start_date' => $this->start_date,
          'end_date'=> $this->end_date,
          'budget' => $this->budget,
          'city' => $this->city,
          'state' => $this->state,
          'transactions' => new TransactionResource($this->transactions)
        ];
    }
}
