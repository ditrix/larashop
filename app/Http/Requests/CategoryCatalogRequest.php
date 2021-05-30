<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CategoryParent;

class CategoryCatalogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'parent_id' => 'required|regex:~^[0-9]+$~',
                    'name' => 'required|max:100',
                    'slug' => 'required|max:100|unique:categories,slug|regex:~^[-_a-z0-9]+$~i',
                    'image' => 'mimes:jpeg,jpg,png|max:5000'
                ];
            case 'PUT':
            case 'PATCH':
                // получаем объект модели категории из маршрута: admin/category/{category}
                $model = $this->route('category');
                // из объекта модели получаем уникальный идентификатор для валидации
                $id = $model->id;
                return [
                   // задаем правило валидации, что категорию не пытаются поместить внутрь себя
                   'parent_id' => ['required', 'regex:~^[0-9]+$~', new CategoryParent($model)],
                    'name' => 'required|max:100',
                    'slug' => 'required|max:100|unique:categories,slug,'.$id.',id|regex:~^[-_a-z0-9]+$~i',
                    'image' => 'mimes:jpeg,jpg,png|max:5000'
                ];
        }
    }
}
