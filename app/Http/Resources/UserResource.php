<?php

namespace App\Http\Resources;

use App\Repositories\Contracts\PaginationInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                    'id' => $item->id,
                    'name' => strtoupper($item->name),
                    'email' => $item->email,
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

        // $array = (array) $this->resource;
        // foreach ($this->resource as $item) {
        //     $result[] = [
        //         'id' => $item->id,
        //         'name' => strtoupper($item->name),
        //         'email' => $item->email,
        //         'createdAt' => Carbon::make($item->created_at)->format('Y-m-d H:i:s'),
        //         'updatedAt' => $item->updated_at ? Carbon::make($item->updated_at)->format('Y-m-d H:i:s') : null,
        //     ];
        // }
        // return $result;

        return [
            'id' => $this->id,
            'name' => strtoupper($this->name),
            'email' => $this->email,
            'createdAt' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at ? Carbon::make($this->updated_at)->format('Y-m-d H:i:s') : null,
        ];
    }
}
