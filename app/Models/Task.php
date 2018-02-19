<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'archive'];


    /**
     * Filter Tasks
     *
     * @param  Array $data
     * @param  int $totalPage
     *
     * @return \Illuminate\Http\Response
     */
    public function getResults(Array $data, int $totalPage)
    {
    	if (!isset($data['name']) && !isset($data['archive']))
    		return $this->paginate($totalPage);

    	return $this->where(function ($query) use ($data) {
    				if (isset($data['name'])) {
    					$name = $data['name'];
    					$query->where('name', 'LIKE', "%{$name}%");
    				}

    				if (isset($data['archive']))
    					$query->where('archive', $data['archive']);

    			})->paginate($totalPage);
    }
}
