<?php

namespace App\Repositories\WebContent;


use App\Models\Comment;
use App\Models\ContentBanner;
use App\Models\StaticPage;

class StaticPageRepository
{
    
    public static function getStaticPage(array $filter=[])
    {
        $query = StaticPage::select(['*']);
        
        if ($filter and (isset($filter['search']))) {
            $query->where('title', 'like', "%" . $filter['search'] . "%");
        }
        
        if ($filter and (isset($filter['is_active'])) or (isset($filter['is_active']) and (int)$filter['is_active'] === 0)) {
            $query->where('is_active', $filter['is_active']);
        }
        
        if ($filter and (isset($filter['id']))) {
            $query->where('id', $filter['id']);
        }
        
        if ($filter and (isset($filter['type']))) {
            $query->where('type', $filter['type']);
        }
        
        if ($filter and (isset($filter['source']))) {
            $query->where('source', $filter['source']);
        }
        if ($filter and (isset($filter['language']))) {
            $query->where('language', $filter['language']);
        }
        
        $query->orderBy('id', 'ASC')->orderBy('language', 'ASC');
        
        return $query;
    }
    
    
    public static function getContact(array $filter=[])
    {
        $query = Comment::select(['*']);
        
        if ($filter and (isset($filter['search']))) {
            $searchTerm = $filter['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('email', 'like', "%{$searchTerm}%")
                    ->orWhere('full_name', 'like', "%{$searchTerm}%");
            });
        }
        
        if ($filter and (isset($filter['is_customer']))) {
            $query->where('is_customer', $filter['is_customer']);
        }
        
        if ($filter and (isset($filter['id']))) {
            $query->where('id', $filter['id']);
        }
        
        $query->orderBy('created_at', 'DESC');
        
        return $query;
    }
    
    
    public static function getContentBanner(array $filter=[])
    {
        $query = ContentBanner::select(['*']);
        
        if ($filter and (isset($filter['search']))) {
            $searchTerm = $filter['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%");
            });
        }
        
        if ($filter and (isset($filter['is_active']))) {
            $query->where('is_active', $filter['is_active']);
        }
        
        if ($filter and (isset($filter['id']))) {
            $query->where('id', $filter['id']);
        }
        
        $query->orderBy('orden_photo', 'ASC');
        
        return $query;
    }
    
}
