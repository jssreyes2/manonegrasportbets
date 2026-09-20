<?php

namespace App\Repositories\WebContent;


use App\Models\Category;
use App\Models\FrequentlyAskedQuestion;

class FrequentlyAskedQuestionRepository
{

    public static function getFaq(array $filter=[])
    {
        $query = FrequentlyAskedQuestion::select(['*']);

        if ($filter and (isset($filter['search']))) {
            $query->where('question', 'like', "%" . $filter['search'] . "%");
        }

        if ($filter and (isset($filter['is_active'])) or (isset($filter['is_active']) and (int)$filter['is_active'] === 0)) {
            $query->where('is_active', $filter['is_active']);
        }

        if ($filter and (isset($filter['id']))) {
            $query->where('id', $filter['id']);
        }
        
        if ($filter and (isset($filter['language']))) {
            $query->where('language', $filter['language']);
        }

        $query->orderBy('orden', 'ASC')->orderBy('language', 'ASC');

        return $query;
    }

}
