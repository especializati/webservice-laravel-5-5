<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    protected $fillable = ['name', 'description'];


    /**
     * Filter Products
     *
     * @param  Array $data
     * @param  int $totalPage
     *
     * @return \Illuminate\Http\Response
     */
    public function getResults(Array $data, int $totalPage)
    {
    	if (!isset($data['name']) && !isset($data['description']) && !isset($data['filter']))
    		return $this->paginate($totalPage);

    	return $this->where(function ($query) use ($data) {
    				if (isset($data['name'])) {
    					$name = $data['name'];
    					$query->where('name', 'LIKE', "%{$name}%");
    				}

    				if (isset($data['description'])) {
    					$description = $data['description'];
    					$query->where('description', 'LIKE', "%{$description}%");
    				}

    				if (isset($data['filter'])) {
    					$filter = $data['filter'];

    					$query->where('name', $filter);
    					$query->orWhere('description', 'LIKE', "%{$filter}%");
    				}
    			})->paginate($totalPage);
    }
}
