<?php

namespace App\Http\Requests\WebContent;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Cambia esto según tus necesidades de autorización
    }
    
    public function rules()
    {
        return [
            'full_name' => 'required|min:3|max:100|regex:/^[\pL\s]+$/u',
            'email'     => 'required|email|max:191',
            'subject'   => 'nullable|in:' . implode(',', Comment::SUBJECTS),
            'comment'   => 'required|string|min:10|max:' . Comment::MAX_LENGTH,
        ];
    }
    
    public function messages()
    {
        return [
            'full_name.required' => __t('text.frontend.ux.v_required'),
            'full_name.min'      => __t('text.frontend.ux.v_name'),
            'full_name.regex'    => __t('text.frontend.ux.v_name'),
            'email.required'     => __t('text.frontend.ux.v_required'),
            'email.email'        => __t('text.frontend.ux.v_email'),
            'subject.in'         => __t('text.frontend.ux.v_subject'),
            'comment.required'   => __t('text.frontend.ux.v_required'),
            'comment.min'        => __t('text.frontend.ux.v_comment_min'),
            'comment.max'        => __t('text.frontend.ux.v_comment_max'),
        ];
    }
}
