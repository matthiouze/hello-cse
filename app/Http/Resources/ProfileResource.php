<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $data = [
            'name' => $this->resource->name,
            'firstname' => $this->resource->firstname,
            'image_path' => $this->resource->image_path,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'commment' => new CommentResource($this->resource->comment),
        ];

        if ($request->user()?->isAdmin()) {
            $data['status'] = $this->resource->status;
        }

        return $data;
    }
}
