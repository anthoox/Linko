<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\AppService; 
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $icon;
    public $editingCategoryId = null;
    public $currentIcon = null;

    public $categoryToDeleteId = null;
    public $categoryToDeleteName = null;


    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:15|unique:categories,name,' . $this->editingCategoryId,
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
        ];
    }

    public function editCategory($id)
    {
        $this->resetFields();

        $category = Category::where('user_id', Auth::id())->findOrFail($id);

        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
        $this->currentIcon = $category->icon;

        $this->dispatch('open-modal');
    }

    public function resetFields()
    {
        $this->reset(['name', 'icon', 'editingCategoryId', 'currentIcon']);
        $this->resetErrorBag();
        $this->resetPage();
    }

    public function save()
    {
        $this->validate();

        try {
            $wasEditing = $this->editingCategoryId !== null;

            $userPath = 'users/' . Auth::id() . '/category-icons';

            if ($this->editingCategoryId) {
                $category = Category::where('user_id', Auth::id())->findOrFail($this->editingCategoryId);
                $iconPath = $category->icon;

                if ($this->icon instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    if ($category->icon) {
                        Storage::disk('public')->delete($category->icon);
                    }

                    $iconPath = $this->icon->store($userPath, 'public');
                }

                $category->update([
                    'name' => $this->name,
                    'icon' => $iconPath,
                ]);
            } else {
                $iconPath = null;

                if ($this->icon) {
                    $iconPath = $this->icon->store($userPath, 'public');
                }

                Category::create([
                    'name' => $this->name,
                    'icon' => $iconPath,
                    'user_id' => Auth::id(),
                ]);
            }

            $this->resetFields();

            $this->dispatch('category-created');

            $this->dispatch(
                'show-toast',
                type: 'success',
                message: $wasEditing ? 'Categoría actualizada correctamente.' : 'Categoría creada correctamente.'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'show-toast',
                type: 'error',
                message: 'Ocurrió un error al guardar: ' . $e->getMessage()
            );
        }
    }

    public function deleteCategory()
    {
        if (!$this->categoryToDeleteId) {
            return;
        }

        try {
            $category = Category::where('user_id', Auth::id())
                ->findOrFail($this->categoryToDeleteId);

            if (strtolower($category->name) === 'general') {
                $tieneServicios = AppService::where('user_id', Auth::id())
                    ->where('category_id', $category->id)
                    ->exists();

                if ($tieneServicios) {
                    $this->resetDeleteFields();
                    $this->dispatch('close-delete-modal');

                    $this->dispatch(
                        'show-toast',
                        type: 'error',
                        message: 'No puedes eliminar la categoría General porque contiene servicios.'
                    );

                    return;
                }
            }

            $generalCategory = Category::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'name' => 'General',
                ],
                [
                    'icon' => null,
                ]
            );

            if ($category->id !== $generalCategory->id) {
                AppService::where('user_id', Auth::id())
                    ->where('category_id', $category->id)
                    ->update([
                        'category_id' => $generalCategory->id,
                    ]);
            }

            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }

            $category->delete();

            if ($this->editingCategoryId == $category->id) {
                $this->resetFields();
            }

            $this->resetDeleteFields();

            $this->dispatch('close-delete-modal');

            $this->dispatch(
                'show-toast',
                type: 'success',
                message: 'Categoría eliminada correctamente.'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'show-toast',
                type: 'error',
                message: 'Error técnico: ' . $e->getMessage()
            );
        }
    }
    public function resetDeleteFields()
    {
        $this->reset(['categoryToDeleteId', 'categoryToDeleteName']);
    }
    public function render()
    {
        return view('livewire.category.index', [
            'categories' => Category::where('user_id', Auth::id())->latest()->simplePaginate(10)
        ]);
    }

    public function confirmDeleteCategory($id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);

        $this->categoryToDeleteId = $category->id;
        $this->categoryToDeleteName = $category->name;

        $this->dispatch('open-delete-modal');
    }
}
