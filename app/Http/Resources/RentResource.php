<?php

namespace App\Http\Resources;

use App\Adapters\ApiAdapter;
use App\Repositories\Contracts\PaginationInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $result['data'] = [];
        if ($this->resource instanceof PaginationInterface) {
            $resource = $this->resource->items();

            foreach ($resource as $item) {
                $result['data'][] = [
                    'idCar' => $item->id_car,
                    'brand' => strtoupper($item->brand),
                    'model' => $item->model,
                    'plate' => $item->plate,
                    'createdAt' => Carbon::make($item->created_at)->format('Y-m-d H:i:s'),
                    'updatedAt' => $item->updated_at ? Carbon::make($item->updated_at)->format('Y-m-d H:i:s') : null,
                ];
            }

            $result['meta'] = [
                'total' => $this->resource->total(),
                'is_first_page' => $this->resource->isFirstPage(),
                'is_last_page' => $this->resource->isLastPage(),
                'current_page' => $this->resource->currentPage(),
                'next_page' => $this->resource->getNumberNextPage(),
                'previous_page' => $this->resource->getNumberPreviousPage(),
            ];
            return $result;
        }

        return  [
            'idCar' => $this->id_car,
            'brand' => strtoupper($this->brand),
            'model' => $this->model,
            'plate' => $this->plate,
            'user' => strtoupper($this->name),
            'createdAt' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at ? Carbon::make($this->updated_at)->format('Y-m-d H:i:s') : null,
        ];
    }
}
